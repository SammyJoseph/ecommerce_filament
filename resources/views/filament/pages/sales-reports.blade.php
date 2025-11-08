<x-filament-panels::page>
    <!-- Filters Section -->
    <x-filament::section collapsible collapsed class="mb-6">
        <x-slot name="heading">
            <div class="flex items-center gap-2">
                <x-heroicon-o-funnel class="w-5 h-5" />
                Filters
            </div>
        </x-slot>

        <x-slot name="description">
            Filter sales data by date range and status
        </x-slot>

        {{ $this->form }}
    </x-filament::section>
</x-filament-panels::page>