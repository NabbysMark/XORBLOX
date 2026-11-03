<?php

require_once __DIR__ . '/../vendor/autoload.php';

use CompactInteractive\RCCServiceSoap08;

$init = RCCServiceSoap08::init("127.0.0.1", 64989, "roblox.com");

if(!$init || RCCServiceSoap08::hasErrors() === false) {
    echo "Init failed.";
    echo RCCServiceSoap08::getErrors();
    exit;
}

$script = <<<LUA
player = game:GetService("Players"):CreateLocalPlayer(0)

player:LoadCharacter(0)

return game:GetService("ThumbnailGenerator"):Click("PNG", 1012, 1012, true)
LUA;

$rand = bin2hex(random_bytes(16));
$response = RCCServiceSoap08::execute($script, $rand, 0.1);

if($response === false) {
    echo RCCServiceSoap08::getErrors();
}else {
    header("Content-type: image/png");
    echo base64_decode($response);
}

?>