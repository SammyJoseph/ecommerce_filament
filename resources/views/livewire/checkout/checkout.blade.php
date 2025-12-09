<div class="checkout-wrap pt-30">
    <form class="row" wire:submit="placeOrder">
        <!-- FORMULARIO DE FACTURACIÓN -->
        <div class="col-lg-7">
            <div class="billing-info-wrap mr-50">
                <h3>Billing Details</h3>
                
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="billing-info mb-20">
                            <label>First Name <abbr class="required" title="required">*</abbr></label>
                            <input type="text" wire:model="firstName" class="@error('firstName') border-danger @enderror" required>
                            @error('firstName') <span class="text-danger text-small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="billing-info mb-20">
                            <label>Last Name <abbr class="required" title="required">*</abbr></label>
                            <input type="text" wire:model="lastName" class="@error('lastName') border-danger @enderror" required>
                            @error('lastName') <span class="text-danger text-small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="billing-info mb-20">
                            <label>Email Address <abbr class="required" title="required">*</abbr></label>
                            <input type="email" wire:model="email" class="@error('email') border-danger @enderror" required>
                            @error('email') <span class="text-danger text-small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="billing-info mb-20">
                            <label>Phone <abbr class="required" title="required">*</abbr></label>
                            <input type="text" wire:model="phone" class="@error('phone') border-danger @enderror" required>
                            @error('phone') <span class="text-danger text-small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    @if(auth()->check())
                    <div class="col-lg-12 mb-3 tax-select">
                        <label class="form-label">Select address</label>
                        <select wire:model.live="selectedShippingAddressId" class="email s-email s-wid tw-border tw-p-3">
                            <option value="" @if(count($shippingAddresses) >= 5) hidden @endif>Enter new address below</option>
                            @foreach($shippingAddresses as $addr)
                            <option value="{{ $addr->id }}">
                                {{ $addr->department }}, {{ $addr->province }}, {{ $addr->district }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    
                    @endif
                    <div class="col-lg-12">
                        <div class="billing-info mb-20">                                                        
                            @if($selectedShippingAddressId)
                                <div class="tw-p-4 tw-border tw-rounded tw-bg-gray-50 tw-flex tw-justify-between tw-items-start">
                                    <div>
                                        <p class="tw-mb-1 tw-font-medium">{{ $address }}</p>
                                        @if($reference)
                                            <p class="tw-text-sm tw-text-gray-500">Ref: {{ $reference }}</p>
                                        @endif
                                    </div>
                                    <button type="button" wire:click="editAddress" class="check-btn sqr-btn tw-border-none tw-bg-transparent hover:tw-text-blue-700 tw-text-xs">
                                        Edit
                                    </button>
                                </div>
                            @else
                                <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-3 tw-gap-4 tw-mb-4">
                                    <div>
                                        <label>Department <abbr class="required" title="required">*</abbr></label>
                                        <select wire:model.live="selectedDeptId" class="tw-w-full tw-border tw-p-2 tw-rounded" required>
                                            <option value="">Select</option>
                                            @foreach($departments as $dept)
                                                <option value="{{ $dept['id_ubigeo'] }}">{{ $dept['nombre_ubigeo'] }}</option>
                                            @endforeach
                                        </select>
                                        @error('department') <span class="text-danger text-small">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label>Province <abbr class="required" title="required">*</abbr></label>
                                        <select wire:model.live="selectedProvId" class="tw-w-full tw-border tw-p-2 tw-rounded" {{ empty($provinces) ? 'disabled' : '' }} required>
                                            <option value="">Select</option>
                                            @foreach($provinces as $prov)
                                                <option value="{{ $prov['id_ubigeo'] }}">{{ $prov['nombre_ubigeo'] }}</option>
                                            @endforeach
                                        </select>
                                        @error('province') <span class="text-danger text-small">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label>District <abbr class="required" title="required">*</abbr></label>
                                        <select wire:model.live="selectedDistId" class="tw-w-full tw-border tw-p-2 tw-rounded" {{ empty($districts) ? 'disabled' : '' }} required>
                                            <option value="">Select</option>
                                            @foreach($districts as $dist)
                                                <option value="{{ $dist['id_ubigeo'] }}">{{ $dist['nombre_ubigeo'] }}</option>
                                            @endforeach
                                        </select>
                                        @error('district') <span class="text-danger text-small">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <label>Street Address <abbr class="required" title="required">*</abbr></label>
                                <input class="billing-address @error('address') border-danger @enderror" placeholder="House number and street name" type="text" wire:model="address" required>
                                @error('address') <span class="text-danger text-small">{{ $message }}</span> @enderror
                                
                                <input placeholder="Reference" type="text" wire:model="reference">
                            @endif

                            @if($isEditingAddress)
                                <div class="tw-fixed tw-inset-0 tw-z-50 tw-flex tw-items-center tw-justify-center tw-bg-black tw-bg-opacity-50">
                                    <div class="tw-bg-white tw-p-6 tw-rounded-lg tw-shadow-xl tw-w-full tw-max-w-md">
                                        <h3 class="tw-text-lg tw-font-bold tw-mb-4">Edit Address</h3>
                                        
                                        <div class="tw-mb-4">
                                            <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Address Type</label>
                                            <select wire:model="address_type" class="tw-w-full tw-border tw-p-2 tw-rounded">
                                                <option value="home">Home</option>
                                                <option value="work">Work</option>
                                                <option value="other">Other</option>
                                            </select>
                                            @error('address_type') <span class="text-danger text-small">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-3 tw-gap-4 tw-mb-4">
                                            <div>
                                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Department</label>
                                                <select wire:model.live="selectedDeptId" class="tw-w-full tw-border tw-p-2 tw-rounded">
                                                    <option value="">Select</option>
                                                    @foreach($departments as $dept)
                                                        <option value="{{ $dept['id_ubigeo'] }}">{{ $dept['nombre_ubigeo'] }}</option>
                                                    @endforeach
                                                </select>
                                                @error('department') <span class="text-danger text-small">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Province</label>
                                                <select wire:model.live="selectedProvId" class="tw-w-full tw-border tw-p-2 tw-rounded" {{ empty($provinces) ? 'disabled' : '' }}>
                                                    <option value="">Select</option>
                                                    @foreach($provinces as $prov)
                                                        <option value="{{ $prov['id_ubigeo'] }}">{{ $prov['nombre_ubigeo'] }}</option>
                                                    @endforeach
                                                </select>
                                                @error('province') <span class="text-danger text-small">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">District</label>
                                                <select wire:model.live="selectedDistId" class="tw-w-full tw-border tw-p-2 tw-rounded" {{ empty($districts) ? 'disabled' : '' }}>
                                                    <option value="">Select</option>
                                                    @foreach($districts as $dist)
                                                        <option value="{{ $dist['id_ubigeo'] }}">{{ $dist['nombre_ubigeo'] }}</option>
                                                    @endforeach
                                                </select>
                                                @error('district') <span class="text-danger text-small">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="tw-mb-4">
                                            <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Address</label>
                                            <input type="text" wire:model="address" class="tw-w-full tw-border tw-p-2 tw-rounded">
                                            @error('address') <span class="text-danger text-small">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="tw-mb-4">
                                            <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Reference</label>
                                            <input type="text" wire:model="reference" class="tw-w-full tw-border tw-p-2 tw-rounded">
                                        </div>

                                        <div class="tw-flex tw-justify-end tw-gap-2">
                                            <button wire:click="cancelEditAddress" class="tw-px-4 tw-py-2 tw-bg-gray-200 tw-rounded hover:tw-bg-gray-300">Cancel</button>
                                            <button wire:click="saveAddress" class="tw-px-4 tw-py-2 tw-bg-black tw-text-white tw-rounded hover:tw-bg-gray-800">Save</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
                                <li class="tw-flex tw-justify-between tw-items-center">
                                    Shipping 
                                    <span>
                                        <span wire:loading.remove wire:target="selectedShippingAddressId, selectedDeptId, selectedProvId, selectedDistId">
                                            ${{ number_format($this->shipping, 2) }}
                                        </span>
                                        <span wire:loading wire:target="selectedShippingAddressId, selectedDeptId, selectedProvId, selectedDistId">
                                            <svg class="tw-animate-spin tw-h-4 tw-w-4 tw-text-gray-500 tw-inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="tw-opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="tw-opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <div class="your-order-info order-total">
                            <ul>
                                <li class="tw-flex tw-justify-between tw-items-center">
                                    Total 
                                    <span>
                                        <span wire:loading.remove wire:target="selectedShippingAddressId, selectedDeptId, selectedProvId, selectedDistId">
                                            ${{ number_format($total, 2) }} 
                                        </span>
                                        <span wire:loading wire:target="selectedShippingAddressId, selectedDeptId, selectedProvId, selectedDistId">
                                            <svg class="tw-animate-spin tw-h-4 tw-w-4 tw-text-gray-500 tw-inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="tw-opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="tw-opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
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
                    @if (session()->has('error'))
                        <div class="alert alert-danger mb-3">
                            {{ session('error') }}
                        </div>
                    @endif

                    <button type="submit" wire:loading.attr="disabled" wire:target="placeOrder" class="tw-border-none">                        
                        <span wire:loading.remove wire:target="placeOrder">PLACE ORDER</span>                        
                        <span wire:loading wire:target="placeOrder">
                            <i class="fa fa-spinner fa-spin mr-2"></i> PROCESSING...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>