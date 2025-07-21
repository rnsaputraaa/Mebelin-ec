<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use App\Models\Price;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ProductResource\Pages;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationGroup = 'Product Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('product_name')
                ->label('Nama Produk')
                ->required()
                ->maxLength(100)
                ->reactive()
                ->afterStateUpdated(function (callable $set, ?string $state, ?string $context) {
                    if ($context === 'create' && $state) {
                        $set('slug', Str::slug($state));
                    }
                }),

            TextInput::make('slug')
                ->label('Slug')
                ->helperText('Kosongkan untuk mengisi otomatis.')
                ->maxLength(100)
                ->disabled()
                ->dehydrated(),

            Textarea::make('description')
                ->label('Deskripsi')
                ->maxLength(500)
                ->rows(4),

            Fieldset::make('Stok dan Ukuran')
                ->schema([
                    TextInput::make('stok')
                        ->label('Stok')
                        ->numeric()
                        ->default(0)
                        ->required(),
                    
                    TextInput::make('stok_sales')
                        ->label('Stok Terjual')
                        ->numeric()
                        ->default(0),
                    
                    TextInput::make('size')
                        ->label('Ukuran')
                        ->numeric()
                        ->placeholder('Contoh: 120 (cm)')
                ])
                ->columns(3),

            Select::make('id_category')
                ->label('Kategori')
                ->relationship('category', 'category_name')
                ->searchable()
                ->preload()
                ->required(),

            Fieldset::make('Varian Produk')
                ->schema([
                    Repeater::make('variants')
                        ->label('Daftar Varian')
                        ->schema([
                            TextInput::make('color')
                                ->label('Warna')
                                ->required()
                                ->placeholder('Contoh: Merah, Biru, Hijau'),

                            TextInput::make('regular_price')
                                ->label('Harga Normal')
                                ->numeric()
                                ->required()
                                ->prefix('Rp'),
                            
                            TextInput::make('price_sale')
                                ->label('Harga Diskon')
                                ->numeric()
                                ->nullable()
                                ->prefix('Rp')
                        ])
                        ->columns(3)
                        ->createItemButtonLabel('Tambah Varian')
                        ->minItems(1)
                        ->defaultItems(1),
                ])
                ->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product_name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.category_name')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('stok')
                    ->label('Stok')
                    ->sortable(),

                TextColumn::make('variants_count')
                    ->label('Jumlah Varian')
                    ->counts('variants'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('id_product', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ])
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}