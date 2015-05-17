@extends('layouts.front')
<!-- CSS Page Style -->

@section('styles-content')
    <link rel="stylesheet" href="{{ '/assets/css/pages/page_log_reg_v1.css' }}">
@stop

@section('breadcrumb')
    <!--=== Breadcrumbs ===-->
    <div class="breadcrumbs">
        <div class="container">
            <h1 class="pull-left">Login</h1>
            <ul class="pull-right breadcrumb">
                <li><a href="index.html">Home</a></li>
                <li><a href="">Pages</a></li>
                <li class="active">Login</li>
            </ul>
        </div>
        <!--/container-->
    </div><!--/breadcrumbs-->
    <!--=== End Breadcrumbs ===-->
@stop

@section('content')
    <!--=== Content Part ===-->
    <div class="container content">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                <form class="reg-page" action="{{ route('signin.store') }}" method="POST">

                    <input value="{{csrf_token()}}" name="_token" type="hidden"/>

                    <div class="reg-header">
                        <h2>{{ Lang::get('users::general.signin') }}</h2>
                    </div>

                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input name="email" id="email" type="text" placeholder="{{ Lang::get('users::general.email') }}" value="{{ Input::old('email') }}" class="form-control">
                    </div>

                    @if($errors->has('email'))
                        <p class="alert alert-danger">
                            {!! $errors->first('email') !!}
                        </p>
                    @endif

                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input name="password" id="password" type="password" placeholder="{{ Lang::get('users::general.password') }}" class="form-control">
                    </div>

                    @if($errors->has('password'))
                        <p class="alert alert-danger">
                            {!! $errors->first('password') !!}
                        </p>
                    @endif

                    <div class="row">
                        <div class="col-md-6 checkbox">
                            <label><input type="checkbox" name="remember_me" value="1" {{Input::old('remember_me') ? 'checked': ''}}>{{ Lang::get('users::general.remember-me') }}
                            </label>
                        </div>
                        <div class="col-md-6">
                            <button class="btn-u pull-right" type="submit">{{ Lang::get('users::general.signin') }}</button>
                        </div>
                    </div>

                    @if($errors->has('reason'))
                        <p class="alert alert-danger">
                            {!! $errors->first('reason') !!}
                        </p>
                    @endif

                    @if(Session::has('success'))
                        <p class="alert alert-success">{{ Session::get('success') }}</p>
                    @endif

                    <hr>

                    <h4>{{ Lang::get('users::general.forgot-password') }}</h4>

                    <p>
                        {!! Lang::get('users::general.forgot-password-text', ['url' => route('forgot-password.index')]) !!}
                    </p>
                </form>
            </div>
        </div>
        <!--/row-->
    </div><!--/container-->
    <!--=== End Content Part ===-->
@stop