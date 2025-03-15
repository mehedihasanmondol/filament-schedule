<?php

namespace App\Filament\Resources\TimeLogResource\Pages;

use Filament\Tables\Table;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\TimeLogResource;

class ReportTimeLogs extends Page
{
    protected static string $resource = TimeLogResource::class;

    protected static string $view = 'filament.resources.time-log-resource.pages.report-time-logs';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                static::getResource()::getModel()::query()
                    ->selectRaw('user_id, SUM(hours_worked) as total_hours, SUM(total_payable) as total_amount, COUNT(*) as shifts')
                    ->groupBy('user_id')
                    ->with('user')
            )
            ->columns([
                TextColumn::make('user.name')->label('Security Guard')->sortable(),
                TextColumn::make('total_hours')->label('Total Hours')->sortable(),
                TextColumn::make('total_amount')->label('Total Amount')->money(get_site_setting('currency','USD')),
                TextColumn::make('shifts')->label('Total Shifts')->sortable(),
            ]);
    }
}