<?php
namespace App\Filament\Resources;

use App\Filament\Resources\BankAccountResource\Pages\CreateBankAccount;
use App\Filament\Resources\BankAccountResource\Pages\EditBankAccount;
use App\Filament\Resources\BankAccountResource\Pages\ListBankAccounts;
use App\Models\BankAccount;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Resources\Pages\{ListRecords, CreateRecord, EditRecord};

class BankAccountResource extends Resource
{
    protected static ?string $model = BankAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Hides the resource from the menu
    }
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('account_name')->required(),
                Forms\Components\Select::make('bank_id')
                    ->relationship('bank', 'name')
                    ->searchable()
                    ->required()
                    ->options(fn () => BankResource::getBankOptions()) // Load first 10 banks
                    ->preload(), // Preload initial options,
                Forms\Components\TextInput::make('bsb')->required(),
                Forms\Components\TextInput::make('account_number')->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('account_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('bank.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('bsb'),
                Tables\Columns\TextColumn::make('account_number'),
            ])
            ->filters([])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBankAccounts::route('/'),
            'create' => CreateBankAccount::route('/create'),
            'edit' => EditBankAccount::route('/{record}/edit'),
        ];
    }
}
