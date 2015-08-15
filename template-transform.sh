# dont forget to remove new lines in the pattern when searching
# 
# you also might need to change the breadcrumbs and footer versioning

([\s\S]*)
<link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css">
([\s\S]*)
<!-- CSS Customization -->
([\s\S]*)
<!--=== Breadcrumbs v3 ===-->
([\s\S]*)
<!--=== End Breadcrumbs v3 ===-->
([\s\S]*)
<!--=== Footer Version 1 ===-->
([\s\S]*)
<!-- JS Implementing Plugins -->
([\s\S]*)
<!-- JS Page Level -->
([\s\S]*)
<\/body>
([\s\S]*)



@extends('Unify::unify')

@section('styles-content')
    $2
@stop

@section('breadcrumb')
    $4
@stop

@section('content')
    $5
@stop


@section('scripts-plugins')
    @parent
    $7
@stop

@section('scripts-app')
    $8
@stop