<?php

namespace App\Filament\Admin\Resources\CategoryProductResource\Pages;

use App\Filament\Admin\Resources\CategoryProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategoryProduct extends CreateRecord
{
    protected static string $resource = CategoryProductResource::class;
}
