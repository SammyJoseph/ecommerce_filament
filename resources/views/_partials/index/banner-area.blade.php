@php
    $settings = app(\App\Settings\HomePageSettings::class);
    $banners = $settings->banners ?? [];
@endphp
<div class="banner-area pb-85">
    <div class="container">
        <div class="section-title mb-45">
            <h2>Destacados</h2>
        </div>
        <div class="row">
            @if(isset($banners[0]))
            <div class="col-lg-7 col-md-7">
                <div class="banner-wrap banner-mr-1 mb-30">
                    <div class="banner-img banner-img-zoom">
                        <a href="{{ $banners[0]['link'] ?? '#' }}">
                            <img src="{{ isset($banners[0]['image']) ? asset('storage/'.$banners[0]['image']) : asset('assets/images/banner/banner-1.jpg') }}" alt="">
                        </a>
                    </div>
                    <div class="banner-content-1">
                        <h2>{!! nl2br(e($banners[0]['title'] ?? '')) !!}</h2>
                        <p>{{ $banners[0]['description'] ?? '' }}</p>
                        <div class="btn-style-1">
                            <a class="animated btn-1-padding-2" href="{{ $banners[0]['link'] ?? '#' }}">Ver ahora</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(isset($banners[1]))
            <div class="col-lg-5 col-md-5">
                <div class="banner-wrap  banner-ml-1 mb-30">
                    <div class="banner-img banner-img-zoom">
                        <a href="{{ $banners[1]['link'] ?? '#' }}">
                            <img src="{{ isset($banners[1]['image']) ? asset('storage/'.$banners[1]['image']) : asset('assets/images/banner/banner-2.jpg') }}" alt="">
                        </a>
                    </div>
                    <div class="banner-content-2">
                        <h2>{!! nl2br(e($banners[1]['title'] ?? '')) !!}</h2>
                        <p>{{ $banners[1]['description'] ?? '' }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>