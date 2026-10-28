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
	$chatmode = $_POST["chatmode"] ?? null;
	$agegroup = $_POST["chatmode"] ?? null;
	$email = $_POST["email"] ?? null;

	$hasError = false;

	if ($agegroup == 1) {
		http_response_code(403);
        header("Location: /Error/Default.aspx");
        exit;
	}

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
        $_SESSION["password_error"] = [];
        $hasError = true;
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
					
	
		<div id="Registration">
			<form id="ctl00_cphRoblox_upAccountRegistration" method="post">
				<input type="hidden" id="crsf_token" name="csrf_verification" value="<?= htmlspecialchars($_SESSION["csrf_token"], ENT_QUOTES, "UTF-8") ?>">
					<h2>Sign Up and Play</h2>
					<h3>Step 1 of 2: Create Account</h3>
					<div id="EnterAgeGroup">
						<fieldset title="Provide your age-group">
							<legend>Provide your age-group</legend>
							<div class="Suggestion">
								This will help us to customize your experience.  Users under 13 years will only be shown pre-approved images.
							</div>
							<div class="AgeGroupRow">
								<span id="ctl00_cphRoblox_rblAgeGroup"><input id="ctl00_cphRoblox_rblAgeGroup_0" type="radio" name="agegroup" value="1" tabindex="5"><label for="ctl00_cphRoblox_rblAgeGroup_0">Under 13 years</label><br><input id="ctl00_cphRoblox_rblAgeGroup_1" type="radio" name="agegroup" value="2" onclick="javascript:setTimeout('__doPostBack(\'ctl00$cphRoblox$rblAgeGroup$1\',\'\')', 0)" checked="checked" tabindex="5"><label for="ctl00_cphRoblox_rblAgeGroup_1">13 years or older</label></span>
							</div>
						</fieldset>
					</div>
					<div id="EnterUsername">
						<fieldset title="Choose a name for your XORBLOX character">
							<legend>Choose a name for your XORBLOX character</legend>
							<div class="Suggestion">
								Use 3-20 alphanumeric characters: A-Z, a-z, 0-9, no spaces
							</div>
							<div class="Validators">
								<?php if (isset($_SESSION["username_error"])): ?>
								<div>
                                	<div style="color:red;text-align:left;"><?= $_SESSION["username_error"] ?></div>
                                </div>
								<?php unset($_SESSION["username_error"]); ?>
								<?php endif; ?>
							</div>
							<div class="UsernameRow">
								<label for="username" id="ctl00_cphRoblox_UserNameLabel" class="Label">Character Name:</label>&nbsp;<input name="username" type="text" id="username" tabindex="1" class="TextBox">
							</div>
						</fieldset>
					</div>
					<div id="EnterPassword">
						<fieldset title="Choose your XORBLOX password">
							<legend>Choose your XORBLOX password</legend>
							<div class="Suggestion">
								4-10 characters, no spaces
							</div>
							<div class="Validators">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
							<div class="PasswordRow">
								<label for="password" id="ctl00_cphRoblox_LabelPassword" class="Label">Password:</label>&nbsp;<input name="password" type="password" id="password" tabindex="2" class="TextBox">
							</div>
							<div class="ConfirmPasswordRow">
								<label for="ctl00_cphRoblox_TextBoxPasswordConfirm" id="ctl00_cphRoblox_LabelPasswordConfirm" class="Label">Confirm Password:</label>&nbsp;<input name="ctl00$cphRoblox$TextBoxPasswordConfirm" type="password" id="ctl00_cphRoblox_TextBoxPasswordConfirm" tabindex="3" class="TextBox">
							</div>
						</fieldset>
					</div>
					<div id="EnterChatMode">
						<fieldset title="Choose your chat mode">
							<legend>Choose your chat mode</legend>
							<div class="Suggestion">
								All in-game chat is subject to profanity filtering and moderation.  For enhanced chat safety, choose SuperSafe Chat; only chat from pre-approved menus will be shown to you.
							</div>
							<div class="ChatModeRow">
								<span id="ctl00_cphRoblox_rblChatMode"><input id="ctl00_cphRoblox_rblChatMode_0" type="radio" name="chatmode" value="false" checked="checked" tabindex="6"><label for="ctl00_cphRoblox_rblChatMode_0">Safe Chat</label><br><input id="ctl00_cphRoblox_rblChatMode_1" type="radio" name="chatmode" value="true" tabindex="6"><label for="ctl00_cphRoblox_rblChatMode_1">SuperSafe Chat</label></span>
							</div>
						</fieldset>
					</div>
					<div id="EnterEmail">
						<fieldset title="Provide your email address">
							<legend>Provide your email address</legend>
							<div class="Suggestion">
								This will allow you to recover a lost password
							</div>
							<div class="Validators">
								<div></div>
								<div></div>
								<div></div>
							</div>
							<div class="EmailRow">
								<label for="email" id="ctl00_cphRoblox_LabelEmail" class="Label">Your Email:</label>&nbsp;<input name="email" type="text" id="email" tabindex="4" class="TextBox">
							</div>
						</fieldset>
					</div>
					<div class="Confirm">
						<input type="submit" name="ctl00$cphRoblox$ButtonCreateAccount" value="Register" onclick="this.closest('form').submit(); return false;" id="ctl00_cphRoblox_ButtonCreateAccount" tabindex="5" class="BigButton">
					</div>
				
            </form>
		</div>
		<div id="Sidebars">
			<div id="AlreadyRegistered">
				<h3>Already Registered?</h3>
				<p>If you just need to login, go to the <a id="ctl00_cphRoblox_HyperLinkLogin" href="Default.aspx?ReturnUrl=%2f">Login</a> page.</p>
				<p>If you have already registered but you still need to download the game installer, go directly to <a id="ctl00_cphRoblox_HyperLinkDownload" href="/web/20070804083927/http://roblox.com/Install/Default.aspx?ReturnUrl=%2f">download</a>.</p>
			</div>
			<div id="TermsAndConditions">
				<h3>Terms &amp; Conditions</h3>
				<p>Registration does not provide any guarantees of service. See our <a id="ctl00_cphRoblox_HyperLinkToS" href="/web/20070804083927/http://roblox.com/Info/TermsOfService.aspx?layout=null" target="_blank">Terms of Service</a> and <a id="ctl00_cphRoblox_HyperLinkEULA" href="/web/20070804083927/http://roblox.com/Info/EULA.htm" target="_blank">Licensing Agreement</a> for details.</p>
				<p>XORBLOX will not share your email address with 3rd parties. See our <a id="ctl00_cphRoblox_HyperLinkPrivacy" href="/web/20070804083927/http://roblox.com/Info/Privacy.aspx?layout=null" target="_blank">Privacy Policy</a> for details.</p>
			</div>
		</div>
		<div id="ctl00_cphRoblox_ie6_peekaboo" style="clear: both"></div>

			</div>
            <?php Component::Render("footer"); ?>
        </div>
    </body>
</html>