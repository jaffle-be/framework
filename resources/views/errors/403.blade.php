@extends('layouts.clean')

@section('styles-content')
    <link rel="stylesheet" href="{{ asset('themes/Unify/assets/css/pages/page_404_error.css') }}">
@stop

@section('content')
    <div class="container content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="error-v1">
                    <span class="error-v1-title">403</span>
                    <span>That’s an error!</span>

                    <p>The requested URL was not found on this server. That’s all we know.</p>
                    <a class="btn-u btn-bordered" href="index.html">Back Home</a>
                </div>
            </div>
        </div>
    </div>
@stop