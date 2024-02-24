<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Sorty;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class CreateSorty extends Component  implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];
    // create attribute boolean
    public $is_update = false;
    public $bonde_id = null ;
    public function mount($item , $bondeId): void
    {
        if($item){
            $this->form->fill([
                'quantity' => $item['quantity'] ,
                'product' => $item['product_id']
            ]);
            $this->is_update = true;
        }else {
            $this->form->fill();
        }
        $this->bonde_id = $bondeId ;
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('product')
                    ->searchable()
                    ->required()
                    ->relationship('product',  'name'),
                TextInput::make('quantity')
                    ->required()
                    ->label('quantité')
                    ->numeric()
                    ->placeholder('Nombre de produit'),
            ])
            ->statePath('data')
            ->model(Sorty::class);
    }
    public function submit()
    {
        $data = $this->form->getState();
        $product  = Product::find($data['product'])->load('category');
        if ($product) {
            if ((int) $data['quantity'] >  $product->stock_quantity) {
                $this->dispatch('alert', type: 'error', message: 'Nombre de stock insuffisante');
                return false;
            }
            $sorty = Sorty::where('product_id' , $product->id)->where('bonde_id' , $this->bonde_id)->first();
            if($sorty){
                $sorty->product_id = $product->id;
                $sorty->quantity = $data['quantity'];
                $sorty->save();
            }else {
                Sorty::create([
                    'bonde_id' => $this->bonde_id,
                    'quantity' => $data['quantity'],
                    'product_id' => $product->id,
                    'client_name' => 'test',
                    'price' => 0,
                    'status' => false,
                    'date_vente' => now(),
                ]);
            }
            $datas = Sorty::where('bonde_id' , $this->bonde_id)->with('product.category')->latest()->get();
        }
        $this->dispatch('up', $datas);
        $this->form->fill();
        $this->is_update = false ;
        return redirect()->to(route('achats.create' , ['bonde' => $this->bonde_id  , 'type' => 'sotry']));
    }
    public function render()
    {
        return view('livewire.create-sorty');
    }
}
