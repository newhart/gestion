<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>
<div>
    <a href="#" wire:click="logout"  class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">Déconnexion</a>
</div>