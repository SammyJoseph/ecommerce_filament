@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="tw-bg-white tw-px-4 tw-pt-5 tw-pb-4 sm:tw-p-6 sm:tw-pb-4">
        <div class="sm:tw-flex sm:tw-items-start">
            <div class="tw-mx-auto tw-shrink-0 tw-flex tw-items-center tw-justify-center tw-size-12 tw-rounded-full tw-bg-red-100 sm:tw-mx-0 sm:tw-size-10">
                <svg class="tw-size-6 tw-text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>

            <div class="tw-mt-3 tw-text-center sm:tw-mt-0 sm:tw-ms-4 sm:tw-text-start">
                <h3 class="tw-text-lg tw-font-medium tw-text-gray-900">
                    {{ $title }}
                </h3>

                <div class="tw-mt-4 tw-text-sm tw-text-gray-600">
                    {{ $content }}
                </div>
            </div>
        </div>
    </div>

    <div class="tw-flex tw-flex-row tw-justify-end tw-px-6 tw-py-4 tw-bg-gray-100 tw-text-end">
        {{ $footer }}
    </div>
</x-modal>
