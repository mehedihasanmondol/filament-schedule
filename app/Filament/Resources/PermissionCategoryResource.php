<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermissionCategoryResource\Pages;
use App\Filament\Resources\PermissionCategoryResource\RelationManagers;
use App\Models\PermissionCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PermissionCategoryResource extends Resource
{
    protected static ?string $model = PermissionCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->unique()->label('Category Name'),
            Forms\Components\TextInput::make('slug')->required()->unique()->label('Slug'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Category Name'),
                Tables\Columns\TextColumn::make('slug')->label('Slug'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPermissionCategories::route('/'),
            'create' => Pages\CreatePermissionCategory::route('/create'),
            'edit' => Pages\EditPermissionCategory::route('/{record}/edit'),
        ];
    }

    public static function getPermissionCategoryOptions($search = null): array
    {
        // Apply search condition only if the search term is provided
        $query = PermissionCategory::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Fetch up to 10 results regardless of search, but apply the search filter if it exists
        return $query->limit(10)
            ->pluck('name', 'id')
            ->toArray();
    }
}
