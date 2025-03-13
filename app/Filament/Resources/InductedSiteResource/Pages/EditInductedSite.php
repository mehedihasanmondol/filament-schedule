<?php

namespace App\Filament\Resources\InductedSiteResource\Pages;

use App\Filament\Resources\InductedSiteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInductedSite extends EditRecord
{
    protected static string $resource = InductedSiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
