{{-- <div class="coupon__code mb-30">
    <h3 class="coupon__code--title">Coupon</h3>
    <p class="coupon__code--desc">Enter your coupon code if you have one.</p>

    @if (session()->has('success'))
        <div style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div style="color: red; margin-bottom: 10px;">{{ session('error') }}</div>
    @endif

    <div class="coupon__code--field d-flex">
        <label>
            <input class="coupon__code--field__input border-radius-5"
                placeholder="Coupon code" type="text" wire:model="couponCode">
        </label>
        <button class="coupon__code--field__btn primary__btn btn__style3" type="button" wire:click="applyCoupon">
            Apply Coupon
        </button>
    </div>
    @error('couponCode') <span style="color: red;">{{ $message }}</span> @enderror
</div> --}}
<div>
    @if (session()->has('success'))
        <div style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div style="color: red; margin-bottom: 10px;">{{ session('error') }}</div>
    @endif
    <input wire:model="couponCode" class="tw-mb-7" type="text" name="name">
    <button wire:click="applyCoupon" class="cart-btn-2" type="submit">Apply Coupon</button>
    @error('couponCode') <span style="color: red;">{{ $message }}</span> @enderror
</div>