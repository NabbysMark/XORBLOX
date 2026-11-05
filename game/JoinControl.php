<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php";

header("Content-Type: text/plain");

$action = $_GET["Action"] ?? "";
$userId = (int)($_GET["UserId"] ?? 0);
$jobId = $_GET["jobID"] ?? "";
$accessKey = $_GET["accessKey"] ?? "";

if (!hash_equals((string)$settings["site"]["securitykey"], (string)$accessKey)) {
    http_response_code(403);
    exit("403");
}

if ($userId <= 0 || empty($jobId)) {
    http_response_code(400);
    exit("400");
}

$job = $db->fetch(
    "SELECT * FROM jobs WHERE jobid = ?",
    [$jobId]
);

if (!$job) {
    http_response_code(404);
    exit("404");
}

switch ($action) {
    case "Join":
        $existing = $db->fetch("SELECT id FROM players WHERE userid = ? AND jobid = ? LIMIT 1", [$userId, $jobId]);

        if (!$existing) {
            $db->execute("INSERT INTO players (userid, jobid) VALUES (?, ?)", [$userId, $jobId]);
        }
        break;

    case "Leave":
        $db->execute("DELETE FROM players WHERE userid = ? AND jobid = ?", [$userId, $jobId]);
        break;

    default:
        http_response_code(400);
        exit("400");
}

$count = $db->fetch("SELECT COUNT(*) AS total FROM players WHERE jobid = ?", [$jobId]);
$db->execute("UPDATE jobs SET players = (SELECT COUNT(*) FROM players WHERE jobid = ?) WHERE jobid = ?", [$jobId, $jobId]);

$db->execute(
    "UPDATE jobs SET players = ? WHERE jobid = ?",
    [(int)$count["total"], $jobId]
);

echo "OK";