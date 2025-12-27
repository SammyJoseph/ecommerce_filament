<div class="subscribe-area bg-gray pt-115">
    <div class="container">
        <div class="row tw-items-center">
            <div class="col-lg-5 col-md-5">
                <div class="section-title">
                    <h2>¡Suscríbete!</h2>
                    <p>Recibe ofertas exclusivas en tu correo</p>
                </div>
            </div>
            <div class="col-lg-7 col-md-7">
                <div class="subscribe-form">
                    @if($subscribed)
                        <div class="tw-flex tw-items-center tw-p-4 tw-text-sm tw-text-gray-800 tw-border tw-border-solid tw-border-gray-300 tw-rounded-lg tw-bg-gray-50 dark:tw-bg-gray-800 dark:tw-text-gray-300 dark:tw-border-gray-600" role="alert">
                            <svg class="tw-shrink-0 tw-inline tw-w-4 tw-h-4 tw-me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="tw-sr-only">Info</span>
                            <div>
                                {{ $message }}
                            </div>
                        </div>
                    @else
                        <form wire:submit="subscribe" class="subscribe-form-style">
                            <div class="mc-form">
                                <input wire:model="email" class="email" type="email" placeholder="Ingresa tu correo electrónico" required>
                                
                                <div class="clear">
                                    <button class="button tw-relative" type="submit" wire:loading.attr="disabled">
                                        <span>Suscribirme</span>
                                        <span wire:loading wire:target="subscribe">
                                            <svg class="tw-animate-spin tw-h-4 tw-w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="tw-opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="tw-opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            @error('email') 
                                <span class="text-danger" style="color: #dc3545; display: block; margin-top: 5px;">{{ $message }}</span>                                 
                            @enderror
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
