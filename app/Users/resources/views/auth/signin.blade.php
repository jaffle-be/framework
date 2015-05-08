@extends('layouts.front')

@section('content')

    <div class="container-fluid">

        <div class="row">

            <div class="signup-box">

                <h2>{{ Lang::get('users::general.signin') }}</h2>

                <form action="{{ route('signin.store') }}" method="POST">

                    <input value="{{csrf_token()}}" name="_token" type="hidden"/>

                    <div class="form-group">
                        <label for="email" class="control-label">{{ Lang::get('users::general.email') }}</label>

                        <div>
                            <input type="text" name="email" id="email" class="form-control" value="{{ Input::old('email') }}"/>
                        </div>
                    </div>

                    @if($errors->has('email'))
                        <p class="alert alert-danger">
                            {!! $errors->first('email') !!}
                        </p>
                    @endif

                    <div class="form-group">
                        <label for="password" class="control-label">{{ Lang::get('users::general.password') }}</label>

                        <div>
                            <input type="password" name="password" id="password" class="form-control" value=""/>
                        </div>
                    </div>

                    @if($errors->has('password'))
                        <p class="alert alert-danger">
                            {!! $errors->first('password') !!}
                        </p>
                    @endif

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember_me" value="1" {{Input::old('remember_me') ? 'checked': ''}}>
                            {{ Lang::get('users::general.remember-me') }}
                        </label>
                    </div>

                    <p class="text-right">
                        <a href="{{ route('forgot-password.index') }}">{{ Lang::get('users::general.forgot-password') }}</a>
                    </p>

                    @if($errors->has('reason'))
                        <p class="alert alert-danger">
                            {!! $errors->first('reason') !!}
                        </p>
                    @endif

                    <p class="text-center">

                        <input class="btn-lg btn-block btn btn-primary" type="submit" value="{{ Lang::get('users::general.signin') }}"/>

                        <a class="btn-lg btn-block btn btn-default" href="{{ route('signup.index') }}">{{ Lang::get('users::general.register') }}</a>

                    </p>

                </form>

            </div>

        </div>

    </div>

@stop