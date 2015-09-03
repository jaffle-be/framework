@extends(Theme::email())

@section('content')

    <div class="container">

        <div class="content-sm text-center">

            <p class="margin-bottom-40">{{ Lang::get('account::admin.users.invitation-text') }}</p>

            <a class="btn btn-u btn-lg" href="{{ route('store.auth.invitation.show', $invitation->token) }}">{{ Lang::get('account::admin.users.accept') }}</a>

        </div>

    </div>

@stop