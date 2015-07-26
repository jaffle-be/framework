@extends('layouts.email')

@section('content')

    <p>
        {{ Lang::get('users::emails.reset-password.intro', [':user' => $user->email]) }}
    </p>

    <p class="alert alert-success">
        {!! Lang::get('users::emails.reset-password.link', ['url' => route('store.auth.reset-password.show', [$token->value]) ]) !!}
    </p>

    <p>
        {{ Lang::get('users::emails.reset-password.outro') }}
    </p>

@stop