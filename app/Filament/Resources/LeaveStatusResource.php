<?php
namespace App\Filament\Resources;

use App\Filament\Resources\LeaveStatusResource\Pages\CreateLeaveStatus;
use App\Filament\Resources\LeaveStatusResource\Pages\EditLeaveStatus;
use App\Filament\Resources\LeaveStatusResource\Pages\ListLeaveStatuses;
use App\Models\LeaveStatus;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Resources\Pages\{ListRecords, CreateRecord, EditRecord};

class LeaveStatusResource extends Resource
{
    protected static ?string $model = LeaveStatus::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'Settings';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\ColorPicker::make('color')->required(),
                Forms\Components\Textarea::make('remarks')->nullable(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\ColorColumn::make('color'),
                Tables\Columns\TextColumn::make('remarks'),
            ])
            ->filters([])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLeaveStatuses::route('/'),
            'create' => CreateLeaveStatus::route('/create'),
            'edit' => EditLeaveStatus::route('/{record}/edit'),
        ];
    }

    public static function getLeaveStatusOptions($search = null): array
    {
        // Apply search condition only if the search term is provided
        $query = LeaveStatus::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Fetch up to 10 results regardless of search, but apply the search filter if it exists
        return $query->limit(10)
            ->pluck('name', 'id')
            ->toArray();
    }

}
