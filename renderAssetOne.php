<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php";
$b64 = renderAsset(1);
file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/thumbs/assets/1.png", $b64);