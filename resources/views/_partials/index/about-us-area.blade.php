@php
    $settings = app(\App\Settings\HomePageSettings::class);
@endphp
<div class="about-us-area pt-85">
    <div class="container">
        <div class="border-bottom-1 about-content-pb">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="about-us-logo">
                        <img src="{{ $settings->about_us_image ? asset('storage/'.$settings->about_us_image) : asset('assets/images/about/logo.png') }}" alt="{{ $settings->about_us_title }}">
                    </div>
                </div>
                <div class="col-lg-9 col-md-9">
                    <div class="about-us-content">
                        <h3>{{ $settings->about_us_title }}</h3>
                        <p>{{ $settings->about_us_text }}</p>
                        <div class="signature">
                            <h2>{{ $settings->about_us_author }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>