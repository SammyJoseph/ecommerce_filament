<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
        {{-- Productos en el carrito --}}
        <div class="table-content table-responsive cart-table-content">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Unit Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productsInCart as $product)
                    <tr wire:key="cart-item-{{ $product->rowId }}" x-data="{ qty: {{ $product->qty }}, loading: false }">
                        <td class="product-thumbnail tw-p-6">
                            <img class="tw-inline tw-w-full tw-object-cover" src="{{ $product->options->image }}" alt="">
                        </td>
                        <td class="product-name"><a href="{{ route('product.show', $product->options->slug) }}">{{ $product->name }}</a></td>
                        <td class="product-price-cart"><span class="amount">${{ number_format($product->price, 2) }}</span></td>
                        <td class="product-quantity pro-details-quality">
                            <div class="cart-plus-minus-livewire">
                                <div class="dec qtybutton" @click="if(qty > 1) { qty--; loading = true; $wire.updateQuantity('{{ $product->rowId }}', qty).then(() => loading = false); }">-</div>
                                <input class="cart-plus-minus-box" type="text" name="qtybutton" x-model="qty" @change="loading = true; $wire.updateQuantity('{{ $product->rowId }}', qty).then(() => loading = false)">
                                <div class="inc qtybutton" @click="qty++; loading = true; $wire.updateQuantity('{{ $product->rowId }}', qty).then(() => loading = false)">+</div>
                            </div>
                        </td>
                        <td class="product-subtotal">
                            <span x-show="!loading">${{ number_format($product->subtotal, 2) }}</span>
                            <div x-show="loading" class="tw-flex tw-justify-center tw-items-center">
                                <svg class="tw-animate-spin tw-h-5 tw-w-5 tw-text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="tw-opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="tw-opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </td>
                        <td class="product-remove">
                            <button wire:click="removeFromCart('{{ $product->rowId }}')" wire:loading.attr="disabled" wire:target="removeFromCart('{{ $product->rowId }}')">
                                <i class="icon_close" wire:loading.remove wire:target="removeFromCart('{{ $product->rowId }}')"></i>
                                <div wire:loading wire:target="removeFromCart('{{ $product->rowId }}')" class="tw-inline-block">
                                    <svg class="tw-animate-spin tw-h-3 tw-w-3 tw-text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="tw-opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="tw-opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="tw-text-center tw-py-10">
                            Your cart is empty.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Botones de acción --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="cart-shiping-update-wrapper">
                    <div class="cart-shiping-update">
                        <a href="#">Continue Shopping</a>
                    </div>
                    <div class="cart-clear">
                        <button wire:click="clearCart" type="button">
                            <span>Clear Cart</span>
                            <div wire:loading wire:target="clearCart" class="tw-inline-block tw-ml-1">
                                <svg class="tw-animate-spin tw-h-3 tw-w-3 tw-text-gray-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="tw-opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="tw-opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            {{-- Dirección de envío --}}
            <div class="col-lg-4 col-md-6">
                <div class="cart-tax">
                    <div class="title-wrap">
                        <h4 class="cart-bottom-title section-bg-gray">Estimate Shipping And Tax</h4>
                    </div>
                    <div class="tax-wrapper">
                        <p>Enter your destination to get a shipping estimate.</p>
                        
                        @auth
                            <div class="tax-select-wrapper tw-mb-4">
                                <div class="tax-select">
                                    <label>
                                        Saved Address
                                    </label>
                                    <select wire:model.live="selectedAddressId" class="email s-email s-wid">
                                        @foreach($userAddresses as $address)
                                            <option value="{{ $address->id }}">
                                                {{ $address->address }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="tw-bg-gray-50 tw-rounded-lg tw-mt-4">
                                    <div class="tw-flex tw-items-center tw-justify-between"><h5>Departamento:</h5> <p>{{ $selectedDepartment ?? 'Not selected' }}</p></div>
                                    <div class="tw-flex tw-items-center tw-justify-between mt-2"><h5>Provincia:</h5> <p>{{ $selectedProvince ?? 'Not selected' }}</p></div>
                                    <div class="tw-flex tw-items-center tw-justify-between mt-2"><h5>Distrito:</h5> <p>{{ $selectedDistrict ?? 'Not selected' }}</p></div>
                                </div>
                            </div>
                        @endauth

                        @guest
                        <div class="tax-select-wrapper" wire:ignore>
                            <div class="tax-select">
                                <label>
                                    * Departamento
                                </label>
                                <select id="select-departamento" class="email s-email s-wid">
                                    <option value="">Seleccione Departamento</option>
                                </select>
                            </div>
                            <div class="tax-select">
                                <label>
                                    * Provincia
                                </label>
                                <select id="select-provincia" class="email s-email s-wid" disabled>
                                    <option value="">Seleccione Provincia</option>
                                </select>
                            </div>
                            <div class="tax-select">
                                <label>
                                    * Distrito
                                </label>
                                <select id="select-distrito" class="email s-email s-wid" disabled>
                                    <option value="">Seleccione Distrito</option>
                                </select>
                            </div>
                        </div>     
                        @endguest
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
                    <h5>Total products 
                        <span wire:target="updateQuantity" wire:loading.remove>{{ number_format($cartSubtotal, 2) }}</span>
                        <div wire:target="updateQuantity" wire:loading class="tw-float-end">
                            <svg class="tw-animate-spin tw-h-4 tw-w-4 tw-text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="tw-opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="tw-opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </h5>
                    @if (session()->has('coupon'))
                    <p class="tw-mb-6">
                        Discount
                        <button wire:click="removeCoupon" class="tw-ml-2 tw-border-none tw-bg-transparent">x</button>
                        <span class="tw-float-end">-{{ number_format($cartDiscount, 2) }}</span></p>
                    @endif
                    <div class="total-shipping tw-flex tw-justify-between tw-items-center">
                        <p class="tw-mb-0">Shipping Cost</p>
                        <ul class="!tw-pt-0">
                            <li wire:loading.remove>
                                @if($shippingCost > 0)
                                    <span>${{ number_format($shippingCost, 2) }}</span>
                                @else
                                    <span>0.00</span>
                                @endif
                            </li>
                            <li wire:loading class="tw-w-full">
                                <div class="tw-flex tw-justify-end">
                                    <svg class="tw-animate-spin tw-h-4 tw-w-4 tw-text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="tw-opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="tw-opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <h4 class="grand-totall-title">Grand Total 
                        <span wire:loading.remove>${{ number_format($cartGrandTotal, 2) }}</span>
                        <div wire:loading class="tw-float-end">
                            <svg class="tw-animate-spin tw-h-5 tw-w-5 tw-text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="tw-opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="tw-opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </h4>
                    <a href="{{ route('checkout.index') }}">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Only run ubigeo logic for guests
            const isLoggedIn = @json(auth()->check());
            if (isLoggedIn) {
                return; // Exit early for authenticated users
            }

            const deptSelect = document.getElementById('select-departamento');
            const provSelect = document.getElementById('select-provincia');
            const distSelect = document.getElementById('select-distrito');

            const initialDept = @json($selectedDeptCode);
            const initialProv = @json($selectedProvCode);
            const initialDist = @json($selectedDistCode);

            let departamentos = @json($departments);
            let provincias = {};
            let distritos = {};

            Promise.all([
                fetch('/ubigeo/provincias.json').then(res => res.json()),
                fetch('/ubigeo/distritos.json').then(res => res.json())
            ]).then(([provData, distData]) => {
                provincias = provData;
                distritos = distData;

                populateDepartamentos();
                
                if (initialDept) {
                    deptSelect.value = initialDept;
                    populateProvincias(initialDept);
                    
                    if (initialProv) {
                        provSelect.value = initialProv;
                        populateDistritos(initialProv);
                        
                        if (initialDist) {
                            distSelect.value = initialDist;
                        }
                    }
                }
            }).catch(err => console.error('Error loading Ubigeo data:', err));

            function populateDepartamentos() {
                departamentos.forEach(dept => {
                    const option = document.createElement('option');
                    option.value = dept.id_ubigeo;
                    option.textContent = dept.nombre_ubigeo;
                    deptSelect.appendChild(option);
                });
            }

            function populateProvincias(deptId) {
                provSelect.innerHTML = '<option value="">Seleccione Provincia</option>';
                distSelect.innerHTML = '<option value="">Seleccione Distrito</option>';
                provSelect.disabled = true;
                distSelect.disabled = true;

                if (deptId && provincias[deptId]) {
                    provincias[deptId].forEach(prov => {
                        const option = document.createElement('option');
                        option.value = prov.id_ubigeo;
                        option.textContent = prov.nombre_ubigeo;
                        provSelect.appendChild(option);
                    });
                    provSelect.disabled = false;
                }
            }

            function populateDistritos(provId) {
                distSelect.innerHTML = '<option value="">Seleccione Distrito</option>';
                distSelect.disabled = true;

                if (provId && distritos[provId]) {
                    distritos[provId].forEach(dist => {
                        const option = document.createElement('option');
                        option.value = dist.id_ubigeo;
                        option.textContent = dist.nombre_ubigeo;
                        distSelect.appendChild(option);
                    });
                    distSelect.disabled = false;
                }
            }

            deptSelect.addEventListener('change', function() {
                const deptId = this.value;
                @this.set('selectedDepartment', deptId);
                populateProvincias(deptId);
            });

            provSelect.addEventListener('change', function() {
                const provId = this.value;
                @this.set('selectedProvince', provId);
                populateDistritos(provId);
            });
            
            distSelect.addEventListener('change', function() {
                const distId = this.value;
                @this.set('selectedDistrict', distId);
            });

            window.addEventListener('address-changed', event => {
                const { department, province, district } = event.detail;
                
                if (department) {
                    deptSelect.value = department;
                    populateProvincias(department);
                    
                    if (province) {
                        provSelect.value = province;
                        populateDistritos(province);
                        
                        if (district) {
                            distSelect.value = district;
                        }
                    }
                }
            });            
        });
    </script>
@endpush