<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameResource\Pages;
use App\Models\Game;
use App\Models\Team;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GameResource extends Resource
{
    protected static ?string $model = Game::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        $teams = Team::all()->pluck('name', 'id')->toArray();

        return $form
            ->schema([
                Forms\Components\Section::make('general')->schema([
                    Forms\Components\DateTimePicker::make('date_time')
                        ->required(),
                    Forms\Components\Select::make('location_id')
                        ->relationship(name: 'location', titleAttribute: 'address')
                        ->searchable()
                        ->preload()
                        ->live()
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\Select::make('league')
                        ->options([
                            'kreisoberliga' => 'Kreisoberliga'
                        ])
                        ->required(),
                    Forms\Components\Select::make('season')
                        ->options([
                            '2023/2024' => '2023/2024'
                        ])
                        ->required(),
                ]),
                Forms\Components\Section::make('home team')->schema([
                    Forms\Components\Select::make('home_team_id')
                        ->label('Home Team')
                        ->options($teams)
                        ->reactive()
                        ->required(),
                    Forms\Components\TextInput::make('home_team_points')
                        ->required()
                        ->numeric()
                        ->default(0),
                ])->columnSpan(1),
                Forms\Components\Section::make('guest team')->schema([
                    Forms\Components\Select::make('guest_team_id')
                        ->label('Guest Team')
                        ->options($teams)
                        ->reactive()
                        ->required(),
                    Forms\Components\TextInput::make('guest_team_points')
                        ->required()
                        ->numeric()
                        ->default(0),
                ])->columnSpan(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('home_team_id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('guest_team_id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('league')
                    ->searchable(),
                Tables\Columns\TextColumn::make('season')
                    ->searchable(),
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
            'index' => Pages\ListGames::route('/'),
            'create' => Pages\CreateGame::route('/create'),
            'edit' => Pages\EditGame::route('/{record}/edit'),
        ];
    }
}
