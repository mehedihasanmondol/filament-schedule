<?php

namespace App\Filament\Resources\TimeLogResource\Pages;

use Filament\Actions;
use App\Models\TimeLog;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\TimeLogResource;

class CreateTimeLog extends CreateRecord
{
    protected static string $resource = TimeLogResource::class;

}
