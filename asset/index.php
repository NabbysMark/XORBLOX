<?php
$id = $_GET["id"] ?? null;

if (empty($id)) {
    die("Invalid id");
}

$api = "https://proxy.95.fyi/assetrequest.php?id=".$id;
$path = $_SERVER["DOCUMENT_ROOT"] . "/asset/assets/$id";

$content = null;

if (!file_exists($path)) {
    $content = @file_get_contents($api);
    if ($content === false) {
        die("Failed to fetch asset");
    }
} else {
    $content = file_get_contents($path);
}

header("Content-Type: text/plain");
echo $content;