<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php";

$assetId = $_GET["assetId"] ?? null;
$format = $_GET["format"] ?? "Png";

if (empty($assetId)) {
    http_response_code(403);
    header("Location: /Error/Default.aspx");
    exit;
}

$asset = $db->fetch("SELECT * FROM assets WHERE id = ?", [$assetId]);

if (!$asset) {
    http_response_code(404);
    header("Location: /Error/Default.aspx");
    exit;
}

$defaultX = 420;
$defaultY = 230;

if ($asset["category"] != 9) {
    $defaultX = 500;
    $defaultY = 500;
}
$x = $_GET["x"] ?? $defaultX;
$y = $_GET["y"] ?? $defaultY;

$path = $_SERVER["DOCUMENT_ROOT"] . "/thumbs/assets/" . $asset["id"] . ".png";

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

    imagedestroy($background);
} else {
    header("Content-Type: image/png");
    imagepng($resized);
}

imagedestroy($image);
imagedestroy($resized);