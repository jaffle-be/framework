@extends(Theme::email())

@section('content')

    <table width="700" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
        <tr>
            <td width="100%" bgcolor="#ffffff" style="text-align: center; padding: 10px 5px;"><h2>{{ Lang::get('contact::front.email.intro') }}</h2></td>
        </tr>

        <tr>
            <td width="100%" bgcolor="#ffffff" style="padding: 20px;">
                <strong>{{ Lang::get('contact::front.email.name') }}</strong>{{ $name }},<br>
                <strong>{{ Lang::get('contact::front.email.email') }}</strong>{{$email}}<br><br>

                <h4>{{ Lang::get('contact::front.email.subject') }}{{ $subject }}</h4>

                <br>

                <label style="display:block;">{{ Lang::get('contact::front.email.message') }}</label>
                <p>
                    {{ $contact_message }}
                </p>

            </td>
        </tr>

    </table>
    <!--End Two Blocks -->

@stop