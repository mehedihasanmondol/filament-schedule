<?php
namespace App\Filament\Resources;

use App\Filament\Resources\LeaveTypeResource\Pages\CreateLeaveType;
use App\Filament\Resources\LeaveTypeResource\Pages\EditLeaveType;
use App\Filament\Resources\LeaveTypeResource\Pages\ListLeaveTypes;
use App\Models\LeaveType;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Resources\Pages\{ListRecords, CreateRecord, EditRecord};

class LeaveTypeResource extends Resource
{
    protected static ?string $model = LeaveType::class;

    // protected static ?string $navigationIcon = 'heroicon-o-clipboard-check';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\Textarea::make('remarks')->nullable(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('remarks'),
            ])
            ->filters([])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLeaveTypes::route('/'),
            'create' => CreateLeaveType::route('/create'),
            'edit' => EditLeaveType::route('/{record}/edit'),
        ];
    }
}
