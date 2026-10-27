<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php"; ?>
<?php
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $returnUrl = $_REQUEST["ReturnUrl"] ?? null;
    $csrfToken = $_POST["csrf_verification"] ?? null;
    $username = $_POST["username"] ?? null;
    $password = $_POST["password"] ?? null;

    $hasError = false;

    if (!is_string($csrfToken) || !hash_equals($_SESSION["csrf_token"], $csrfToken)) {
        http_response_code(403);
        header("Location: /Error/Default.aspx");
        exit;
    }

    if (empty($username) || !is_string($username)) {
        $_SESSION["username_error"] = "Please enter your username.";
        $hasError = true;
    }

    if (empty($password) || !is_string($password)) {
        $_SESSION["password_error"] = "Please enter your password.";
        $hasError = true;
    }

    $user = $db->fetch("SELECT * FROM users WHERE username = ?", [$username]);

    if (empty($user)) {
        $_SESSION["general_error"] = "Incorrect username or password.";
        $hasError = true;
    }

    if (!password_verify($password, $user["password"])) {
        $_SESSION["general_error"] = "Incorrect username or password.";
        $hasError = true;
    }

    if ($hasError) {
        header("Location: /Login/Default.aspx");
        exit;
    }

    if (!$hasError) {
        $_SESSION["user_id"] = $user["id"];
        if (isset($returnUrl)) {
            $returnUrl = urldecode($returnUrl);
            header("Location: $returnUrl");
        } else {
            header("Location: /Default.aspx");
        }
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
            <?php Component::Render("nav2"); ?>
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
                                <label for="username" class="TextboxLabel"><em>U</em>ser Name:</label>
                                <input type="text" id="username" name="username" value="" accesskey="u">&nbsp;
                                <?php if (isset($_SESSION["username_error"])): ?>
                                <p style="color:red;text-align:left;margin:0;"><?= $_SESSION["username_error"] ?></p>
                                <?php unset($_SESSION["username_error"]); ?>
                                <?php endif; ?>
                            </div>
                            <div class="AspNet-Login-PasswordPanel">
                                <label for="password" class="TextboxLabel"><em>P</em>assword:</label>
                                <input type="password" id="password" name="password" value="" accesskey="p">&nbsp;
                                <?php if (isset($_SESSION["password_error"])): ?>
                                <p style="color:red;text-align:left;margin:0;"><?= $_SESSION["password_error"] ?></p>
                                <?php unset($_SESSION["password_error"]); ?>
                                <?php endif; ?>
                            </div>
                            <div class="AspNet-Login-SubmitPanel">
                                <button type="submit" id="ctl00_cphRoblox_lRobloxLogin_LoginButton" name="LoginButton">Log In</button>
                            </div>
                            <?php if (isset($_SESSION["general_error"])): ?>
                            <p style="color:red;text-align:left;margin:0;">Incorrect username or password.</p>
                            <?php unset($_SESSION["general_error"]); ?>
                            <?php endif; ?>
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