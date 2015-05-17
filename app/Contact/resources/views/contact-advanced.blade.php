@extends('layouts.front')
<?php

// Make the page validate
ini_set('session.use_trans_sid', '0');

// Create a random string, leaving out 'o' to avoid confusion with '0'
$char = strtoupper(substr(str_shuffle('abcdefghjkmnpqrstuvwxyz'), 0, 4));

// Concatenate the random string onto the random numbers
// The font 'Anorexia' doesn't have a character for '8', so the numbers will only go up to 7
// '0' is left out to avoid confusion with 'O'
$str = rand(1, 7) . rand(1, 7) . $char;

// Begin the session
session_start();

// Set the session contents
$_SESSION['captcha_id'] = $str;

?>
@section('styles-plugins')
    @parent

    <link rel="stylesheet" href="{{ asset('/assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') }}">
    <!--[if lt IE 9]><link rel="stylesheet" href="{{ asset('/assets/plugins/sky-forms-pro/skyforms/css/sky-forms-ie8.css') }}"><![endif]-->
@stop

@section('styles-content')
    <link rel="stylesheet" href="{{ asset('/assets/css/pages/page_contact.css') }}">
    @stop
<body>

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
        <div class="row margin-bottom-30">
            <div class="col-md-9 mb-margin-bottom-30">
                <div class="headline"><h2>Contact Form</h2></div>
                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas feugiat. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, consectetur adipiscing elit landitiis.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas feugiat.</p><br>
                <form action="{{ asset('/assets/php/sky-forms-pro/demo-contacts-process.php') }}" method="post" id="sky-form3" class="sky-form sky-changes-3">
                    <fieldset>
                        <div class="row">
                            <section class="col col-6">
                                <label class="label">Name</label>
                                <label class="input">
                                    <i class="icon-append fa fa-user"></i>
                                    <input type="text" name="name" id="name">
                                </label>
                            </section>
                            <section class="col col-6">
                                <label class="label">E-mail</label>
                                <label class="input">
                                    <i class="icon-append fa fa-envelope-o"></i>
                                    <input type="email" name="email" id="email">
                                </label>
                            </section>
                        </div>

                        <section>
                            <label class="label">Subject</label>
                            <label class="input">
                                <i class="icon-append fa fa-tag"></i>
                                <input type="text" name="subject" id="subject">
                            </label>
                        </section>

                        <section>
                            <label class="label">Message</label>
                            <label class="textarea">
                                <i class="icon-append fa fa-comment"></i>
                                <textarea rows="4" name="message" id="message"></textarea>
                            </label>
                        </section>

                        <section>
                            <label class="label">Enter characters below:</label>
                            <label class="input input-captcha">
                                <img src="{{ asset('/assets/plugins/sky-forms-pro/skyforms/captcha/image.php?' . time()) }}" width="100" height="32" alt="Captcha image" />
                                <input type="text" maxlength="6" name="captcha" id="captcha">
                            </label>
                        </section>

                        <section>
                            <label class="checkbox"><input type="checkbox" name="copy"><i></i>Send a copy to my e-mail address</label>
                        </section>
                    </fieldset>

                    <footer>
                        <button type="submit" class="btn-u">Send message</button>
                    </footer>

                    <div class="message">
                        <i class="rounded-x fa fa-check"></i>
                        <p>Your message was successfully sent!</p>
                    </div>
                </form>
            </div><!--/col-md-9-->

            <div class="col-md-3">
                <!-- Contacts -->
                <div class="headline"><h2>Contacts</h2></div>
                <ul class="list-unstyled who margin-bottom-30">
                    <li><a href="#"><i class="fa fa-home"></i>5B Streat, City 50987 New Town US</a></li>
                    <li><a href="#"><i class="fa fa-envelope"></i>info@example.com</a></li>
                    <li><a href="#"><i class="fa fa-phone"></i>1(222) 5x86 x97x</a></li>
                    <li><a href="#"><i class="fa fa-globe"></i>http://www.example.com</a></li>
                </ul>

                <!-- Business Hours -->
                <div class="headline"><h2>Business Hours</h2></div>
                <ul class="list-unstyled margin-bottom-30">
                    <li><strong>Monday-Friday:</strong> 10am to 8pm</li>
                    <li><strong>Saturday:</strong> 11am to 3pm</li>
                    <li><strong>Sunday:</strong> Closed</li>
                </ul>

                <!-- Why we are? -->
                <div class="headline"><h2>Why we are?</h2></div>
                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum.</p>
                <ul class="list-unstyled">
                    <li><i class="fa fa-check color-green"></i> Odio dignissimos ducimus</li>
                    <li><i class="fa fa-check color-green"></i> Blanditiis praesentium volup</li>
                    <li><i class="fa fa-check color-green"></i> Eos et accusamus</li>
                </ul>
            </div><!--/col-md-3-->
        </div><!--/row-->
    </div>

    <div id="map" class="map">
    </div>
    @stop


@section('scripts-plugins')
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="{{ asset('/assets/plugins/gmap/gmap.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets/plugins/sky-forms-pro/skyforms/js/jquery.validate.min.js') }}"></script>
@stop

@section('scripts-app')
<script type="text/javascript" src="{{ asset('/assets/js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets/js/pages/page_contacts.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets/js/pages/page_contact_advanced.js') }}"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        App.init();
        ContactPage.initMap();
        PageContactForm.initPageContactForm();
 });
</script>

@stop