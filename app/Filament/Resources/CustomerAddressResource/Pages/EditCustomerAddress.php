<?php

namespace App\Filament\Resources\CustomerAddressResource\Pages;

use App\Filament\Resources\CustomerAddressResource;
use App\Models\CustomerAddress;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
use Filament\Notifications\Notification;

class EditCustomerAddress extends EditRecord
{
    protected static string $resource = CustomerAddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->color('info'),
            
            Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Hapus Alamat Customer')
                ->modalDescription('Apakah Anda yakin ingin menghapus alamat ini? Tindakan ini tidak dapat dibatalkan.'),
                
            Actions\Action::make('duplicate')
                ->label('Duplikat Alamat')
                ->icon('heroicon-o-document-duplicate')
                ->color('gray')
                ->requiresConfirmation()
                ->modalHeading('Duplikat Alamat')
                ->modalDescription('Apakah Anda ingin membuat duplikat dari alamat ini?')
                ->action(function () {
                    $newAddress = $this->record->replicate();
                    $newAddress->alamat_utama = false; // Duplikat tidak boleh jadi alamat utama
                    $newAddress->save();
                    
                    Notification::make()
                        ->title('Alamat Berhasil Diduplikat!')
                        ->body('Alamat baru telah dibuat berdasarkan alamat ini.')
                        ->success()
                        ->send();
                        
                    return redirect($this->getResource()::getUrl('edit', ['record' => $newAddress]));
                }),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Alamat customer berhasil diperbarui!';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Jika alamat ini dijadikan utama, set alamat lain menjadi tidak utama
        if ($data['alamat_utama'] && !$this->record->alamat_utama) {
            CustomerAddress::where('id_customer', $data['id_customer'])
                ->where('id_customer_addresses', '!=', $this->record->id_customer_addresses)
                ->update(['alamat_utama' => false]);
        }

        return $data;
    }

    protected function afterSave(): void
    {
        $customer = $this->record->customer;
        
        Notification::make()
            ->title('Alamat Berhasil Diperbarui!')
            ->body("Alamat untuk customer {$customer->nama_lengkap} telah berhasil diperbarui.")
            ->success()
            ->duration(5000)
            ->send();
    }
}