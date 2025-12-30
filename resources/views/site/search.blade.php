@extends('layouts.site')

@section('content')
<div class="bg-gray tw-text-center tw-py-6 tw-hidden sm:tw-block">
    <p class="tw-text-base"><span class="tw-text-black tw-font-semibold">Búsqueda de </span><span class="tw-text-red-500 tw-font-normal">"{{ $query }}"</span></p>
</div>

<div class="search-page-area tw-py-4 sm:tw-py-12">
    <div class="container">
        <!-- Search Input -->
        <div class="tw-max-w-2xl tw-mx-auto tw-mb-12">
            <form action="{{ route('search') }}" method="GET" class="tw-relative">
                <input type="text" name="q" value="{{ $query }}" placeholder="Buscar..." 
                    class="tw-w-full tw-px-6 tw-py-4 tw-rounded-full tw-border tw-bg-white tw-border-gray-300 tw-outline-none tw-focus:border-red-500 tw-focus:ring-1 tw-focus:ring-red-500 tw-shadow-sm tw-transition-all">
                <button type="submit" class="tw-absolute tw-right-0 tw-top-0 tw-bg-red-500 tw-text-white tw-px-6 tw-py-2 tw-rounded-full tw-hover:bg-red-600 tw-transition-colors">
                    <i class="icon-magnifier"></i>
                </button>
            </form>
        </div>

        @if($products->isEmpty() && $categories->isEmpty() && $blogs->isEmpty())
            <div class="tw-text-center tw-py-12">
                <div class="tw-text-6xl tw-mb-4 text-gray-300"><i class="icon-magnifier"></i></div>
                <h3 class="tw-text-2xl tw-font-bold tw-text-gray-800 tw-mb-2">No se encontraron resultados</h3>
                <p class="tw-text-gray-600">No encontramos nada para "{{ $query }}". Intenta con otros términos.</p>
            </div>
        @else
            <!-- Products Section -->
            @if($products->isNotEmpty())
            <div class="tw-mb-16">
                <h3 class="tw-text-2xl tw-font-bold tw-mb-6 tw-border-b tw-pb-4">
                    Productos <span class="tw-text-sm tw-font-normal tw-text-gray-500 tw-ml-2">({{ $products->count() }})</span>
                </h3>
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="product-wrap-2 tw-mb-8 tw-bg-white tw-rounded-lg tw-shadow-sm hover:tw-shadow-md tw-transition-shadow">
                                <div class="product-img tw-relative tw-overflow-hidden tw-rounded-t-lg">
                                    <a href="{{ route('product.show', $product) }}">
                                        @if($product->hasMedia('product_images'))
                                            <img class="default-img tw-w-full tw-h-64 tw-object-cover" src="{{ $product->getFirstMediaUrl('product_images', 'preview') }}" alt="{{ $product->name }}">
                                            @if($product->getMedia('product_images')->count() > 1)
                                                <img class="hover-img tw-w-full tw-h-64 tw-object-cover tw-absolute tw-top-0 tw-left-0 tw-opacity-0 tw-transition-opacity duration-500" src="{{ $product->getMedia('product_images')[1]->getUrl('preview') }}" alt="{{ $product->name }}">
                                            @endif
                                        @else
                                            <img class="default-img tw-w-full tw-h-64 tw-object-cover" src="{{ asset('assets/images/product/default.jpg') }}" alt="{{ $product->name }}">
                                        @endif
                                    </a>
                                    @if($product->sale_price)
                                        <div class="product-img-badges tw-absolute tw-top-3 tw-left-3">
                                            <span class="tw-bg-red-500 tw-text-white tw-px-2 tw-py-1 tw-rounded tw-text-xs tw-font-bold">-{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="product-content-2 tw-p-4">
                                    <div class="title-price-wrap-2">
                                        <h3><a href="{{ route('product.show', $product) }}" class="tw-text-gray-800 hover:tw-text-red-500 tw-font-medium tw-text-lg">{{ $product->name }}</a></h3>
                                        <div class="price-2 tw-mt-2">
                                            @if($product->sale_price)
                                                <span class="tw-text-lg tw-font-bold tw-text-red-500">${{ number_format($product->sale_price, 2) }}</span>
                                                <span class="tw-text-sm tw-text-gray-400 tw-line-through tw-ml-2">${{ number_format($product->price, 2) }}</span>
                                            @else
                                                <span class="tw-text-lg tw-font-bold tw-text-gray-900">${{ number_format($product->price, 2) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="pro-wishlist-2">
                                        {{-- <livewire:product.add-to-wishlist :productId="$product->id" wire:key="'search-wishlist-'.$product->id" /> --}}
                                        @livewire('product.wishlist-toggle', ['productId' => $product->id], key('search-wishlist-' . $product->id))
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Categories Section -->
            @if($categories->isNotEmpty())
            <div class="tw-mb-16">
                <h3 class="tw-text-2xl tw-font-bold tw-mb-6 tw-border-b tw-pb-4">
                    Categorías <span class="tw-text-sm tw-font-normal tw-text-gray-500 tw-ml-2">({{ $categories->count() }})</span>
                </h3>
                <div class="row">
                    @foreach($categories as $category)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <a href="#" class="tw-block tw-p-6 tw-bg-white tw-rounded-lg tw-shadow-sm hover:tw-shadow-md tw-transition-all hover:tw-text-red-500 tw-text-center tw-border tw-border-gray-100">
                                <h4 class="tw-font-bold tw-text-lg">{{ $category->name }}</h4>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Blog Section -->
            @if($blogs->isNotEmpty())
            <div class="tw-mb-16">
                <h3 class="tw-text-2xl tw-font-bold tw-mb-6 tw-border-b tw-pb-4">
                    Blog <span class="tw-text-sm tw-font-normal tw-text-gray-500 tw-ml-2">({{ $blogs->count() }})</span>
                </h3>
                <div class="row">
                    @foreach($blogs as $blog)
                        <div class="col-lg-4 col-md-6">
                            <div class="blog-wrap tw-mb-8 tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden hover:tw-shadow-md tw-transition-shadow">
                                <div class="blog-img tw-relative tw-h-48 tw-overflow-hidden">
                                    <a href="{{ route('blog.show', $blog) }}">
                                        @if($blog->image)
                                            <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->title }}" class="tw-w-full tw-h-full tw-object-cover hover:tw-scale-110 tw-transition-transform tw-duration-500">
                                        @else
                                            <img src="{{ asset('assets/images/blog/blog-1.jpg') }}" alt="" class="tw-w-full tw-h-full tw-object-cover hover:tw-scale-110 tw-transition-transform tw-duration-500">
                                        @endif
                                    </a>
                                </div>
                                <div class="blog-content tw-p-6">
                                    <div class="blog-meta tw-mb-3 tw-text-sm tw-text-gray-500">
                                        <ul>
                                            <li><a href="#">{{ $blog->created_at->format('d M, Y') }}</a></li>
                                        </ul>
                                    </div>
                                    <h3 class="tw-text-xl tw-font-bold tw-mb-3 tw-leading-snug">
                                        <a href="{{ route('blog.show', $blog) }}" class="tw-text-gray-800 hover:tw-text-red-500 hover:tw-underline tw-transition-colors">{{ $blog->title }}</a>
                                    </h3>
                                    <div class="blog-btn-2">
                                        <a href="{{ route('blog.show', $blog) }}" class="tw-inline-flex tw-items-center tw-text-red-500 tw-font-medium hover:tw-text-red-700">
                                            Leer más <i class="icon-arrow-right tw-ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        @endif
    </div>
</div>
@endsection
