<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php"; ?>
<?php
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $csrfToken = $_POST["csrf_verification"] ?? null;

    if (!is_string($csrfToken) || !hash_equals($_SESSION["csrf_token"], $csrfToken)) {
        http_response_code(403);
        header("Location: /Error/Default.aspx");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php Component::Render("head"); ?>
    </head>
    <body>
        <div id="Container">
            <?php Component::Render("nav"); ?>
            <div id="Body">
                <script type="text/javascript">
                    function signUp()
                    {
                        window.location = "/Login/New.aspx";
                    }
                </script>
                <div id="FrameLogin" style="margin: 150px auto 150px auto; width: 500px; border: black thin solid; padding: 22px;">
                    <div id="PaneNewUser">
                        <h3>New User?</h3>
                        <p>You need an account to play XORBLOX.</p>
                        <p>If you aren't a XORBLOX member then <a id="ctl00_cphRoblox_HyperLink1" href="New.aspx">register</a>. It's easy and we do <em>not</em> share your personal information with anybody.</p>
                    </div>
                    <div id="PaneLogin">
                        <h3>Log In</h3>
                        
                        <form class="AspNet-Login" method="post">
                            <input type="hidden" id="crsf_token" name="csrf_verification" value="<?= htmlspecialchars($_SESSION["csrf_token"], ENT_QUOTES, "UTF-8") ?>">
                            <div class="AspNet-Login-UserPanel">
                                <label for="ctl00_cphRoblox_lRobloxLogin_UserName" class="TextboxLabel"><em>U</em>ser Name:</label>
                                <input type="text" id="ctl00_cphRoblox_lRobloxLogin_UserName" name="ctl00$cphRoblox$lRobloxLogin$UserName" value="" accesskey="u">&nbsp;
                            </div>
                            <div class="AspNet-Login-PasswordPanel">
                                <label for="ctl00_cphRoblox_lRobloxLogin_Password" class="TextboxLabel"><em>P</em>assword:</label>
                                <input type="password" id="ctl00_cphRoblox_lRobloxLogin_Password" name="ctl00$cphRoblox$lRobloxLogin$Password" value="" accesskey="p">&nbsp;
                            </div>
                            <div class="AspNet-Login-SubmitPanel">
                                <button type="submit" id="ctl00_cphRoblox_lRobloxLogin_LoginButton" name="ctl00$cphRoblox$lRobloxLogin$LoginButton">Log In</button>
                            </div>
                            <div class="AspNet-Login-PasswordRecoveryPanel">
                                <a href="ResetPasswordRequest.aspx" title="Password recovery">Forgot your password?</a>
                            </div>
                        </form>
                    </div>
                </div>
			</div>
            <?php Component::Render("footer"); ?>
        </div>
    </body>
</html>