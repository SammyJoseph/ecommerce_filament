<script src="{{ asset('assets/js/vendor/modernizr-3.11.7.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery-v3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery-migrate-v3.3.2.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/slick.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery.syotimer.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/wow.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/plugins/magnific-popup.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sticky-sidebar.js') }}"></script>
<script src="{{ asset('assets/js/plugins/easyzoom.js') }}"></script>
{{-- <script src="{{ asset('assets/js/plugins/scrollup.js') }}"></script> --}}
<script src="{{ asset('assets/js/plugins/ajax-mail.js') }}"></script>
<script src="{{ asset('assets/js/main.js?v=0.03') }}"></script>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('open-side-cart', () => {
            $('.sidebar-cart-active').addClass('inside');
            $('.main-wrapper').addClass('overlay-active');
        });

        Livewire.on('close-side-cart', () => {
            $('.sidebar-cart-active').removeClass('inside');
            $('.main-wrapper').removeClass('overlay-active');
        });
    });
</script>