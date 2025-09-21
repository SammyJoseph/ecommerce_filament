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
                                <template x-if="product.sale_price && product.sale_price > 0">
                                    <div>
                                        <span class="new-price" x-text="'S/.' + product.sale_price"></span>
                                        <span class="old-price" x-text="'S/.' + product.price"></span>
                                    </div>
                                </template>
                                <template x-if="!product.sale_price || product.sale_price <= 0">
                                    <span class="new-price" x-text="'S/.' + product.price"></span>
                                </template>
                            </div>
                            <div class="pro-details-color-wrap">
                                <span>Color:</span>
                                <div class="pro-details-color-content">
                                    <ul>
                                        <li><a class="dolly" href="#">dolly</a></li>
                                        <li><a class="white" href="#">white</a></li>
                                        <li><a class="azalea" href="#">azalea</a></li>
                                        <li><a class="peach-orange" href="#">Orange</a></li>
                                        <li><a class="mona-lisa active" href="#">lisa</a></li>
                                        <li><a class="cupid" href="#">cupid</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="pro-details-size">
                                <span>Talla:</span>
                                <div class="pro-details-size-content">
                                    <ul>
                                        <li><a href="#">XS</a></li>
                                        <li><a href="#">S</a></li>
                                        <li><a href="#">M</a></li>
                                        <li><a href="#">L</a></li>
                                        <li><a href="#">XL</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="pro-details-quality">
                                <span>Cantidad:</span>
                                <div class="cart-plus-minus">
                                    <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1">
                                </div>
                            </div>
                            <div class="product-details-meta">
                                <ul>
                                    <li><span>Categorías:</span> <a href="#">Mujer,</a> <a href="#">Vestido,</a> <a href="#">Polo</a></li>
                                    <li><span>Etiqueta: </span> <a href="#">Moda,</a> <a href="#">Mentone</a> , <a href="#">Texas</a></li>
                                </ul>
                            </div>
                            <div class="pro-details-action-wrap">
                                <div class="pro-details-add-to-cart">
                                    <a title="Add to Cart" href="#">Añadir al carrito </a>
                                </div>
                                <div class="pro-details-action">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>