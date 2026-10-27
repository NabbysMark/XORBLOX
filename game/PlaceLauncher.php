<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php";
$request = $_GET["request"] ?? "";

switch ($request) {
    case "RequestGame":
        $placeId = (int)($_GET["placeId"] ?? 0);

        break;

    case "CheckGameJobStatus":
        $jobId = $_GET["jobId"] ?? "";
        $interval = (int)($_GET["interval"] ?? 3);

        break;

    default:
        http_response_code(400);
        header("Content-Type: application/json");
        echo json_encode(["error" => "Invalid request"]);
        exit;
}

header("Content-Type: application/json");