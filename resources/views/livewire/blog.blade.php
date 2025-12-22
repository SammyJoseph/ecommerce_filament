<div class="blog-area tw-pt-6 sm:tw-pt-24 pb-120">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9">
                <div class="row tw-relative">
                    <div wire:loading.flex class="tw-absolute tw-inset-0 tw-flex tw-justify-center tw-items-center tw-bg-white/60 tw-z-50">
                        <div class="tw-animate-spin tw-rounded-full tw-h-12 tw-w-12 tw-border-4 tw-border-solid tw-border-gray-300 tw-border-t-red-600"></div>
                    </div>
                    @foreach ($blogs as $blog)
                    <div class="col-lg-6 col-md-6 col-12 col-sm-6" wire:loading.class="tw-opacity-50">
                        <div class="blog-wrap mb-40">
                            <div class="blog-img mb-20">
                                <a href="{{ route('blog.show', $blog->slug) }}"><img src="{{ asset('storage/' . $blog->image) }}" alt="blog-img"></a>
                            </div>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <ul>
                                        <li>
                                            @foreach ($blog->categories as $category)
                                            <a href="{{ route('blog.category.show', $category->slug) }}">{{ $category->name }}</a>@if (!$loop->last), @endif
                                            @endforeach
                                        </li>
                                        <li>{{ $blog->published_at->format('F j, Y') }}</li>
                                    </ul>
                                </div>
                                <h1><a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a></h1>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{ $blogs->links('livewire.pagination') }}
            </div>
            <div class="col-lg-3">
                <div class="sidebar-wrapper sidebar-wrapper-mrg-right">
                    <div class="sidebar-widget mb-40">
                        <h4 class="sidebar-widget-title">Search </h4>
                        <div class="sidebar-search">
                            <form class="sidebar-search-form" action="#" wire:submit.prevent>
                                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search Post">
                                @if(!empty($search))
                                    <button type="button" wire:click="clearSearch">
                                        <i class="icon-close"></i>
                                    </button>
                                @else
                                    <button type="submit">
                                        <i class="icon-magnifier"></i>
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                    <div class="sidebar-widget shop-sidebar-border mb-35 pt-40">
                        <h4 class="sidebar-widget-title">Categories </h4>
                        <div class="shop-catigory">
                            <ul>
                                @foreach ($categories as $category)
                                <li>
                                    <a href="#" wire:click.prevent="filterByCategory('{{ $category->slug }}')" class="{{ $categorySlug == $category->slug ? '!tw-text-red-500 !tw-flex tw-justify-between tw-items-center' : '' }}">
                                        <span>{{ $category->name }} <span class="tw-text-xs tw-text-gray-400 tw-ml-1">{{ $category->blogs_count }}</span></span>
                                        @if($categorySlug == $category->slug)
                                            <i class="icon-close"></i>
                                        @endif
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="sidebar-widget shop-sidebar-border mb-40 pt-40">
                        <h4 class="sidebar-widget-title">Recent Posts </h4>
                        <div class="recent-post">
                            <div class="single-sidebar-blog">
                                <div class="sidebar-blog-img">
                                    <a href="blog-details.html"><img src="assets/images/blog/blog-4.jpg" alt=""></a>
                                </div>
                                <div class="sidebar-blog-content">
                                    <h5><a href="blog-details.html">Basic colord mixed</a></h5>
                                    <span>Sep 5th, 2022</span>
                                </div>
                            </div>
                            <div class="single-sidebar-blog">
                                <div class="sidebar-blog-img">
                                    <a href="blog-details.html"><img src="assets/images/blog/blog-5.jpg" alt=""></a>
                                </div>
                                <div class="sidebar-blog-content">
                                    <h5><a href="blog-details.html">Five things you only</a></h5>
                                    <span>Sep 15th, 2022</span>
                                </div>
                            </div>
                            <div class="single-sidebar-blog">
                                <div class="sidebar-blog-img">
                                    <a href="blog-details.html"><img src="assets/images/blog/blog-4.jpg" alt=""></a>
                                </div>
                                <div class="sidebar-blog-content">
                                    <h5><a href="blog-details.html">Basic colord mixed</a></h5>
                                    <span>Sep 5th, 2022</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-widget shop-sidebar-border mb-40 pt-40">
                        <h4 class="sidebar-widget-title">Archives </h4>
                        <div class="archives-wrap">
                            <select>
                                <option>Select Month</option>
                                <option> January 2022 </option>
                                <option> December 2022 </option>
                                <option> November 2022 </option>
                            </select>
                        </div>
                    </div>
                    <div class="sidebar-widget shop-sidebar-border pt-40">
                        <h4 class="sidebar-widget-title">Popular Tags</h4>
                        <div class="tag-wrap sidebar-widget-tag">
                            <a href="#">Clothing</a>
                            <a href="#">Accessories</a>
                            <a href="#">For Men</a>
                            <a href="#">Women</a>
                            <a href="#">Fashion</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>