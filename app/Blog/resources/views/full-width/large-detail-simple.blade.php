@extends('layouts.front')

@section('styles-content')
    <link rel="stylesheet" href="{{ asset('/assets/css/pages/blog.css') }}">
@stop

<body>

@section('breadcrumb')
    <div class="breadcrumbs">
        <div class="container">
            <h1 class="pull-left">Blog Item 2</h1>
            <ul class="pull-right breadcrumb">
                <li><a href="index.html">Home</a></li>
                <li><a href="">Blog</a></li>
                <li class="active">Blog Item 2</li>
            </ul>
        </div>
    </div>
@stop

@section('content')
    <div class="container content blog-page blog-item">
        <!--Blog Post-->
        <div class="blog margin-bottom-40">
            <div class="blog-img">
                <img class="img-responsive" src="{{ asset('/assets/img/sliders/4.jpg') }}" alt="">
            </div>
            <h2>
                <a href="blog_item_option1.html">Unify is an incredibly beautiful and fully responsive Bootstrap 3 Template</a>
            </h2>

            <div class="blog-post-tags">
                <ul class="list-unstyled list-inline blog-info">
                    <li><i class="fa fa-calendar"></i> February 02, 2013</li>
                    <li><i class="fa fa-pencil"></i> Diana Anderson</li>
                    <li><i class="fa fa-comments"></i> <a href="#">24 Comments</a></li>
                    <li><i class="fa fa-tags"></i> Technology, Education, Internet, Media</li>
                </ul>
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
                <img class="media-object" src="{{ asset('/assets/img/testimonials/img2.jpg') }}" alt=""/>
            </a>

            <div class="media-body">
                <h4 class="media-heading">Media heading <span>5 hours ago / <a href="#">Reply</a></span></h4>

                <p>Donec id erum quidem rerumd facilis est et expedita distinctio lorem ipsum dolorlit non mi portas sats eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna..</p>

                <hr>

                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="{{ asset('/assets/img/testimonials/img5.jpg') }}" alt=""/>
                    </a>

                    <div class="media-body">
                        <h4 class="media-heading">Media heading <span>17 hours ago / <a href="#">Reply</a></span></h4>

                        <p>Donec id erum quidem rerumd facilis est et expedita distinctio lorem ipsum dolorlit non mi portas sats eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna..</p>
                    </div>
                </div>

                <hr>

                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="{{ asset('/assets/img/testimonials/img1.jpg') }}" alt=""/>
                    </a>

                    <div class="media-body">
                        <h4 class="media-heading">Media heading <span>2 days ago / <a href="#">Reply</a></span></h4>

                        <p>Donec id erum quidem rerumd facilis est et expedita distinctio lorem ipsum dolorlit non mi portas sats eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna..</p>
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

                <p>Donec id erum quidem rerumd facilis est et expedita distinctio lorem ipsum dolorlit non mi portas sats eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna..</p>
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
@stop