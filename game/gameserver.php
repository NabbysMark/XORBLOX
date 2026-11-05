<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php";
$jobID = $_REQUEST["jobID"] ?? null;

if (empty($jobID)) {
    die("Invalid jobID");
}

$job = $db->fetch("SELECT * FROM jobs WHERE jobid = ?", [$jobID]);
if (empty($job)) {
    die("Invalid job");
}

$asset = $db->fetch("SELECT * FROM assets WHERE id = ?", [$job["assetid"]]);
if (empty($asset)) {
    die("Invalid asset");
}

header("Content-Type: text/plain");
?>
local placeId, sleeptime, port, url = <?= $job["assetid"] ?>, 0, <?= $job["port"] ?>, "http://<?= $settings["site"]["baseUrl"] ?>"
local test = false

------------------- UTILITY FUNCTIONS --------------------------

-- This code might move to C++
function characterRessurection(player)
	if player.Character then
		local humanoid = player.Character.Humanoid
		humanoid.Died:connect(function() wait(5)
			if player then
				player:LoadCharacter()
			end
		end)
	end
end

-----------------------------------END UTILITY FUNCTIONS -------------------------

-----------------------------------"CUSTOM" SHARED CODE----------------------------------



pcall(function() settings().Diagnostics:LegacyScriptMode() end)

-----------------------------------START GAME SHARED SCRIPT------------------------------

local scriptContext = game:GetService('ScriptContext')
scriptContext.ScriptsDisabled = true

if not test then
    pcall(function() game:SetCreatorID(<?= $asset["creatorid"] ?>, Enum.CreatorType.User) end)
    pcall(function() game:SetPlaceID(placeId, true) end)
    pcall(function() players.MaxPlayers = <?= $job["maxplayers"] ?> end)
end

-- establish this peer as the Server
local ns = game:GetService("NetworkServer")

pcall(function() game:GetService("Players"):SetAbuseReportUrl(url .. "/AbuseReport/InGameChatHandler.ashx") end)
pcall(function() game:GetService("ScriptInformationProvider"):SetAssetUrl(url .. "/Asset/") end)
pcall(function() game:GetService("ContentProvider"):SetBaseUrl(url .. "/") end)
--pcall(function() game:GetService("Players"):SetChatFilterUrl(url .. "/Game/ChatFilter.ashx") end)

shared["__time"] = 0
game:GetService("RunService").Stepped:connect(function (time) shared["__time"] = time end)

game:GetService("Players").PlayerAdded:connect(function(player)
   	if not test then
        print(url .. "/Game/JoinControl.ashx?Action=Join&UserId="..player.userId.."&jobID=".."<?= $job["jobid"] ?>".."&accessKey=<?= $settings["site"]["securitykey"] ?>")
	    dofile(url .. "/Game/JoinControl.ashx?Action=Join&UserId="..player.userId.."&jobID=".."<?= $job["jobid"] ?>".."&accessKey=<?= $settings["site"]["securitykey"] ?>")
	end
	print("Player " .. player.userId .. " added")
	characterRessurection(player)
	player.Changed:connect(function(name)
		if name=="Character" then
			characterRessurection(player)
		end
    end)
	delay(2, function()
		if player ~= nil then
			loadfile(url .. "/Game/DeathFunction.ashx")(player)
		end
	end)
end)


game:GetService("Players").PlayerRemoving:connect(function(player)
	print("Player " .. player.userId .. " leaving")
    if not test then
        print(url .. "/Game/JoinControl.ashx?Action=Join&UserId="..player.userId.."&jobID=".."<?= $job["jobid"] ?>".."&accessKey=<?= $settings["site"]["securitykey"] ?>")
	    dofile(url .. "/Game/JoinControl.ashx?Action=Leave&UserId="..player.userId.."&jobID=".."<?= $job["jobid"] ?>".."&accessKey=<?= $settings["site"]["securitykey"] ?>")
	end
end)

if not test then
    -- yield so that file load happens in the heartbeat thread
    wait()

    -- load the game
    game:Load(url .. "/asset/?id=" .. <?= $asset["assetid"] ?> .. "&securityKey=<?= $settings["site"]["securitykey"] ?>")
end

-- Now start the connection
ns.ChildAdded:connect(function(child) child.Name = "Connection" end)
ns:Start(port, sleeptime)

scriptContext.ScriptsDisabled = false

------------------------------END START GAME SHARED SCRIPT--------------------------

-- StartGame --
game:GetService("RunService"):Run()