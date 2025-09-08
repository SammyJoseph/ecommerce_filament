<div class="row">
    <div class="col-lg-8">
        @livewire('product.cart')
    </div>
    <div class="col-lg-4">
        <div class="cart__summary border-radius-10">
            @livewire('product.coupon-code')
            <div class="cart__note mb-20">
                <h3 class="cart__note--title">Note</h3>
                <p class="cart__note--desc">Add special instructions for your seller...</p>
                <textarea class="cart__note--textarea border-radius-5"></textarea>
            </div>
            <div class="cart__summary--total mb-20">
                <table class="cart__summary--total__table">
                    <tbody>
                        <tr class="cart__summary--total__list">
                            <td class="cart__summary--total__title text-left">SUBTOTAL</td>
                            <td class="cart__summary--amount text-right">${{ number_format($cartSubtotal, 2) }}</td>
                        </tr>
                        @if (session()->has('coupon'))
                        <tr class="cart__summary--total__list">
                            <td class="cart__summary--total__title text-left">
                                DISCOUNT ({{ session('coupon')['code'] }})
                                <button wire:click="removeCoupon" style="background: transparent; border: none; color: red; cursor: pointer;">[Remove]</button>
                            </td>
                            <td class="cart__summary--amount text-right">-${{ number_format($cartDiscount, 2) }}</td>
                        </tr>
                        @endif
                        <tr class="cart__summary--total__list">
                            <td class="cart__summary--total__title text-left">GRAND TOTAL</td>
                            <td class="cart__summary--amount text-right">${{ number_format($cartGrandTotal, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="cart__summary--footer">
                <p class="cart__summary--footer__desc">Shipping & taxes calculated at checkout
                </p>
                <ul class="d-flex justify-content-end">
                    {{-- <li><button class="cart__summary--footer__btn primary__btn cart"
                            type="submit">Update Cart</button></li> --}}
                    <li><a class="cart__summary--footer__btn primary__btn checkout"
                            href="checkout.html">Check Out</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>