<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Sorty;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class CreateSorty extends Component  implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];
    public function mount(): void
    {
        $this->form->fill();
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('product')
                    ->searchable()
                    ->relationship('product',  'name'),
                TextInput::make('quantity')
                    ->label('quantité')
                    ->numeric()
                    ->placeholder('Nombre de produit'),
            ])
            ->statePath('data')
            ->model(Sorty::class);
    }
    public function submit()
    {
        $data = $this->form->getState();
        $product  = Product::find($data['product']);
        if($product){
            if ((int) $data['quantity'] >  $product->stock_quantity) {
                $this->dispatch('alert', type: 'error', message: 'Nombre de stock insuffisante');
                return false;
            }
            $this->data[] = [
                'product_name' => $product->name ,
                'quantity' => $data['quantity'],
                'product_id' => $product->id
            ];
        }
        $this->dispatch('up', $this->data);
        $this->form->fill();
    }
    public function render()
    {
        return view('livewire.create-sorty');
    }
}
