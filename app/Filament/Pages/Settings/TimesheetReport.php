<?php

namespace App\Filament\Pages\Settings;

use Filament\Tables\Table;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Columns\TextColumn;
use App\Models\TimeLog;
use Illuminate\Database\Eloquent\Model;

class TimesheetReport extends Page implements \Filament\Tables\Contracts\HasTable
{
    use InteractsWithTable;

    protected static ?string $slug = 'settings/timesheet-report';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    // protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Timesheet Report';

    protected static string $view = 'filament.pages.settings.timesheet-report';

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