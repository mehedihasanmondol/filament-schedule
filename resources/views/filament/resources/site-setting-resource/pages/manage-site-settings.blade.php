<x-filament-panels::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}
        <div class="filament-page-actions py-4">
            <x-filament::button
                type="submit"
                color="primary"
                size="lg"
                wire:loading.attr="disabled"
            >
                <x-filament::loading-indicator
                    wire:loading
                    class="w-4 h-4 me-3"
                />
                Save Settings
            </x-filament::button>
        </div>
    </form>

</x-filament-panels::page>
