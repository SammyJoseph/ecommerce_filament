<footer class="footer-area bg-gray pt-115 pb-30">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="contact-info-wrap">
                    <div class="footer-logo">
                        <a href="#"><img src="{{ asset('assets/images/logo/logo.png') }}"></a>
                    </div>
                    <div class="single-contact-info">
                        <span>Dirección</span>
                        <p>Av. Lima 123, Perú</p>
                    </div>
                    <div class="single-contact-info">
                        <span>Teléfono:</span>
                        <p>(+51) 987654321</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="footer-right-wrap">
                    <div class="footer-menu">
                        <nav>
                            <ul>
                                <li><a href="{{ route('index') }}">Inicio</a></li>
                                <li><a href="{{ route('shop') }}">Tienda</a></li>
                                <li><a href="{{ route('about') }}">Nosotros</a></li>
                                <li><a href="{{ route('blog.index') }}">Blog</a></li>
                                <li><a href="{{ route('contact') }}">Contacto</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="social-style-2 social-style-2-mrg">
                        <a href="#"><i class="social_twitter"></i></a>
                        <a href="#"><i class="social_facebook"></i></a>
                        <a href="#"><i class="social_googleplus"></i></a>
                        <a href="#"><i class="social_instagram"></i></a>
                        <a href="#"><i class="social_youtube"></i></a>
                    </div>
                    <div class="copyright">
                        <p>© {{ date('Y') }} <a target="_blank" href="https://artisam.dev">Desarrollado por <span>Artisam Web</span></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>