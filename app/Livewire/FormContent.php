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
                    ->searchable()
                    ->relationship('product',  'name')
                    ->reactive()
                    ->afterStateUpdated(function (int|null $state, callable $set) {
                        $product = Product::find($state);
                        if ($product) {
                            $set('price', $product->price);
                        }
                    })
                    ->required(),
                TextInput::make('price')
                    ->label('Prix')
                    ->numeric()
                    ->placeholder('Prix')
                    ->disabled()
                    ->required(),
                TextInput::make('qty')
                    ->label('Qty')
                    ->numeric()
                    ->placeholder('Qty')
                    ->reactive()
                    ->afterStateUpdated(function (int|null $state, callable $set) {
                        $current_state = $this->form->getState();
                        $product = Product::find((int)$current_state['product_id']);
                        if ($state) {
                            if ($state >= 6) {
                                $set('price', floatval($product->price_gros));
                            } else {
                                $set('price', floatval($product->price));
                            }
                        }
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
        if ($product) {
            $data['facture_id'] = $this->facture->id;
            $data['name'] = $product->name;
            // unset($data['product_id']);
            $data['price'] = $product->price * (int) $data['qty'];
            $facture_content  = FactureContent::create($data);
            // load product in facture content
            $facture_content->load('product');
            if ($facture_content) {
                $this->data[] = [
                    'name' => $facture_content->name,
                    'qty' => $facture_content->qty,
                    'price' => $facture_content->product?->price
                ];
                $facture = $this->facture->load('contents.product');
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
