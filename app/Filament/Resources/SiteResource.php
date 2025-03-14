<?php
namespace App\Filament\Resources;

use App\Filament\Resources\SiteResource\Pages\CreateSite;
use App\Filament\Resources\SiteResource\Pages\EditSite;
use App\Filament\Resources\SiteResource\Pages\ListSites;
use App\Models\Site;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Resources\Pages\{ListRecords, CreateRecord, EditRecord};

class SiteResource extends Resource
{
    protected static ?string $model = Site::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('contact_name')->required(),
                Forms\Components\TextInput::make('contact_number')->required(),
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive'])
                    ->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('contact_name'),
                Tables\Columns\TextColumn::make('contact_number'),
                Tables\Columns\TextColumn::make('client.name'),
                Tables\Columns\BadgeColumn::make('status')->colors([
                    'active' => 'success',
                    'inactive' => 'danger',
                ]),
            ])
            ->filters([])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSites::route('/'),
            'create' => CreateSite::route('/create'),
            'edit' => EditSite::route('/{record}/edit'),
        ];
    }
    public static function getSiteOptions($search = null): array
    {
        // Apply search condition only if the search term is provided
        $query = Site::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Fetch up to 10 results regardless of search, but apply the search filter if it exists
        return $query->limit(10)
            ->pluck('name', 'id')
            ->toArray();
    }
}
