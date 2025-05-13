<?php

namespace App\Filament\Admin\Resources\CategoryProductResource\Pages;

use App\Filament\Admin\Resources\CategoryProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategoryProduct extends EditRecord
{
    protected static string $resource = CategoryProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
