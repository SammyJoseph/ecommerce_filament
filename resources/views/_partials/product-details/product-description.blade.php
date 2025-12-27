<div class="description-review-wrapper pb-110">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="dec-review-topbar nav mb-45">
                    <a class="active" data-bs-toggle="tab" href="#des-details1">Description</a>
                    <a data-bs-toggle="tab" href="#des-details2">Specification</a>
                    <a data-bs-toggle="tab" href="#des-details3">Materials </a>
                    <a data-bs-toggle="tab" href="#des-details4">Reviews and Ratting </a>
                </div>
                <div class="tab-content dec-review-bottom">
                    <div id="des-details1" class="tab-pane active">
                        <div class="description-wrap">
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>
                    <div id="des-details2" class="tab-pane">
                        <div class="specification-wrap table-responsive">
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="title width1">Name</td>
                                        <td>Salwar Kameez</td>
                                    </tr>
                                    <tr>
                                        <td class="title width1">SKU</td>
                                        <td>0x48e2c</td>
                                    </tr>
                                    <tr>
                                        <td class="title width1">Models</td>
                                        <td>FX 829 v1</td>
                                    </tr>
                                    <tr>
                                        <td class="title width1">Categories</td>
                                        <td>Digital Print</td>
                                    </tr>
                                    <tr>
                                        <td class="title width1">Size</td>
                                        <td>60’’ x 40’’</td>
                                    </tr>
                                    <tr>
                                        <td class="title width1">Brand </td>
                                        <td>Individual Collections</td>
                                    </tr>
                                    <tr>
                                        <td class="title width1">Color</td>
                                        <td>Black, White</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="des-details3" class="tab-pane">
                        <div class="specification-wrap table-responsive">
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="title width1">Top</td>
                                        <td>Cotton Digital Print Chain Stitch Embroidery Work</td>
                                    </tr>
                                    <tr>
                                        <td class="title width1">Bottom</td>
                                        <td>Cotton Cambric</td>
                                    </tr>
                                    <tr>
                                        <td class="title width1">Dupatta</td>
                                        <td>Digital Printed Cotton Malmal With Chain Stitch</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="des-details4" class="tab-pane">
                        @livewire('product-reviews', ['product' => $product])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>