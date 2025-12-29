@if (filament()->auth()->check())
    <div class="flex items-center gap-2">
        <div class="font-bold text-xl">
            Ir a la tienda
        </div>
        <svg class="w-6 h-6 text-primary-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M160-720v-80h640v80H160Zm0 560v-240h-40v-80l40-200h640l40 200v80h-40v240h-80v-240H560v240H160Zm80-80h240v-160H240v160Z"/></svg>
    </div>
@else
    <div class="font-bold text-xl">
        {{ config('app.name') }}
    </div>
@endif
