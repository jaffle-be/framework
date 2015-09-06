@extends(Theme::email())

@section('content')

    <table width="700" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
        <tr>
            <td width="100%" bgcolor="#ffffff" style="text-align: center; padding: 10px 5px;"><h2>{{ Lang::get('contact::front.email.intro') }}</h2></td>
        </tr>

        <tr>
            <td width="100%" bgcolor="#ffffff" style="padding: 20px;">
                <strong>{{ ucfirst(Lang::get('contact::front.email.name')) }}:</strong>&nbsp;{{ $name }},<br>
                <strong>{{ ucfirst(Lang::get('contact::front.email.email')) }}:</strong>&nbsp;{{ $email }}<br><br>

                <p>
                    <strong>{{ ucfirst(Lang::get('contact::front.email.subject')) }}:</strong>&nbsp;{{ $subject }}
                </p>

                <p>
                    <strong>{{ ucfirst(Lang::get('contact::front.email.message')) }}</strong>:&nbsp;
                    {{ $contact_message }}
                </p>

            </td>
        </tr>

    </table>
    <!--End Two Blocks -->

@stop