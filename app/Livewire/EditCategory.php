<?php

namespace App\Livewire;

use App\Models\Category;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class EditCategory extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public Category $record;

    public function mount($id): void
    {
        $category = Category::find($id);
        $this->record = $category;
        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Ajouteur une nouveaux categorie')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom')
                            ->placeholder('Ajouter le nom de la categorie')
                            ->required(),
                    ])
            ])
            ->statePath('data')
            ->model($this->record);
    }

    public function submit(): void
    {
        $data = $this->form->getState();
        $this->record->update($data);
        $this->form->model($this->record)->saveRelationships();
        $this->dispatch('alert', type: 'success', message: 'Moidification fait avec success ');
    }

    public function render()
    {
        return view('livewire.edit-category');
    }
}
