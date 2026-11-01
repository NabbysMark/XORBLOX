<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php"; ?>
<?php 
requireLogin(); 
if (!isset($_USER)) {
    die("ok");
}
if ($_USER["role"] === "member") {
    http_response_code(404);
    header("Location: /Error/Default.aspx");
    exit;
}
?>
<?php Component::Render("adminNav"); ?>
<title>Admin - Renders</title>
<h2>Renders</h2>
<p>This is for managing renders. you might want to use this if something has gone wrong on the server end for some asset or avatar.</p>
<form method="post">
    <label for="render-type">Render Type</label>
    <select name="render-type" id="render-type">
        <option value="avatar">Avatar</option>
        <option value="asset">Asset</option>
    </select>
    <div class="form-control">
        <label for="avatar-username">Avatar Username</label>
        <input name="avatar-username" id="avatar-username" placeholder="Username here">
    </div>
    <div class="form-control">
        <label for="asset-id">Asset Id</label>
        <input name="asset-id" id="asset-id" placeholder="Asset id here">
    </div>
    <button>Render</button>
</form>