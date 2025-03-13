<?php

namespace App\Filament\Resources\UserResource\EditForms\Tabs;

use App\Filament\Resources\BankResource;
use App\Models\Bank;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class UserBankTab
{
    public static function getSchema(): array
    {
        return [
            TextInput::make('account_name')->required(),
            Select::make('bank_id')
            ->options(fn () => BankResource::getBankOptions()) // Load 5 banks initially
            ->getSearchResultsUsing(fn (string $search) =>
            BankResource::getBankOptions($search)
            )->searchable()
            ->required(),

            TextInput::make('bsb')->required(),
            TextInput::make('account_number')->required(),
        ];
    }
}
