<?php

namespace App\Livewire\Product;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Attributes\On;
use Livewire\Component;

class ShoppingCart extends Component
{    
    public $selectedDepartment = null;
    public $selectedProvince = null;
    public $selectedDistrict = null;
    public $shippingCost = 0;

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
        $this->selectedDepartment = session('selected_department');
        $this->selectedProvince = session('selected_province');
        $this->selectedDistrict = session('selected_district');
        $this->shippingCost = session('shipping_cost', 0);
    }

    public function updatedSelectedDepartment($value)
    {
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
        $this->dispatch('cart-updated');
    }

    public function clearCart()
    {
        Cart::instance('shopping')->destroy();
        $this->dispatch('cart-updated');
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