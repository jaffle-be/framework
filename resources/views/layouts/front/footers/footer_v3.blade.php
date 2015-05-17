@section('styles-footer')
    <link rel="stylesheet" href="{{ asset('assets/css/footers/footer-v3.css') }}">
@section('styles-header')

@section('scripts-footer')
    <!-- JS Implementing Plugins -->
    <script type="text/javascript" src="{{ asset('assets/plugins/back-to-top.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/smoothScroll.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/jquery.parallax.js') }}"></script>
@stop

@section('footer')
    <!--=== Footer v3 ===-->
    <div id="footer-v3" class="footer-v3">
        <div class="footer">
            <div class="container">
                <div class="row">
                    <!-- About -->
                    <div class="col-sm-3 md-margin-bottom-40">
                        <a href="index.html"><img id="logo-footer" class="footer-logo" src="{{ asset('/assets/img/logo2-default.png') }}" alt=""></a>

                        <p>About Unify dolor sit amet, consectetur adipiscing elit. Maecenas eget nisl id libero tincidunt sodales.</p>

                        <p>Duis eleifend fermentum ante ut aliquam. Cras mi risus, dignissim sed adipiscing ut, placerat non arcu.</p>
                    </div>
                    <!--/col-md-3-->
                    <!-- End About -->

                    <!-- Simple List -->
                    <div class="col-sm-3 md-margin-bottom-40">
                        <div class="thumb-headline"><h2>About Unify</h2></div>
                        <ul class="list-unstyled simple-list margin-bottom-20">
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Forum</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Community</a></li>
                            <li><a href="#">Stories</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ul>

                        <div class="thumb-headline"><h2>Help &amp; Information Center</h2></div>
                        <ul class="list-unstyled simple-list">
                            <li><a href="#">Help</a></li>
                            <li><a href="#">Customer Service</a></li>
                            <li><a href="#">New on Unify</a></li>
                            <li><a href="#">Tour the New Journey</a></li>
                            <li><a href="#">Registration Requirements</a></li>
                        </ul>
                    </div>
                    <!--/col-md-3-->

                    <div class="col-sm-3">
                        <div class="thumb-headline"><h2>Topics</h2></div>
                        <ul class="list-unstyled simple-list margin-bottom-20">
                            <li><a href="#">Bootstrap</a></li>
                            <li><a href="#">Font Awesome</a></li>
                            <li><a href="#">WordPress</a></li>
                            <li><a href="#">Favicon</a></li>
                            <li><a href="#">Javascript</a></li>
                            <li><a href="#">iOS</a></li>
                        </ul>

                        <div class="thumb-headline"><h2>Tools &amp; Formats</h2></div>
                        <ul class="list-unstyled simple-list">
                            <li><a href="#">Today's Paper</a></li>
                            <li><a href="#">Journal Community</a></li>
                            <li><a href="#">Video Canter</a></li>
                        </ul>

                        <div class="thumb-headline"><h2>Archives</h2></div>
                        <ul class="list-unstyled simple-list">
                            <li><a href="#">February 2014</a></li>
                            <li><a href="#">August 2013</a></li>
                            <li><a href="#">December 2013r</a></li>
                        </ul>
                    </div>
                    <!--/col-md-3-->

                    <div class="col-sm-3">
                        <div class="thumb-headline"><h2>Developers</h2></div>
                        <ul class="list-unstyled simple-list margin-bottom-20">
                            <li><a href="#">Web Development</a></li>
                            <li><a href="#">Web Design</a></li>
                            <li><a href="#">Android Development</a></li>
                            <li><a href="#">PHP Development</a></li>
                            <li><a href="#">Programmer</a></li>
                            <li><a href="#">Start-up</a></li>
                        </ul>

                        <div class="thumb-headline"><h2>Digital Network</h2></div>
                        <ul class="list-unstyled simple-list">
                            <li><a href="#">Wrapbootstrap.com</a></li>
                            <li><a href="#">Bootstrap.com</a></li>
                            <li><a href="#">Fortawesome.com</a></li>
                            <li><a href="#">Jquery.com</a></li>
                            <li><a href="#">Wordpress.com</a></li>
                            <li><a href="#">Unslpash.com</a></li>
                            <li><a href="#">Github.com</a></li>
                        </ul>
                    </div>
                    <!--/col-md-3-->
                    <!-- End Simple List -->
                </div>
            </div>
        </div>
        <!--/footer-->

        <div class="copyright">
            <div class="container">
                <div class="row">
                    <!-- Terms Info-->
                    <div class="col-md-6">
                        <p>
                            2015 &copy; All Rights Reserved. Unify Theme by
                            <a target="_blank" href="https://twitter.com/htmlstream">Htmlstream</a> |
                            <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
                        </p>
                    </div>
                    <!-- End Terms Info-->

                    <!-- Social Links -->
                    <div class="col-md-6">
                        <ul class="social-icons pull-right">
                            <li><a href="#" data-original-title="Facebook" class="rounded-x social_facebook"></a></li>
                            <li><a href="#" data-original-title="Twitter" class="rounded-x social_twitter"></a></li>
                            <li><a href="#" data-original-title="Goole Plus" class="rounded-x social_googleplus"></a>
                            </li>
                            <li><a href="#" data-original-title="Linkedin" class="rounded-x social_linkedin"></a></li>
                            <li><a href="#" data-original-title="Pinterest" class="rounded-x social_pintrest"></a></li>
                        </ul>
                    </div>
                    <!-- End Social Links -->
                </div>
            </div>
        </div>
        <!--/copyright-->
    </div>
    <!--=== End Footer v3 ===-->
@stop

