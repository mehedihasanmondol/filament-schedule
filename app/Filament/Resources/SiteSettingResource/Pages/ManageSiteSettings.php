<?php

namespace App\Filament\Resources\SiteSettingResource\Pages;

use App\Models\SiteSetting;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\SiteSettingResource;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
class ManageSiteSettings extends Page
{
    protected static string $resource = SiteSettingResource::class;

    protected static string $view = 'filament.resources.site-setting-resource.pages.manage-site-settings';


    public ?Model $record = null;
    public ?array $data = [];

    public function mount(): void
    {
        $this->record = SiteSetting::firstOrCreate(
            [],
            [
                'site_name' => 'Schedule management system',
                'contact_email' => 'admin@example.com',
                'contact_phone' => '1234567890',
                'currency' => 'USD',
                'address' => '',
            ]
        );
        $this->form->fill($this->record->toArray());
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $this->record->update($data);

        Notification::make()
            ->success()
            ->title('Site settings updated successfully!')
            ->send();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getFormSchema())->columns(2)
            ->statePath('data')
            ->model($this->record);
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('site_name')->required(),
            TextInput::make('contact_email')->email()->required(),
            TextInput::make('contact_phone')->required(),
            Textarea::make('address')->rows(3),
            TextInput::make('currency')->required(),
            FileUpload::make('site_logo')->image()->directory('site-settings'),
            FileUpload::make('site_favicon')->image()->directory('site-settings'),
        ];
    }

}
