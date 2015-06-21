@extends('layouts.front')

@section('styles-plugins')
    @parent
    <link rel="stylesheet" href="{{ asset('/assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') }}">
@stop



@section('breadcrumb')
    <div class="breadcrumbs-v1 text-center">
        <div class="container">
            <span>Blog Item Page</span>

            <h1>Basic Item Page</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="bg-color-light">
        <div class="container content-sm">
            <!-- News v3 -->
            <div class="news-v3 margin-bottom-30">
                <img class="img-responsive full-width" src="{{ asset($post->images->first()->sizes->first()->path) }}" alt="{{ $post->images->first()->title }}">

                <div class="news-v3-in">
                    <ul class="list-inline posted-info">
                        <li>By <a href="#">{{ $post->user->name }}</a></li>
                        @foreach($post->tags as $tag)
                        <li>In <a href="#">{{ $tag->name }}</a></li>
                        @endforeach
                        <li>Posted {{ $post->published_at->format('d M, Y') }}</li>
                    </ul>
                    <h2><a href="#">{{ $post->title }}</a></h2>

                    <blockquote class="hero">
                        <p>
                            <em>{{ $post->extract }}</em>
                        </p>
                    </blockquote>

                    <p>
                        {{ $post->content }}
                    </p>

                    <ul class="post-shares post-shares-lg">
                        <li>
                            <a href="#">
                                <i class="rounded-x icon-speech"></i>
                                <span>28</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="rounded-x icon-share"></i>
                                <span>355</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="rounded-x icon-heart"></i>
                                <span>107</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End News v3 -->

            <!-- Blog Post Author -->
            <div class="blog-author margin-bottom-30">
                <img src="{{ asset('/assets/img/team/img1-md.jpg') }}" alt="">

                <div class="blog-author-desc">
                    <div class="overflow-h">
                        <h4>Alexander Jenni</h4>
                        <ul class="list-inline">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                    <p>In auctor fringilla turpis eu rhoncus. Vivamus quis nisi vel dui ultrices lacinia ac eu massa. Quis que vitae consequat sapien. Vivamus sit amet tincidunt ipsum, nec blandit ipsum. Lorem ipsu m dolor sit amet, consectetur adipiscing elit...</p>
                </div>
            </div>
            <!-- End Blog Post Author -->

            <!-- Authored Blog -->
            @include('blog::elements.news-2', ['posts' => $related])
            <!-- End Authored Blog -->

            <hr>

            <h2 class="margin-bottom-20">Comments</h2>
            <!-- Blog Comments -->
            <div class="row blog-comments margin-bottom-30">
                <div class="col-sm-2 sm-margin-bottom-40">
                    <img src="{{ asset('/assets/img/team/img1-sm.jpg') }}" alt="">
                </div>
                <div class="col-sm-10">
                    <div class="comments-itself">
                        <h4>
                            Jalen Davenport
                            <span>5 hours ago / <a href="#">Reply</a></span>
                        </h4>

                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae, gravida pellentesque urna varius vitae. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod..</p>
                    </div>
                </div>
            </div>
            <!-- End Blog Comments -->

            <!-- Blog Comments -->
            <div class="row blog-comments blog-comments-reply margin-bottom-30">
                <div class="col-sm-2 sm-margin-bottom-40">
                    <img src="{{ asset('/assets/img/team/img3-sm.jpg') }}" alt="">
                </div>
                <div class="col-sm-10">
                    <div class="comments-itself">
                        <h4>
                            Jorny Alnordussen
                            <span>6 hours ago / <a href="#">Reply</a></span>
                        </h4>

                        <p>Gravida pellentesque urna varius vitae, gravida pellentesque urna varius vitae. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod..</p>
                    </div>
                </div>
            </div>
            <!-- End Blog Comments -->

            <!-- Blog Comments -->
            <div class="row blog-comments margin-bottom-50">
                <div class="col-sm-2 sm-margin-bottom-40">
                    <img src="{{ asset('/assets/img/team/img5-sm.jpg') }}" alt="">
                </div>
                <div class="col-sm-10">
                    <div class="comments-itself">
                        <h4>
                            Marcus Farrell
                            <span>7 hours ago / <a href="#">Reply</a></span>
                        </h4>

                        <p>Nam viverra euismod odio, gravida pellentesque urna varius vitae, gravida pellentesque urna varius vitae. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod..</p>
                    </div>
                </div>
            </div>
            <!-- End Blog Comments -->

            <hr>

            <h2 class="margin-bottom-20">Post a Comment</h2>
            <!-- Form -->
            <form action="{{ asset('/assets/php/sky-forms-pro/demo-comment-process.php') }}" method="post" id="sky-form3" class="sky-form comment-style">
                <fieldset>
                    <div class="row sky-space-30">
                        <div class="col-md-6">
                            <div>
                                <input type="text" name="name" id="name" placeholder="Name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <input type="text" name="email" id="email" placeholder="Email" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="sky-space-30">
                        <div>
                            <textarea rows="8" name="message" id="message" placeholder="Write comment here ..." class="form-control"></textarea>
                        </div>
                    </div>

                    <p>
                        <button type="submit" class="btn-u">Submit</button>
                    </p>
                </fieldset>

                <div class="message">
                    <i class="rounded-x fa fa-check"></i>

                    <p>Your comment was successfully posted!</p>
                </div>
            </form>
            <!-- End Form -->
        </div>
        <!--/end container-->
    </div>
@stop

@section('scripts-plugins')
    @parent
    <script type="text/javascript" src="{{ asset('/assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/plugins/sky-forms-pro/skyforms/js/jquery.validate.min.js') }}"></script>
@stop

@section('scripts-app')
    <script type="text/javascript" src="{{ asset('/assets/js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/forms/login.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/forms/contact.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            App.init();
            LoginForm.initLoginForm();
            ContactForm.initContactForm();
        });
    </script>

@stop