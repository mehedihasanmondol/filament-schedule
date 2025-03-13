<?php

namespace App\Filament\Resources\ComplianceTypeResource\Pages;

use App\Filament\Resources\ComplianceTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListComplianceTypes extends ListRecords
{
    protected static string $resource = ComplianceTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
