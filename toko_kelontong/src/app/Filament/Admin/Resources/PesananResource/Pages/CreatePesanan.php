<?php

namespace App\Filament\Admin\Resources\PesananResource\Pages;

use App\Filament\Admin\Resources\PesananResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePesanan extends CreateRecord
{
    protected static string $resource = PesananResource::class;

    protected function afterCreate(): void
    {
        $this->record->update([
            'total' => $this->record->items()->sum('total'),
        ]);
    }
}
