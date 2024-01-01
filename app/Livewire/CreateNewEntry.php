<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Company;
use App\Models\Entry;
use App\Models\Product;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class CreateNewEntry extends Component implements HasForms
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
                Section::make('Ajouter un nouveau produit')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom')
                            ->placeholder('Ajouter le nom du produit')
                            ->required(),
                        Select::make('category')
                            ->label('Catégorie')
                            ->required()
                            ->searchable()
                            ->relationship('category',  'name'),
                        Select::make('company')
                            ->label('Fournisseur')
                            ->required()
                            ->searchable()
                            ->relationship('company',  'name'),
                        // TextInput::make('price')
                        //     ->numeric()
                        //     ->label('Prix')
                        //     ->placeholder('Ajouter la prix du produit')
                        //     ->required(),
                        TextInput::make('stock_quantity')
                            ->numeric()
                            ->label('Quantité')
                            ->placeholder('Ajouter le nombre total de la  produit')
                            ->required(),
                        TextInput::make('stock_alert')
                            ->numeric()
                            ->label('Limite stock')
                            ->placeholder('Ajouter le nombre stock limit de la  produit')
                            ->required(),
                        TextInput::make('code')
                            ->label('Code')
                            ->placeholder('Ajouter le code du produit')
                    ])
            ])
            ->statePath('data')
            ->model(Product::class);
    }
    public function submit()
    {
        $data = $this->form->getState();
        $category = Category::find((int)$data['category']);
        $company = Company::find((int)$data['company']);
        if ($category && $company) {
            $data['category_id'] = $category->id;
            $data['company_id'] = $company->id;
        }
        $entry_quantity = $data['stock_quantity'];
        $data['price'] = 0;
        $data['stock_quantity'] = 0;
        unset($data['category']);
        unset($data['company']);
        $product =  Product::create($data);
        $this->form->model($product)->saveRelationships();
        // create new entry with product and company 
        Entry::create(['quantity' => $entry_quantity, 'product_id' => $product->id, 'company_id' => $company->id, 'status' => 0,  'date_achat' => now()]);
        return redirect()->route('products.list')->with('success', 'Product created with success');
    }
    public function render()
    {
        return view('livewire.create-new-entry');
    }
}
