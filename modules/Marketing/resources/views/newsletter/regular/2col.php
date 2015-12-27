<tr>
    <td align="center" valign="top">
        <!-- CENTERING TABLE // -->
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td align="center" valign="top">
                    <!-- FLEXIBLE CONTAINER // -->
                    <table border="0" cellpadding="0" cellspacing="0" width="600" class="flexibleContainer">
                        <tr>
                            <td valign="top" width="600" class="flexibleContainerCell">


                                <!-- CONTENT TABLE // -->
                                <table align="Left" border="0" cellpadding="0" cellspacing="0" width="260"
                                       class="flexibleContainer">
                                    <tr>
                                        <td valign="top" class="imageContent">
                                            <img src="<?php echo asset($widget->present()->image_left) ?>" width="260"
                                                 class="flexibleImage" style="max-width:260px;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="textContent">
                                            <h3><?php echo $widget->present()->title_left($locale) ?></h3>
                                            <br>
                                            <?php echo $widget->present()->text_left($locale) ?>
                                        </td>
                                    </tr>
                                </table>
                                <!-- // CONTENT TABLE -->


                                <!-- CONTENT TABLE // -->
                                <table align="Right" border="0" cellpadding="0" cellspacing="0" width="260"
                                       class="flexibleContainer">
                                    <tr>
                                        <td valign="top" class="imageContentLast">
                                            <img src="<?php echo asset($widget->present()->image_right) ?>" width="260"
                                                 class="flexibleImage" style="max-width:260px;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="textContent">
                                            <h3><?php echo $widget->present()->title_right($locale) ?></h3>
                                            <br>
                                            <?php echo $widget->present()->text_right($locale) ?>
                                        </td>
                                    </tr>
                                </table>
                                <!-- // CONTENT TABLE -->


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
