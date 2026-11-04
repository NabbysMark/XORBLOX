<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php";
$assetId = $_REQUEST["id"] ?? $_REQUEST["ID"] ?? $_REQUEST["assetversionid"] ?? null;
$version = $_REQUEST["version"] ?? null;
$assetId = is_numeric($assetId) ? (int) $assetId : null;

if (empty($assetId)) {
    exit("Invalid assetId");
}

$assetPath = $_SERVER["DOCUMENT_ROOT"] . "/Asset/assets/$assetId";
$cachedPath = $_SERVER["DOCUMENT_ROOT"] . "/Asset/assets/CachedRBLXAssets/$assetId";
$coreScriptPath = $_SERVER["DOCUMENT_ROOT"] . "/Asset/assets/CoreScripts/$assetId";
$content = null;

$asset = $db->fetch("SELECT * FROM assets WHERE assetid = ?", [$assetId]);

if (isset($asset) && (!isset($_REQUEST["securityKey"]) || $_REQUEST["securityKey"] !== $settings["site"]["securitykey"])) {
    http_response_code(401);
    exit("Unauthorized");
}

$content = null;
$errorResponse = null;
$errorStatusCode = null;

if (file_exists($assetPath)) {
    $content = @file_get_contents($assetPath);

} elseif (file_exists($coreScriptPath)) {
    $content = @file_get_contents($coreScriptPath);

    if ($content !== false) {
        $asset = "--rbxassetid%" . $assetId . "%\r\n" . $content;

        $asset = str_replace("www.roblox.com", "www.voxera.fit", $asset);
        $asset = str_replace("roblox.com", "voxera.fit", $asset);

        $signature = null;
        $privateKeyPath = $_SERVER["DOCUMENT_ROOT"] . "/game/PrivateKey.pem";

        if (file_exists($privateKeyPath)) {
            $key = file_get_contents($privateKeyPath);

            if ($key !== false) {
                openssl_sign($asset, $signature, $key, OPENSSL_ALGO_SHA1);
            }
        }

        $content = sprintf("--rbxsig%%%s%%%s", base64_encode($signature ?? ''), $asset);
    }

} elseif (file_exists($cachedPath)) {
    $content = @file_get_contents($cachedPath);
} else {
    $roblosecurity = $settings["site"]["assetcookie"];

    $url = "https://assetdelivery.roproxy.com/v2/assetId/" . $assetId;

    if (isset($version)) {
        $url .= "/version/" . $version;
    }

    $content = false;

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTPHEADER => ["Cookie: .ROBLOSECURITY=" . $roblosecurity],
        CURLOPT_TIMEOUT => 30
    ]);

    $response = curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($response !== false && $statusCode === 200) {
        $data = json_decode($response, true);

        if (isset($data["locations"][0]["location"])) {
            $assetUrl = $data["locations"][0]["location"];

            $ch = curl_init($assetUrl);

            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_TIMEOUT => 30
            ]);

            $content = curl_exec($ch);
            $downloadStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($content === false || $downloadStatus !== 200) {
                $content = false;
            }
        }
    }

    if ($content === false) {
        $fallbackUrl = "https://proxy.95.fyi/assetrequest.php?id=" . urlencode($assetId);

        if (isset($version)) {
            $fallbackUrl .= "&version=" . urlencode($version);
        }

        $ch = curl_init($fallbackUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 30
        ]);

        $content = curl_exec($ch);
        $fallbackStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($content === false || $fallbackStatus !== 200) {
            $errorStatusCode = $fallbackStatus ?: 502;
            $errorResponse = $content !== false ? $content : "Asset delivery failed.";

            $content = false;
        }
    }

    if ($content !== false) {
        $content = str_replace("roblox.com", "voxera.fit", $content);

        if (!is_dir(dirname($cachedPath))) {
            mkdir(dirname($cachedPath), 0755, true);
        }

        file_put_contents($cachedPath, $content);
    }
}

if ($errorStatusCode !== null) {
    http_response_code($errorStatusCode);
    exit($errorResponse);
}

if ($content === false || $content === null) {
    http_response_code(404);
    exit;
}

$content = str_replace("roblox.com", "voxera.fit", $content);

header("Content-Type: application/octet-stream");
header('Content-Disposition: attachment; filename="' . $assetId . '"');
header("Content-Length: " . strlen($content));

echo $content;