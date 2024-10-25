<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_name')
                    ->required()
                    ->label('Customer Name'),

                Forms\Components\DatePicker::make('invoice_date')
                    ->required()
                    ->label('Invoice Date'),

                Forms\Components\Repeater::make('lineItems')
                    ->relationship('lineItems')
                    ->schema([
                        Forms\Components\TextInput::make('description')
                            ->required()
                            ->label('Description'),
                        Forms\Components\TextInput::make('quantity')
                            ->required()
                            ->numeric()
                            ->label('Quantity'),
                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->label('Price'),
                    ])
                    ->createItemButtonLabel('Add Line Item')
                    ->required()
                    ->columns(3)->columnSpan(2),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer_name'),
                TextColumn::make('invoice_date'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('customer_name')
                    ->label(__('Customer'))
                    
                    ->options(fn() => Invoice::all()->pluck('customer_name', 'customer_name')->toArray()),
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }    
}
