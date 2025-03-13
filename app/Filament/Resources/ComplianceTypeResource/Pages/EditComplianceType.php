<?php

namespace App\Filament\Resources\ComplianceTypeResource\Pages;

use App\Filament\Resources\ComplianceTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditComplianceType extends EditRecord
{
    protected static string $resource = ComplianceTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
