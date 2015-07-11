<? throw new Exception('this footer needs implementation for javascript and the form etc') ?>

@section('styles-footer')
    <link rel="stylesheet" href="{{ asset('assets/css/footers/footer-v7.css') }}">
@stop
@section('footer')

    <!--=== Footer v7 ===-->
    <section id="footer-v7" class="contacts-section">
        <div class="container content-lg">
            <div class="row contacts-in">
                <div class="col-md-6 md-margin-bottom-40">
                    <ul class="list-unstyled">
                        <li><i class="fa fa-home"></i> 5B Streat, City 50987 New Town US</li>
                        <li><i class="fa fa-phone"></i> 1(800) 220 084</li>
                        <li><i class="fa fa-envelope"></i> <a href="info@example.com">info@example.com</a></li>
                        <li><i class="fa fa-globe"></i> <a href="http://htmlstream.com">www.htmlstream.com</a></li>
                    </ul>
                </div>

                <div class="col-md-6">
                    <form action="assets/php/sky-forms-pro/demo-contacts-process.php" method="post" id="sky-form3" class="sky-form contact-style">
                        <fieldset>
                            <label>Name</label>

                            <div class="row">
                                <div class="col-md-7 margin-bottom-20 col-md-offset-0">
                                    <div>
                                        <input type="text" name="name" id="name" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <label>Email <span class="color-red">*</span></label>

                            <div class="row">
                                <div class="col-md-7 margin-bottom-20 col-md-offset-0">
                                    <div>
                                        <input type="text" name="email" id="email" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <label>Message</label>

                            <div class="row">
                                <div class="col-md-11 margin-bottom-20 col-md-offset-0">
                                    <div>
                                        <textarea rows="8" name="message" id="message" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>

                            <p>
                                <button type="submit" class="btn-u btn-brd btn-brd-hover btn-u-dark">Send Message</button>
                            </p>
                        </fieldset>

                        <div class="message">
                            <i class="rounded-x fa fa-check"></i>

                            <p>Your message was successfully sent!</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="copyright-section">
            <p>2015 &copy; All Rights Reserved. Unify Theme by
                <a target="_blank" href="https://twitter.com/htmlstream">Htmlstream</a></p>
            <ul class="social-icons">
                <li><a href="#" data-original-title="Facebook" class="social_facebook rounded-x"></a></li>
                <li><a href="#" data-original-title="Twitter" class="social_twitter rounded-x"></a></li>
                <li><a href="#" data-original-title="Goole Plus" class="social_googleplus rounded-x"></a></li>
                <li><a href="#" data-original-title="Pinterest" class="social_pintrest rounded-x"></a></li>
                <li><a href="#" data-original-title="Linkedin" class="social_linkedin rounded-x"></a></li>
            </ul>
            <a href="#top"><i class="fa fa-angle-double-up back-to-top"></i></a>
        </div>
    </section>
    <!--=== End Footer v7 ===-->
@stop

@section('scripts-footer')
    <!-- JS Implementing Plugins -->
    {{--@todo: this part needs cleanup, this is not properly done--}}

    <script type="text/javascript" src="{{ asset('assets/plugins/back-to-top.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/smoothScroll.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/sky-forms-pro/skyforms/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/forms/login.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            App.init();
            LoginForm.initLoginForm();
            ContactForm.initContactForm();
        });
    </script>
@stop

{{--@todo: these sections don't exist yet--}}
@section('scripts-ie-lt-9')
    <script src="assets/plugins/respond.js"></script>
    <script src="assets/plugins/html5shiv.js"></script>
    <script src="assets/plugins/placeholder-IE-fixes.js"></script>
    <script src="assets/plugins/sky-forms-pro/skyforms/js/sky-forms-ie8.js"></script>
@stop

@section('scripts-ie-lt-10')
    <script src="assets/plugins/sky-forms-pro/skyforms/js/jquery.placeholder.min.js"></script>
@stop