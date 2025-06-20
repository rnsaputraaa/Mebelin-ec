<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Content;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ContentResource\Pages;

class ContentResource extends Resource
{
    protected static ?string $model = Content::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    protected static ?string $navigationGroup = 'Customer Management';

    protected static ?string $navigationLabel = 'Comments';

    protected static ?string $modelLabel = 'Comment';

    protected static ?string $pluralModelLabel = 'Comments';

    protected static ?int $navigationSort = 2;

    // Disable create dan edit - hanya read only
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            // Form tidak digunakan karena read-only
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.nama_lengkap')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->limit(20)
                    ->weight('medium'),

                TextColumn::make('customer.user.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->limit(25)
                    ->color('info'),

                TextColumn::make('product.product_name')
                    ->label('Produk')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 30 ? $state : null;
                    }),

                TextColumn::make('comment')
                    ->label('Comment')
                    ->limit(60)
                    ->wrap()
                    ->tooltip(function (TextColumn $column): ?string {
                        return $column->getState();
                    })
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Comment Date')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->since()
                    ->tooltip(function (TextColumn $column): ?string {
                        return $column->getRecord()->created_at->format('d M Y H:i:s');
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('product_id')
                    ->label('Filter Produk')
                    ->relationship('product', 'product_name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('customer_id')
                    ->label('Filter Customer')
                    ->relationship('customer', 'nama_lengkap')
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Comment dari tanggal'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Comment sampai tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['created_from'], fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date))
                            ->when($data['created_until'], fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->actions([
                ViewAction::make()
                    ->modalContent(fn ($record) => view('filament.modals.comment-detail', ['record' => $record]))
                    ->modalWidth('2xl')
                    ->label('Detail'),

                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Comment')
                    ->modalDescription('Apakah Anda yakin ingin menghapus comment ini?')
                        ->visible(fn () => Auth::check() && Auth::user()->u_type === 'admin'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Comment Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus semua comment yang dipilih?')
                       ->visible(fn (): bool => Auth::check() && Auth::user()->u_type === 'admin'),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Comment')
            ->emptyStateDescription('Belum ada customer yang memberikan comment untuk produk.')
            ->emptyStateIcon('heroicon-o-chat-bubble-left-ellipsis');
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
            'index' => Pages\ListContents::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getModel()::count();
        
        if ($count > 100) {
            return 'success';
        } elseif ($count > 50) {
            return 'warning';
        }
        
        return 'primary';
    }
}