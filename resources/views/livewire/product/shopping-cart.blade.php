<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
        {{-- Productos en el carrito --}}
        @livewire('product.cart')        
        
        <div class="row">
            {{-- Dirección de envío --}}
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
            {{-- Cupón de descuento --}}
            <div class="col-lg-4 col-md-6">
                <div class="discount-code-wrapper">
                    <div class="title-wrap">
                        <h4 class="cart-bottom-title section-bg-gray">Use Coupon Code</h4>
                    </div>
                    <div class="discount-code">
                        <p>Enter your coupon code if you have one.</p>
                        @livewire('product.coupon-code')
                    </div>
                </div>
            </div>
            {{-- Total del carrito --}}
            <div class="col-lg-4 col-md-12">
                <div class="grand-totall">
                    <div class="title-wrap">
                        <h4 class="cart-bottom-title section-bg-gary-cart">Cart Total</h4>
                    </div>
                    <h5>Total products <span>{{ number_format($cartSubtotal, 2) }}</span></h5>
                    @if (session()->has('coupon'))
                    <p class="tw-mb-6">
                        Discount
                        <button wire:click="$dispatch('removeCoupon')" class="tw-ml-2">x</button>
                        <span class="tw-float-end">-{{ number_format($cartDiscount, 2) }}</span></p>
                    @endif
                    <div class="total-shipping">
                        <h5>Total shipping</h5>
                        <ul>
                            <li><input type="checkbox"> Standard <span>$20.00</span></li>
                            <li><input type="checkbox"> Express <span>$30.00</span></li>
                        </ul>
                    </div>
                    <h4 class="grand-totall-title">Grand Total <span>${{ number_format($cartGrandTotal, 2) }}</span></h4>
                    <a href="#">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>