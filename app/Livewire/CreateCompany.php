<?php

namespace App\Livewire;

use App\Models\Company;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class CreateCompany extends Component implements HasForms
{

    use InteractsWithForms;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Ajouteur une nouveaux fournisseure')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom')
                            ->placeholder('Nom du fournisseure')
                            ->required(),
                    ])
            ])
            ->statePath('data')
            ->model(Company::class);
    }

    public function render()
    {
        return view('livewire.create-company');
    }
}
