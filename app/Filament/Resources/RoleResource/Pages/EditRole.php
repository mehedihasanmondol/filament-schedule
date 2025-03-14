<?php

namespace App\Filament\Resources\RoleResource\Pages;

use Filament\Forms;
use Filament\Actions;
use Forms\Components\TextInput;
use App\Models\PermissionCategory;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Section;
use App\Filament\Resources\RoleResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Resources\PermissionResource;
use App\Filament\Resources\PermissionCategoryResource;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([

                Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('Permissions')
                    ->schema(function () {
                        $sections = [];
                        foreach (PermissionCategoryResource::getPermissionCategoryOptions() as $categoryId => $categoryName) {

                            $sections[] = Section::make($categoryName)
                                ->schema([
                                    CheckboxList::make("permissions_{$categoryId}") // Unique field name for each section
                                        ->label("")
                                        ->relationship('permissions', 'name',
                                            modifyQueryUsing: fn (Builder $query) => $query->where("category_id", $categoryId)
                                        )
                                        ->columns(4)
                                        ->bulkToggleable(),
                                ]);
                        }
                        return $sections;
                    }),


                    Tabs\Tab::make('Basic')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('remarks')->nullable(),
                        ]),



                ])

            ])->columns(1);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
