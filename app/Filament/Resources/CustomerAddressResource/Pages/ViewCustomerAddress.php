<?php

namespace App\Filament\Resources\CustomerAddressResource\Pages;

use App\Filament\Resources\CustomerAddressResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;

class ViewCustomerAddress extends ViewRecord
{
    protected static string $resource = CustomerAddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->color('warning'),
            Actions\DeleteAction::make()
                ->requiresConfirmation(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informasi Customer')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('customer.nama_lengkap')
                                    ->label('Nama Customer')
                                    ->icon('heroicon-m-user')
                                    ->copyable()
                                    ->weight('bold'),
                                
                                TextEntry::make('customer.no_telepon')
                                    ->label('No. Telepon')
                                    ->icon('heroicon-m-phone')
                                    ->copyable(),
                            ]),
                    ]),

                Section::make('Detail Alamat')
                    ->schema([
                        TextEntry::make('alamat_lengkap')
                            ->label('Alamat Lengkap')
                            ->icon('heroicon-m-map-pin')
                            ->columnSpanFull(),
                            
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('kota')
                                    ->label('Kota')
                                    ->badge()
                                    ->color('info'),
                                
                                TextEntry::make('provinsi')
                                    ->label('Provinsi')
                                    ->badge()
                                    ->color('success'),
                                
                                TextEntry::make('kode_pos')
                                    ->label('Kode Pos')
                                    ->badge()
                                    ->color('gray'),
                            ]),
                            
                        TextEntry::make('patokan')
                            ->label('Patokan')
                            ->placeholder('Tidak ada patokan')
                            ->icon('heroicon-m-map')
                            ->columnSpanFull(),
                    ]),

                Section::make('Status & Informasi Tambahan')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                IconEntry::make('alamat_utama')
                                    ->label('Status Alamat Utama')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-badge')
                                    ->falseIcon('heroicon-o-x-mark')
                                    ->trueColor('success')
                                    ->falseColor('gray'),
                                
                                TextEntry::make('created_at')
                                    ->label('Dibuat Pada')
                                    ->dateTime('d F Y, H:i')
                                    ->icon('heroicon-m-calendar'),
                            ]),
                    ]),
            ]);
    }
}