@extends('layouts.front')

@section('styles-content')
    <link rel="stylesheet" href="{{ asset('/assets/css/pages/blog.css') }}">
@stop

@section('breadcrumb')
    <div class="breadcrumbs">
        <div class="container">
            <h1 class="pull-left">Blog Item 1</h1>
            <ul class="pull-right breadcrumb">
                <li><a href="index.html">Home</a></li>
                <li><a href="">Blog</a></li>
                <li class="active">Blog Item 1</li>
            </ul>
        </div>
    </div><!--/breadcrumbs-->
@stop

@section('content')
    <div class="container content">
        <div class="row blog-page blog-item">
            <!-- Left Sidebar -->
            <div class="col-md-9 md-margin-bottom-60">
                <!--Blog Post-->
                <div class="blog margin-bottom-40">
                    <h2>
                        <a href="blog_item_option1.html">Unify is an incredibly beautiful and fully responsive Bootstrap 3 Template</a>
                    </h2>

                    <div class="blog-post-tags">
                        <ul class="list-unstyled list-inline blog-info">
                            <li><i class="fa fa-calendar"></i> February 02, 2013</li>
                            <li><i class="fa fa-pencil"></i> Diana Anderson</li>
                            <li><i class="fa fa-comments"></i> <a href="#">24 Comments</a></li>
                        </ul>
                        <ul class="list-unstyled list-inline blog-tags">
                            <li>
                                <i class="fa fa-tags"></i>
                                <a href="#">Technology</a>
                                <a href="#">Education</a>
                                <a href="#">Internet</a>
                                <a href="#">Media</a>
                            </li>
                        </ul>
                    </div>
                    <div class="blog-img">
                        <img class="img-responsive" src="{{ asset('/assets/img/sliders/11.jpg') }}" alt="">
                    </div>
                    <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, mollitia animi, id est laborum et dolorum fug consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna.</p>
                    <br>

                    <div class="tag-box tag-box-v2">
                        <p>Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet consectetur adipiscing elit. Fusce condimentum eleifend enim a feugiatt non libero consectetur adipiscing elit magna. Sed et quam lacus. Condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat.</p>
                    </div>
                    <p>Officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, mollitia animi, id est laborum et dolorum fug consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus. Fusce condimentum eleifend.</p>

                    <p>Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus. Fusce condimentum</p>
                    <br>
                    <blockquote>
                        <p>Award winning digital agency. We bring a personal and effective approach to every project we work on, which is why.</p>
                        <small>CEO Jack Bour</small>
                    </blockquote>
                    <p>Deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, mollitia animi, id est laborum et dolorum fug consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus.</p>
                </div>
                <!--End Blog Post-->

                <hr>

                <!-- Recent Comments -->
                <div class="media">
                    <h3>Comments</h3>
                    <a class="pull-left" href="#">
                        <img class="media-object" src="{{ asset('/assets/img/testimonials/img1.jpg') }}" alt=""/>
                    </a>

                    <div class="media-body">
                        <h4 class="media-heading">Media heading <span>5 hours ago / <a href="#">Reply</a></span></h4>

                        <p>Donec id elit non mi portas sats eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna..</p>

                        <hr>

                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="{{ asset('/assets/img/testimonials/img2.jpg') }}" alt=""/>
                            </a>

                            <div class="media-body">
                                <h4 class="media-heading">Media heading
                                    <span>17 hours ago / <a href="#">Reply</a></span></h4>

                                <p>Donec id elit non mi portas sats eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum anibhut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna..</p>
                            </div>
                        </div>

                        <hr>

                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="{{ asset('/assets/img/testimonials/img3.jpg') }}" alt=""/>
                            </a>

                            <div class="media-body">
                                <h4 class="media-heading">Media heading <span>2 days ago / <a href="#">Reply</a></span>
                                </h4>

                                <p>Donec id elit non mi portas sats eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum anibhut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna..</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/media-->

                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="{{ asset('/assets/img/testimonials/img4.jpg') }}" alt=""/>
                    </a>

                    <div class="media-body">
                        <h4 class="media-heading">Media heading <span>July 5,2013 / <a href="#">Reply</a></span></h4>

                        <p>Donec id elit non mi portas sats eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna..</p>
                    </div>
                </div>
                <!--/media-->
                <!-- End Recent Comments -->

                <hr>

                <!-- Comment Form -->
                <div class="post-comment">
                    <h3>Leave a Comment</h3>

                    <form>
                        <label>Name</label>

                        <div class="row margin-bottom-20">
                            <div class="col-md-7 col-md-offset-0">
                                <input type="text" class="form-control">
                            </div>
                        </div>

                        <label>Email <span class="color-red">*</span></label>

                        <div class="row margin-bottom-20">
                            <div class="col-md-7 col-md-offset-0">
                                <input type="text" class="form-control">
                            </div>
                        </div>

                        <label>Message</label>

                        <div class="row margin-bottom-20">
                            <div class="col-md-11 col-md-offset-0">
                                <textarea class="form-control" rows="8"></textarea>
                            </div>
                        </div>

                        <p>
                            <button class="btn-u" type="submit">Send Message</button>
                        </p>
                    </form>
                </div>
                <!-- End Comment Form -->
            </div>
            <!-- End Left Sidebar -->

            <!-- Right Sidebar -->
            <div class="col-md-3 magazine-page">
                <!-- Search Bar -->
                <div class="headline headline-md"><h2>Search</h2></div>
                <div class="input-group margin-bottom-40">
                    <input type="text" class="form-control" placeholder="Search">
                    <span class="input-group-btn">
                        <button class="btn-u" type="button">Go</button>
                    </span>
                </div>
                <!-- End Search Bar -->

                <!-- Posts -->
                <div class="posts margin-bottom-40">
                    <div class="headline headline-md"><h2>Recent Posts</h2></div>
                    <dl class="dl-horizontal">
                        <dt><a href="#"><img src="{{ asset('/assets/img/sliders/elastislide/6.jpg') }}" alt=""/></a>
                        </dt>
                        <dd>
                            <p><a href="#">Responsive Bootstrap 3 Template placerat idelo alac eratamet.</a></p>
                        </dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt><a href="#"><img src="{{ asset('/assets/img/sliders/elastislide/10.jpg') }}" alt=""/></a>
                        </dt>
                        <dd>
                            <p><a href="#">100+ Amazing Features Layer Slider, Layer Slider, Icons, 60+ Pages etc.</a>
                            </p>
                        </dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt><a href="#"><img src="{{ asset('/assets/img/sliders/elastislide/11.jpg') }}" alt=""/></a>
                        </dt>
                        <dd>
                            <p><a href="#">Developer Friendly Code imperdiet condime ntumi mperdiet condim.</a></p>
                        </dd>
                    </dl>
                </div>
                <!--/posts-->
                <!-- End Posts -->

                <!-- Tabs Widget -->
                <div class="headline headline-md"><h2>Tabs Widget</h2></div>
                <div class="tab-v2 margin-bottom-40">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home-1">About Us</a></li>
                        <li><a data-toggle="tab" href="#home-2">Quick Links</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="home-1" class="tab-pane active">
                            <p>Vivamus imperdiet condimentum diam, eget placerat felis consectetur id. Donec eget orci metus, ac ac adipiscing nunc.</p>

                            <p>Pellentesque fermentum, ante ac felis consectetur id. Donec eget orci metusvivamus imperdiet.</p>
                        </div>
                        <div id="home-2" class="tab-pane magazine-sb-categories">
                            <div class="row">
                                <ul class="list-unstyled col-xs-6">
                                    <li><a href="#">Best Sliders</a></li>
                                    <li><a href="#">Parralax Page</a></li>
                                    <li><a href="#">Backgrounds</a></li>
                                    <li><a href="#">Parralax Slider</a></li>
                                    <li><a href="#">Responsive</a></li>
                                    <li><a href="#">800+ Icons</a></li>
                                </ul>
                                <ul class="list-unstyled col-xs-6">
                                    <li><a href="#">60+ Pages</a></li>
                                    <li><a href="#">Layer Slider</a></li>
                                    <li><a href="#">Bootstrap 3</a></li>
                                    <li><a href="#">Fixed Header</a></li>
                                    <li><a href="#">Best Template</a></li>
                                    <li><a href="#">And Many More</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Tabs Widget -->

                <!-- Photo Stream -->
                <div class="headline headline-md"><h2>Photo Stream</h2></div>
                <ul class="list-unstyled blog-photos margin-bottom-30">
                    <li>
                        <a href="#"><img class="hover-effect" alt="" src="{{ asset('/assets/img/sliders/elastislide/5.jpg') }}"></a>
                    </li>
                    <li>
                        <a href="#"><img class="hover-effect" alt="" src="{{ asset('/assets/img/sliders/elastislide/6.jpg') }}"></a>
                    </li>
                    <li>
                        <a href="#"><img class="hover-effect" alt="" src="{{ asset('/assets/img/sliders/elastislide/8.jpg') }}"></a>
                    </li>
                    <li>
                        <a href="#"><img class="hover-effect" alt="" src="{{ asset('/assets/img/sliders/elastislide/10.jpg') }}"></a>
                    </li>
                    <li>
                        <a href="#"><img class="hover-effect" alt="" src="{{ asset('/assets/img/sliders/elastislide/11.jpg') }}"></a>
                    </li>
                    <li>
                        <a href="#"><img class="hover-effect" alt="" src="{{ asset('/assets/img/sliders/elastislide/1.jpg') }}"></a>
                    </li>
                    <li>
                        <a href="#"><img class="hover-effect" alt="" src="{{ asset('/assets/img/sliders/elastislide/2.jpg') }}"></a>
                    </li>
                    <li>
                        <a href="#"><img class="hover-effect" alt="" src="{{ asset('/assets/img/sliders/elastislide/7.jpg') }}"></a>
                    </li>
                </ul>
                <!-- End Photo Stream -->

                <!-- Blog Tags -->
                <div class="headline headline-md"><h2>Blog Tags</h2></div>
                <ul class="list-unstyled blog-tags margin-bottom-30">
                    <li><a href="#"><i class="fa fa-tags"></i> Business</a></li>
                    <li><a href="#"><i class="fa fa-tags"></i> Music</a></li>
                    <li><a href="#"><i class="fa fa-tags"></i> Internet</a></li>
                    <li><a href="#"><i class="fa fa-tags"></i> Money</a></li>
                    <li><a href="#"><i class="fa fa-tags"></i> Google</a></li>
                    <li><a href="#"><i class="fa fa-tags"></i> TV Shows</a></li>
                    <li><a href="#"><i class="fa fa-tags"></i> Education</a></li>
                    <li><a href="#"><i class="fa fa-tags"></i> People</a></li>
                    <li><a href="#"><i class="fa fa-tags"></i> People</a></li>
                    <li><a href="#"><i class="fa fa-tags"></i> Math</a></li>
                    <li><a href="#"><i class="fa fa-tags"></i> Photos</a></li>
                    <li><a href="#"><i class="fa fa-tags"></i> Electronics</a></li>
                    <li><a href="#"><i class="fa fa-tags"></i> Apple</a></li>
                    <li><a href="#"><i class="fa fa-tags"></i> Canada</a></li>
                </ul>
                <!-- End Blog Tags -->

                <!-- Blog Latest Tweets -->
                <div class="blog-twitter margin-bottom-30">
                    <div class="headline headline-md"><h2>Latest Tweets</h2></div>
                    <div class="blog-twitter-inner">
                        <i class="fa fa-twitter"></i>
                        <a href="#">@htmlstream</a>
                        At vero eos et accusamus et iusto odio dignissimos.
                        <a href="#">http://t.co/sBav7dm</a>
                        <span>5 hours ago</span>
                    </div>
                    <div class="blog-twitter-inner">
                        <i class="fa fa-twitter"></i>
                        <a href="#">@htmlstream</a>
                        At vero eos et accusamus et iusto odio dignissimos.
                        <a href="#">http://t.co/sBav7dm</a>
                        <span>5 hours ago</span>
                    </div>
                    <div class="blog-twitter-inner">
                        <i class="fa fa-twitter"></i>
                        <a href="#">@htmlstream</a>
                        At vero eos et accusamus et iusto odio dignissimos.
                        <a href="#">http://t.co/sBav7dm</a>
                        <span>5 hours ago</span>
                    </div>
                    <div class="blog-twitter-inner">
                        <i class="fa fa-twitter"></i>
                        <a href="#">@htmlstream</a>
                        At vero eos et accusamus et iusto odio dignissimos.
                        <a href="#">http://t.co/sBav7dm</a>
                        <span>5 hours ago</span>
                    </div>
                </div>
                <!-- End Blog Latest Tweets -->
            </div>
            <!-- End Right Sidebar -->
        </div>
        <!--/row-->
    </div><!--/container-->
@stop