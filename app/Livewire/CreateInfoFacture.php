<?php

namespace App\Livewire;

use App\Models\Facture;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Blade;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateInfoFacture extends Component
{

    public Facture $facture;
    public ?array $data = [];
    protected $listeners = ['up'];

    #[On('up')]
    public function up($data)
    {
        $this->data = $data;
    }

    public function mount(Facture $facture)
    {
        $this->facture = $facture;
        $this->data = $facture->load('contents.product')->toArray();
    }
    public function render()
    {
        return view('livewire.create-info-facture', ['facture' => $this->facture, 'data' => $this->data]);
    }

    public function down(Facture $facture)
    {

        return  response()->streamDownload(function () use ($facture) {
            $facture->load('contents.product');
            echo Pdf::loadHtml(
                Blade::render('facture-show', ['facture' => $facture])
            )
                ->setPaper('a4', 'landscape')
                ->stream();
        }, 'facture.pdf');
    }
}
