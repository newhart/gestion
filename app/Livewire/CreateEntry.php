<?php

namespace App\Livewire;

use App\Models\Bonde;
use App\Models\Category;
use App\Models\Company;
use App\Models\Entry;
use App\Models\Product;
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
    public   $is_new = false;
    public $bonde_id = null;
    public $is_update = false;
    public function mount($item, $bonde_id): void
    {
        $this->bonde_id = $bonde_id;
        if ($item && $this->is_new === false) {
            $this->form->fill([
                'quantity' => $item['quantity'],
                'product' => $item['product_id']
            ]);
            $this->is_update = true;
        } else {
            $this->form->fill();
        }
    }

    public function form(Form $form): Form
    {
        if ($this->is_new) {
            return $form->schema([
                TextInput::make('name')->label('Nom du produit')
                    ->placeholder('Nom du produit')->required(),
                TextInput::make('code')
                    ->label('Code barre')
                    ->placeholder('Ajouter le code barre du produit'),
                Select::make('category_id')->label('Catégorie')->options(Category::all()->pluck('name', 'id'))->required(),
                TextInput::make('stock_quantity')->label('Quantité')->placeholder('Quantité')->numeric()->required(),
                TextInput::make('stock_alert')
                    ->numeric()
                    ->label('Limite stock')
                    ->placeholder('Ajouter le nombre stock limit de la  produit')
                    ->required(),
                TextInput::make('price')->placeholder('Ajouter un prix')->numeric()->required(),
            ])->statePath('data')
                ->model(Product::class);
        }
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

    public function new_product()
    {
        $this->is_new = true;
    }

    public function submit()
    {
        $data = $this->form->getState();
        if ($this->is_new) {
            $data['stock_quantity'] = 0;
            $product_new  = Product::create($data);
            $product = $product_new->load('category');
        } else {
            $product  = Product::find($data['product'])->load('category');
        }

        if ($product) {
            $entry = Entry::where('product_id', $product->id)->where('bonde_id', $this->bonde_id)->first();

            if ($entry) {
                $entry->product_id = $product->id;
                $entry->quantity = $data['quantity'];
                $entry->save();
            } else {
                Entry::create([
                    'bonde_id' => $this->bonde_id,
                    'quantity' => $data['quantity'],
                    'product_id' => $product->id,
                    'status' => false,
                    'date_achat' => now(),
                ]);
            }

            $datas = Entry::where('bonde_id', $this->bonde_id)->with('product.category')->latest()->get();
        }
        $this->dispatch('up',  $datas);
        $this->form->fill();
        $this->is_new = false;
        $this->is_update = false;
    }

    public function render()
    {
        return view('livewire.create-entry');
    }
}
