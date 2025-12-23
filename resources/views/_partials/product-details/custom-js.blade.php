<script>
    $(document).ready(function() {
        const colors = @json($variantCombinations['colors']);
        const productMediaCount = {{ $productImages->count() }};

        function goToSlide(slider, index) {
            if (slider.hasClass('slick-initialized')) {
                slider.slick('slickGoTo', index, false);
            } else {
                setTimeout(() => goToSlide(slider, index), 50);
            }
        }

        // Listen for color selection from Alpine.js
        window.addEventListener('color-selected', function(e) {
            const selectedColor = e.detail.color;
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
        });
    });
</script>