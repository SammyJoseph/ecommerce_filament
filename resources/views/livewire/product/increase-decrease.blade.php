<div class="quantity__box minicart__quantity">
    <button wire:click="decreaseQuantity" type="button" class="quantity__value decrease" aria-label="quantity value">-</button>
    <label>
        <input type="number" class="quantity__number" value="{{ $quantity }}" readonly />
    </label>
    <button wire:click="increaseQuantity" type="button" class="quantity__value increase" aria-label="quantity value">+</button>
</div>
