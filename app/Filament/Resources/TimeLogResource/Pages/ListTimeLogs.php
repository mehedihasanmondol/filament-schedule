<?php

namespace App\Filament\Resources\TimeLogResource\Pages;

use Filament\Forms;
use Filament\Actions;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\TimeLogResource;

class ListTimeLogs extends ListRecords
{
    protected static string $resource = TimeLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('createMultipleDaysTimeLog')
                ->label('Create Many')
                ->modalHeading('Create Time Logs')
                ->modalDescription('Create time logs for multiple days')
                ->modalSubmitActionLabel('Create Time Logs')
                ->form(fn (Forms\Form $form) => static::$resource::form(
                    $form->extraAttributes(['modal' => 'createMultipleDaysTimeLog']))
                    )
                ->action(function (array $data) {
                    // Handle form submission
                    $this->handleTimeLogCreation($data);
                    Notification::make()
                    ->title('Time Logs Created')
                    ->success()
                    ->body('Multiple time logs have been created successfully.')
                    ->send();
                }),
        ];
    }

    protected function handleTimeLogCreation(array $data): Model
    {
        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['end_date']);
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $data['date'] = $currentDate->format('Y-m-d');
            static::getModel()::create($data);
            $currentDate->addDay();
        }

        return static::getModel()::latest()->first();
    }
}
