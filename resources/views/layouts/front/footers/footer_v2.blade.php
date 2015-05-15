@section('styles-footer')
    <link rel="stylesheet" href="{{ asset('assets/css/footers/footer-v2.css') }}">
@stop

@section('scripts-footer')

    <script type="text/javascript" src="{{ asset('assets/plugins/back-to-top.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/smoothScroll.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/jquery.parallax.js') }}"></script>
@stop

@section('footer')
    <!--=== Footer v2 ===-->
    <div id="footer-v2" class="footer-v2">
        <div class="footer">
            <div class="container">
                <div class="row">
                    <!-- About -->
                    <div class="col-md-3 md-margin-bottom-40">
                        <a href="index.html"><img id="logo-footer" class="footer-logo" src="{{ asset('/assets/img/logo1-default.png') }}" alt=""></a>

                        <p class="margin-bottom-20">Unify is an incredibly beautiful responsive Bootstrap Template for corporate and creative professionals.</p>

                        <form class="footer-subsribe">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Email Address">                            
                                <span class="input-group-btn">
                                    <button class="btn-u" type="button">Go</button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <!-- End About -->

                    <!-- Link List -->
                    <div class="col-md-3 md-margin-bottom-40">
                        <div class="headline"><h2 class="heading-sm">Useful Links</h2></div>
                        <ul class="list-unstyled link-list">
                            <li><a href="#">About us</a><i class="fa fa-angle-right"></i></li>
                            <li><a href="#">Portfolio</a><i class="fa fa-angle-right"></i></li>
                            <li><a href="#">Latest jobs</a><i class="fa fa-angle-right"></i></li>
                            <li><a href="#">Community</a><i class="fa fa-angle-right"></i></li>
                            <li><a href="#">Contact us</a><i class="fa fa-angle-right"></i></li>
                        </ul>
                    </div>
                    <!-- End Link List -->

                    <!-- Latest Tweets -->
                    <div class="col-md-3 md-margin-bottom-40">
                        <div class="latest-tweets">
                            <div class="headline"><h2 class="heading-sm">Latest Tweets</h2></div>
                            <div class="latest-tweets-inner">
                                <i class="fa fa-twitter"></i>

                                <p>
                                    <a href="#">@htmlstream</a>
                                    At vero seos etodela ccusamus et
                                    <a href="#">http://t.co/sBav7dm</a>
                                    <small class="twitter-time">2 hours ago</small>
                                </p>
                            </div>
                            <div class="latest-tweets-inner">
                                <i class="fa fa-twitter"></i>

                                <p>
                                    <a href="#">@htmlstream</a>
                                    At vero seos etodela ccusamus et
                                    <a href="#">http://t.co/sBav7dm</a>
                                    <small class="twitter-time">4 hours ago</small>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- End Latest Tweets -->

                    <!-- Address -->
                    <div class="col-md-3 md-margin-bottom-40">
                        <div class="headline"><h2 class="heading-sm">Contact Us</h2></div>
                        <address class="md-margin-bottom-40">
                            <i class="fa fa-home"></i>25, Lorem Lis Street, California, US <br/>
                            <i class="fa fa-phone"></i>Phone: 800 123 3456 <br/>
                            <i class="fa fa-globe"></i>Website: <a href="#">www.htmlstream.com</a> <br/>
                            <i class="fa fa-envelope"></i>Email: <a href="mailto:info@anybiz.com">info@anybiz.com</a>
                        </address>

                        <!-- Social Links -->
                        <ul class="social-icons">
                            <li><a href="#" data-original-title="Facebook" class="rounded-x social_facebook"></a></li>
                            <li><a href="#" data-original-title="Twitter" class="rounded-x social_twitter"></a></li>
                            <li><a href="#" data-original-title="Goole Plus" class="rounded-x social_googleplus"></a>
                            </li>
                            <li><a href="#" data-original-title="Linkedin" class="rounded-x social_linkedin"></a></li>
                        </ul>
                        <!-- End Social Links -->
                    </div>
                    <!-- End Address -->
                </div>
            </div>
        </div>
        <!--/footer-->

        <div class="copyright">
            <div class="container">
                <p class="text-center">2015 &copy; All Rights Reserved. Unify Theme by
                    <a target="_blank" href="https://twitter.com/htmlstream">Htmlstream</a></p>
            </div>
        </div>
        <!--/copyright-->
    </div>
    <!--=== End Footer v2 ===-->

@stop