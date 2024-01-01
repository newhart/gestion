<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Tables\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class ListMembre extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {

        return $table
            ->query(User::query())
            ->columns([
                TextColumn::make('name')->label('Nom')->searchable(),
                TextColumn::make('email')->searchable()
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
                    ->action(fn (User $record) => $record->delete()),
                Action::make('edit')
                    ->button()
                    ->icon('heroicon-m-pencil-square')
                    ->label('modifier')
                    ->url(fn (User $record): string => route('membres.edit', $record))
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.list-membre');
    }
}
