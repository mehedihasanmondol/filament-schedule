<?php

namespace App\Filament\Resources\TimeLogResource\Pages;

use App\Models\TimeLog;
use Filament\Tables\Table;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\TimeLogResource;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
class TimesheetReport extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = TimeLogResource::class;

    protected static string $view = 'filament.resources.time-log-resource.pages.timesheet-report';


    public function getTableRecordKey(Model $record): string
    {
        return $record->user_id;
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(
                TimeLog::query()
                    ->selectRaw('user_id, SUM(hours_worked) as total_hours, SUM(total_payable) as total_amount, COUNT(*) as shifts')
                    ->groupBy('user_id')
                    ->with('user')
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label('Security Guard')
                    ->sortable(),
                TextColumn::make('total_hours')
                    ->label('Total Hours')
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->money(get_site_setting('currency','USD'))
                    ->sortable(),
                TextColumn::make('shifts')
                    ->label('Total Shifts')
                    ->sortable(),
            ]);
    }
}