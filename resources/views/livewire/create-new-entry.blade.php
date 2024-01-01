<div>
    <div class="card card-custom">
        <div class="card-body">
            <form wire:submit.prevent="submit">
                {{ $this->form }}
                <button type="submit" class="btn btn-primary mt-3">
                    Ajouter
                </button>
                <a href="{{route('achats.list')}}" class="btn btn-secondary mt-3 mx-3">
                    Annuler
                </a>
            </form>
            <x-filament-actions::modals />
        </div>
    </div>
    
</div>
