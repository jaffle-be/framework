@extends('shop::front')

@section('styles-plugins')
    @parent
    <link rel="stylesheet" href="{{ asset('/assets/plugins/owl-carousel/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/revolution-slider/rs-plugin/css/settings.css') }}">
@stop

@include('shop::elements.slider-home')

@section('content')

    @include('shop::elements.product-content')

    @include('shop::elements.twitter')

    <div class="container">
        @include('shop::elements.product-service')

        @include('shop::elements.illustrations')
    </div>

    @include('shop::elements.collection-banner')

    @include('shop::elements.sponsors')

    @include('shop::elements.subscribe')
@stop

@section('scripts-plugins')
    @parent
    <script src="{{ asset('/assets/plugins/jquery.parallax.js') }}"></script>
    <script src="{{ asset('/assets/plugins/owl-carousel/owl-carousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('/assets/plugins/revolution-slider/rs-plugin/js/jquery.themepunch.tools.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/revolution-slider/rs-plugin/js/jquery.themepunch.revolution.min.js') }}"></script>

@stop

@section('scripts-app')
    <script src="{{ asset('/assets/js/shop.app.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/owl-carousel.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/revolution-slider.js') }}"></script>
    <script>
        jQuery(document).ready(function () {
            App.init();
            App.initScrollBar();
            App.initParallaxBg();
            OwlCarousel.initOwlCarousel();
            RevolutionSlider.initRSfullWidth();
        });
    </script>
@stop