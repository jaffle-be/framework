@extends('layouts.front')

@section('content')

    <div class="container-fluid">

        <div class="row">

            <div class="signup-box">

                <h2>{{ Lang::get('users::general.forgot-password') }}</h2>

                <form action="{{ route('forgot-password.store') }}" method="post">

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

                    <p>
                        <input class="btn btn-lg btn-primary pull-left" type="submit" value="{{ Lang::get('users::general.submit') }}"/>

                        <a class="pull-right btn btn-lg btn-default" href="{{ route('signin.index') }}">{{ Lang::get('users::general.back') }}</a>
                    </p>

                </form>

            </div>

        </div>

    </div>

@stop