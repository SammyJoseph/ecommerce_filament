<script>
    $(document).ready(function() {
        const combinations = @json($variantCombinations['combinations']);
        const colors = @json($variantCombinations['colors']);
        const sizes = @json($variantCombinations['sizes']);
        const productMediaCount = {{ $productImages->count() }};

        let selectedColor = null;
        let selectedSize = null;

        const $colorSwatches = $('.pro-details-color-content a');
        const $sizeSwatches = $('.pro-details-size-content a');
        const $variantPrice = $('#variant-price');
        const $variantOldPrice = $('#variant-old-price');
        const $addToCartBtn = $('.pro-details-add-to-cart a');

        function updateUI() {
            // First, enable all options
            $sizeSwatches.parent().removeClass('disabled');
            $colorSwatches.parent().removeClass('disabled');

            // Update size availability based on selected color
            if (selectedColor && colors[selectedColor]) {
                const availableSizes = colors[selectedColor].available_sizes;
                $sizeSwatches.each(function() {
                    const size = $(this).data('size').toString();
                    if (!availableSizes.map(s => s.toString()).includes(size)) {
                        $(this).parent().addClass('disabled');
                        if (selectedSize === size) {
                            selectedSize = null;
                            $sizeSwatches.removeClass('active');
                        }
                    }
                });
            }

            // Update price and add to cart button
            let displayPrice = '';
            let displayOldPrice = '';
            let isValidCombo = false;
            let currentCombination = null;

            if (selectedColor) {
                let comboKey;
                let combination;

                if (selectedSize) {
                    // Use specific combination if size selected
                    comboKey = selectedColor + '-' + selectedSize;
                    combination = combinations[comboKey];
                    isValidCombo = !!combination;
                } else {
                    // Use first available size for color if no size selected
                    if (colors[selectedColor] && colors[selectedColor].available_sizes && colors[selectedColor].available_sizes.length > 0) {
                        const firstSize = colors[selectedColor].available_sizes[0].toString();
                        comboKey = selectedColor + '-' + firstSize;
                        combination = combinations[comboKey];
                        isValidCombo = !!combination;
                    }
                }

                if (isValidCombo && combination) {
                    currentCombination = combination;
                    if (combination.sale_price && parseFloat(combination.sale_price) < parseFloat(combination.price)) {
                        displayPrice = '$' + parseFloat(combination.sale_price).toFixed(2);
                        displayOldPrice = '$' + parseFloat(combination.price).toFixed(2);
                        $variantOldPrice.text(displayOldPrice).show();
                    } else {
                        displayPrice = '$' + parseFloat(combination.price).toFixed(2);
                        $variantOldPrice.hide();
                    }
                    $variantPrice.text(displayPrice);
                } else {
                    $variantPrice.text('');
                    $variantOldPrice.hide();
                }
            } else {
                $variantPrice.text('');
                $variantOldPrice.hide();
            }

            // Add to cart button only enabled if both selected and valid
            if (selectedColor && selectedSize && isValidCombo && currentCombination) {
                if (currentCombination.stock > 0) {
                    $addToCartBtn.text('Add To Cart').removeClass('disabled');
                } else {
                    $addToCartBtn.text('Out of Stock').addClass('disabled');
                }
            } else {
                $addToCartBtn.text(selectedColor ? 'Select Size' : 'Select Options').addClass('disabled');
            }
        }

        function goToSlide(slider, index) {
            if (slider.hasClass('slick-initialized')) {
                slider.slick('slickGoTo', index, false);
            } else {
                setTimeout(() => goToSlide(slider, index), 50);
            }
        }

        function updateImage() {
            if (!selectedColor) return;

            const $mainSlider = $('.pro-dec-big-img-slider');

            // Calculate main image index
            let variantImageIndex = -1;
            let i = 0;
            for (let key in colors) {
                if (colors[key].image && colors[key].image.trim() !== '') {
                    if (key === selectedColor) {
                        variantImageIndex = i;
                        break;
                    }
                    i++;
                }
            }
            if (variantImageIndex !== -1 && $mainSlider.length > 0) {
                const slideIndex = productMediaCount + variantImageIndex;
                goToSlide($mainSlider, slideIndex);
            }

            // Update thumbnail
            const $thumbSlider = $('.product-dec-left');

            let variantThumbIndex = -1;
            let j = 0;
            for (let key in colors) {
                if (colors[key].thumb && colors[key].thumb.trim() !== '') {
                    if (key === selectedColor) {
                        variantThumbIndex = j;
                        break;
                    }
                    j++;
                }
            }
            if (variantThumbIndex !== -1 && $thumbSlider.length > 0) {
                const thumbSlideIndex = productMediaCount + variantThumbIndex;
                goToSlide($thumbSlider, thumbSlideIndex);
            }
        }


        $sizeSwatches.on('click', function(e) {
            e.preventDefault();
            if ($(this).parent().hasClass('disabled') || $(this).hasClass('active')) return;

            selectedSize = $(this).data('size').toString();
            $sizeSwatches.removeClass('active');
            $(this).addClass('active');
            updateUI();
        });

        $colorSwatches.on('click', function(e) {
            e.preventDefault();
            if ($(this).parent().hasClass('disabled')) return;

            // Get the clicked color
            const clickedColor = $(this).data('color').toString();
            
            // Always reset size selection when clicking a color (even if same color)
            selectedSize = null;
            $sizeSwatches.removeClass('active');
            
            // Update selected color
            selectedColor = clickedColor;
            $colorSwatches.removeClass('active');
            $(this).addClass('active');
            
            updateImage();
            updateUI();
        });

        // Initial state - no color selected by default
        updateUI(); // Initialize UI with no selections
    });
</script>