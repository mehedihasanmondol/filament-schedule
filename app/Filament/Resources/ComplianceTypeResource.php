<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ComplianceTypeResource\Pages\CreateComplianceType;
use App\Filament\Resources\ComplianceTypeResource\Pages\EditComplianceType;
use App\Filament\Resources\ComplianceTypeResource\Pages\ListComplianceTypes;
use App\Models\ComplianceType;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Resources\Pages\{ListRecords, CreateRecord, EditRecord};

class ComplianceTypeResource extends Resource
{
    protected static ?string $model = ComplianceType::class;
    // protected static ?string $navigationIcon = 'heroicon-o-clipboard-check';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('remarks')->nullable(),
                Forms\Components\Toggle::make('is_required')
                    ->label('Is Required?')
                    ->default(true),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('remarks'),
                Tables\Columns\BooleanColumn::make('is_required')
                    ->label('Required'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListComplianceTypes::route('/'),
            'create' => CreateComplianceType::route('/create'),
            'edit' => EditComplianceType::route('/{record}/edit'),
        ];
    }
}
