@extends('theme::email')

@section('content')

    <div class="container">

        {{ Lang::get('account::user.invite') }}

        <a class="btn btn-primary btn-lg" href="{{ route('store.auth.invitation.show', $invitation->token) }}">Accept me</a>

    </div>

@stop