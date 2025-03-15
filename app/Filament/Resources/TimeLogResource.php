<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\TimeLog;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TimeLogResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TimeLogResource\RelationManagers;

class TimeLogResource extends Resource
{
    protected static ?string $model = TimeLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'Time Management';
    // protected static ?string $title = 'Time logs';

    public static function form(Form $form): Form
    {
        $isModal = $form->getExtraAttributeBag()->get("modal",false); // Retrieve the passed attribute


        return $form->schema([
            Select::make('user_id')
                ->relationship('user', 'name')
                ->required()
                ->label('Security Guard'),
            Select::make('site_id')
                ->relationship('site', 'name')
                ->required()
                ->label('Site'),
            DatePicker::make('date')->required()->visible(!$isModal),

            DatePicker::make('start_date')
                ->required()
                ->label('Start Date')
                ->visible($isModal),
            DatePicker::make('end_date')
                ->required()
                ->label('End Date')
                ->afterOrEqual('start_date')
                ->visible($isModal),


            TimePicker::make('shift_start')->required(),
            TimePicker::make('shift_end')->required(),
            TextInput::make('hourly_rate')->numeric()->required(),
        ])->columns(2);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Security Guard')->sortable(),
                TextColumn::make('site.name')->label('Site')->sortable(),
                TextColumn::make('date')->sortable()->date('F j, Y'),
                TextColumn::make('shift_start')->label('Start Time')->dateTime('h:i A'),
                TextColumn::make('shift_end')->label('End Time')->dateTime('h:i A'),
                TextColumn::make('hours_worked')->label('Total hours')->sortable(),
                TextColumn::make('hourly_rate')->label('Hourly Rate')->sortable()->money(get_site_setting('currency','USD')),
                TextColumn::make('total_payable')->label('Total Payable')->money(get_site_setting('currency','USD')),
            ])
            ->filters([
                SelectFilter::make('site_id')
                    ->relationship('site', 'name')
                    ->label('Filter by Site'),
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
            'index' => Pages\ListTimeLogs::route('/'),
            'create' => Pages\CreateTimeLog::route('/create'),
            'edit' => Pages\EditTimeLog::route('/{record}/edit'),

        ];
    }
}
