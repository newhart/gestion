<?php

namespace App\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Livewire\Component;
use Filament\Forms\Contracts\HasForms;

class UpdateSorty extends Component implements HasForms
{
    use InteractsWithForms;

    public function render()
    {
        return view('livewire.update-sorty');
    }
}
