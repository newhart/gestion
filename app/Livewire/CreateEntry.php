<?php

namespace App\Livewire;

use App\Models\Bonde;
use App\Models\Category;
use App\Models\Company;
use App\Models\Entry;
use App\Models\Product;
use DragonCode\Support\Facades\Helpers\Boolean;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use PhpParser\Node\Expr\Cast\Bool_;

class CreateEntry extends Component implements HasForms
{
    use InteractsWithForms;


    public ?array $data = [];
    public   $is_new = false;
    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        if ($this->is_new) {
            return $form->schema([
                TextInput::make('name')->label('Nom de la produit')
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

    private function convertArray($array)
    {
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                // Appel récursif si la valeur est un tableau
                $result = array_merge($result, $this->convertArray($value));
            } else {
                // Supprimer le préfixe numérique (0 =>)
                $newKey = is_numeric($key) ? "" : $key;
                // Ajouter à $result
                $result[$newKey] = $value;
            }
        }
        return $result;
    }

    public function submit()
    {
        $data = $this->form->getState();
        $current_quantity  = 0;
        if ($this->is_new) {
            $current_quantity = $data['stock_quantity'];
            $data['stock_quantity'] = 0;
            $product_new  = Product::create($data);
            $product = $product_new->load('category');
        } else {
            $product  = Product::find($data['product'])->load('category');
        }

        if ($product) {
            $this->data[] = [
                'product_name' => $product->name,
                'quantity' => $this->is_new ? $current_quantity :  $data['quantity'],
                'product_id' => $product->id,
                'category' => $product->category->name
            ];
        }
        $this->dispatch('up', $this->data);
        $this->form->fill();
        $this->is_new = false;
    }

    public function render()
    {
        return view('livewire.create-entry');
    }
}
