<?php

namespace App\Filament\Resources\InductedSiteResource\Pages;

use App\Filament\Resources\InductedSiteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInductedSites extends ListRecords
{
    protected static string $resource = InductedSiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
