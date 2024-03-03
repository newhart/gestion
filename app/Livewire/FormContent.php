<?php

namespace App\Livewire;

use App\Models\Facture;
use App\Models\FactureContent;
use App\Models\Product;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class FormContent extends Component implements HasForms
{

    use InteractsWithForms;

    public ?array $data = [];

    public Facture $facture;

    public function mount(Facture $facture): void
    {
        $this->form->fill();
        $this->facture = $facture;
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('product_id')
                    ->label('Selectioner le produit')
                    ->options(Product::all()->pluck('name', 'id'))
                    ->reactive()
                    ->afterStateUpdated(function (int $state, callable $set) {
                        $product = Product::find($state);
                        $set('price', $product->price);
                    })
                    ->required(),
                TextInput::make('price')
                    ->label('Prix')
                    ->numeric()
                    ->placeholder('Prix')
                    ->disabled()
                    ->required()  ,
                TextInput::make('qty')
                    ->label('Qty')
                    ->numeric()
                    ->placeholder('Qty')
                    ->reactive()
                    ->afterStateUpdated(function(int $state , callable $set){
                        $current_state = $this->form->getState();
                        $product = Product::find((int)$current_state['product_id']);
                        $set('price', floatval($product->price) * floatval($state));
                    })
                    ->required(),
            ])
            ->statePath('data')
            ->model(FactureContent::class);
    }

    public function submit()
    {
        $data = $this->form->getState();
        $product = Product::find($data['product_id']);
        if($product){
            $data['facture_id'] = $this->facture->id;
            $data['name'] = $product->name ;
            unset($data['product_id']);
            $data['price'] = $product->price * (int) $data['qty'];
            $facture_content  = FactureContent::create($data);
            if ($facture_content) {
                $this->data[] = [
                    'name' => $facture_content->name,
                    'qty' => $facture_content->qty,
                    'price' => $facture_content->price
                ];
                $facture = $this->facture->load('contents');
                $this->dispatch('up', $facture);
                $this->form->fill();
            }
        }

    }


    public function render()
    {
        return view('livewire.form-content');
    }
}
