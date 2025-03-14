<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ComplianceResource\Pages\CreateCompliance;
use App\Filament\Resources\ComplianceResource\Pages\EditCompliance;
use App\Filament\Resources\ComplianceResource\Pages\ListCompliances;
use App\Models\Compliance;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Resources\Pages\{ListRecords, CreateRecord, EditRecord};

class ComplianceResource extends Resource
{
    protected static ?string $model = Compliance::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    public static function shouldRegisterNavigation(): bool
    {
        return false; // Hides the resource from the menu
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('compliance_type_id')
                    ->searchable()
                    ->required()
                    ->options(fn () => ComplianceTypeResource::getComplianceTypeOptions()) // Load first 10 banks
                    ->getSearchResultsUsing(fn (string $search) => ComplianceTypeResource::getComplianceTypeOptions($search)), // Dynamic search

                Forms\Components\TextInput::make('certificate_number')->required(),
                Forms\Components\DatePicker::make('expire_date')->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('complianceType.name')->sortable(),
                Tables\Columns\TextColumn::make('certificate_number'),
                Tables\Columns\TextColumn::make('expire_date')->date(),
            ])
            ->filters([])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCompliances::route('/'),
            'create' => CreateCompliance::route('/create'),
            'edit' => EditCompliance::route('/{record}/edit'),
        ];
    }
}
