<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoanResource\Pages;
use App\Filament\Resources\LoanResource\RelationManagers;
use App\Models\Loan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->searchable()
                    ->preload()
                    // ->createOptionForm([
                    //     Forms\Components\TextInput::make('name')
                    //         ->required()
                    //         ->maxLength(255),
                    //     Forms\Components\TextInput::make('email')
                    //         ->label('Email address')
                    //         ->email()
                    //         ->required()
                    //         ->maxLength(255),
                    //     Forms\Components\TextInput::make('phone')
                    //         ->label('Phone number')
                    //         ->tel()
                    //         ->required(),
                    // ])
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->maxValue(42949672.95),
                Forms\Components\TextInput::make('interest_rate')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('installments')
                    ->required()
                    ->maxLength(255),
                // Forms\Components\TextInput::make('installment_value')
                //     ->required()
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('amount_payable')->required(),
                Forms\Components\DatePicker::make('start_date')
                    ->required()
                    ->maxDate(now()),
                // Forms\Components\Select::make('created_by')
                //     ->relationship('user', 'name')
                //     ->label('Created by')
                //     ->searchable()
                //     ->preload()
                //     ->required(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('client.name'),
                Infolists\Components\TextEntry::make('amount')->label('Loan Amount'),
                Infolists\Components\TextEntry::make('interest_rate')->label('Interest Rate %'),
                Infolists\Components\TextEntry::make('installments')->label('Number of Installments'),
                Infolists\Components\TextEntry::make('installment_value')->label('Installment Amount'),
                Infolists\Components\TextEntry::make('amount_payable')->label('Amount Payable'),
                Infolists\Components\TextEntry::make('status'),
                Infolists\Components\TextEntry::make('start_date'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.name')->searchable(),
                Tables\Columns\TextColumn::make('amount')->label('Loan Amount'),
                Tables\Columns\TextColumn::make('amount_payable'),
                Tables\Columns\TextColumn::make('status')->sortable(),
                Tables\Columns\TextColumn::make('start_date'),
                Tables\Columns\TextColumn::make('user.name')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListLoans::route('/'),
            'create' => Pages\CreateLoan::route('/create'),
            'view' => Pages\ViewLoan::route('/{record}'),
            //'edit' => Pages\EditLoan::route('/{record}/edit'),
        ];
    }
}
