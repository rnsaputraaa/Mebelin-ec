<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\ReportStock;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ReportStockResource\Pages;
use Illuminate\Support\Facades\Auth;

class ReportStockResource extends Resource
{
    protected static ?string $model = ReportStock::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Inventory Management';

    protected static ?string $navigationLabel = 'Stock Reports';

    protected static ?string $modelLabel = 'Stock Report';

    protected static ?string $pluralModelLabel = 'Stock Reports';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('id_product')
                ->label('Produk')
                ->relationship('product', 'product_name')
                ->searchable()
                ->preload()
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    if ($state) {
                        $product = \App\Models\Product::find($state);
                        $set('current_stock', $product?->stok ?? 0);
                    }
                }),

            TextInput::make('current_stock')
                ->label('Stok Saat Ini')
                ->disabled()
                ->dehydrated(false)
                ->placeholder('Pilih produk untuk melihat stok'),

            Select::make('type')
                ->label('Jenis Pergerakan')
                ->options([
                    'in' => 'Stok Masuk (+)',
                    'out' => 'Stok Keluar (-)',
                ])
                ->required()
                ->reactive(),

            TextInput::make('quantity')
                ->label('Jumlah')
                ->numeric()
                ->required()
                ->minValue(1)
                ->step(1)
                ->helperText('Masukkan jumlah stok yang masuk atau keluar'),

            DatePicker::make('movement_date')
                ->label('Tanggal Pergerakan')
                ->required()
                ->default(now())
                ->maxDate(now()),

            Select::make('reference_type')
                ->label('Jenis Referensi')
                ->options([
                    'purchase' => 'Pembelian',
                    'sale' => 'Penjualan',
                    'adjustment' => 'Penyesuaian',
                    'return' => 'Retur',
                    'damage' => 'Kerusakan',
                    'transfer' => 'Transfer',
                    'initial' => 'Stok Awal',
                    'other' => 'Lainnya',
                ])
                ->nullable(),

            TextInput::make('reference_id')
                ->label('ID Referensi')
                ->placeholder('Order ID, Invoice ID, etc')
                ->maxLength(255)
                ->nullable(),

            Textarea::make('notes')
                ->label('Catatan')
                ->rows(3)
                ->maxLength(500)
                ->placeholder('Catatan tambahan tentang pergerakan stok')
                ->nullable(),

            TextInput::make('created_by')
                ->label('Dibuat Oleh')
                ->default(fn (): mixed => Auth::user()?->username ?? 'Admin')
                ->maxLength(255)
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('movement_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('product.product_name')
                    ->label('Produk')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'in' => 'success',
                        'out' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'in' => 'Masuk',
                        'out' => 'Keluar',
                        default => $state,
                    }),

                TextColumn::make('signed_quantity')
                    ->label('Jumlah')
                    ->badge()
                    ->color(fn ($record): string => $record->type === 'in' ? 'success' : 'danger')
                    ->sortable(),

                TextColumn::make('reference_type')
                    ->label('Referensi')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'purchase' => 'Pembelian',
                        'sale' => 'Penjualan',
                        'adjustment' => 'Penyesuaian',
                        'return' => 'Retur',
                        'damage' => 'Kerusakan',
                        'transfer' => 'Transfer',
                        'initial' => 'Stok Awal',
                        'other' => 'Lainnya',
                        default => '-',
                    })
                    ->badge()
                    ->color('secondary'),

                TextColumn::make('reference_id')
                    ->label('Ref ID')
                    ->limit(15)
                    ->placeholder('-'),

                TextColumn::make('product.stok')
                    ->label('Stok Saat Ini')
                    ->badge()
                    ->color('info'),

                TextColumn::make('created_by')
                    ->label('Dibuat Oleh')
                    ->limit(15)
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('movement_date', 'desc')
            ->filters([
                SelectFilter::make('type')
                    ->label('Jenis Pergerakan')
                    ->options([
                        'in' => 'Stok Masuk',
                        'out' => 'Stok Keluar',
                    ]),

                SelectFilter::make('id_product')
                    ->label('Filter Produk')
                    ->relationship('product', 'product_name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('reference_type')
                    ->label('Jenis Referensi')
                    ->options([
                        'purchase' => 'Pembelian',
                        'sale' => 'Penjualan',
                        'adjustment' => 'Penyesuaian',
                        'return' => 'Retur',
                        'damage' => 'Kerusakan',
                        'transfer' => 'Transfer',
                        'initial' => 'Stok Awal',
                        'other' => 'Lainnya',
                    ]),

                Tables\Filters\Filter::make('movement_date')
                    ->form([
                        Forms\Components\DatePicker::make('date_from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('date_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['date_from'], fn (Builder $query, $date): Builder => $query->whereDate('movement_date', '>=', $date))
                            ->when($data['date_until'], fn (Builder $query, $date): Builder => $query->whereDate('movement_date', '<=', $date));
                    }),
            ])
            ->actions([
                ViewAction::make()
                    ->modalContent(fn ($record) => view('filament.modals.report-stock-detail', ['record' => $record]))
                    ->modalWidth('2xl')
                    ->label('Detail'),

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Laporan Stok')
                    ->modalDescription('Apakah Anda yakin ingin menghapus laporan stok ini? Stok produk akan diupdate ulang.')
                    ->visible(fn () => static::isAdmin()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Laporan Stok Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus semua laporan stok yang dipilih?')
                        ->visible(fn () => static::isAdmin()),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Laporan Stok')
            ->emptyStateDescription('Belum ada laporan pergerakan stok yang tercatat.')
            ->emptyStateIcon('heroicon-o-clipboard-document-list');
    }

    // Helper method untuk check admin
    protected static function isAdmin(): bool
    {
        return Auth::check() && Auth::user()?->u_type === 'admin';
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReportStocks::route('/'),
            'create' => Pages\CreateReportStock::route('/create'),
            'edit' => Pages\EditReportStock::route('/{record}/edit'),
        ];
    }



    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereDate('created_at', today())->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}