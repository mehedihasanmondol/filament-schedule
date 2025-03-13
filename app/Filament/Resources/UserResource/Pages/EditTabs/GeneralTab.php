<?php

namespace App\Filament\Resources\UserResource\EditForms\Tabs;

use Filament\Forms;

class GeneralTab
{
    public static function getSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('mobile')
                ->required(),
            Forms\Components\TextInput::make('password')
                ->password(),

            Forms\Components\TextInput::make('birth_date')
                ->mask('9999/99/99')
                ->placeholder('YYYY/MM/DD'),
            Forms\Components\FileUpload::make('image')
                ->image()
                ->nullable(),

            Forms\Components\TextInput::make('rate')
            ->numeric(),
            Forms\Components\TextInput::make('remarks'),
            Forms\Components\Select::make('status')
                ->options([
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ])
                ->required(),
        ];
    }
}
