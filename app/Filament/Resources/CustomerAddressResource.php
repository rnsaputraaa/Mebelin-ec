<?php

namespace App\Filament\Resources;

use App\Models\CustomerAddress;
use App\Models\Customer;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\Grid;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CustomerAddressResource\Pages;

class CustomerAddressResource extends Resource
{
    protected static ?string $model = CustomerAddress::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationGroup = 'Customer Management';
    protected static ?string $navigationLabel = 'Customer Addresses';
    protected static ?string $modelLabel = 'Customer Address';
    protected static ?string $pluralModelLabel = 'Customer Addresses';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Informasi Customer')
                ->description('Pilih customer yang akan ditambahkan alamatnya')
                ->schema([
                    Select::make('id_customer')
                        ->label('Customer')
                        ->relationship('customer', 'nama_lengkap')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->placeholder('Pilih customer...')
                        ->createOptionForm([
                            TextInput::make('nama_lengkap')
                                ->label('Nama Lengkap')
                                ->required(),
                            TextInput::make('no_telepon')
                                ->label('No. Telepon')
                                ->tel()
                                ->required(),
                        ])
                        ->helperText('Jika customer belum ada, Anda bisa menambahkan customer baru'),
                ])->columns(1),

            Section::make('Detail Alamat')
                ->description('Masukkan detail alamat lengkap customer')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Textarea::make('alamat_lengkap')
                                ->label('Alamat Lengkap')
                                ->required()
                                ->maxLength(120)
                                ->rows(3)
                                ->placeholder('Contoh: Jl. Merdeka No. 123, RT 01/RW 02')
                                ->columnSpanFull(),

                            TextInput::make('kota')
                                ->label('Kota')
                                ->required()
                                ->maxLength(40)
                                ->placeholder('Contoh: Surabaya'),

                            TextInput::make('provinsi')
                                ->label('Provinsi')
                                ->required()
                                ->maxLength(20)
                                ->placeholder('Contoh: Jawa Timur'),

                            TextInput::make('kode_pos')
                                ->label('Kode Pos')
                                ->required()
                                ->maxLength(20)
                                ->numeric()
                                ->placeholder('Contoh: 60123'),

                            TextInput::make('patokan')
                                ->label('Patokan')
                                ->maxLength(100)
                                ->placeholder('Contoh: Dekat Masjid Al-Ikhlas, Sebelah Warung Bu Tini')
                                ->columnSpanFull(),
                        ]),
                ]),

            Section::make('Pengaturan Alamat')
                ->description('Atur status alamat ini')
                ->schema([
                    Toggle::make('alamat_utama')
                        ->label('Jadikan Alamat Utama')
                        ->helperText('Centang jika ini adalah alamat utama customer. Alamat utama lainnya akan otomatis dinonaktifkan.')
                        ->default(false),
                ])->columns(1),
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
                    ->weight('medium')
                    ->copyable()
                    ->copyMessage('Nama customer berhasil disalin!')
                    ->icon('heroicon-m-user'),

                TextColumn::make('alamat_lengkap')
                    ->label('Alamat')
                    ->limit(50)
                    ->wrap()
                    ->searchable()
                    ->tooltip(function (CustomerAddress $record): string {
                        return $record->alamat_lengkap;
                    }),

                TextColumn::make('kota')
                    ->label('Kota')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('provinsi')
                    ->label('Provinsi')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('kode_pos')
                    ->label('Kode Pos')
                    ->badge()
                    ->color('gray')
                    ->toggleable(),

                IconColumn::make('alamat_utama')
                    ->label('Alamat Utama')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark')
                    ->trueColor('success')
                    ->falseColor('gray'),

                TextColumn::make('patokan')
                    ->label('Patokan')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('customer.no_telepon')
                    ->label('No. Telepon')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->copyable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('id_customer')
                    ->label('Filter Customer')
                    ->relationship('customer', 'nama_lengkap')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                SelectFilter::make('kota')
                    ->label('Filter Kota')
                    ->options(function () {
                        return CustomerAddress::distinct()
                            ->pluck('kota', 'kota')
                            ->toArray();
                    })
                    ->searchable(),

                SelectFilter::make('provinsi')
                    ->label('Filter Provinsi')
                    ->options(function () {
                        return CustomerAddress::distinct()
                            ->pluck('provinsi', 'provinsi')
                            ->toArray();
                    })
                    ->searchable(),

                Filter::make('alamat_utama')
                    ->label('Hanya Alamat Utama')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('alamat_utama', true)),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->color('info'),
                    
                    Tables\Actions\EditAction::make()
                        ->color('warning'),
                    
                    Action::make('set_primary')
                        ->label('Jadikan Utama')
                        ->icon('heroicon-o-star')
                        ->color('success')
                        ->visible(fn (CustomerAddress $record) => !$record->alamat_utama)
                        ->requiresConfirmation()
                        ->modalHeading('Jadikan Alamat Utama')
                        ->modalDescription('Apakah Anda yakin ingin menjadikan alamat ini sebagai alamat utama? Alamat utama lainnya akan dinonaktifkan.')
                        ->action(function (CustomerAddress $record) {
                            // Set semua alamat customer lain menjadi bukan utama
                            CustomerAddress::where('id_customer', $record->id_customer)
                                ->where('id_customer_addresses', '!=', $record->id_customer_addresses)
                                ->update(['alamat_utama' => false]);
                            
                            // Set alamat ini menjadi utama
                            $record->update(['alamat_utama' => true]);
                            
                            Notification::make()
                                ->title('Berhasil!')
                                ->body('Alamat berhasil dijadikan alamat utama.')
                                ->success()
                                ->send();
                        }),
                    
                    Tables\Actions\DeleteAction::make()
                        ->color('danger'),
                ])
                ->label('Actions')
                ->icon('heroicon-m-ellipsis-vertical')
                ->size('sm')
                ->color('gray')
                ->button(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Alamat Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus alamat yang dipilih? Tindakan ini tidak dapat dibatalkan.'),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Alamat Customer')
                    ->icon('heroicon-m-plus'),
            ])
            ->poll('30s') // Auto refresh setiap 30 detik
            ->striped();
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomerAddresses::route('/'),
            'create' => Pages\CreateCustomerAddress::route('/create'),
            'view' => Pages\ViewCustomerAddress::route('/{record}'),
            'edit' => Pages\EditCustomerAddress::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'customer.nama_lengkap',
            'alamat_lengkap',
            'kota',
            'provinsi',
            'kode_pos',
            'patokan'
        ];
    }
}