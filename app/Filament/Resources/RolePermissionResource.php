<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Role;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Permission;
use Filament\Tables\Table;
use App\Models\RolePermission;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RolePermissionResource\Pages;
use App\Filament\Resources\RolePermissionResource\RelationManagers;

class RolePermissionResource extends Resource
{
    protected static ?string $model = RolePermission::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('role_id')
                    ->searchable()
                    ->required()
                    ->options(fn () => RoleResource::getRoleOptions()) // Load first 10 banks
                    ->getSearchResultsUsing(fn (string $search) => RoleResource::getRoleOptions($search)), // Dynamic search



            Forms\Components\Select::make('permission_id')
                    ->searchable()
                    ->required()
                    ->options(fn () => PermissionResource::getPermissionOptions()) // Load first 10 banks
                    ->getSearchResultsUsing(fn (string $search) => PermissionResource::getPermissionOptions($search)), // Dynamic search



        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('permission.name')->label('Permission'),
                TextColumn::make('role.name')->label('Role'),
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
            'index' => Pages\ListRolePermissions::route('/'),
            'create' => Pages\CreateRolePermission::route('/create'),
            'edit' => Pages\EditRolePermission::route('/{record}/edit'),
        ];
    }
}
