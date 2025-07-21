<?php

namespace App\Filament\Resources\OrdersResource\Pages;

use App\Filament\Resources\OrdersResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrdersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->color('warning'),
                
            Actions\Action::make('view_items')
                ->label('View Order Items')
                ->icon('heroicon-o-list-bullet')
                ->color('primary')
                ->url(fn (): string => route('filament.admin.resources.order-items.index', ['tableFilters[id_order][values][0]' => $this->record->id_order])),

            Actions\Action::make('add_item')
                ->label('Add Item')
                ->icon('heroicon-o-plus')
                ->color('success')
                ->url(fn (): string => route('filament.admin.resources.order-items.create', ['id_order' => $this->record->id_order]))
                ->visible(fn () => in_array($this->record->status_order, ['pending', 'processing'])),

            Actions\Action::make('change_status')
                ->label('Change Status')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->form([
                    \Filament\Forms\Components\Select::make('new_status')
                        ->label('Status Baru')
                        ->options([
                            'pending' => 'Pending',
                            'processing' => 'Processing',
                            'shipped' => 'Shipped',
                            'delivered' => 'Delivered',
                            'cancelled' => 'Cancelled',
                        ])
                        ->required()
                        ->default($this->record->status_order),
                    \Filament\Forms\Components\Textarea::make('status_note')
                        ->label('Catatan Perubahan Status')
                        ->rows(3)
                        ->placeholder('Alasan perubahan status...'),
                ])
                ->action(function (array $data) {
                    $oldStatus = $this->record->status_order;
                    $this->record->updateStatus($data['new_status'], $data['status_note']);
                    
                    \Filament\Notifications\Notification::make()
                        ->title('Status Berhasil Diubah!')
                        ->body("Status order {$this->record->order_number} berhasil diubah dari {$oldStatus} ke {$data['new_status']}")
                        ->success()
                        ->send();
                }),

            Actions\DeleteAction::make()
                ->requiresConfirmation(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Order Information')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('order_number')
                                    ->label('Order Number')
                                    ->icon('heroicon-m-hashtag')
                                    ->copyable()
                                    ->weight('bold')
                                    ->color('primary'),
                                
                                TextEntry::make('status_order')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'pending' => 'gray',
                                        'processing' => 'warning',
                                        'shipped' => 'info',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger',
                                        default => 'gray',
                                    }),
                                
                                TextEntry::make('tanggal_order')
                                    ->label('Order Date')
                                    ->date('d F Y')
                                    ->icon('heroicon-m-calendar'),
                            ]),
                    ]),

                Section::make('Customer Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('customer.nama_lengkap')
                                    ->label('Customer Name')
                                    ->icon('heroicon-m-user')
                                    ->copyable()
                                    ->weight('bold'),
                                
                                TextEntry::make('customer.user.email')
                                    ->label('Email')
                                    ->icon('heroicon-m-envelope')
                                    ->copyable()
                                    ->color('info'),
                                
                                TextEntry::make('customer.no_telepon')
                                    ->label('Phone Number')
                                    ->icon('heroicon-m-phone')
                                    ->copyable(),
                                
                                TextEntry::make('customer.tanggal_lahir')
                                    ->label('Birth Date')
                                    ->date('d F Y')
                                    ->icon('heroicon-m-cake'),
                            ]),
                    ]),

                Section::make('Order Summary')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextEntry::make('total_items')
                                    ->label('Total Items')
                                    ->getStateUsing(fn ($record) => $record->orderItems->count())
                                    ->badge()
                                    ->color('info'),
                                
                                TextEntry::make('total_quantity')
                                    ->label('Total Quantity')
                                    ->getStateUsing(fn ($record) => $record->orderItems->sum('total'))
                                    ->badge()
                                    ->color('warning'),
                                
                                TextEntry::make('total_harga')
                                    ->label('Total Amount')
                                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                                    ->weight('bold')
                                    ->color('success'),
                                
                                IconEntry::make('expired_status')
                                    ->label('Expired Status')
                                    ->getStateUsing(fn ($record) => !$record->isExpired())
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('danger'),
                            ]),
                    ]),

                Section::make('Order Items')
                    ->schema([
                        RepeatableEntry::make('orderItems')
                            ->label('')
                            ->schema([
                                Grid::make(5)
                                    ->schema([
                                        TextEntry::make('product.product_name')
                                            ->label('Product')
                                            ->weight('medium')
                                            ->limit(30),
                                        
                                        TextEntry::make('product.category.category_name')
                                            ->label('Category')
                                            ->badge()
                                            ->color('info'),
                                        
                                        TextEntry::make('total')
                                            ->label('Qty')
                                            ->badge()
                                            ->color('secondary'),
                                        
                                        TextEntry::make('unit_price')
                                            ->label('Unit Price')
                                            ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                                        
                                        TextEntry::make('subtotal')
                                            ->label('Subtotal')
                                            ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                                            ->weight('bold')
                                            ->color('success'),
                                    ]),
                            ])
                            ->contained(false),
                    ])
                    ->collapsible(),

                Section::make('Additional Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('expired_at')
                                    ->label('Expires At')
                                    ->dateTime('d F Y, H:i')
                                    ->placeholder('No expiration date')
                                    ->icon('heroicon-m-clock')
                                    ->color(fn ($record) => $record->isExpired() ? 'danger' : 'gray'),
                                
                                TextEntry::make('created_at')
                                    ->label('Created At')
                                    ->dateTime('d F Y, H:i')
                                    ->icon('heroicon-m-calendar')
                                    ->since(),
                            ]),
                        
                        TextEntry::make('catatan')
                            ->label('Notes')
                            ->placeholder('No notes')
                            ->columnSpanFull()
                            ->prose(),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('Customer Address')
                    ->schema([
                        TextEntry::make('customer.primaryAddress.alamat_lengkap')
                            ->label('Full Address')
                            ->placeholder('No primary address')
                            ->icon('heroicon-m-map-pin')
                            ->columnSpanFull(),
                        
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('customer.primaryAddress.kota')
                                    ->label('City')
                                    ->placeholder('-')
                                    ->badge()
                                    ->color('info'),
                                
                                TextEntry::make('customer.primaryAddress.provinsi')
                                    ->label('Province')
                                    ->placeholder('-')
                                    ->badge()
                                    ->color('success'),
                                
                                TextEntry::make('customer.primaryAddress.kode_pos')
                                    ->label('Postal Code')
                                    ->placeholder('-')
                                    ->badge()
                                    ->color('gray'),
                            ]),
                        
                        TextEntry::make('customer.primaryAddress.patokan')
                            ->label('Landmarks')
                            ->placeholder('No landmarks')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('Order Timeline')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Order Created')
                                    ->dateTime('d F Y, H:i:s')
                                    ->since()
                                    ->icon('heroicon-m-plus-circle')
                                    ->color('success'),
                                
                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime('d F Y, H:i:s')
                                    ->since()
                                    ->icon('heroicon-m-pencil-square')
                                    ->color('warning'),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    /**
     * Custom page title
     */
    public function getTitle(): string
    {
        return "Order: {$this->record->order_number}";
    }

    /**
     * Custom subheading
     */
    public function getSubheading(): ?string
    {
        return "Customer: {$this->record->customer->nama_lengkap} | Status: {$this->record->formatted_status} | Total: Rp " . number_format($this->record->total_harga, 0, ',', '.');
    }
}