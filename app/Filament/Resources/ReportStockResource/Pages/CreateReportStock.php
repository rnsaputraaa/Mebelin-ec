<?php

namespace App\Filament\Resources\ReportStockResource\Pages;

use App\Filament\Resources\ReportStockResource;
use Filament\Resources\Pages\CreateRecord;

class CreateReportStock extends CreateRecord
{
    protected static string $resource = ReportStockResource::class;

    /**
     * Redirect ke halaman index setelah berhasil
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * Notification message
     */
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Laporan stok berhasil dicatat! Stok produk telah diupdate.';
    }
}