<?php

namespace App\Livewire;

use App\Models\Company;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Livewire\Component;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;

class ListCompany extends Component implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {

        return $table
            ->query(Company::query())
            ->columns([
                TextColumn::make('name')->searchable(),
            ])
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
                    ->action(fn (Company $record) => $record->delete()),
                Action::make('edit')
                    ->button()
                    ->icon('heroicon-m-pencil-square')
                    ->label('modifier')
                    ->url(fn (Company $record): string => route('companies.edit', $record))
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.list-company');
    }
}
