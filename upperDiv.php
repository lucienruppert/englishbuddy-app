<div id='UpperDiv' style='position:relative;width:100%;background:#031525'>
    <table align='center' border='0'  width='100%' valign='top'>
        <tr>
            <td align="right">
                <?php 
                    if($userObject && in_array($userObject['status'], array(4, 5, 6))){
                ?>
                    <a href='#' style='color:white;' onclick="p_Click(event)">p</a>
                    &nbsp;&nbsp;
                <?php }
                    if($userObject && in_array($userObject['status'], array(4, 5, 6))){
                ?>
                    <a href='#' style='color:white;' onclick="t_Click(event)">t</a>
                    &nbsp;&nbsp;
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td colspan='2' align=<?php print $userObject ? "'right'" : "'center'" ?> valign='top' style=<?php print "'height:" . $TopRedHeight . ";'"; ?>>

            <?php
                if($userObject){
            ?>

                <a href='#' style=<?php print "'font-size:" . $loginFontSize . ";color:white;margin-right: 5px;'"; ?> onclick="event.stopPropagation();location.href='index.php?usersettings=1'">
                    <?php print translate('beallitasok'); ?>
                </a>
                <b>
                <a href='#' style=<?php print "'font-size:" . $loginFontSize . ";color:white;'"; ?> onclick="event.stopPropagation();location.href='logout.php'">
                    <?php print translate('kijelentkezes'); ?>
                </a>
                &nbsp;&nbsp;&nbsp;

                <?php
                    }
                    else{
                ?>
                <form id="formLogin" action='index.php' method='POST'>
                <table id="tblLogin" border='0' width='202' cellspacing='3'>
                    <tr>
                        <td align='center' style=<?php print "'white-space:nowrap;padding-top:" . $MiddlePadding . "'"; ?>>
                        <?php if($isAndroid) {  ?>
                        <img class="imgLangChange" data-lang="0" src='images/hun.jpg' height=<?php print $FlagHeight ?> width=<?php print $FlagWidth ?>>
                        <img class="imgLangChange" data-lang="1" src='images/uk.jpg' height=<?php print $FlagHeight ?> width=<?php print $FlagWidth ?>>
                        <img class="imgLangChange" data-lang="2" src='images/sp.jpg' height=<?php print $FlagHeight ?> width=<?php print $FlagWidth ?>>
                        <?php   } ?>
                        </td>
                    </tr>

                    <?php /*
                        <tr>
                            <td valign='center' align='center' style=<?php print "'padding-top:" . $Padding . ";padding-bottom:" . $Padding . ";border:1px solid white;height:22px'"; ?>>
                                <a href='#' style=<?php print "'font-size:" . $ButtonFontSize . ";color:white;'"; ?> onclick="goToRegistration()"><?php print translate('subscribe'); ?></a>
                            </td>
                        </tr>
                    */ ?>

                    <tr>
                        <td valign='center' align='center' style=<?php print "'padding-top:" . $Padding . ";padding-bottom:" . $Padding . ";border:1px solid white;height:22px'"; ?>>
                            <input type='hidden' name='actionType' value='login'>
                            <input style='display:none' type='submit'>
                            <a href='#' style=<?php print "'font-size:" . $ButtonFontSize . ";color:white;'"; ?> id='btnLogin' onclick="if(!$('.loginInput').is(':visible')){ $('.loginInput').show(); } else{ $('#formLogin').submit(); }">&nbsp;<?php print translate('enter'); ?>&nbsp;</a>
                        </td>
                    </tr>
                    <tr>
                        <td align='left'>
                            <table border='0' align='right'>
                                <tr>
                                    <td  align='right' class='loginInput' style=<?php print "'font-size:" . $email_password_title_Size . ";color:white;'"; ?>>Email</td>
                                    <td>
                                    <input class='loginInput' type='text' name='email' size=<?php print $PasswordSize ?> style=<?php print "'font-size:" . $EmailFieldFontSize . ";color:white;border:1px solid white;background-color:" . $globalcolor . ";'" ?> onclick="event.stopPropagation();clearit(this, 0);">
                                    </td>
                                </tr>
                                <tr>
                                    <td  align='right' class='loginInput' style=<?php print "'font-size:" . $email_password_title_Size . ";color:white;'"; ?>><?php print translate('subs_Jelsz�'); ?></td>
                                    <td>
                                    <input class='loginInput' type='password' name='username' id='username' size=<?php print $PasswordSize ?> style=<?php print "'font-size:" . $EmailFieldFontSize . ";color:white;border:1px solid white;background-color:" . $globalcolor . ";'" ?>>
                                </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                </form>
            <?php
                }
            ?>
            </td>
        </tr>
    </table>
</div>