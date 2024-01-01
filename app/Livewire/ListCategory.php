<?php

namespace App\Livewire;

use App\Models\Category;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Filament\Tables\Actions\Action;

class ListCategory extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    public function render()
    {
        return view('livewire.list-category');
    }

    public function table(Table $table): Table
    {

        return $table
            ->query(Category::query())
            ->columns([
                TextColumn::make('name')->label('Nom de la catégorie')->searchable(),
                TextColumn::make('childrenCategories.name')
                    ->label('Catégorie parent')
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('delete')
                    ->button()
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->label('supprimer')
                    ->color('danger')
                    ->modalIcon('heroicon-o-trash')
                    ->action(fn (Category $record) => $record->delete()),
                Action::make('edit')
                    ->button()
                    ->icon('heroicon-m-pencil-square')
                    ->label('modifier')
                    ->url(fn (Category $record): string => route('categories.edit', $record))
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
