<?php

namespace App\Livewire;

use App\Models\Archive;
use App\Models\Bonde;
use App\Models\Category;
use App\Models\Entry;
use App\Models\Product;
use App\Models\Sorty;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;

class ListSorty extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {

        return $table
            ->query(Bonde::query()->where('type' , 'sorty')->where('is_confirm' , true)->whereHas('sorties'))
            ->columns([
                TextColumn::make('num')
                    ->label('Numéro de la bande de livraison')
                    ->searchable(),
                IconColumn::make('status')
                    ->label('Status de validation')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label("Date d'entrée")
                    ->dateTime(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('date_vente')
                        ->label('Date de vente'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_vente'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', $date),
                            );
                    }),
                Filter::make('category')
                    ->form([
                        Select::make('category')
                            ->label('Catégorie')
                            ->searchable()
                            ->options(Category::all()->pluck('name', 'id'))
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['category'],
                                function (Builder $query, $date): Builder {
                                    return $query->whereHas('sorties', function($query) use($date){
                                        $query->where('category_id' , $date);
                                    });
                                },
                            );
                    })
            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(2)
            ->actions([
                Action::make('validation')
                    ->icon('heroicon-m-pencil-square')
                    ->hidden(auth()->user()->role !== 'Admin')
                    ->disabled(fn (Bonde $bonde) => $bonde->status)
                    ->button()
                    ->requiresConfirmation()
                    ->label('Valider')
                    ->color('success')
                    ->action(function (Bonde $bonde) {
                        $bonde  = Bonde::where('id' , $bonde->id)->with(['sorties'=> function($query){
                            $query->with('product');
                        }])->first();
                        foreach ($bonde->sorties as $sorty) {
                            $product = Product::find($sorty->product_id);
                            if($product){
                                $product->stock_quantity -= $sorty->quantity ; // delete la qty
                                $product->save();
                            }
                        }
                        $bonde->status = true ;
                        $bonde->save();
                        $this->dispatch('alert', type: 'success', message: 'Validation fait avec success');
                    }),
                Action::make('Détail')
                    ->button()
                    ->icon('heroicon-o-user')
                    ->modalContent(function(Bonde $bonde)
                    {
                        $bonde = Bonde::where('id', $bonde->id)->with(['sorties' => function($query){
                            $query->with('product');
                        }])->first();

                        return view('modal.index', compact('bonde'));
                    })->modalSubmitAction(false) ,
                 Action::make('Modifier')
                     ->url(fn (Bonde $record): string => route('achats.create', ['bonde' => $record , 'type' => 'sorty']))
                     ->openUrlInNewTab(false)
                     ->button()
                     ->icon('heroicon-o-pencil')
                     ->color('info')
                     ->disabled(fn (Bonde $bonde) => $bonde->status)
                     ->openUrlInNewTab()
            ])
            ->bulkActions([
                // ...
            ]);
    }

    private function add_to_archive(Sorty $sorty): void
    {
        Archive::create([
            'type' => 'Sortie',
            'archiveable_type' => 'App\Models\Sorty',
            'archiveable_id' => $sorty->id,
        ]);
    }

    public function render()
    {
        return view('livewire.list-sorty');
    }
}
