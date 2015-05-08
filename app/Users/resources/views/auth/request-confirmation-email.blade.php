@extends('layouts.front')

@section('content')

    <div class="container-fluid">

        <div class="row">

            <div class="signup-box">

                <h2>{{ Lang::get('auth.request-confirmation-email') }}</h2>

                <form action="{{ route('confirm-email.store') }}" method="POST">

                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

                    <div class="form-group">
                        <label for="email" class="control-label">{{ Lang::get('users::general.email') }}</label>

                        <div>
                            <input type="text" name="email" id="email" class="form-control" value="{{ $email ? $email : Input::old('email') }}"/>
                        </div>
                    </div>

                    @if($errors->has('email'))
                        <p class="alert alert-danger">
                            {!! $errors->first('email') !!}
                        </p>
                    @endif

                    <p>
                        <input class="pull-left btn btn-primary" type="submit" value="{{ Lang::get('users::general.submit') }}"/>

                        <a class="pull-right btn btn-lg btn-default" href="{{ route('signin.index') }}">{{ Lang::get('users::general.back') }}</a>
                    </p>

                </form>

            </div>

        </div>

    </div>

@stop