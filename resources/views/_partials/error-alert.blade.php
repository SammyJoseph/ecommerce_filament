@if (session('error') || $errors->any())
<div x-data="{ show: true }" x-show="show" 
     x-transition:enter="tw-transition tw-ease-out tw-duration-300"
     x-transition:enter-start="tw-opacity-0 tw-translate-y-full"
     x-transition:enter-end="tw-opacity-100 tw-translate-y-0"
     x-transition:leave="tw-transition tw-ease-in tw-duration-200"
     x-transition:leave-start="tw-opacity-100 tw-translate-y-0"
     x-transition:leave-end="tw-opacity-0 tw-translate-y-full"
    id="alert-border-2" class="tw-fixed tw-bottom-0 tw-left-1/2 -tw-translate-x-1/2 tw-w-full tw-max-w-2xl tw-z-20 tw-flex tw-items-center tw-p-4 tw-text-red-800 tw-border-solid tw-border-0 tw-border-t-4 tw-border-red-300 tw-bg-red-50 dark:tw-text-red-400 dark:tw-bg-gray-800 dark:tw-border-red-800" role="alert">
    <svg class="tw-shrink-0 tw-w-4 tw-h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
      <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
    </svg>
    <div class="tw-ms-3 tw-text-sm tw-font-medium">
      @if (session('error'))
          {{ session('error') }}
      @else
          <ul class="tw-list-none">
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      @endif
    </div>
    <button type="button" @click="show = false" class="tw-border-none tw-ms-auto tw--mx-1.5 tw--my-1.5 tw-bg-red-50 tw-text-red-500 tw-rounded-lg focus:tw-ring-2 focus:tw-ring-red-400 tw-p-1.5 hover:tw-bg-red-200 tw-inline-flex tw-items-center tw-justify-center tw-h-8 tw-w-8 dark:tw-bg-gray-800 dark:tw-text-red-400 dark:hover:tw-bg-gray-700"  data-dismiss-target="#alert-border-2" aria-label="Close">
      <span class="tw-sr-only">Dismiss</span>
      <svg class="tw-w-3 tw-h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
      </svg>
    </button>
</div>
@endif