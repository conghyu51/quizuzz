<x-filament-panels::page.simple>
    <x-slot name="subheading">
        hoặc {{ $this->registerAction }}
    </x-slot>

    <x-filament-panels::form id="form" wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            fullWidth="true" />
    </x-filament-panels::form>
</x-filament-panels::page.simple>
