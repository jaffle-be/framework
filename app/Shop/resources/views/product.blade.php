@extends('shop::front')

@section('styles-plugins')
    @parent
    <link rel="stylesheet" href="{{ asset('/assets/plugins/owl-carousel/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/master-slider/quick-start/masterslider/style/masterslider.css') }}">
    <link rel='stylesheet' href="{{ asset('/assets/plugins/master-slider/quick-start/masterslider/skins/default/style.css') }}">
@stop

@section('content')
    @include('shop::elements.product-detail')

    <!--=== Content Medium ===-->
    <div class="content-md container">

        @include('shop::elements.product-service')

        @include('shop::elements.tabs')
    </div>

    @include('shop::elements.subscribe')

@stop

@section('scripts-plugins')
    @parent
    <script src="{{ asset('/assets/plugins/owl-carousel/owl-carousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('/assets/plugins/master-slider/quick-start/masterslider/masterslider.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/master-slider/quick-start/masterslider/jquery.easing.min.js') }}"></script>
@stop

@section('scripts-app')
    <!-- JS Page Level -->
    <script src="{{ asset('/assets/js/shop.app.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/owl-carousel.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/master-slider.js') }}"></script>
    <script src="{{ asset('/assets/js/forms/shop/product-quantity.js') }}"></script>
    <script>
        jQuery(document).ready(function () {
            App.init();
            App.initScrollBar();
            OwlCarousel.initOwlCarousel();
            MasterSliderShowcase2.initMasterSliderShowcase2();
        });
    </script>
@stop