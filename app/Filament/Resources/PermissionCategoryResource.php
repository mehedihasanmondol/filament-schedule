<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use App\Models\PermissionCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PermissionCategoryResource\Pages;
use App\Filament\Resources\PermissionCategoryResource\RelationManagers;

class PermissionCategoryResource extends Resource
{
    protected static ?string $model = PermissionCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->unique()->label('Category Name')
            ->live(onBlur:true) // Make this field reactive to trigger changes on the slug field
                ->afterStateUpdated(function ($operation, $state, callable $set) {
                    if ($operation === 'edit') return; // Skip if the operation is edit

                    // Automatically generate the slug from the name
                    $slug = Str::slug($state);
                    $set('slug', $slug); // Set the slug field
                }),
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

    public static function getPermissionCategoryOptions($search = null, $limit = null): array
    {
        $query = PermissionCategory::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($limit) {
            $query->limit($limit);
        }

        return $query->pluck('name', 'id')
            ->toArray();
    }
}
