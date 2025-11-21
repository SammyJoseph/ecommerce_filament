<div>
    <div class="pro-details-add-to-cart tw-inline-block">
        <a title="Add to Cart" href="#" 
           @click.prevent="
                if (product.has_variants && (!selectedColor || !selectedSize)) {
                    alert('Por favor selecciona un color y una talla.');
                    return;
                }
                let variantData = null;
                if (product.has_variants) {
                    const key = selectedColor + '-' + selectedSize;
                    variantData = product.variant_combinations.combinations[key];
                }
                $wire.addToCart(product.id, parseInt(document.getElementById('quick-view-quantity').value), variantData);
           ">
           <span wire:loading.remove wire:target="addToCart">Añadir al carrito</span>
           <span wire:loading wire:target="addToCart">Procesando...</span>
        </a>
    </div>
    <div class="pro-details-action tw-inline-block">
        <a title="Añadir a la lista de deseos" href="#"><i class="icon-heart"></i></a>
        <a title="Añadir para comparar" href="#"><i class="icon-refresh"></i></a>
        <a class="social" title="Social" href="#"><i class="icon-share"></i></a>
        <div class="product-dec-social">
            <a class="facebook" title="Facebook" href="#"><i class="icon-social-facebook"></i></a>
            <a class="twitter" title="Twitter" href="#"><i class="icon-social-twitter"></i></a>
            <a class="instagram" title="Instagram" href="#"><i class="icon-social-instagram"></i></a>
            <a class="pinterest" title="Pinterest" href="#"><i class="icon-social-pinterest"></i></a>
        </div>
    </div>
</div>
