<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php";

$userId = $_GET["userId"] ?? null;
$username = $_GET["username"] ?? null;
$x = $_GET["x"] ?? 500;
$y = $_GET["y"] ?? 500;

if (empty($userId) && empty($username)) {
    http_response_code(403);
    header("Location: /Error/Default.aspx");
    exit;
}

if (!empty($userId)) {
    $user = $db->fetch("SELECT * FROM users WHERE id = ?", [$userId]);
} else {
    $user = $db->fetch("SELECT * FROM users WHERE username = ?", [$username]);
}

if (!$user) {
    http_response_code(404);
    header("Location: /Error/Default.aspx");
    exit;
}

$path = $_SERVER["DOCUMENT_ROOT"] . "/thumbs/avatars/" . $user["id"] . ".png";

if (!file_exists($path)) {
    http_response_code(404);
    header("Location: /Error/Default.aspx");
    exit;
}
$content = file_get_contents($path);

header("Content-Type: image/png");
echo $content;