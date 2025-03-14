<?php

namespace App\Filament\Resources\PermissionResource\Pages;

use Filament\Actions;
use App\Models\Permission;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use App\Models\PermissionCategory;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PermissionResource;

class ListPermissions extends ListRecords
{
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Custom action button
            Action::make('updatePermissions') // Unique identifier
                ->label('Update Permissions') // Label for the button
                ->color('gray') // Button variant
                ->icon('heroicon-o-play') // Optional icon
                ->action('executeCustomMethod'), // The method to call on click
            Actions\CreateAction::make(),

        ];
    }
    /**
     * Custom method that will be triggered by the button.
     */
    public function executeCustomMethod()
    {
        $resources = Filament::getResources(); // Get all Filament resources

        foreach ($resources as $resource) {
            // Get the name of the resource (usually the model name)
            $resourceName = class_basename($resource);
            $navigationName = $resource::getNavigationLabel();

            // Generate a slug from the resource name, removing the word "resource"
            $slug = $resourceName;

            // Check if the category exists, if not, create it
            $category = PermissionCategory::firstOrCreate(
                ['slug' => $slug], // Search by slug
                ['name' => $navigationName] // Set name if it does not exist
            );
            $actions = $resource::getPages(); // Get the pages of the resource
            foreach ($actions as $action => $endpoint) {
                // Generate a slug from the action name
                $actionSlug = $action;
                // Check if the category exists, if not, create it
                Permission::firstOrCreate(
                    ['slug' => $slug.':'.$actionSlug], // Search by slug
                    [
                        'name' => $action,
                        'category_id' => $category->id
                    ]
                );
            }
        }

    }
}
