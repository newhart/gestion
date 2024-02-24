<?php

namespace App\Livewire;

use App\Models\Bonde;
use App\Models\Entry;
use App\Models\Sorty;
use Livewire\Attributes\On;
use Livewire\Component;

class AddNewEntry extends Component
{
    public ?array $data = [];

    public Bonde $bonde;

    public string $type = '';

    public  function  mount(int $id, string $type)
    {
        $this->bonde = Bonde::find($id) ?? new Bonde();
        $this->type = $type;
        $this->data = $this->type === 'entry' ? Entry::where('bonde_id', $id)->with('product.category')->latest()->get()->toArray() :   Sorty::where('bonde_id', $id)->with('product.category')->latest()->get()->toArray();
    }

    protected $listeners = ['up'];

    public function render()
    {
        return view('livewire.add-new-entry', [
            'data' => $this->data,
            'idBonde' => $this->bonde?->id
        ]);
    }

    #[On('up')]
    public function up($data)
    {
        $this->data = $data;
    }

    public function click()
    {
        $this->bonde->is_confirm = true;
        $this->bonde->save();
        if ($this->type === 'entry') {
            return redirect()->route('achats.list')->with('success', 'Product created with success');
        }

        return redirect()->route('ventes.list')->with('success', 'Product created with success');
    }


    public function delete($current)
    {
        if ($this->type === 'entry') {
            Entry::find($current)->delete();
        } else {
            Sorty::find($current)->delete();
        }
        $this->data = Sorty::where('bonde_id', $this->bonde->id)->with('product.category')->latest()->get()->toArray();
    }
}
