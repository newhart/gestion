<?php

namespace App\Livewire;

use App\Models\Facture;
use App\Models\FactureContent;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;

class CreateFacture extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public function mount(): void
    {
        $this->form->fill();
    }

    public function render()
    {
        return view('livewire.create-facture');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Information sur le  client')
                    ->schema([
                        TextInput::make('client_name')
                            ->label('Nom du client')
                            ->required(),
                        TextInput::make('phone')->label('Numéro du client'),
                        TextInput::make('address')->label('Adresse du client'),
                    ]),
            ])
            ->statePath('data')
            ->model(Facture::class);
    }

    public function submit()
    {
        $data = $this->form->getState();
        $data['date'] = now();
        $data['code'] = Str::random(8);
        $facture = Facture::create($data);
        return redirect()->route('factures.create.detail' , $facture)->with('success', 'Facture created with success');
    }
}
