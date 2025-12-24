<?php

namespace App\Livewire\Product;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ShoppingCart extends Component
{    
    public $selectedDepartment = null;
    public $selectedProvince = null;
    public $selectedDistrict = null;
    public $shippingCost = 0;
    
    public $userAddresses = [];
    public $selectedAddressId = null;
    
    // Ubigeo codes for frontend selects
    public $selectedDeptCode = null;
    public $selectedProvCode = null;
    public $selectedDistCode = null;
    
    // Ubigeo Data
    public $departments = [];
    public $provinces = [];
    public $districts = [];

    protected $ubigeoService;

    public function boot(\App\Services\UbigeoService $ubigeoService)
    {
        $this->ubigeoService = $ubigeoService;
    }

    public function mount()
    {
        $this->loadDepartments();
        
        if (Auth::check()) {
            $this->userAddresses = Auth::user()->addresses;
            $defaultAddress = Auth::user()->defaultAddress;
            
            $sessionAddressId = session('selected_address_id');
            
            $addresses = collect($this->userAddresses);

            if ($sessionAddressId && $addresses->contains('id', $sessionAddressId)) {
                $this->selectedAddressId = $sessionAddressId;
                $address = $addresses->firstWhere('id', $sessionAddressId);
                $this->setAddressLocation($address);
            } elseif ($defaultAddress) {
                $this->selectedAddressId = $defaultAddress->id;
                $this->setAddressLocation($defaultAddress);
                session()->put('selected_address_id', $defaultAddress->id);
            }
        } else {
            // For guests, load CODES from session (not names)
            $this->selectedDeptCode = session('selected_department');
            $this->selectedProvCode = session('selected_province');
            $this->selectedDistCode = session('selected_district');
            $this->shippingCost = session('shipping_cost', 0);
        }
    }

    protected function loadDepartments()
    {
        $this->departments = $this->ubigeoService->getDepartments();
    }

    public function updatedSelectedAddressId($value)
    {
        if ($value) {
            $address = collect($this->userAddresses)->where('id', $value)->first();
            if ($address) {
                $this->setAddressLocation($address);
                
                // Get ubigeo codes for the frontend
                $deptCode = $this->ubigeoService->getDepartmentIdByName($address->department);
                $provCode = $this->ubigeoService->getProvinceIdByName($deptCode, $address->province);
                $distCode = $this->ubigeoService->getDistrictIdByName($provCode, $address->district);
                
                $this->dispatch('address-changed', 
                    department: $deptCode,
                    province: $provCode,
                    district: $distCode
                );
                
                session()->put('selected_address_id', $value);
            }
        }
    }

    protected function setAddressLocation($address)
    {
        // Store names (for display/storage)
        $this->selectedDepartment = $address->department;
        $this->selectedProvince = $address->province;
        $this->selectedDistrict = $address->district;
        
        // Convert names to ubigeo codes
        $this->selectedDeptCode = $this->ubigeoService->getDepartmentIdByName($address->department);
        $this->selectedProvCode = $this->ubigeoService->getProvinceIdByName($this->selectedDeptCode, $address->province);
        $this->selectedDistCode = $this->ubigeoService->getDistrictIdByName($this->selectedProvCode, $address->district);
        
        // Calculate shipping using the CODE
        $this->shippingCost = $this->ubigeoService->getShippingRate($this->selectedDeptCode);
        
        // Sync with session (store CODE for shipping calculation)
        session()->put('selected_department', $this->selectedDeptCode);
        session()->put('selected_province', $this->selectedProvCode);
        session()->put('selected_district', $this->selectedDistCode);
    }



    public function updatedSelectedDepartment($value)
    {
        // Only allow manual update if not authenticated or (optional) if we want to allow override
        // But per requirements: "no dejando editar los selects" for logged in users.
        // So this might only be triggered by guest users or if we allow it.
        
        $this->shippingCost = $value ? $this->ubigeoService->getShippingRate($value) : 0;
        session()->put('selected_department', $value);

        $this->selectedProvince = null;
        $this->selectedDistrict = null;
        session()->forget(['selected_province', 'selected_district']);
    }

    public function updatedSelectedProvince($value)
    {
        session()->put('selected_province', $value);
        $this->selectedDistrict = null;
        session()->forget('selected_district');
    }

    public function updatedSelectedDistrict($value)
    {
        session()->put('selected_district', $value);
    }

    public function render()
    {
        Cart::instance('shopping');
        $productsInCart = Cart::content();
        $subtotal = (float) str_replace(',', '', Cart::subtotal());
        $discount = 0;

        if (session()->has('coupon')) {
            $coupon = session('coupon');
            
            if ($coupon['type'] === 'fixed') {
                $discount = $coupon['value'];
            } elseif ($coupon['type'] === 'percentage') {
                $discount = ($subtotal * $coupon['value']) / 100;
            }
        }

        $grandTotal = max(0, $subtotal - $discount + $this->shippingCost);
        $cartQty = $productsInCart->sum('qty');

        return view('livewire.product.shopping-cart', [
            'productsInCart' => $productsInCart,
            'cartSubtotal' => $subtotal,
            'cartDiscount' => $discount,
            'cartGrandTotal' => $grandTotal,
            'shippingCost' => $this->shippingCost,
            'cartQty' => $cartQty,
        ]);
    }

    public function removeFromCart($rowId)
    {
        Cart::instance('shopping')->remove($rowId);
        $this->storeCart();
        $this->dispatch('cart-updated');
    }

    public function clearCart()
    {
        Cart::instance('shopping')->destroy();
        $this->storeCart();
        $this->dispatch('cart-updated');
    }

    private function storeCart()
    {
        if (Auth::check()) {
            Cart::store(Auth::user()->id);
        }
    }

    public function updateQuantity($rowId, $qty)
    {
        if ($qty <= 0) {
            $this->removeFromCart($rowId);
        } else {
            Cart::instance('shopping')->update($rowId, $qty);
            $this->dispatch('cart-updated');
        }
    }

    #[On('removeCoupon')]
    public function removeCoupon()
    {
        session()->forget('coupon');
        $this->dispatch('couponRemoved');
        session()->flash('success', 'Cupón eliminado.');
    }

    #[On('cart-updated')] 
    #[On('couponApplied')]
    public function updateTotals()
    {
        // This method listens for events to trigger a re-render
    }
}