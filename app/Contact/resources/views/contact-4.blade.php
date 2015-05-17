@extends('layouts.front')
@section('styles-plugins')
    @parent
    <link rel="stylesheet" href="{{ asset('/assets/plugins/owl-carousel/owl-carousel/owl.carousel.css') }}">
@stop

@section('styles-content')
    <link rel="stylesheet" href="{{ asset('/assets/css/pages/page_contact.css') }}">
@stop

@section('breadcrumb')
    <div class="breadcrumbs">
        <div class="container">
            <h1 class="pull-left">Our Contacts</h1>
            <ul class="pull-right breadcrumb">
                <li><a href="index.html">Home</a></li>
                <li><a href="">Pages</a></li>
                <li class="active">Contacts</li>
            </ul>
        </div>
    </div>
@stop

@section('content')
    <div class="container content">
        <div class="row margin-bottom-60">
            <div class="col-md-6 col-sm-6">
                <!-- Google Map -->
                <div id="map" class="height-450">
                </div>
                <!-- End Google Map -->
            </div>
            <div class="col-md-6 col-sm-6">
                <!-- Get in Touch -->
                <h3>Get in Touch</h3>

                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, justo sit amet risus etiam porta sem</p>

                <hr>

                <!-- Contacts -->
                <h3>The Office</h3>
                <ul class="list-unstyled who">
                    <li><a href="#"><i class="fa fa-home"></i>5B Streat, City 50987 New Town US</a></li>
                    <li><a href="#"><i class="fa fa-envelope"></i>info@example.com</a></li>
                    <li><a href="#"><i class="fa fa-phone"></i>1(222) 5x86 x97x</a></li>
                    <li><a href="#"><i class="fa fa-globe"></i>http://www.example.com</a></li>
                </ul>

                <hr>

                <!-- Business Hours -->
                <h3>Business Hours</h3>
                <ul class="list-unstyled">
                    <li><strong>Monday-Friday:</strong> 10am to 8pm</li>
                    <li><strong>Saturday:</strong> 11am to 3pm</li>
                    <li><strong>Sunday:</strong> Closed</li>
                </ul>
            </div>
        </div>

        <!-- Owl Clients v1 -->
        <div class="headline"><h2>Our Clients</h2></div>
        <div class="owl-clients-v1">
            <div class="item">
                <img src="{{ asset('/assets/img/clients4/1.png') }}" alt="">
            </div>
            <div class="item">
                <img src="{{ asset('/assets/img/clients4/2.png') }}" alt="">
            </div>
            <div class="item">
                <img src="{{ asset('/assets/img/clients4/3.png') }}" alt="">
            </div>
            <div class="item">
                <img src="{{ asset('/assets/img/clients4/4.png') }}" alt="">
            </div>
            <div class="item">
                <img src="{{ asset('/assets/img/clients4/5.png') }}" alt="">
            </div>
            <div class="item">
                <img src="{{ asset('/assets/img/clients4/6.png') }}" alt="">
            </div>
            <div class="item">
                <img src="{{ asset('/assets/img/clients4/7.png') }}" alt="">
            </div>
            <div class="item">
                <img src="{{ asset('/assets/img/clients4/8.png') }}" alt="">
            </div>
            <div class="item">
                <img src="{{ asset('/assets/img/clients4/9.png') }}" alt="">
            </div>
        </div>
        <!-- End Owl Clients v1 -->
    </div>
@stop

@section('scripts-plugins')
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="{{ asset('/assets/plugins/gmap/gmap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/plugins/owl-carousel/owl-carousel/owl.carousel.js') }}"></script>
@stop

@section('scripts-app')
    <script type="text/javascript" src="{{ asset('/assets/js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/pages/page_contacts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/plugins/owl-carousel.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            App.init();
            ContactPage.initMap();
            OwlCarousel.initOwlCarousel();
        });
    </script>

@stop
