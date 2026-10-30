<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php"; ?>
<title>XORBLOX</title>
<div align="center">
    <img src="/images/roblox_logo.png">
    <h2>THIS WEBSITE IS HOSTING A XORBLOX INSTANCE!</h2>
    <p>If your seeing this, congratulations! Youre on a XORBLOX rehost.</p>
    <?php if ($settings["site"]["inviteonly"]): ?>
    <b style="color: red;">Sadly. This XORBLOX instance is invite only, which means you need a referal code from somebody.</b>
    <?php else: ?>
    <button onclick="this.window.location = '/Login/New.aspx'">Create an Account!</button>
    <?php endif; ?>
</div>
<style>
* {
    font-family: "Comic Sans MS";
}
</style>