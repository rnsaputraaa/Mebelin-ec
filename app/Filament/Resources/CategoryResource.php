<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\CategoryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Filament\Resources\CategoryResource\Pages\EditCategory;
use App\Filament\Resources\CategoryResource\Pages\CreateCategory;
use App\Filament\Resources\CategoryResource\Pages\ListCategories;
use Illuminate\Support\Str;


class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Product Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
                    TextInput::make('category_name')
            ->label('Nama Kategori')
            ->required()
            ->maxLength(100)
            ->reactive() // Penting agar perubahan terdeteksi
            ->afterStateUpdated(fn (callable $set, ?string $state) =>
                $set('slug', Str::slug($state))
            ),

            TextInput::make('slug')
                ->label('Slug')
                ->helperText('Kosongkan untuk mengisi otomatis.')
                ->maxLength(100)
                ->disabled()
                ->dehydrated(),


            Textarea::make('description')
                ->label('Deskripsi')
                ->maxLength(255)
                ->rows(3),

            FileUpload::make('img')
                ->label('Gambar Kategori')
                ->image()
                ->imagePreviewHeight('150')
                ->maxSize(2048)
                ->directory('categories')
                ->helperText('Format: JPG, PNG. Maks 2MB.'),
        ]);
    }

     public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category_name')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->toggleable(),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->toggleable(),
            ])
            ->defaultSort('id_category', 'desc');
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}