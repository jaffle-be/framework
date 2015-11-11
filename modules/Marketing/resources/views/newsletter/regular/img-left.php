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
                                <table align="Left" border="0" cellpadding="0" cellspacing="0" width="200" class="flexibleContainer">
                                    <tr>
                                        <td align="Left" valign="top" class="imageContent">
                                            <img src="<?= asset($widget->present()->image) ?>" width="200" class="flexibleImage" style="max-width:200px;">
                                        </td>
                                    </tr>
                                </table>
                                <!-- // CONTENT TABLE -->


                                <!-- CONTENT TABLE // -->
                                <table align="Right" border="0" cellpadding="0" cellspacing="0" width="340" class="flexibleContainer">
                                    <tr>
                                        <td valign="top" class="textContent">
                                            <h3><?= $widget->present()->title($locale) ?></h3>
                                            <br>
                                            <?= $widget->present()->text($locale) ?>
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
