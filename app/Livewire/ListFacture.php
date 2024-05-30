<?php

namespace App\Livewire;

use App\Models\Bonde;
use App\Models\Facture;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms\Concerns\InteractsWithForms;
use Livewire\Component;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Blade;

class ListFacture extends Component implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {

        return $table
            ->query(Facture::query())
            ->columns([
                TextColumn::make('client_name')->label('Nom du client')->searchable(),
                TextColumn::make('date')
                    ->label('Date')
                    ->date(),
                TextColumn::make('contents.name')->label('Tous les produits')
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('pdf')
                    ->label('Télécharger')
                    ->button()
                    ->color('success')
                    ->action(function (Facture $record) {
                        return response()->streamDownload(function () use ($record) {
                            $record->load('contents');
                            echo Pdf::loadHtml(
                                Blade::render('invoice', ['record' => $record])
                            )
                                ->setPaper('a4', 'landscape')
                                ->stream();
                        }, 'invoice' . '.pdf');
                    }),
                Action::make('Détail')
                    ->button()
                    ->icon('heroicon-o-user')
                    ->modalContent(function (Facture $facture) {
                        $facture = Facture::where('id', $facture->id)->with('contents.product')->first();
                        return view('modal.facture', compact('facture'));
                    })->modalSubmitAction(false),
                Action::make('delete')
                    ->button()
                    ->icon('heroicon-o-trash')
                    ->hidden(auth()->user()->role !== 'Admin')
                    ->requiresConfirmation()
                    ->label('supprimer')
                    ->color('danger')
                    ->modalIcon('heroicon-o-trash')
                    ->action(fn (Facture $record) => $record->delete()),
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.list-facture');
    }
}
