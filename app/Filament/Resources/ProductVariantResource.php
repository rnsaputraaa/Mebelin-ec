<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Price;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ProductVariantResource\Pages;

class ProductVariantResource extends Resource
{
    protected static ?string $model = ProductVariant::class;

    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $navigationGroup = 'Product Management';

    protected static ?string $navigationLabel = 'Product Variants';

    protected static ?string $modelLabel = 'Product Variant';

    protected static ?string $pluralModelLabel = 'Product Variants';

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
                ->afterStateUpdated(fn (callable $set) => $set('color', null)),

            TextInput::make('color')
                ->label('Warna/Variant')
                ->required()
                ->maxLength(50)
                ->placeholder('Contoh: Merah, Biru, Hijau, dll'),

            Fieldset::make('Harga')
                ->schema([
                    TextInput::make('regular_price')
                        ->label('Harga Normal')
                        ->numeric()
                        ->required()
                        ->prefix('Rp')
                        ->placeholder('0'),

                    TextInput::make('price_sale')
                        ->label('Harga Diskon')
                        ->numeric()
                        ->nullable()
                        ->prefix('Rp')
                        ->placeholder('Kosongkan jika tidak ada diskon'),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.product_name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('color')
                    ->label('Variant/Warna')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('price.regular_price')
                    ->label('Harga Normal')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),

                TextColumn::make('price.price_sale')
                    ->label('Harga Diskon')
                    ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : '-')
                    ->sortable(),

                TextColumn::make('final_price')
                    ->label('Harga Final')
                    ->getStateUsing(function ($record) {
                        $finalPrice = $record->price->price_sale ?? $record->price->regular_price;
                        return 'Rp ' . number_format($finalPrice, 0, ',', '.');
                    })
                    ->badge()
                    ->color('success'),

                TextColumn::make('discount_percentage')
                    ->label('Diskon')
                    ->getStateUsing(function ($record) {
                        if ($record->price->price_sale && $record->price->regular_price > $record->price->price_sale) {
                            $discount = round((($record->price->regular_price - $record->price->price_sale) / $record->price->regular_price) * 100);
                            return $discount . '%';
                        }
                        return '-';
                    })
                    ->badge()
                    ->color('warning'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('id_product')
                    ->label('Filter Produk')
                    ->relationship('product', 'product_name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListProductVariants::route('/'),
            'create' => Pages\CreateProductVariant::route('/create'),
            'edit' => Pages\EditProductVariant::route('/{record}/edit'),
        ];
    }
}