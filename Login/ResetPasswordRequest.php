<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <?php Component::Render("head"); ?>
    </head>
    <body>
        <div id="Container">
            <?php Component::Render("nav2"); ?>
            <div id="Body">
                <h3>
                    Forgot your password or wish to change it?</h3>
                <p>
                    We can send you an email to reset it. If you can't remember your username then
                    just enter your email address.<br>
                </p>
                <p>
                    Username or email:
                    <input name="usernameOrEmail" type="text" id="usernameOrEmail"></p>
                <p>
                    </p><table id="Table1">
                        <tbody><tr>
                            <td>
                            </td>
                            <td width="140">
                                <a id="ctl00_cphRoblox_LinkButtonResetPassword" href="">Reset password</a></td>
                            <td>
                                
                                <input name="ctl00$cphRoblox$hiddenEmail" type="hidden" id="ctl00_cphRoblox_hiddenEmail" value="An email with instructions has been sent to {0}"></td>
                        </tr>
                    </tbody></table>
                <p></p>
			</div>
            <?php Component::Render("footer"); ?>
        </div>
    </body>
</html>