<?php

namespace App\Livewire;

use App\Models\Bonde;
use App\Models\Entry;
use App\Models\Sorty;
use Livewire\Component;

class AddNewEntry extends Component
{
    public ?array $data = [];

    public Bonde $bonde ;

    public string $type = '';

    public  function  mount(int $id, string $type){
        $this->bonde = Bonde::find($id) ?? new Bonde();
        $this->type = $type ;
    }

    protected $listeners = ['up'];

    public function render()
    {
        return view('livewire.add-new-entry' , [
            'data' => $this->data
        ]);
    }

    #[On('up')]
    public function up($data)
    {
        unset($data['product']);
        unset($data['quantity']);
        $this->data = $data ;
    }

    public function click(){
        foreach ($this->data as $valid){
            if($this->type === 'entry'){
                Entry::create([
                    'bonde_id' => $this->bonde->id ,
                    'quantity' => $valid['quantity'],
                    'product_id' => $valid['product_id'],
                    'date_achat' => now(),
                    'status' => false,
                ]);
            }else{
                Sorty::create([
                    'bonde_id' => $this->bonde->id ,
                    'quantity' => $valid['quantity'],
                    'product_id' => $valid['product_id'],
                    'client_name' => 'test',
                    'price' => 0,
                    'status' => false ,
                    'date_vente' => now(),
                ]);
            }

        }

        if($this->type === 'entry'){
            return redirect()->route('achats.list')->with('success', 'Product created with success');
        }

        return redirect()->route('ventes.list')->with('success', 'Product created with success');


    }
}
