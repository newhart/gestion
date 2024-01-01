<?php

namespace App\Livewire;

use App\Models\Entry;
use App\Models\Facture;
use App\Models\FactureContent;
use App\Models\Product;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class FormContent extends Component implements HasForms
{

    use InteractsWithForms;

    public ?array $data = [];

    public Facture $facture ;

    public function mount(Facture $facture): void
    {
        $this->form->fill();
        $this->facture = $facture;
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nom de la produit')
                    ->required(),
                TextInput::make('price')
                    ->label('Prix')
                    ->numeric()
                    ->placeholder('Prix')
                    ->required(),
                TextInput::make('qty')
                    ->label('Qty')
                    ->numeric()
                    ->placeholder('Qty')
                    ->required(),
            ])
            ->statePath('data')
            ->model(FactureContent::class);
    }

    public function submit()
    {
        $data = $this->form->getState();
        $data['facture_id'] = $this->facture->id ;

        $facture_content  = FactureContent::create($data);
        if($facture_content){
            $this->data[] = [
                'name' => $facture_content->name ,
                'qty' => $facture_content->qty ,
                'price' => $facture_content->price
            ];
            $facture = $this->facture->load('contents');
            $this->dispatch('up', $facture);
            $this->form->fill();
        }


    }

    public function render()
    {
        return view('livewire.form-content');
    }
}
