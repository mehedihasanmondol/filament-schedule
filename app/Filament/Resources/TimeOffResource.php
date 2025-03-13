<?php
namespace App\Filament\Resources;

use App\Filament\Resources\TimeOffResource\Pages\CreateTimeOff;
use App\Filament\Resources\TimeOffResource\Pages\EditTimeOff;
use App\Filament\Resources\TimeOffResource\Pages\ListTimeOffs;
use App\Models\TimeOff;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Resources\Pages\{ListRecords, CreateRecord, EditRecord};

class TimeOffResource extends Resource
{
    protected static ?string $model = TimeOff::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('start_date')->required(),
                Forms\Components\DatePicker::make('end_date')->required(),
                Forms\Components\Select::make('leave_type_id')
                    ->searchable()
                    ->required()
                    ->options(fn () => LeaveTypeResource::getLeaveTypeOptions()) // Load first 10 banks
                    ->getSearchResultsUsing(fn (string $search) => LeaveTypeResource::getLeaveTypeOptions($search)), // Dynamic search

                Forms\Components\Select::make('status_id')
                    ->searchable()
                    ->required()
                    ->options(fn () => LeaveStatusResource::getLeaveStatusOptions()) // Load first 10 banks
                    ->getSearchResultsUsing(fn (string $search) => LeaveStatusResource::getLeaveStatusOptions($search)), // Dynamic search

                Forms\Components\Textarea::make('remarks')->nullable(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('start_date')->sortable(),
                Tables\Columns\TextColumn::make('end_date')->sortable(),
                Tables\Columns\TextColumn::make('leaveType.name')->sortable(),
                Tables\Columns\BadgeColumn::make('status.name')->colors([
                    'Pending' => 'warning',
                    'Approved' => 'success',
                    'Rejected' => 'danger',
                ]),
            ])
            ->filters([])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTimeOffs::route('/'),
            'create' => CreateTimeOff::route('/create'),
            'edit' => EditTimeOff::route('/{record}/edit'),
        ];
    }
}
