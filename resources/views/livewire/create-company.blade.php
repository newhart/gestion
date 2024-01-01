<div class="card card-custom">
    <div class="card-body">
        <form wire:submit.prevent="submit">
            {{ $this->form }}
            <div class="flex">
                <button type="submit" class="btn btn-primary mt-3">
                    Ajouter
                </button>
                <a href="{{route('companies.list')}}" class="btn btn-secondary mt-3 mr-4">
                    Annuler
                </a>
            </div>
        </form>
        <x-filament-actions::modals />
    </div>
</div>
