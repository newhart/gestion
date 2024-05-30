<?php

namespace App\Livewire;

use App\Models\Archive;
use App\Models\Bonde;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Livewire\Component;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Blade;

class ListArchive extends Component implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {

        return $table
            ->query(Bonde::query()->where('status', true))
            ->columns([
                TextColumn::make('num')
                    ->label('Numéro du BL')
                    ->searchable(),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Action::make('delete')
                    ->button()
                    ->icon('heroicon-o-trash')
                    ->hidden(auth()->user()->role !== 'Admin')
                    ->requiresConfirmation()
                    ->label('supprimer')
                    ->color('danger')
                    ->modalIcon('heroicon-o-trash')
                    ->action(fn (Bonde $bonde) => $bonde->delete()),
                //                Action::make('pdf')
                //                    ->label('Telecharger')
                //                    ->icon('heroicon-o-arrow-down-tray')
                //                    ->color('success')
                //                    ->action(function (Bonde $record) {
                //                        return response()->streamDownload(function () use ($record) {
                //                            echo Pdf::loadHtml(
                //                                Blade::render('invoice', ['record' => $record])
                //                            )
                //                                ->setPaper('a4', 'landscape')
                //                                ->stream();
                //                        }, 'invoice' . '.pdf');
                //                    }),

                Action::make('Detail')
                    ->button()
                    ->icon('heroicon-o-user')
                    ->modalContent(function (Bonde $bonde) {
                        $bonde = Bonde::where('id', $bonde->id)->with(['sorties' => function ($query) {
                            $query->with('product');
                        }, 'entries' => function ($query) {
                            $query->with('product');
                        }])->first();

                        return view('modal.index', compact('bonde'));
                    })->modalSubmitAction(false)
            ])
            ->bulkActions([
                // ...
            ]);
    }


    public function render()
    {
        return view('livewire.list-archive');
    }
}
