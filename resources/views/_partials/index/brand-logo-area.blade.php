<div class="brand-logo-area pt-100 pb-100">
    <div class="container">
        <div class="brand-logo-wrap brand-logo-mrg">
            @forelse($brandLogos as $logo)
                <div class="single-brand-logo mb-10">
                    <img src="{{ asset('storage/'.$logo['image']) }}" alt="Brand Logo">
                </div>
            @empty
                <div class="single-brand-logo mb-10">
                    <img src="{{ asset('assets/images/brand-logo/brand-logo-1.png') }}">
                </div>
                <div class="single-brand-logo mb-10">
                    <img src="{{ asset('assets/images/brand-logo/brand-logo-2.png') }}">
                </div>
                <div class="single-brand-logo mb-10">
                    <img src="{{ asset('assets/images/brand-logo/brand-logo-3.png') }}">
                </div>
                <div class="single-brand-logo mb-10">
                    <img src="{{ asset('assets/images/brand-logo/brand-logo-4.png') }}">
                </div>
                <div class="single-brand-logo mb-10">
                    <img src="{{ asset('assets/images/brand-logo/brand-logo-5.png') }}">
                </div>
            @endforelse
        </div>
    </div>
</div>