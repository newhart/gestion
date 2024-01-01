<?php

namespace App\Livewire;

use App\Models\Category;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class CreateSubCategory extends Component  implements  HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public function mount(): void
    {
        $this->form->fill();
    }

    public function render()
    {
        return view('livewire.create-sub-category');
    }

    public function submit()
    {
        $data = $this->form->getState();
        $category = Category::create($data);
        if($category){
            return redirect()->route('categories.list')->with('success', 'Product created with success');
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Ajout d\'une nouvelle  sous-catégorie')
                    ->schema([
                        Select::make('category_id')
                            ->label('Catégorie')
                            ->required()
                            ->options(Category::all()->pluck('name', 'id'))
                            ->searchable(),
                        TextInput::make('name')
                            ->label('Nom')
                            ->placeholder('Ajouter le nom de la sous-catégorie')
                            ->required(),
                    ])
            ])
            ->statePath('data')
            ->model(Category::class);
    }

}
