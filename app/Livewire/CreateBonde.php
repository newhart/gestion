<?php

namespace App\Livewire;

use App\Models\Bonde;
use App\Models\Category;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class CreateBonde extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public ?string $type = '';
    public function mount(string $type): void
    {
        $this->form->fill();
        $this->type = $type;
    }


    public function render()
    {
        return view('livewire.create-bonde');
    }

    public function submit()
    {
        $data = $this->form->getState();
        $data['status'] = false;
        $data['type'] = $this->type;
        $bonde =  Bonde::create($data);
        return redirect()->route('achats.create', ['bonde' => $bonde,  'type' => $this->type])->with('success', 'Product created with success');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Ajouter une bande de livraison')
                    ->schema([
                        TextInput::make('num')
                            ->label('Numéro')
                            ->placeholder('Ajouter le numero')
                            ->unique()
                            ->required(),
                        DateTimePicker::make('created_at')
                            ->default(now())
                            ->disabled(true)
                            ->label('Date')
                            ->required()
                    ])
            ])
            ->statePath('data')
            ->model(Bonde::class);
    }
}
