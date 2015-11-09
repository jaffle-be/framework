<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Modular Template Patterns</title>

    <!--
        This email is an experimental proof-of-concept based on the
        idea that the most common design patterns seen in email can
        be placed in modular blocks and moved around to create
        different designs.

        The same principle is used to build the email templates in
        MailChimp's Drag-and-Drop email editor.

        This email is optimized for mobile email clients, and even
        works relatively well in the Android Gmail App, which does
        not support Media Queries, but does have limited mobile-
        friendly functionality.

        While this coding method is very flexible, it can be more
        brittle than traditionally-coded emails, particularly in
        Microsoft Outlook 2007-2010. Outlook-specific conditional
        CSS is included to counteract the inconsistencies that
        crop up.

        For more information on HTML email design and development,
        visit http://templates.mailchimp.com
    -->


    <!--
        Outlook Conditional CSS

        These two style blocks target Outlook 2007 & 2010 specifically, forcing
        columns into a single vertical stack as on mobile clients. This is
        primarily done to avoid the 'page break bug' and is optional.

        More information here:
        http://templates.mailchimp.com/development/css/outlook-conditional-css
    -->
    <!--[if mso 12]>
    <style type="text/css">
        .flexibleContainer{display:block !important; width:100% !important;}
    </style>
    <![endif]-->
    <!--[if mso 14]>
    <style type="text/css">
        .flexibleContainer{display:block !important; width:100% !important;}
    </style>
    <![endif]-->

    @include('Unify::newsletter.styles')
</head>
<body>
<center>
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
        <tr>
            <td align="center" valign="top" id="bodyCell">
                <!-- EMAIL CONTAINER // -->
                <!--
                    The table "emailBody" is the email's container.
                    Its width can be set to 100% for a color band
                    that spans the width of the page.
                -->
                <table border="0" cellpadding="0" cellspacing="0" width="600" id="emailBody">

                    <?

                    $data = [
                        'img' => 'http://placekitten.com/g/1120/800',
                        'title' => 'Title',
                        'text' => 'A kitten or kitty is a juvenile domesticated cat. A feline litter usually consists of two to five kittens. To survive, kittens need the care of their mother for the first several weeks of their life. Kittens are highly social animals and spend most of their waking hours playing and interacting with available companions.',
                    ];

                    $data = array_merge($data, ['left' => $data], ['right' => $data]);

                    ?>


                    @include('Unify::newsletter.text-only.full', $data)
                    @include('Unify::newsletter.text-only.2col', $data)
                    @include('Unify::newsletter.text-only.full-bg', $data)
                    @include('Unify::newsletter.text-only.2col-bg', $data)

                    @include('Unify::newsletter.img-only.full', $data)
                    @include('Unify::newsletter.img-only.2col', $data)

                    @include('Unify::newsletter.regular.full', $data)
                    @include('Unify::newsletter.regular.2col', $data)
                    @include('Unify::newsletter.regular.img-left', $data)
                    @include('Unify::newsletter.regular.img-right', $data)

                    @include('Unify::newsletter.complex.full', $data)
                    @include('Unify::newsletter.complex.2col', $data)
                    @include('Unify::newsletter.complex.img-left', $data)
                    @include('Unify::newsletter.complex.img-right', $data)


                    <? //leave these for now, as we do not have any data for them ?>
<!--                    --><?// @include('Unify::newsletter._toimplement.date-left', $data) ?>
<!--                    --><?// @include('Unify::newsletter._toimplement.date-right', $data) ?>
<!--                    --><?// @include('Unify::newsletter._toimplement.callout', $data) ?>
<!--                    --><?// @include('Unify::newsletter._toimplement.callout-complex', $data) ?>

                </table>
                <!-- // EMAIL CONTAINER -->
            </td>
        </tr>
    </table>
</center>
</body>
</html>