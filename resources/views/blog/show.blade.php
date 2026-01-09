@extends('layouts.site')
@section('title', $blog->title)

@section('header-extra-classes', '')
@section('container-class', 'container')

@section('breadcrumbs')
    <li class="active"><a href="{{ route('blog.index') }}">Blog</a></li>
@endsection

@section('content')
    <div class="blog-area tw-pt-6 sm:tw-pt-20 pb-120">
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="col-lg-9">
                    <div class="blog-details-wrapper">
                        <div class="blog-details-top">
                            <div class="blog-details-img">
                                <img alt="" src="{{ asset('storage/' . $blog->image) }}">
                            </div>
                            <div class="blog-details-content">
                                <div class="blog-meta-2">
                                    <ul>
                                        <li>News</li>
                                        <li>May 25, 2022</li>
                                    </ul>
                                </div>
                                <h1>{{ $blog->title }}</h1>
                                
                                @if(is_array($blog->content))
                                    @foreach ($blog->content as $block)
                                        @if ($block['type'] === 'paragraph')
                                            <div class="mb-4">
                                                {!! $block['data']['text'] !!}
                                            </div>
                                        @elseif ($block['type'] === 'quote')
                                            <blockquote>
                                                {{ $block['data']['text'] }}
                                                @if(!empty($block['data']['author']))
                                                    <footer>— {{ $block['data']['author'] }}</footer>
                                                @endif
                                            </blockquote>
                                        @elseif ($block['type'] === 'two_images')
                                            <div class="dec-img-wrapper">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-12">
                                                        <div class="dec-img mb-50">
                                                            <img src="{{ Storage::url($block['data']['image_left']) }}" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-12">
                                                        <div class="dec-img mb-50">
                                                            <img src="{{ Storage::url($block['data']['image_right']) }}" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                @if(!empty($block['data']['caption']))
                                                    <p>{{ $block['data']['caption'] }}</p>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    {!! $blog->content !!}
                                @endif
                            </div>
                        </div>
                        <div class="tag-share">
                            <div class="dec-tag">
                                <ul>
                                    <li><a href="#">lifestyle ,</a></li>
                                    <li><a href="#">interior ,</a></li>
                                    <li><a href="#">outdoor</a></li>
                                </ul>
                            </div>
                            <div class="blog-share">
                                <span>share :</span>
                                <div class="share-social">
                                    <ul>
                                        <li>
                                            <a class="facebook" href="#">
                                                <i class="icon-social-facebook"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="twitter" href="#">
                                                <i class="icon-social-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="instagram" href="#">
                                                <i class="icon-social-instagram"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="next-previous-post">
                            <a href="#"> <i class="fa fa-angle-left"></i> prev post</a>
                            <a href="#">next post <i class="fa fa-angle-right"></i></a>
                        </div>
                        <div class="blog-comment-wrapper mt-55">
                            <h4 class="blog-dec-title">comments : 02</h4>
                            <div class="single-comment-wrapper mt-35">
                                <div class="blog-comment-img">
                                    <img src="assets/images/blog/comment-1.jpg" alt="">
                                </div>
                                <div class="blog-comment-content">
                                    <h4>Anthony Stephens</h4>
                                    <span>October 14, 2022 </span>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolor magna aliqua. Ut enim ad minim veniam, </p>
                                    <div class="blog-details-btn">
                                        <a href="blog-details.html">read more</a>
                                    </div>
                                </div>
                            </div>
                            <div class="single-comment-wrapper mt-50 ml-120">
                                <div class="blog-comment-img">
                                    <img src="assets/images/blog/comment-2.jpg" alt="">
                                </div>
                                <div class="blog-comment-content">
                                    <h4>DX Joxova</h4>
                                    <span>October 14, 2022 </span>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolor magna aliqua. Ut enim ad minim veniam, </p>
                                    <div class="blog-details-btn">
                                        <a href="blog-details.html">read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="blog-reply-wrapper mt-50">
                            <h4 class="blog-dec-title">post a comment</h4>
                            <form class="blog-form" action="#">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="leave-form">
                                            <input type="text" placeholder="Full Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="leave-form">
                                            <input type="email" placeholder="Email Address ">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="text-leave">
                                            <textarea placeholder="Message"></textarea>
                                            <input type="submit" value="POST COMMENT">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="sidebar-wrapper sidebar-wrapper-mrg-right">
                        <div class="sidebar-widget mb-40">
                            <h4 class="sidebar-widget-title">Search </h4>
                            <div class="sidebar-search">
                                <form class="sidebar-search-form" action="#">
                                    <input type="text" placeholder="Search Post">
                                    <button>
                                        <i class="icon-magnifier"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="sidebar-widget shop-sidebar-border mb-35 pt-40">
                            <h4 class="sidebar-widget-title">Categorías </h4>
                            <div class="shop-catigory">
                                <ul>
                                    @foreach ($categories as $category)
                                        <li><a href="#">{{ $category->name }} <span class="tw-text-xs tw-text-gray-400 tw-ml-1">{{ $category->blogs_count }}</span></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="sidebar-widget shop-sidebar-border mb-40 pt-40">
                            <h4 class="sidebar-widget-title">Posts Recientes </h4>
                            <div class="recent-post">
                                @foreach ($recentPosts as $post)
                                <div class="single-sidebar-blog">
                                    <div class="sidebar-blog-img">
                                        <a href="{{ route('blog.show', $post->slug) }}"><img src="{{ Storage::url($post->image) }}" alt=""></a>
                                    </div>
                                    <div class="sidebar-blog-content">
                                        <h5><a href="{{ route('blog.show', $post->slug) }}">{{ Str::words($post->title, 5) }}</a></h5>
                                        <span>{{ $post->published_at->translatedFormat('j \d\e F, Y') }}</span>
                                    </div>
                                </div>
                                @endforeach
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
@endsection