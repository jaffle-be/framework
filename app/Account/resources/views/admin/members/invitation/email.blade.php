@extends('theme::email')

@section('content')

    <div class="container">

        {{ Lang::get('account::users.invite') }}

        <a class="btn btn-primary btn-lg" href="{{ route('store.auth.invitation.show', $invitation->token) }}">{{ Lang::get('account::users.accept') }}</a>

    </div>

@stop