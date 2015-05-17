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
                <img class="img-responsive full-width" src="{{ asset('/assets/img/main/img12.jpg') }}" alt="">

                <div class="news-v3-in">
                    <ul class="list-inline posted-info">
                        <li>By <a href="#">Alexander Jenni</a></li>
                        <li>In <a href="#">Design</a></li>
                        <li>Posted January 24, 2015</li>
                    </ul>
                    <h2><a href="#">Incredible standard post “IMAGE”</a></h2>

                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec arcu ipsum. Curabitur tincidunt nisi ex, ut eleifend turpis egestas vitae. Proin convallis et eros eget rutrum. Duis luctus lorem id mattis placerat. Etiam pharetra libero ut suscipit mollis. Morbi augue mi, maximus at lectus id, mollis ornare dui. Curabitur consequat, est non cursus suscipit, quam nulla porta enim, sed pharetra diam elit non nisi. Praesent pulvinar ante eu euismod cursus. Fusce quis est justo. Nullam id egestas diam. Etiam ac augue orci. Aliquam scelerisque convallis est sed pretium. In vel elementum lorem.</p>

                    <p>Pellentesque eleifend metus vitae commodo finibus. Proin eget mi a sem placerat facilisis. Aenean interdum aliquet sapien, non scelerisque massa vestibulum ut. Quisque mollis, ante nec volutpat dignissim, lectus libero porta magna, at volutpat massa orci a turpis. Duis tincidunt nunc magna, non semper metus tempus ut. Duis vulputate enim condimentum posuere lacinia. Ut venenatis massa ex.</p>
                    <blockquote class="hero">
                        <p>
                            <em>"Lorem ipsum dolor sit amet, consectetur adipiscing duis mollis, est non commodo luctus elit posuere erat a ante. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis lorem ipsum dolor sit amet, consectetur adipiscing"</em>
                        </p>
                    </blockquote>
                    <p>Sed placerat diam auctor eget. Mauris tellus eros, iaculis id leo quis, finibus aliquet ipsum. Duis volutpat lacus in purus bibendum, at sollicitudin eros malesuada. Sed nec diam a eros eleifend mattis. Phasellus in facilisis enim. Vestibulum sodales lacinia lectus, quis efficitur velit posuere sed.</p>

                    <p>Pellentesque eleifend metus vitae commodo finibus. Proin eget mi a sem placerat facilisis. Aenean interdum aliquet sapien, non scelerisque massa vestibulum ut. Quisque mollis, ante nec volutpat dignissim, lectus libero porta magna, at volutpat massa orci a turpis. Duis tincidunt nunc magna, non semper metus tempus ut. Duis vulputate enim condimentum posuere lacinia. Ut venenatis massa ex.</p>
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
            <div class="row news-v2 margin-bottom-50">
                <div class="col-sm-4 sm-margin-bottom-30">
                    <div class="news-v2-badge">
                        <img class="img-responsive" src="{{ asset('/assets/img/main/img3.jpg') }}" alt="">

                        <p>
                            <span>24</span>
                            <small>Jan</small>
                        </p>
                    </div>
                    <div class="news-v2-desc">
                        <h3><a href="#">Blog Image Post</a></h3>
                        <small>By Admin | California, US | In <a href="#">Art</a></small>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae, gravida pellentesque urna varius vitae.</p>
                    </div>
                </div>
                <div class="col-sm-4 sm-margin-bottom-30">
                    <div class="news-v2-badge">
                        <img class="img-responsive" src="{{ asset('/assets/img/main/img6.jpg') }}" alt="">

                        <p>
                            <span>23</span>
                            <small>Jan</small>
                        </p>
                    </div>
                    <div class="news-v2-desc">
                        <h3><a href="#">Blog Image Post</a></h3>
                        <small>By Admin | California, US | In <a href="#">Art</a></small>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae, gravida pellentesque urna varius vitae.</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="news-v2-badge">
                        <img class="img-responsive" src="{{ asset('/assets/img/main/img4.jpg') }}" alt="">

                        <p>
                            <span>22</span>
                            <small>Jan</small>
                        </p>
                    </div>
                    <div class="news-v2-desc">
                        <h3><a href="#">Blog Image Post</a></h3>
                        <small>By Admin | California, US | In <a href="#">Art</a></small>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae, gravida pellentesque urna varius vitae.</p>
                    </div>
                </div>
            </div>
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