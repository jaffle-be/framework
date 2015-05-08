@extends('layouts.front')

@section('content')

    <div class="container-fluid">

    <div class="row">

        <div class="signup-box">

            <h2>{{ Lang::get('auth.reset-password') }}</h2>

            <form action="{{ route('reset-password.store', [$token]) }}">

            <div class="form-group">
            	<label for="email" class="control-label">{{ Lang::get('users:general.email') }}</label>
            	<div>
            		<input type="text" name="email" id="email" class="form-control" value="{{ Input::old('email') }}"/>
            	</div>
            </div>


            <div class="form-group">
            	<label for="password" class="control-label">{{ Lang::get('users::general.password') }}</label>
            	<div>
            		<input type="password" name="password" id="password" class="form-control"/>
            	</div>
            </div>

            <div class="form-group">
            	<label for="password_confirmation" class="control-label">{{ Lang::get('users::general.password-confirmation') }}</label>
            	<div>
            		<input type="password" name="password_confirmation" id="password_confirmation" class="form-control"/>
            	</div>
            </div>

            @if($errors->count())
                <p class="alert alert-danger">
                    {!! $errors->first() !!}
                </p>
            @endif

            <p>
                <input class="btn btn-primary btn-lg pull-left" type="submit" value="{{ Lang::get('users::general.submit') }}"/>

                <a class="pull-right btn-lg btn btn-default" href="{{ route('signin.index') }}">{{ Lang::get('users::general.back') }}</a>
            </p>


            </form>

        </div>

    </div>

    </div>

@stop