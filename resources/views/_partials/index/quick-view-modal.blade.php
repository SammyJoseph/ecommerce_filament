<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5 col-md-6 col-12 col-sm-12">
                        <div class="tab-content quickview-big-img">
                            <div class="tab-pane fade show active">
                                <img :src="activeImage" alt="">
                            </div>
                        </div>
                        <div class="quickview-wrap mt-15">
                            <div class="nav nav-style-6 tw-flex tw-flex-nowrap tw-overflow-x-auto tw-gap-2" role="tablist">
                                <template x-for="(thumb, index) in product.thumb_images" :key="index">
                                    <a href="#" class="nav-link" 
                                            :class="{ 'active': activeThumbIndex === index }" 
                                            @click.prevent="activeImage = product.images[index]; activeThumbIndex = index">
                                        <img :src="thumb" alt="product-thumbnail" class="tw-w-24 tw-h-24 tw-object-cover">
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-6 col-12 col-sm-12">
                        <div class="product-details-content quickview-content">
                            <h2 x-text="product.name"></h2>
                            <div class="product-ratting-review-wrap">
                                <div class="product-ratting-digit-wrap">
                                    <div class="product-ratting">
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                    </div>
                                    <div class="product-digit">
                                        <span>5.0</span>
                                    </div>
                                </div>
                                <div class="product-review-order">
                                    <span>62 Reseñas</span>
                                    <span>242 ordenes</span>
                                </div>
                            </div>
                            <p x-html="product.description" class="tw-line-clamp-2"></p>
                            <div class="pro-details-price">
                                <template x-if="currentSalePrice && currentSalePrice > 0">
                                    <div>
                                        <span class="new-price" x-text="'S/.' + currentSalePrice"></span>
                                        <span class="old-price" x-text="'S/.' + currentPrice"></span>
                                    </div>
                                </template>
                                <template x-if="!currentSalePrice || currentSalePrice <= 0">
                                    <span class="new-price" x-text="'S/.' + currentPrice"></span>
                                </template>
                            </div>
                            <template x-if="product.has_variants && product.variant_combinations">
                                <div class="pro-details-color-wrap">
                                    <span>Color:</span>
                                    <div class="pro-details-color-content">
                                        <ul>
                                            <template x-for="(colorData, colorName) in product.variant_combinations.colors" :key="colorName">
                                                <li>
                                                    <a href="#" 
                                                       :class="{ 'active': selectedColor === colorName }"
                                                       :style="'background-color: ' + colorData.color_code"
                                                       :title="colorName"
                                                       @click.prevent="selectColor(colorName)">
                                                    </a>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </template>
                            
                            <template x-if="product.has_variants">
                                <div class="pro-details-size">
                                    <span>Talla:</span>
                                    <div class="pro-details-size-content">
                                        <ul>
                                            <template x-for="size in availableSizes" :key="size">
                                                <li>
                                                    <a href="#" 
                                                       :class="{ 'active': selectedSize === size }"
                                                       @click.prevent="selectSize(size)"
                                                       x-text="size">
                                                    </a>
                                                </li>
                                            </template>
                                            <template x-if="!selectedColor">
                                                <li><span>Selecciona un color primero</span></li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </template>

                            <div class="pro-details-quality">
                                <span>Cantidad:</span>
                                <div class="cart-plus-minus">
                                    <div class="dec qtybutton" @click="quantity = Math.max(1, quantity - 1)">-</div>
                                    <input class="cart-plus-minus-box" type="text" x-model="quantity" readonly id="quick-view-quantity">
                                    <div class="inc qtybutton" @click="quantity++">+</div>
                                </div>
                            </div>
                            <div class="product-details-meta">
                                <ul>
                                    <li><span>Categorías:</span> <a href="#">Mujer,</a> <a href="#">Vestido,</a> <a href="#">Polo</a></li>
                                    <li><span>Etiqueta: </span> <a href="#">Moda,</a> <a href="#">Mentone</a> , <a href="#">Texas</a></li>
                                </ul>
                            </div>
                            <div class="pro-details-action-wrap">
                                @livewire('product.quick-view-add-to-cart')
                            </div>
                            </div>
</div>
<style>
    .pro-details-size-content ul li a.active {
        background-color: #333;
        color: #fff;
    }
</style>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>