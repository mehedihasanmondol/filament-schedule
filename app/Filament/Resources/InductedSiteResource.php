<?php
namespace App\Filament\Resources;

use App\Filament\Resources\InductedSiteResource\Pages\CreateInductedSite;
use App\Filament\Resources\InductedSiteResource\Pages\EditInductedSite;
use App\Filament\Resources\InductedSiteResource\Pages\ListInductedSites;
use App\Models\InductedSite;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Resources\Pages\{ListRecords, CreateRecord, EditRecord};

class InductedSiteResource extends Resource
{
    protected static ?string $model = InductedSite::class;
    protected static ?string $navigationIcon = 'heroicon-o-map';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('site_id')
                    ->searchable()
                    ->required()
                    ->options(fn () => SiteResource::getSiteOptions()) // Load first 10 banks
                    ->getSearchResultsUsing(fn (string $search) => SiteResource::getSiteOptions($search)), // Dynamic search

                    Forms\Components\DatePicker::make('induction_date')->required(),
                Forms\Components\Textarea::make('remarks')->nullable(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('site.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('induction_date')->date(),
                Tables\Columns\TextColumn::make('remarks'),
            ])
            ->filters([])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInductedSites::route('/'),
            'create' => CreateInductedSite::route('/create'),
            'edit' => EditInductedSite::route('/{record}/edit'),
        ];
    }

}
