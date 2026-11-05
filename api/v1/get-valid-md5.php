<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php";
if ($_REQUEST["accessKey"] != "AccessKey-" . $settings["site"]["securitykey"]) {
    die("Invalid apiKey");
}
header("Content-Type: application/json");
echo json_encode(
    [
        "success" => true,
        "hashes" => ["3ee5e726fa5953cbde0ec010f76a55d9"]
    ]
);