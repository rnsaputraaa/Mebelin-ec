<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    /**
     * Custom query untuk optimasi loading dengan eager loading
     */
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->with([
                'user',
                'orders',
            ]);
    }
}