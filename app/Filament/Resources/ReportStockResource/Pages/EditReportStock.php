<?php

namespace App\Filament\Resources\ReportStockResource\Pages;

use App\Filament\Resources\ReportStockResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportStock extends EditRecord
{
    protected static string $resource = ReportStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Redirect setelah update
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * Notification message
     */
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Laporan stok berhasil diupdate! Stok produk telah diupdate.';
    }
}