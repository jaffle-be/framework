@extends('layouts.front')

@section('breadcrumb')
    <div class="breadcrumbs-v1 text-center">
        <div class="container">
            <span>Blog Page</span>

            <h1>Basic Full Width</h1>
        </div>
    </div>

@stop

@section('content')
    <div class="bg-color-light">
        <div class="container content-sm">
            <!-- Blog Posts -->
            <div class="news-v3 margin-bottom-60">
                <img class="img-responsive full-width" src="{{ asset('/assets/img/main/img12.jpg') }}" alt="">

                <div class="news-v3-in">
                    <ul class="list-inline posted-info">
                        <li>By <a href="#">Alexander Jenni</a></li>
                        <li>In <a href="#">Design</a></li>
                        <li>Posted January 24, 2015</li>
                    </ul>
                    <h2><a href="#">Incredible standard post “IMAGE”</a></h2>

                    <p>Nullam elementum tincidunt massa, a pulvinar leo ultricies ut. Ut fringilla lectus tellus, imperdiet molestie est volutpat at. Sed viverra cursus nibh, sed consectetur ipsum sollicitudin sed. Cras erat est, euismod id congue sed, sollicitudin sed odio. Nullam non metus in mi rhoncus efficitur...</p>
                    <ul class="post-shares">
                        <li>
                            <a href="#">
                                <i class="rounded-x icon-speech"></i>
                                <span>26</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="rounded-x icon-share"></i>
                                <span>98</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="rounded-x icon-heart"></i>
                                <span>30</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End Blog Posts -->

            <!-- Blog Posts -->
            <div class="news-v3 margin-bottom-60">
                <div class="carousel slide carousel-v2" id="portfolio-carousel">
                    <ol class="carousel-indicators">
                        <li class="rounded-x active" data-target="#portfolio-carousel" data-slide-to="0"></li>
                        <li class="rounded-x" data-target="#portfolio-carousel" data-slide-to="1"></li>
                        <li class="rounded-x" data-target="#portfolio-carousel" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="item active">
                            <img class="img-responsive full-width" src="{{ asset('/assets/img/main/img3.jpg') }}" alt="">
                        </div>
                        <div class="item">
                            <img class="img-responsive full-width" src="{{ asset('/assets/img/main/img4.jpg') }}" alt="">
                        </div>
                        <div class="item">
                            <img class="img-responsive full-width" src="{{ asset('/assets/img/main/img10.jpg') }}" alt="">
                        </div>
                    </div>
                    <a class="left carousel-control rounded-x" href="#portfolio-carousel" role="button" data-slide="prev">
                        <i class="fa fa-angle-left arrow-prev"></i>
                    </a>
                    <a class="right carousel-control rounded-x" href="#portfolio-carousel" role="button" data-slide="next">
                        <i class="fa fa-angle-right arrow-next"></i>
                    </a>
                </div>

                <div class="news-v3-in">
                    <ul class="list-inline posted-info">
                        <li>By Luke Etheridge</li>
                        <li>In <a href="#">Design</a></li>
                        <li>Posted January 24, 2015</li>
                    </ul>
                    <h2><a href="#">Amazing post “IMAGE-SLIDER”</a></h2>

                    <p>Nullam elementum tincidunt massa, a pulvinar leo ultricies ut. Ut fringilla lectus tellus, imperdiet molestie est volutpat at. Sed viverra cursus nibh, sed consectetur ipsum sollicitudin sed. Cras erat est, euismod id congue sed, sollicitudin sed odio. Nullam non metus in mi rhoncus efficitur...</p>
                    <ul class="post-shares">
                        <li>
                            <a href="#">
                                <i class="rounded-x icon-speech"></i>
                                <span>5</span>
                            </a>
                        </li>
                        <li><a href="#"><i class="rounded-x icon-share"></i></a></li>
                        <li><a href="#"><i class="rounded-x icon-heart"></i></a></li>
                    </ul>
                </div>
            </div>
            <!-- End Blog Posts -->

            <!-- Blog Posts -->
            <div class="news-v3 margin-bottom-60">
                <div class="responsive-video">
                    <iframe src="//player.vimeo.com/video/93003441?color=567fc7" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                </div>
                <div class="news-v3-in">
                    <ul class="list-inline posted-info">
                        <li>By Alexander Jenni</li>
                        <li>In <a href="#">Design</a></li>
                        <li>Posted January 24, 2015</li>
                    </ul>
                    <h2><a href="#">Awesome post “VIDEO”</a></h2>

                    <p>Nullam elementum tincidunt massa, a pulvinar leo ultricies ut. Ut fringilla lectus tellus, imperdiet molestie est volutpat at. Sed viverra cursus nibh, sed consectetur ipsum sollicitudin sed. Cras erat est, euismod id congue sed, sollicitudin sed odio. Nullam non metus in mi rhoncus efficitur...</p>
                    <ul class="post-shares">
                        <li>
                            <a href="#">
                                <i class="rounded-x icon-speech"></i>
                                <span>5</span>
                            </a>
                        </li>
                        <li><a href="#"><i class="rounded-x icon-share"></i></a></li>
                        <li><a href="#"><i class="rounded-x icon-heart"></i></a></li>
                    </ul>
                </div>
            </div>
            <!-- End Blog Posts -->

            <!-- Blog Posts -->
            <div class="blog-post-quote margin-bottom-60">
                <p>Look deep into nature, and then you will understand everything better.</p>
                <span>- Albert Einstein</span>
            </div>
            <!-- End Blog Posts -->

            <!-- Blog Posts -->
            <div class="news-v3 margin-bottom-60">
                <iframe width="100%" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/19048953&amp;color=ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_artwork=true"></iframe>

                <div class="news-v3-in">
                    <ul class="list-inline posted-info">
                        <li>By Luke Etheridge</li>
                        <li>In <a href="#">Design</a></li>
                        <li>Posted January 24, 2015</li>
                    </ul>
                    <h2><a href="#">Wonderful post “AUDIO”</a></h2>

                    <p>Nullam elementum tincidunt massa, a pulvinar leo ultricies ut. Ut fringilla lectus tellus, imperdiet molestie est volutpat at. Sed viverra cursus nibh, sed consectetur ipsum sollicitudin sed. Cras erat est, euismod id congue sed, sollicitudin sed odio. Nullam non metus in mi rhoncus efficitur...</p>
                    <ul class="post-shares">
                        <li>
                            <a href="#">
                                <i class="rounded-x icon-speech"></i>
                                <span>5</span>
                            </a>
                        </li>
                        <li><a href="#"><i class="rounded-x icon-share"></i></a></li>
                        <li><a href="#"><i class="rounded-x icon-heart"></i></a></li>
                    </ul>
                </div>
            </div>
            <!-- End Blog Posts -->

            <!-- Pager v2 -->
            <ul class="pager pager-v2 pager-md no-margin">
                <li class="previous"><a href="#">&larr; Older</a></li>
                <li class="page-amount">1 of 7</li>
                <li class="next"><a href="#">Newer &rarr;</a></li>
            </ul>
            <!-- End Pager v2 -->
        </div>
    </div>

@stop