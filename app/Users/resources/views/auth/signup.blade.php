@extends('layouts.front')

@section('content')

    <div class="container-fluid">

        <div class="row">

            <div class="signup-box">
                <h2>{{ Lang::get('users::general.register') }}</h2>


                    <form action="{{ route('signup.store') }}" method="post">

                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>


                        <div class="form-group">
                            <label for="email" class="control-label">{{ Lang::get('users::general.email') }}</label>

                            <div>
                                <input type="text" name="email" id="email" class="form-control" value="{{ Input::old('email') }}"/>
                            </div>
                        </div>

                        @if($errors->has('email'))
                            <p class="alert alert-danger">
                                {{ $errors->first('email') }}
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
                                {{ $errors->first('password') }}
                            </p>
                        @endif

                        <div class="form-group">
                            <label for="password_confirmation" class="control-label">{{ Lang::get('users::general.password_confirmation') }}</label>

                            <div>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value=""/>
                            </div>
                        </div>

                        @if($errors->has('password_confirmation'))
                            <p class="alert alert-danger">
                                {{ $errors->first('password_confirmation') }}
                            </p>
                        @endif

                        <p class="text-center">

                            <input class="btn btn-block btn-lg btn-primary" type="submit" value="{{ Lang::get('users::general.register') }}"/>

                            <a class="btn btn-block btn-lg btn-default" href="{{ route('signin.index') }}">{{ Lang::get('users::general.back') }}</a>

                        </p>

                    </form>


            </div>

        </div>

    </div>

@stop