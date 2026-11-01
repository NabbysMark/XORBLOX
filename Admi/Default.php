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
<title>Admin - Home</title>
<?php Component::Render("adminNav"); ?>
<h2>Hello!</h2>
<p>Your curret rank is <a href="/Admi/rank/<?= $_USER["role"] ?>.aspx"><?= $_USER["role"] ?></a></p>
<a href="players.aspx"></a>