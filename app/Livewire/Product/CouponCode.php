<?php

namespace App\Livewire\Product;

use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Attributes\On;
use Livewire\Component;

class CouponCode extends Component
{
    public $couponCode;

    public function applyCoupon()
    {
        $this->validate([
            'couponCode' => 'required|string',
        ]);

        $coupon = Coupon::where('code', $this->couponCode)->first();

        // 1. ¿Existe el cupón?
        if (!$coupon) {
            session()->flash('error', 'El código del cupón no es válido.');
            return;
        }

        // 2. ¿El cupón es válido (activo, no expirado, etc.)?
        if (!$coupon->isValid()) {
            session()->flash('error', 'Este cupón no es válido o ha expirado.');
            return;
        }

        // 3. ¿El subtotal del carrito cumple el mínimo requerido?
        Cart::instance('shopping');
        $subtotal = (float) str_replace(',', '', Cart::subtotal());
        if ($coupon->min_cart_amount && $subtotal < $coupon->min_cart_amount) {
            session()->flash('error', "El subtotal de tu carrito debe ser de al menos $" . $coupon->min_cart_amount . " para usar este cupón.");
            return;
        }

        // Guardar el cupón en la sesión
        session()->put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
        ]);

        // Emitir un evento para que el carrito se actualice
        $this->dispatch('couponApplied');

        $this->couponCode = '';

        session()->flash('success', '¡Cupón aplicado con éxito!');
    }

    #[On('removeCoupon')]
    public function removeCoupon()
    {
        session()->forget('coupon');
        $this->dispatch('couponRemoved');
        session()->flash('success', 'Cupón eliminado.');
    }

    public function render()
    {
        return view('livewire.product.coupon-code');
    }
}