<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php";

$userId = $_GET["userId"] ?? null;

$user = $db->fetch("SELECT * FROM users WHERE id = ?", [$userId]);
if (empty($user)) {
    die("Invalid user");
}

$bodycolors = explode(";", $user["bodyColors"]);

header("Content-Type: application/xml");
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<roblox xmlns:xmime="http://www.w3.org/2005/05/xmlmime" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://www.roblox.com/roblox.xsd" version="4">
    <External>null</External>
    <External>nil</External>
    <Item class="BodyColors" referent="RBX0">
        <Properties>
            <int name="HeadColor"><?= $bodycolors[0] ?></int>
            <int name="LeftArmColor"><?= $bodycolors[2] ?></int>
            <int name="LeftLegColor"><?= $bodycolors[4] ?></int>
            <string name="Name">Body Colors</string>
            <int name="RightArmColor"><?= $bodycolors[3] ?></int>
            <int name="RightLegColor"><?= $bodycolors[5] ?></int>
            <int name="TorsoColor"><?= $bodycolors[1] ?></int>
            <bool name="archivable">true</bool>
        </Properties>
    </Item>
</roblox>