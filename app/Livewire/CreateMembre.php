<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CreateMembre extends Component implements HasForms
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
        $data['password'] =  Hash::make($data['password']);
        $data['email_verified_at'] = now();
        $data['type'] = 'User';
        $membre =  User::create($data);
        $this->form->model($membre)->saveRelationships();
        return redirect()->route('membres.list')->with('success', 'Membre  ajouter avec success');
    }

    public function render()
    {
        return view('livewire.create-membre');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Ajout de nouveaux membres')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom')
                            ->placeholder('Ajouter le nom du membre')
                            ->required(),
                        TextInput::make('email')
                            ->label('Indetifiant')
                            ->placeholder('Ajouter une Indetifiant')
                            ->required(),
                        Select::make('role')
                            ->options([
                                'Admin' => 'Admin',
                                'User' => 'Utilisateur',
                            ]),
                        TextInput::make('password')
                            ->label('Mot de passe')
                            ->placeholder('Mot de passe')
                            ->password()
                            ->required()
                    ])
            ])
            ->statePath('data')
            ->model(User::class);
    }
}
