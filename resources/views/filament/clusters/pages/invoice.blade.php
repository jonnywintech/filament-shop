<x-filament-panels::page>
    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}
        <x-filament-panels::form.actions :actions="$this->getFormActions()" />
    </x-filament-panels::form>
    <x-invoice-layout :font="$data['font']"
     :color="$data['color']"
     :logo="$this->logo()"
     :show_logo="$this->showLogo()"
     :invoice_data="[]" />
</x-filament-panels::page>
