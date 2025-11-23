<div class="checkout-wrap pt-30">
    <div class="row">
        <!-- FORMULARIO DE FACTURACIÓN -->
        <div class="col-lg-7">
            <div class="billing-info-wrap mr-50">
                <h3>Billing Details</h3>
                
                <!-- Campos -->
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="billing-info mb-20">
                            <label>First Name <abbr class="required" title="required">*</abbr></label>
                            <!-- Usamos wire:model y clases condicionales de error -->
                            <input type="text" wire:model="firstName" class="@error('firstName') border-danger @enderror">
                            @error('firstName') <span class="text-danger text-small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="billing-info mb-20">
                            <label>Last Name <abbr class="required" title="required">*</abbr></label>
                            <input type="text" wire:model="lastName" class="@error('lastName') border-danger @enderror">
                            @error('lastName') <span class="text-danger text-small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="billing-info mb-20">
                            <label>Email Address <abbr class="required" title="required">*</abbr></label>
                            <input type="text" wire:model="email" class="@error('email') border-danger @enderror">
                            @error('email') <span class="text-danger text-small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="billing-info mb-20">
                            <label>Phone <abbr class="required" title="required">*</abbr></label>
                            <input type="text" wire:model="phone" class="@error('phone') border-danger @enderror">
                            @error('phone') <span class="text-danger text-small">{{ $message }}</span> @enderror
                        </div>
                    </div> 
                    <div class="col-lg-12">
                        <div class="billing-info mb-20">
                            <label>Street Address <abbr class="required" title="required">*</abbr></label>
                            <input class="billing-address @error('address') border-danger @enderror" placeholder="House number and street name" type="text" wire:model="address">
                            @error('address') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            
                            <input class="mt-2" placeholder="Reference (Optional)" type="text" wire:model="reference">
                        </div>
                    </div>                                                                                               
                </div>
                
                <div class="additional-info-wrap">
                    <label>Order notes</label>
                    <textarea placeholder="Notes about your order, e.g. special notes for delivery." wire:model="notes"></textarea>
                </div>
            </div>
        </div>

        <!-- RESUMEN DE ORDEN -->
        <div class="col-lg-5">
            <div class="your-order-area">
                <h3>Your order</h3>
                <div class="your-order-wrap gray-bg-4">
                    <div class="your-order-info-wrap">
                        <div class="your-order-info">
                            <ul>
                                <li>Product <span>Total</span></li>
                            </ul>
                        </div>
                        <div class="your-order-middle">
                            <ul>
                                @foreach($cartItems as $item)
                                    <li>{{ $item->name }} X {{ $item->qty }} <span>${{ number_format($item->price, 2) }} </span></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="your-order-info order-subtotal">
                            <ul>
                                <li>Subtotal <span>${{ number_format($subtotal, 2) }} </span></li>
                            </ul>
                        </div>
                        @if($discount > 0)
                        <div class="your-order-info order-subtotal">
                            <ul>
                                <li>Discount <span class="text-success">-${{ number_format($discount, 2) }} </span></li>
                            </ul>
                        </div>
                        @endif
                        <div class="your-order-info order-shipping">
                            <ul>
                                <li>Shipping <span>${{ number_format($shipping, 2) }}</span></li>
                            </ul>
                        </div>
                        <div class="your-order-info order-total">
                            <ul>
                                <li>Total <span>${{ number_format($total, 2) }} </span></li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- MÉTODOS DE PAGO CON ALPINE + LIVEWIRE -->
                    <div class="payment-method" x-data="{ method: @entangle('paymentMethod') }">                        
                        <!-- Mercado Pago -->
                        <div class="pay-top sin-payment sin-payment-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <input id="payment-method-2" class="input-radio mt-0" type="radio" value="mercadopago" name="payment_method" x-model="method">
                                    <label for="payment-method-2" class="d-flex justify-content-between align-items-center !tw-ml-0">
                                        <span>Mercado Pago</span>
                                    </label>
                                    <img style="height: 24px;" src="https://img.icons8.com/color/48/mercado-pago.png" alt="MP">
                                </div>
                                <img class="tw-max-w-36" alt="" src="assets/images/icon-img/payment.png">
                            </div>
                            <div class="payment-box payment_method_bacs" x-show="method === 'mercadopago'">
                                <p>Serás redirigido a Mercado Pago para completar tu compra de forma segura con Tarjeta, Yape o Plin.</p>
                            </div>
                        </div>

                        <!-- PayPal (Ejemplo) -->
                        <div class="pay-top sin-payment sin-payment-3">
                            <input id="payment-method-3" class="input-radio" type="radio" value="paypal" name="payment_method" x-model="method">
                            <label for="payment-method-3">PayPal <img alt="" src="assets/images/icon-img/payment.png"></label>
                            <div class="payment-box payment_method_bacs" x-show="method === 'paypal'">
                                <p>Paga vía PayPal; puedes pagar con tu tarjeta de crédito si no tienes cuenta de PayPal.</p>
                            </div>
                        </div>

                        <!-- Transferencia (Ejemplo) -->
                        <div class="pay-top sin-payment">
                            <input id="payment_method_1" class="input-radio" type="radio" value="bank_transfer" name="payment_method" x-model="method">
                            <label for="payment_method_1">Direct Bank Transfer</label>
                            <div class="payment-box payment_method_bacs" x-show="method === 'bank_transfer'">
                                <p>Realiza tu pago directamente en nuestra cuenta bancaria.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BOTÓN DE ACCIÓN -->
                <div class="Place-order mt-25">
                    <!-- Mensaje de error general del servidor -->
                    @if (session()->has('error'))
                        <div class="alert alert-danger mb-3">
                            {{ session('error') }}
                        </div>
                    @endif

                    <button type="button" wire:click="placeOrder" wire:loading.attr="disabled" class="tw-border-none">                        
                        <span wire:loading.remove>PLACE ORDER</span>                        
                        <span wire:loading>
                            <i class="fa fa-spinner fa-spin mr-2"></i> PROCESSING...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>