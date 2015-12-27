<tr>
    <td align="center" valign="top">
        <!-- CENTERING TABLE // -->
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td align="center" valign="top">
                    <!-- FLEXIBLE CONTAINER // -->
                    <table border="0" cellpadding="0" cellspacing="0" width="600" class="flexibleContainer">
                        <tr>
                            <td align="center" valign="top" width="600" class="flexibleContainerCell bottomShim">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="nestedContainer">
                                    <tr>
                                        <td align="center" valign="top" class="nestedContainerCell">


                                            <!-- CONTENT TABLE // -->
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td valign="top" class="imageContent">
                                                        <img src="<?php echo asset($widget->present()->image) ?>" width="520" class="flexibleImage" style="max-width:520px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" class="textContent">
                                                        <h3><?php echo $widget->present()->title($locale) ?></h3>
                                                        <br>
                                                        <?php echo $widget->present()->text($locale) ?>
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- // CONTENT TABLE -->


                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <!-- // FLEXIBLE CONTAINER -->
                </td>
            </tr>
        </table>
        <!-- // CENTERING TABLE -->
    </td>
</tr>
