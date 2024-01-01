<div>
    <div class="card card-custom">
        <div class="card-body">
            <form wire:submit.prevent="submit">
                {{ $this->form }}
                <button type="submit" class="btn btn-primary mt-3">
                    Valider
                </button>
            </form>
            <x-filament-actions::modals />
        </div>
    </div>

</div>
