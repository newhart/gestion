<?php

namespace App\Livewire;

use App\Models\Bonde;
use App\Models\Category;
use App\Models\Company;
use App\Models\Entry;
use App\Models\Product;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class CreateEntry extends Component implements HasForms
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
                    ->label('Produit')
                    ->searchable()
                    ->required()
                    ->relationship('product',  'name'),
                TextInput::make('quantity')
                    ->label('Quantité')
                    ->numeric()
                    ->placeholder('Nombre de quantity')
                    ->required(),
            ])
            ->statePath('data')
            ->model(Entry::class);
    }

    public function submit()
    {
        $data = $this->form->getState();
        $product  = Product::find($data['product'])->load('category');
        if ($product) {
            $this->data[] = [
                'product_name' => $product->name,
                'quantity' => $data['quantity'],
                'product_id' => $product->id,
                'category' => $product->category->name
            ];
        }
        $this->dispatch('up', $this->data);
        $this->form->fill();
    }

    public function render()
    {
        return view('livewire.create-entry');
    }
}
