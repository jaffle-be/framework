@extends('shop::front')

@section('styles-plugin')
    <link rel="stylesheet" href="{{ asset('/assets/plugins/noUiSlider/jquery.nouislider.css') }}">
@stop

@section('breadcrumb')
    <div class="breadcrumbs-v4">
        <div class="container">
            <span class="page-name">Product Filter Page</span>
            <h1>Maecenas <span class="shop-green">enim</span> sapien</h1>
            <ul class="breadcrumb-v4-in">
                <li><a href="index.html">Home</a></li>
                <li><a href="">Product</a></li>
                <li class="active">Product Filter Page</li>
            </ul>
        </div>
    </div>
@stop

@section('content')

    <div class="content container">
        <div class="row">

            @include('shop::elements.filter-sidebar')

            <div class="col-md-9">
                @include('shop::elements.category-results')

                @include('shop::elements.filter-list')

            </div>
        </div>
    </div>

    @include('shop::elements.subscribe')
@stop

@section('scripts-plugins')
    @parent
    <script src="{{ asset('/assets/plugins/noUiSlider/jquery.nouislider.full.min.js') }}"></script>
@stop

@section('scripts-app')
    <script src="{{ asset('/assets/js/shop.app.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/mouse-wheel.js') }}"></script>
    <script>
        jQuery(document).ready(function() {
            App.init();
            App.initScrollBar();
            MouseWheel.initMouseWheel();
        });
    </script>
@stop
