<div>
    @if (session()->has('coupon'))
        <div class="tw-p-3 tw-bg-green-100 tw-border tw-border-green-200 tw-rounded-md tw-flex tw-items-center tw-justify-between">
            <p class="tw-text-sm tw-font-medium tw-text-green-800 mb-0">
                Cupón aplicado: <span class="tw-font-bold">{{ session('coupon')['code'] }}</span>
            </p>
            <button wire:click="$dispatch('removeCoupon')" type="button" class="tw-text-green-600 hover:tw-text-green-800 tw-border-none tw-bg-transparent" title="Remover cupón">
                <svg class="tw-w-5 tw-h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
    @else
        <input wire:model.defer="couponCode" class="tw-mb-7 tw-bg-white focus:tw-bg-white" type="text" placeholder="Ingresa tu cupón">
        <button wire:click="applyCoupon" wire:loading.attr="disabled" wire:target="applyCoupon" class="cart-btn-2" type="submit">
            <span wire:loading.remove wire:target="applyCoupon">Apply Coupon</span>
            <span wire:loading wire:target="applyCoupon" class="tw-flex tw-items-center">
                <svg class="tw-animate-spin tw-h-4 tw-w-4 tw-mr-2 tw-text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="tw-opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="tw-opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Applying...
            </span>
        </button>
    @endif

    @if (session()->has('success'))
        <div style="color: green; margin-top: 10px;">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div style="color: red; margin-top: 10px;">{{ session('error') }}</div>
    @endif
    @error('couponCode') <span style="color: red; margin-top: 10px;">{{ $message }}</span> @enderror
</div>