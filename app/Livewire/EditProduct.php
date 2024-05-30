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
use Filament\Notifications\Notification;
use Livewire\Component;

class EditProduct extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public Product $record;

    public function mount($id): void
    {
        $product = Product::findOrfail($id);
        $this->record = $product;
        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Ajouteur une nouveaux produit')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom')
                            ->placeholder('Ajouter le nom du produit')
                            ->required(),
                        Select::make('category')
                            ->searchable()
                            ->relationship('category',  'name'),
                        // Select::make('company')
                        //     ->searchable()
                        //     ->relationship('company',  'name'),
                        TextInput::make('price')
                            ->numeric()
                            ->label('Prix')
                            ->placeholder('Ajouter la prix du produit')
                            ->required(),
                        TextInput::make('price_gros')
                            ->numeric()
                            ->label('Prix de gros')
                            ->placeholder('Ajouter la prix en gros du produit')
                            ->required(),
                        TextInput::make('stock_quantity')
                            ->numeric()
                            ->label('Nombre')
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
            ->model($this->record);
    }

    public function submit(): void
    {
        $data = $this->form->getState();
        $category = Category::findOrFail($data['category']);
        if ($category) {
            $data['category_id'] = $category->id;
            unset($data['category']);
            // unset($data['company']);
        }
        $this->record->update($data);
        $this->form->model($this->record)->saveRelationships();
        $this->dispatch('alert', type: 'success', message: 'Moidification fait avec success ');
    }

    public function render()
    {
        return view('livewire.edit-product');
    }
}
