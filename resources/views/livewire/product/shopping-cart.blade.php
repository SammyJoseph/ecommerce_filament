{{-- <div class="row">
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
                                <button wire:click="removeCoupon" wire:loading.attr="disabled" wire:target="removeCoupon" style="background: transparent; border: none; color: red; cursor: pointer;">
                                    [Remove]
                                    <span wire:loading wire:target="removeCoupon" class="tw-inline-block tw-ml-2">
                                        <svg class="tw-animate-spin tw-h-3 tw-w-3 tw-text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="tw-opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="tw-opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </span>
                                </button>
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
                    <li><a class="cart__summary--footer__btn primary__btn checkout"
                            href="checkout.html">Check Out</a></li>
                </ul>
            </div>
        </div>
    </div>
</div> --}}
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
        @livewire('product.cart')        
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="cart-tax">
                    <div class="title-wrap">
                        <h4 class="cart-bottom-title section-bg-gray">Estimate Shipping And Tax</h4>
                    </div>
                    <div class="tax-wrapper">
                        <p>Enter your destination to get a shipping estimate.</p>
                        <div class="tax-select-wrapper">
                            <div class="tax-select">
                                <label>
                                    * Country
                                </label>
                                <select class="email s-email s-wid">
                                    <option>Bangladesh</option>
                                    <option>Albania</option>
                                    <option>Åland Islands</option>
                                    <option>Afghanistan</option>
                                    <option>Belgium</option>
                                </select>
                            </div>
                            <div class="tax-select">
                                <label>
                                    * Region / State
                                </label>
                                <select class="email s-email s-wid">
                                    <option>Bangladesh</option>
                                    <option>Albania</option>
                                    <option>Åland Islands</option>
                                    <option>Afghanistan</option>
                                    <option>Belgium</option>
                                </select>
                            </div>
                            <div class="tax-select">
                                <label>
                                    * Zip/Postal Code
                                </label>
                                <input type="text">
                            </div>
                            <button class="cart-btn-2" type="submit">Get A Quote</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="discount-code-wrapper">
                    <div class="title-wrap">
                        <h4 class="cart-bottom-title section-bg-gray">Use Coupon Code</h4>
                    </div>
                    <div class="discount-code">
                        <p>Enter your coupon code if you have one.</p>
                        <form>
                            <input type="text" required="" name="name">
                            <button class="cart-btn-2" type="submit">Apply Coupon</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="grand-totall">
                    <div class="title-wrap">
                        <h4 class="cart-bottom-title section-bg-gary-cart">Cart Total</h4>
                    </div>
                    <h5>Total products <span>$260.00</span></h5>
                    <div class="total-shipping">
                        <h5>Total shipping</h5>
                        <ul>
                            <li><input type="checkbox"> Standard <span>$20.00</span></li>
                            <li><input type="checkbox"> Express <span>$30.00</span></li>
                        </ul>
                    </div>
                    <h4 class="grand-totall-title">Grand Total <span>$260.00</span></h4>
                    <a href="#">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>