<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php";

$userId = $_GET["userId"] ?? null;
$username = $_GET["username"] ?? null;
$format = $_GET["format"] ?? "Png";
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

$format = strtolower($format);

if ($format !== "jpg" && $format !== "jpeg" && $format !== "png") {
    $format = "png";
}

$image = imagecreatefrompng($path);

$x = max(1, min(2000, (int)$x));
$y = max(1, min(2000, (int)$y));

$resized = imagecreatetruecolor($x, $y);

imagealphablending($resized, false);
imagesavealpha($resized, true);

$transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
imagefill($resized, 0, 0, $transparent);

imagecopyresampled($resized, $image, 0, 0, 0, 0, $x, $y, imagesx($image), imagesy($image));

if ($format === "jpg" || $format === "jpeg") {
    $background = imagecreatetruecolor($x, $y);
    $white = imagecolorallocate($background, 255, 255, 255);
    imagefill($background, 0, 0, $white);

    imagecopy($background, $resized, 0, 0, 0, 0, $x, $y);

    header("Content-Type: image/jpeg");
    imagejpeg($background, null, 90);
} else {
    header("Content-Type: image/png");
    imagepng($resized);
}