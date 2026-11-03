<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php";

header("Content-Type: text/plain");
$part = (int)$_REQUEST["part"];
$color = (int)$_REQUEST["color"];

if (!isset($_USER)) {
    http_response_code(401);
    exit("Unauthorized");
}

$bodycolors = explode(";", $_USER["bodycolors"]);

switch ($part) {
    case 1:
        $bodycolors[5] = $color;
        break;

    case 2:
        $bodycolors[0] = $color;
        break;

    case 3:
        $bodycolors[1] = $color;
        break;

    case 4:
        $bodycolors[2] = $color;
        break;

    case 5:
        $bodycolors[3] = $color;
        break;

    case 6:
        $bodycolors[4] = $color;
        break;
}

$newColors = implode(";", $bodycolors);

$db->query("UPDATE users SET bodycolors = ? WHERE id = ?", [$newColors, $_USER["id"]]);

$b64 = renderCharacter($_SESSION["user_id"]);
file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/thumbs/avatars/".$_SESSION["user_id"].".png", $b64);