<div>
    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <div class="flex justify-end">
            <button type="submit" class="btn btn-primary mt-3 mx-3">
                Ajouter
            </button>
            <button type="button" class="btn btn-light-primary font-weight-bold mt-3" data-dismiss="modal">Annuler</button>
        </div>
    </form>
    <x-filament-actions::modals />
</div>
