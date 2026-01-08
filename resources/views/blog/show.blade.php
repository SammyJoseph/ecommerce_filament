@extends('layouts.site')
@section('title', $blog->title)

@section('header-extra-classes', '')
@section('container-class', 'container')

@section('breadcrumbs')
    <li class="active"><a href="{{ route('blog.index') }}">Blog</a></li>
@endsection

@section('content')
    <div class="blog-area tw-pt-0 sm:tw-pt-20 lg:tw-pt-24 pb-120">
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
                            <h4 class="sidebar-widget-title">Categories </h4>
                            <div class="shop-catigory">
                                <ul>
                                    <li><a href="shop.html">T-Shirt</a></li>
                                    <li><a href="shop.html">Shoes</a></li>
                                    <li><a href="shop.html">Clothing </a></li>
                                    <li><a href="shop.html">Women </a></li>
                                    <li><a href="shop.html">Baby Boy </a></li>
                                    <li><a href="shop.html">Accessories </a></li>
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
@endsection