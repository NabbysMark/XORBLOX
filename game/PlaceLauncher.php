<?php

use CompactInteractive\RCCServiceSoap08;

require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php";

header("Content-Type: application/json");

$request = $_GET["request"] ?? "";

switch ($request) {
    case "RequestGame":
        $placeId = (int)($_GET["placeId"] ?? 0);

        if ($placeId <= 0) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid place ID"]);
            exit;
        }

        $job = $db->fetch("SELECT * FROM jobs WHERE assetid = ? AND status IN (0, 1, 2) AND players < maxplayers ORDER BY players ASC LIMIT 1", [$placeId]);

        if (!$job) {
            $jobId = bin2hex(random_bytes(16));

            $port = 53640;

            $db->execute(
                "INSERT INTO jobs (jobid, status, port, assetid, players, maxplayers) VALUES (?, 0, ?, ?, 0, 6)",
                [$jobId, $port, $placeId]
            );

            try {
                $gameserverScript = file_get_contents(
                    "http://{$settings["site"]["baseUrl"]}/game/gameserver.ashx?jobID=" . $jobId
                );

                if ($gameserverScript === false) {
                    throw new Exception("Failed to retrieve game server script");
                }

                RCCServiceSoap08::execute($gameserverScript, generateJobId(), 999999999);

                $db->execute("UPDATE jobs SET status = 2 WHERE jobid = ?", [$jobId]);

            } catch (Throwable $e) {
                $db->execute("UPDATE jobs SET status = 3 WHERE jobid = ?", [$jobId]);
                error_log("startup failed: " . $e->getMessage());
            }

            $job = [
                "jobid" => $jobId,
                "status" => $db->fetch("SELECT status FROM jobs WHERE jobid = ?", [$jobId])["status"],
                "port" => $port,
                "assetid" => $placeId,
                "players" => 0,
                "maxplayers" => 6
            ];
        }

        if ($job["status"] == 2) {
            echo json_encode([
                "status" => (int)$job["status"],
                "jobID" => $job["jobid"],
                "joinScriptUrl" => "http://www.voxera.fit/Game/Join.ashx?jobID=" . urlencode($job["jobid"]),
                "authenticationUrl" => "http://www.voxera.fit/Login/Negotiate.ashx",
            ]);
        } else {
            echo json_encode([
                "status" => (int)$job["status"],
                "jobID" => $job["jobid"]
            ]);
        }
        exit;

    case "CheckGameJobStatus":
        $jobId = $_GET["jobId"] ?? "";

        if (empty($jobId)) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid job ID"]);
            exit;
        }

        $job = $db->fetch(
            "SELECT * FROM jobs WHERE jobid = ?",
            [$jobId]
        );

        if (!$job) {
            echo json_encode([
                "status" => 4,
                "jobID" => $jobId
            ]);
            exit;
        }

        $status = (int)$job["status"];

        if ($status === 2 && (int)$job["players"] >= (int)$job["maxplayers"]) {
            $status = 6;
        }

        $response = [
            "status" => $status,
            "jobID" => $job["jobid"]
        ];

        if ($status === 2) {
            $response["joinScriptUrl"] = "http://www.voxera.fit/Game/Join.ashx?jobID=" . urlencode($jobId);
            $response["authenticationUrl"] = "http://www.voxera.fit/Login/Negotiate.ashx?jobID=" . urlencode($jobId);
        }

        echo json_encode($response);
        exit;

    default:
        http_response_code(400);
        echo json_encode([
            "error" => "Invalid request"
        ]);
        exit;
}