<?php

namespace App\Livewire;

use App\Models\Product;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Actions\Action;

class ListProducts extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    public function table(Table $table): Table
    {

        return $table
            ->query(Product::query())
            ->columns([
                TextColumn::make('name')
                    ->label('Nom de la produit')
                    ->searchable(),
                TextColumn::make('stock_quantity')
                    ->label('Quantité'),
                TextColumn::make('category.name')
                    ->label('Catégorie')
                    ->searchable(),
                TextColumn::make('code')
                    ->label('Code barre')
                    ->searchable(),
            ])
            ->recordClasses(function (Product $record) {
                return $record->stock_quantity <= $record->stock_alert ?  'alert-error' : '';
            })
            ->defaultSort('updated_at', 'desc')
            ->filters([
                // ...
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Action::make('delete')
                    ->button()
                    ->icon('heroicon-o-trash')
                    ->hidden(auth()->user()->role !== 'Admin')
                    ->requiresConfirmation()
                    ->label('supprimer')
                    ->color('danger')
                    ->modalIcon('heroicon-o-trash')
                    ->action(fn (Product $record) => $record->delete()),
                Action::make('edit')
                    ->button()
                    ->icon('heroicon-m-pencil-square')
                    ->hidden(auth()->user()->role !== 'Admin')
                    ->label('modifier')
                    ->url(fn (Product $record): string => route('products.edit', $record))
            ])
            ->bulkActions([]);
    }
    public function render()
    {
        return view('livewire.list-products');
    }
}
