<div id='welcomeTextDiv' style=<?php print "'top:" . $welcomeTextTop . ";position:absolute;"; ?>>
        <table width='100%' border='0' style=<?php print "'font-size:" . $HelloFontSize . ";color:white;font-weight:plain;'"; ?>>
            <tr>
                <td align='left' style='padding-left:30px';>
                    <?php
                        if($userObject)
                            print  "<font color='white'>" . translate('szia') . "&nbsp;" . $userObject['keresztnev'] . "!&nbsp;";
                        else
                            print "";
                    ?>
                </td>
            </tr>
        </table>
</div>