<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\ProductImage;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ProductImageResource\Pages;

class ProductImageResource extends Resource
{
    protected static ?string $model = ProductImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Product Management';

    protected static ?string $navigationLabel = 'Product Images';

    protected static ?string $modelLabel = 'Product Image';

    protected static ?string $pluralModelLabel = 'Product Images';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('product_id')
                ->label('Produk')
                ->relationship('product', 'product_name')
                ->searchable()
                ->preload()
                ->required()
                ->reactive(),

            FileUpload::make('images')
                ->label('Upload Multiple Gambar')
                ->image()
                ->multiple()
                ->imagePreviewHeight('150')
                ->maxSize(2048)
                ->directory('products')
                ->required()
                ->maxFiles(10)
                ->helperText('Upload maksimal 10 gambar sekaligus. Format: JPG, PNG, WEBP. Maksimal 2MB per file.'),

            Toggle::make('first_picture')
                ->label('Set Gambar Pertama sebagai Utama')
                ->helperText('Centang jika gambar pertama yang diupload jadi gambar utama')
                ->default(true),

            TextInput::make('start_sort')
                ->label('Mulai Urutan dari Angka')
                ->numeric()
                ->default(0)
                ->helperText('Gambar akan diurutkan mulai dari angka ini (0, 1, 2, dst)')
                ->minValue(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('url_gambar')
                    ->label('Preview')
                    ->height(80)
                    ->width(80)
                    ->square()
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->defaultImageUrl(asset('images/no-image.png')),

                TextColumn::make('product.product_name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable()
                    ->limit(25)
                    ->weight('medium')
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 25) {
                            return null;
                        }
                        return $state;
                    }),

                ToggleColumn::make('first_picture')
                    ->label('Gambar Utama')
                    ->sortable()
                    ->beforeStateUpdated(function ($record, $state) {
                        // Jika diset sebagai gambar utama, unset yang lain untuk produk yang sama
                        if ($state) {
                            ProductImage::where('product_id', $record->product_id)
                                ->where('id_product_images', '!=', $record->id_product_images)
                                ->update(['first_picture' => false]);
                        }
                    }),

                TextColumn::make('sort')
                    ->label('Urutan')
                    ->sortable()
                    ->badge()
                    ->color('gray')
                    ->alignCenter(),

                TextColumn::make('url_gambar')
                    ->label('Nama File')
                    ->formatStateUsing(fn ($state) => basename($state))
                    ->limit(20)
                    ->color('info')
                    ->tooltip(function (TextColumn $column): ?string {
                        return basename($column->getState());
                    }),

                TextColumn::make('file_size')
                    ->label('Ukuran File')
                    ->getStateUsing(function ($record) {
                        $path = storage_path('app/public/' . $record->url_gambar);
                        if (file_exists($path)) {
                            $bytes = filesize($path);
                            return self::formatBytes($bytes);
                        }
                        return '-';
                    })
                    ->badge()
                    ->color('secondary'),

                TextColumn::make('created_at')
                    ->label('Upload Date')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('product_id', 'asc')
            ->filters([
                SelectFilter::make('product_id')
                    ->label('Filter Produk')
                    ->relationship('product', 'product_name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('first_picture')
                    ->label('Filter Gambar Utama')
                    ->options([
                        1 => 'Gambar Utama',
                        0 => 'Gambar Biasa',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalContent(fn ($record) => view('filament.modals.image-preview', ['record' => $record]))
                    ->modalWidth('lg')
                    ->label('Preview'),
                    
                Tables\Actions\EditAction::make(),
                
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Gambar Produk')
                    ->modalDescription('Apakah Anda yakin ingin menghapus gambar ini? File akan dihapus dari storage.'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Gambar Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus semua gambar yang dipilih? File akan dihapus dari storage.'),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Gambar')
            ->emptyStateDescription('Upload gambar pertama untuk produk Anda.')
            ->emptyStateIcon('heroicon-o-photo');
    }

    /**
     * Format bytes ke human readable
     */
    private static function formatBytes($bytes, $precision = 2) 
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
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
            'index' => Pages\ListProductImages::route('/'),
            'create' => Pages\CreateProductImage::route('/create'),
            'edit' => Pages\EditProductImage::route('/{record}/edit'),
        ];
    }
}