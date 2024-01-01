<?php

namespace App\Livewire;

use App\Models\Category;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class CreateCategory extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public function mount(): void
    {
        $this->form->fill();
    }

    public function submit()
    {
        $data = $this->form->getState();
        $category =  Category::create($data);
        $this->form->model($category)->saveRelationships();
        return redirect()->route('categories.list')->with('success', 'Product created with success');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Ajouter une nouvelle catégorie')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom')
                            ->placeholder('Ajouter le nom de la catégorie')
                            ->required(),
                    ])
            ])
            ->statePath('data')
            ->model(Category::class);
    }

    public function render()
    {
        return view('livewire.create-category');
    }
}
