@extends(Theme::email())

@section('content')

    <div style="height:15px">&nbsp;</div><!-- divider -->

    <!--Start Discount -->
    <table width="700" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
        <tr>
            <td width="100%" bgcolor="#ffffff">
                <!-- Left Box  -->
                <table width="70%" border="0" cellpadding="0" cellspacing="0" align="left" class="deviceWidth">
                    <tr>
                        <td class="center">
                            <table border="0" cellpadding="0" cellspacing="0" align="center">
                                <tr>
                                    <td class="center" style="font-size: 16px; color: #687074; font-weight: bold; text-align: center; font-family: Arial, Helvetica, sans-serif; line-height: 25px; vertical-align: middle; padding: 20px 10px 10px;">
                                        {{ Lang::get('users::emails.confirm-email.intro') }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <!--End Left Box-->
                <!--Right Box-->
                <table width="30%" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                    <tr>
                        <td style=" padding: 15px 20px 30px;">
                            <table align="center">
                                <tr>
                                    <td valign="top" style="padding: 7px 15px; text-align: center; background-color: #74C52C;" class="center">
                                        <a style="color: #fff; font-size: 12px; font-weight: bold; text-decoration: none; font-family: Arial, sans-serif; text-alight: center;" href="{{ route('store.auth.confirm-email.show', [$token->value]) }}">{{ Lang::get('users::emails.confirm-email.link') }}</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <!--End Right Box-->
            </td>
        </tr>
    </table>
    <!--End Discount -->

    <div style="height:15px">&nbsp;</div><!-- divider -->

@stop