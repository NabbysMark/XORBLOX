<?php 
require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php"; 

$userCount = $db->fetch("SELECT COUNT(*) as count FROM users")["count"];
?>
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
<h2>Players</h2>
<p>The current amount of users registered on the site is <?= $userCount ?></p>