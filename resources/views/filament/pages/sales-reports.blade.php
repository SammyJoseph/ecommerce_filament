<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Filters Section -->
        <x-filament::section collapsible>
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

        <!-- Stats Overview - Full Width -->
        <!-- Stats Overview - Full Width -->
        <div class="grid grid-cols-1 gap-6">
            <livewire:is :component="$this->getFilteredWidgets()[0]" wire:key="{{ $this->getFilteredWidgets()[0] }}" />
        </div>

        <!-- Sales Over Time Chart - Full Width -->
        <div class="grid grid-cols-1 gap-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <livewire:is :component="$this->getFilteredWidgets()[1]" wire:key="{{ $this->getFilteredWidgets()[1] }}" />
            </div>
        </div>

        <!-- Bottom Row - Three Charts Side by Side -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <livewire:is :component="$this->getFilteredWidgets()[2]" wire:key="{{ $this->getFilteredWidgets()[2] }}" />
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <livewire:is :component="$this->getFilteredWidgets()[3]" wire:key="{{ $this->getFilteredWidgets()[3] }}" />
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <livewire:is :component="$this->getFilteredWidgets()[4]" wire:key="{{ $this->getFilteredWidgets()[4] }}" />
            </div>
        </div>
    </div>
</x-filament-panels::page>