<?php

namespace App\Livewire;

use App\Models\Archive;
use App\Models\Bonde;
use App\Models\Entry;
use App\Models\Product;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Filament\Tables\Actions\Action;


class ListEntry extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    public function table(Table $table): Table
    {

        return $table
            ->query(Bonde::query()->where('type', 'entry')->where('is_confirm' , true)->whereHas('entries'))
            ->columns([
                TextColumn::make('num')
                    ->label('Numéro du bon de livraison')
                    ->searchable(),
                IconColumn::make('status')
                    ->label('Statut de validation')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label("Date d'entrée")
                    ->dateTime(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('validation')
                    ->icon('heroicon-s-check')
                    ->hidden(auth()->user()->role !== 'Admin')
                    ->disabled(fn (Bonde $bonde) => $bonde->status)
                    ->button()
                    ->requiresConfirmation()
                    ->label('Valider')
                    ->color('success')
                    ->action(function (Bonde $bonde) {
                        $bonde  = Bonde::where('id', $bonde->id)
                            ->with(['entries' => function ($query) {
                                $query->with('product');
                            }])->first();
                        foreach ($bonde->entries as $entry) {
                            $product = Product::find($entry->product_id);
                            if ($product) {
                                $product->stock_quantity += $entry->quantity; // augementer la qty
                                $product->save();
                            }
                        }
                        $bonde->status = true; // change status to validated
                        $bonde->save();
                        $this->dispatch('alert', type: 'success', message: 'Validation fait avec success');
                    }),
                Action::make('Détail')
                    ->button()
                    ->icon('heroicon-o-user')
                    ->modalContent(function (Bonde $bonde) {
                        $bonde = Bonde::where('id', $bonde->id)->with(['entries' => function ($query) {
                            $query->with('product');
                        }])->first();

                        return view('modal.index', compact('bonde'));
                    })->modalSubmitAction(false),
                Action::make('Modifier')
                    ->url(fn (Bonde $record): string => route('achats.create', ['bonde' => $record , 'type' => 'entry']))
                    ->openUrlInNewTab(false)
                    ->button()
                    ->disabled(fn (Bonde $bonde) => $bonde->status)
                    ->openUrlInNewTab()
            ])
            ->bulkActions([
                // ...
            ])
            ->recordAction(Tables\Actions\ViewAction::class)
            ->recordUrl(null);
    }
    private function add_to_archive(Entry $entry): void
    {
        Archive::create([
            'type' => 'Entrer',
            'archiveable_type' => 'App\Models\Entry',
            'archiveable_id' => $entry->id,
        ]);
    }
    public function render()
    {
        return view('livewire.list-entry');
    }
}
