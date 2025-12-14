<div class="instagram-area">
    <div class="container">
        <div class="section-title-tag-wrap mb-45">
            <div class="section-title">
                <h2>{{ $settings->instagram_title ?? 'Our Instagram' }}</h2>
            </div>
            <div class="instagram-tag">
                <span>{{ $settings->instagram_hashtag ?? '#monkeylover' }}</span>
            </div>
        </div>
        <div class="row g-0">
            @forelse($instagramItems as $item)
                <div class="col">
                    <div class="instagram-item">
                        <a class="instagram-image" href="{{ $item['link'] ?? '#' }}">
                            <img src="{{ asset('storage/'.$item['image']) }}" alt="Instagram Image">
                        </a>
                        <ul class="add-action">
                            <li>
                                <a href="{{ $item['link'] ?? '#' }}">
                                    <i class="icon_plus"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="instagram-item">
                        <a class="instagram-image" href="#">
                            <img src="{{ asset('assets/images/instagram/1.jpg') }}">
                        </a>
                        <ul class="add-action">
                            <li>
                                <a href="#">
                                    <i class="icon_plus"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col">
                    <div class="instagram-item">
                        <a class="instagram-image" href="#">
                            <img src="{{ asset('assets/images/instagram/2.jpg') }}">
                        </a>
                        <ul class="add-action">
                            <li>
                                <a href="#">
                                    <i class="icon_plus"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col">
                    <div class="instagram-item">
                        <a class="instagram-image" href="#">
                            <img src="{{ asset('assets/images/instagram/3.jpg') }}">
                        </a>
                        <ul class="add-action">
                            <li>
                                <a href="#">
                                    <i class="icon_plus"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col">
                    <div class="instagram-item">
                        <a class="instagram-image" href="#">
                            <img src="{{ asset('assets/images/instagram/4.jpg') }}">
                        </a>
                        <ul class="add-action">
                            <li>
                                <a href="#">
                                    <i class="icon_plus"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col">
                    <div class="instagram-item">
                        <a class="instagram-image" href="#">
                            <img src="{{ asset('assets/images/instagram/5.jpg') }}">
                        </a>
                        <ul class="add-action">
                            <li>
                                <a href="#">
                                    <i class="icon_plus"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>