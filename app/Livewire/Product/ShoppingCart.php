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

    // Tarifas de envío por departamento (ID Ubigeo -> Precio)
    protected function getShippingRate($departmentId): float
    {
        return match ($departmentId) {
            '3926' => 15.00, // Lima
            '3606', '2625' => 20.00, // Ica, Ancash
            '3788', '3884', '4236', '4551', '2900', '4180', '4519' => 25.00, // Costa Lejana
            '3143', '3518', '4204', '3655', '3414', '3020', '2812', '3292', '4309' => 30.00, // Sierra
            '2534', '4108', '4431', '4567', '4165' => 35.00, // Selva
            default => 35.00,
        };
    }

    public function mount()
    {
        $this->loadDepartments();
        
        if (Auth::check()) {
            $this->userAddresses = Auth::user()->addresses;
            $defaultAddress = Auth::user()->defaultAddress;
            
            if ($defaultAddress) {
                $this->selectedAddressId = $defaultAddress->id;
                $this->setAddressLocation($defaultAddress);
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
        $path = storage_path('app/ubigeo/departamentos.json');
        if (file_exists($path)) {
            $this->departments = json_decode(file_get_contents($path), true);
        }
    }

    public function updatedSelectedAddressId($value)
    {
        if ($value) {
            $address = $this->userAddresses->where('id', $value)->first();
            if ($address) {
                $this->setAddressLocation($address);
                
                // Get ubigeo codes for the frontend
                $deptCode = $this->getDepartmentCode($address->department);
                $provCode = $this->getProvinceCode($deptCode, $address->province);
                $distCode = $this->getDistrictCode($provCode, $address->district);
                
                $this->dispatch('address-changed', 
                    department: $deptCode,
                    province: $provCode,
                    district: $distCode
                );
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
        $this->selectedDeptCode = $this->getDepartmentCode($address->department);
        $this->selectedProvCode = $this->getProvinceCode($this->selectedDeptCode, $address->province);
        $this->selectedDistCode = $this->getDistrictCode($this->selectedProvCode, $address->district);
        
        // Calculate shipping using the CODE
        $this->shippingCost = $this->getShippingRate($this->selectedDeptCode);
        
        // Sync with session (store CODE for shipping calculation)
        session()->put('selected_department', $this->selectedDeptCode);
        session()->put('selected_province', $this->selectedProvCode);
        session()->put('selected_district', $this->selectedDistCode);
        session()->put('shipping_cost', $this->shippingCost);
    }

    protected function getDepartmentCode($departmentName)
    {
        $dept = collect($this->departments)->firstWhere('nombre_ubigeo', $departmentName);
        return $dept['id_ubigeo'] ?? '';
    }

    protected function getProvinceCode($departmentCode, $provinceName)
    {
        if (!$departmentCode) return '';
        
        $path = storage_path('app/ubigeo/provincias.json');
        if (file_exists($path)) {
            $allProvinces = json_decode(file_get_contents($path), true);
            $provinces = $allProvinces[$departmentCode] ?? [];
            $prov = collect($provinces)->firstWhere('nombre_ubigeo', $provinceName);
            return $prov['id_ubigeo'] ?? '';
        }
        return '';
    }

    protected function getDistrictCode($provinceCode, $districtName)
    {
        if (!$provinceCode) return '';
        
        $path = storage_path('app/ubigeo/distritos.json');
        if (file_exists($path)) {
            $allDistricts = json_decode(file_get_contents($path), true);
            $districts = $allDistricts[$provinceCode] ?? [];
            $dist = collect($districts)->firstWhere('nombre_ubigeo', $districtName);
            return $dist['id_ubigeo'] ?? '';
        }
        return '';
    }

    public function updatedSelectedDepartment($value)
    {
        // Only allow manual update if not authenticated or (optional) if we want to allow override
        // But per requirements: "no dejando editar los selects" for logged in users.
        // So this might only be triggered by guest users or if we allow it.
        
        $this->shippingCost = $value ? $this->getShippingRate($value) : 0;
        session()->put('selected_department', $value);
        session()->put('shipping_cost', $this->shippingCost);

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

        return view('livewire.product.shopping-cart', [
            'productsInCart' => $productsInCart,
            'cartSubtotal' => $subtotal,
            'cartDiscount' => $discount,
            'cartGrandTotal' => $grandTotal,
            'shippingCost' => $this->shippingCost,
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