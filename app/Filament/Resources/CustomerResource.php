<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\CustomerResource\Pages;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Customer Management';

    protected static ?string $navigationLabel = 'Customers';

    protected static ?string $modelLabel = 'Customer';

    protected static ?string $pluralModelLabel = 'Customers';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('User Account')
                ->description('Data akun login customer')
                ->schema([
                    TextInput::make('username')
                        ->label('Username')
                        ->required()
                        ->unique(User::class, 'username', ignoreRecord: true)
                        ->maxLength(50)
                        ->placeholder('customer123'),

                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->unique(User::class, 'email', ignoreRecord: true)
                        ->maxLength(30)
                        ->placeholder('customer@email.com'),

                    TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->required(fn ($context) => $context === 'create')
                        ->minLength(6)
                        ->placeholder(fn ($context) => $context === 'edit' ? 'Kosongkan jika tidak ingin mengubah password' : 'Minimal 6 karakter')
                        ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                        ->dehydrated(fn ($state) => filled($state)),
                ])
                ->columns(2),

            Section::make('Customer Information')
                ->description('Data personal customer')
                ->schema([
                    TextInput::make('nama_lengkap')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(100),

                    TextInput::make('no_telepon')
                        ->label('No. Telepon')
                        ->tel()
                        ->required()
                        ->maxLength(15)
                        ->placeholder('08123456789'),

                    DatePicker::make('tanggal_lahir')
                        ->label('Tanggal Lahir')
                        ->required()
                        ->maxDate(now()->subYears(13)),

                    FileUpload::make('profil_picture')
                        ->label('Foto Profil (Opsional)')
                        ->image()
                        ->imagePreviewHeight('150')
                        ->maxSize(2048)
                        ->directory('profiles')
                        ->nullable()
                        ->helperText('Upload foto profil customer. Format: JPG, PNG. Maksimal 2MB. Bisa dikosongkan.'),
                ])
                ->columns(2),

            Section::make('Primary Address')
                ->description('Alamat utama customer (akan dibuat otomatis)')
                ->schema([
                    Textarea::make('alamat_lengkap')
                        ->label('Alamat Lengkap')
                        ->required()
                        ->maxLength(120)
                        ->rows(3)
                        ->placeholder('Jl. Contoh No. 123, RT/RW 01/02'),

                    TextInput::make('kota')
                        ->label('Kota/Kabupaten')
                        ->required()
                        ->maxLength(40)
                        ->placeholder('Jakarta Selatan'),

                    TextInput::make('provinsi')
                        ->label('Provinsi')
                        ->required()
                        ->maxLength(20)
                        ->placeholder('DKI Jakarta'),

                    TextInput::make('kode_pos')
                        ->label('Kode Pos')
                        ->required()
                        ->maxLength(20)
                        ->placeholder('12345')
                        ->numeric(),

                    TextInput::make('patokan')
                        ->label('Patokan')
                        ->maxLength(100)
                        ->placeholder('Dekat Masjid, Sebelah Warung, dll'),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->color('info'),

                TextColumn::make('no_telepon')
                    ->label('No. Telepon')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('age')
                    ->label('Umur')
                    ->getStateUsing(function ($record) {
                        return $record->tanggal_lahir ? $record->tanggal_lahir->age . ' tahun' : '-';
                    })
                    ->badge()
                    ->color('secondary'),

                TextColumn::make('orders_count')
                    ->label('Total Order')
                    ->counts('orders')
                    ->badge()
                    ->color('success'),

                TextColumn::make('addresses_count')
                    ->label('Alamat')
                    ->counts('addresses')
                    ->badge()
                    ->color('info'),

                TextColumn::make('created_at')
                    ->label('Registered')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('user_id')
                    ->label('Filter by User')
                    ->relationship('user', 'email')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                ViewAction::make()
                    ->modalContent(fn ($record) => view('filament.modals.customer-detail', ['record' => $record]))
                    ->modalWidth('4xl')
                    ->label('Detail'),

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Customer')
                    ->modalDescription('Apakah Anda yakin ingin menghapus customer ini?')
                    ->visible(fn () => static::isAdmin()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Customer Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus semua customer yang dipilih?')
                        ->visible(fn () => static::isAdmin()),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Customer')
            ->emptyStateDescription('Belum ada customer yang terdaftar.')
            ->emptyStateIcon('heroicon-o-users');
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
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