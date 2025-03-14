<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserRoleResource\Pages;
use App\Filament\Resources\UserRoleResource\RelationManagers;
use App\Models\UserRole;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserRoleResource extends Resource
{
    protected static ?string $model = UserRole::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function shouldRegisterNavigation(): bool
    {
        return false; // Hides the resource from the menu
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('role_id')
                    ->searchable()
                    ->required()
                    ->options(fn () => RoleResource::getRoleOptions()) // Load first 10 banks
                    ->getSearchResultsUsing(fn (string $search) => RoleResource::getRoleOptions($search)), // Dynamic search
                    Forms\Components\Select::make('status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive'])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('role.name')->sortable()->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'active' => 'success',
                        'inactive' => 'danger',
                    ]),
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
            'index' => Pages\ListUserRoles::route('/'),
            'create' => Pages\CreateUserRole::route('/create'),
            'edit' => Pages\EditUserRole::route('/{record}/edit'),
        ];
    }
}
