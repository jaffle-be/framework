@extends(Theme::email())

@section('content')

    <table width="700" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
        <tr>
            <td width="100%" bgcolor="#ffffff" style="text-align: center; padding: 10px 5px;"><h2>Someone wants to contact us.</h2></td>
        </tr>

        <tr>
            <td width="100%" bgcolor="#ffffff" style="padding: 20px;">
                <strong>name: </strong>{{ $name }},<br>
                <strong>email: </strong>{{$email}}<br><br>

                He/she wrote the following: <br><br>

                {{ $contact_message }}
            </td>
        </tr>

    </table>
    <!--End Two Blocks -->

@stop