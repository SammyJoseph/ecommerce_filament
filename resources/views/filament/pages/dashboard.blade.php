<x-filament-panels::page>
    {{-- Filters Form --}}
    <x-filament::section>
        {{ $this->filtersForm }}
    </x-filament::section>

    {{-- Widgets Grid --}}
    <x-filament-widgets::widgets
        :widgets="$this->getVisibleWidgets()"
        :columns="$this->getColumns()"
    />
</x-filament-panels::page>