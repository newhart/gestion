<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class CreateProduct extends Component implements HasForms
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
                        TextInput::make('code')
                            ->label('Code barre')
                            ->placeholder('Ajouter le code barre du produit'),
                        TextInput::make('name')
                            ->label('Nom')
                            ->placeholder('Ajouter le nom du produit')
                            ->required(),
                        Select::make('category')
                            ->label('Catégorie')
                            ->required()
                            ->searchable()
                            ->relationship('category',  'name'),
                        TextInput::make('stock_alert')
                            ->numeric()
                            ->label('Limite stock')
                            ->placeholder('Ajouter le nombre stock limit de la  produit')
                            ->required()
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
        $data['price'] = 0;
        $data['stock_quantity'] = 0 ;
        unset($data['category']);
        unset($data['company']);
        $product =  Product::create($data);
        $this->form->model($product)->saveRelationships();
        return redirect()->route('products.list')->with('success', 'Product created with success');
    }
    public function render()
    {
        return view('livewire.create-product');
    }
}
