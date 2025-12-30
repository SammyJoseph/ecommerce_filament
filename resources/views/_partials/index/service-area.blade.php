@inject('settings', 'App\Settings\HomePageSettings')

<div class="service-area">
    <div class="container">
        <div class="service-wrap">
            <div class="row">
                @foreach($settings->features ?? [] as $feature)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="single-service-wrap mb-30">
                            <div class="service-icon">
                                <i class="{{ $feature['icon'] }}"></i>
                            </div>
                            <div class="service-content">
                                <h3>{{ $feature['title'] }}</h3>
                                <span>{{ $feature['subtitle'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>