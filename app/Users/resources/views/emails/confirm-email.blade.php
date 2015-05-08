@extends('layouts.email')

@section('content')

    <p>
        {{ Lang::get('users::emails.confirm-email.intro') }}
    </p>

    <p class="alert alert-success">
        {!! Lang::get('users::emails.confirm-email.link', ['url' => route('confirm-email.show', [$token->value]) ]) !!}
    </p>

    <p>
        {{ Lang::get('users::emails.confirm-email.outro') }}
    </p>

@stop