<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Review;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ReviewResource\Pages;
use Illuminate\Support\Facades\Auth;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationGroup = 'Customer Management';

    protected static ?string $navigationLabel = 'Reviews & Ratings';

    protected static ?string $modelLabel = 'Review';

    protected static ?string $pluralModelLabel = 'Reviews & Ratings';

    protected static ?int $navigationSort = 1;

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
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 20 ? $state : null;
                    }),

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
                    ->weight('medium')
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 30 ? $state : null;
                    }),

                BadgeColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state) => $state . ' / 5')
                    ->colors([
                        'danger' => fn ($state) => $state <= 2,
                        'warning' => fn ($state) => $state == 3,
                        'success' => fn ($state) => $state >= 4,
                    ])
                    ->icons([
                        'heroicon-s-star' => fn ($state) => $state >= 4,
                        'heroicon-s-exclamation-triangle' => fn ($state) => $state <= 2,
                    ])
                    ->sortable(),

                TextColumn::make('orderItem.order.order_number')
                    ->label('Order ID')
                    ->searchable()
                    ->sortable()
                    ->color('gray')
                    ->copyable()
                    ->copyMessage('Order ID copied!')
                    ->tooltip('Click to copy'),

                TextColumn::make('orderItem.order.status_order')
                    ->label('Order Status')
                    ->badge()
                    ->colors([
                        'secondary' => 'pending',
                        'warning' => 'processing',
                        'info' => 'shipped',
                        'success' => 'delivered',
                        'danger' => 'cancelled',
                    ]),

                TextColumn::make('created_at')
                    ->label('Review Date')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->since()
                    ->tooltip(function (TextColumn $column): ?string {
                        return $column->getRecord()->created_at->format('d M Y H:i:s');
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('rating')
                    ->label('Filter Rating')
                    ->options([
                        5 => '⭐⭐⭐⭐⭐ (5 Stars)',
                        4 => '⭐⭐⭐⭐ (4 Stars)',
                        3 => '⭐⭐⭐ (3 Stars)',
                        2 => '⭐⭐ (2 Stars)',
                        1 => '⭐ (1 Star)',
                    ]),

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
                            ->label('Review dari tanggal'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Review sampai tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['created_from'], fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date))
                            ->when($data['created_until'], fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->actions([
                ViewAction::make()
                    ->modalContent(fn ($record) => view('filament.modals.review-detail', ['record' => $record]))
                    ->modalWidth('2xl')
                    ->label('Detail'),

                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Review')
                    ->modalDescription('Apakah Anda yakin ingin menghapus review ini? Tindakan ini tidak dapat dibatalkan.')
                    ->visible(fn () => auth::user()->u_type === 'admin'), // Hanya admin yang bisa delete
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Review Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus semua review yang dipilih?')
                        ->visible(fn (): bool => Auth::check() && Auth::user()->u_type === 'admin'),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Review')
            ->emptyStateDescription('Belum ada customer yang memberikan review untuk produk.')
            ->emptyStateIcon('heroicon-o-star');
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
            'index' => Pages\ListReviews::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getModel()::count();
        
        if ($count > 50) {
            return 'success';
        } elseif ($count > 20) {
            return 'warning';
        }
        
        return 'primary';
    }
}