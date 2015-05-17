@extends('layouts.front')

@section('breadcrumb')
    <div class="breadcrumbs-v1">
        <div class="container">
            <span>Blog Page</span>

            <h1>Basic Medium Posts</h1>
        </div>
    </div>
@stop

@section('content')

    @include('blog::elements.news-3')

@stop