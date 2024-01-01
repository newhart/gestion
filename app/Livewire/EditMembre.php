<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class EditMembre extends Component implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];
    public User $record;

    public function mount($id): void
    {
        $membre = User::findOrfail($id);
        $this->record = $membre;
        $this->form->fill($this->record->attributesToArray());
    }


    public function render()
    {
        return view('livewire.edit-membre');
    }

    public function submit(): void
    {
        $data = $this->form->getState();
        $this->record->update($data);
        $this->form->model($this->record)->saveRelationships();
        $this->dispatch('alert', type: 'success', message: 'Moidification fait avec success ');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Modification information membre')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom')
                            ->placeholder('Ajouter le nom du membre')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email')
                            ->placeholder('Ajouter l email du membre')
                            ->required(),
                        Select::make('role')
                            ->options([
                                'Admin' => 'Admin',
                                'User' => 'Utilisateur',
                            ]),
                    ])
            ])
            ->statePath('data')
            ->model($this->record);
    }
}
