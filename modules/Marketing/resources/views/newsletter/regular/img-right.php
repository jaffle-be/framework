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
                                <!--
                                    Keeping the table markup in its original
                                    order and swapping the align attribute values
                                    allows the tables to wrap in the correct order
                                    on small displays.
                                -->
                                <table align="Right" border="0" cellpadding="0" cellspacing="0" width="200"
                                       class="flexibleContainer">
                                    <tr>
                                        <td align="Left" valign="top" class="imageContent">
                                            <img src="<?php echo asset($widget->present()->image) ?>" width="200"
                                                 class="flexibleImage" style="max-width:200px;">
                                        </td>
                                    </tr>
                                </table>
                                <!-- // CONTENT TABLE -->


                                <!-- CONTENT TABLE // -->
                                <table align="Left" border="0" cellpadding="0" cellspacing="0" width="340"
                                       class="flexibleContainer">
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
                    <!-- // FLEXIBLE CONTAINER -->
                </td>
            </tr>
        </table>
        <!-- // CENTERING TABLE -->
    </td>
</tr>
