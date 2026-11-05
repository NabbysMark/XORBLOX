<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php";
$jobID = $_REQUEST["jobID"] ?? null;

if (empty($jobID)) {
    die("Invalid jobID");
}

if (!isset($_USER)) {
    header("Location: /Login/Default.aspx?ReturnUrl=" . urlencode("/game/join.ashx?jobID=".$jobID));
    exit;
}

$job = $db->fetch("SELECT * FROM jobs WHERE jobid = ?", [$jobID]);
if (empty($job)) {
    die("Invalid job");
}

$asset = $db->fetch("SELECT * FROM assets WHERE id = ?", [$job["assetid"]]);
if (empty($asset)) {
    die("Invalid asset");
}

$charapp = "http://{$settings["site"]["baseUrl"]}/Asset/BodyColors.ashx?userId=".$_USER["id"];
$equippedItems = $db->fetch("SELECT * FROM inventory WHERE equipped = 1 AND userid = ?", [$_USER["id"]]);
foreach ($equippedItems ?? [] as $item) {
    $assetItem = $db->fetch("SELECT * FROM assets WHERE id = ?", [$item["assetid"]]);
    $charapp .= "http://{$settings["site"]["baseUrl"]}/asset/?id=".$assetItem["assetid"];
}

header("Content-Type: text/plain");
?>
-- MultiplayerSharedScript.lua inserted here ------ Prepended to GroupBuild.lua and Join.lua --
pcall(function() game:SetPlaceID(1818) end)
pcall(function() settings().Rendering.EnableFRM = true end)

-- arguments ---------------------------------------
local threadSleepTime = ...

if threadSleepTime==nil then
	threadSleepTime = 15
end

local test = false

print("! Joining game '' place -1 at localhost")

pcall(function() game:SetCreatorID(<?= $asset["creatorid"] ?>, Enum.CreatorType.User) end)

local waitingForCharacter = false
local waitingForCharacterGuid = "437626ec-6dad-4775-adcc-99d79b53cf4d";


-- globals -----------------------------------------

client = game:GetService("NetworkClient")
visit = game:GetService("Visit")

-- functions ---------------------------------------
function reportError(err, message)
	print("***ERROR*** " .. err)
	client:Disconnect()
	wait(4)
	game:SetMessage("Error: " .. err)
end

-- called when the client connection closes
function onDisconnection(peer, lostConnection)
	if lostConnection then
		game:SetMessage("You have lost the connection to the game")
	else
		game:SetMessage("This game has shut down")
	end
end

function requestCharacter(replicator)
	-- prepare code for when the Character appears
	local connection
	connection = player.Changed:connect(function (property)
		if property=="Character" then
			game:ClearMessage()
			waitingForCharacter = false
			connection:disconnect()
		end
	end)
	
	game:SetMessage("Requesting character")

	local success, err = pcall(function()	
		replicator:RequestCharacter()
		game:SetMessage("Waiting for character")
		waitingForCharacter = true
	end)
	if not success then
		reportError(err,"W4C")
		return
	end
end

-- called when the client connection is established
function onConnectionAccepted(url, replicator)

	local waitingForMarker = true
	
	local success, err = pcall(function()	
		game:SetMessageBrickCount()
		replicator.Disconnection:connect(onDisconnection)
		
		-- Wait for a marker to return before creating the Player
		local marker = replicator:SendMarker()
		
		marker.Received:connect(function()
			waitingForMarker = false
			requestCharacter(replicator)
		end)
	end)
	
	if not success then
		reportError(err,"ConnectionAccepted")
		return
	end
	
	-- TODO: report marker progress
	
	while waitingForMarker do
		workspace:ZoomToExtents()
		wait(0.5)
	end
end

-- called when the client connection fails
function onConnectionFailed(_, error)
	game:SetMessage("Failed to connect to the Game. (ID=" .. error .. ")")
end

-- called when the client connection is rejected
function onConnectionRejected()
	connectionFailed:disconnect()
	game:SetMessage("This game is not available. Please try another")
end

idled = false
function onPlayerIdled(time)
	if time > 20*60 then
		game:SetMessage(string.format("You were disconnected for being idle %d minutes", time/60))
		client:Disconnect()	
		if not idled then
			idled = true
		end
	end
end

delay(0, function()
	local sound = Instance.new("Sound")
	sound.SoundId = "http://www.roblox.com/asset/?id=1"
	sound.Volume = 0
	sound.Parent = workspace
	sound:Play()
	game:GetService("Debris"):AddItem(sound, 0.1)
end)
-- main ------------------------------------------------------------

local success, err = pcall(function()	
	game:SetMessage("Creating Player")
	player = game:GetService("Players"):CreateLocalPlayer(<?= $_USER["id"] ?>)
	player:SetSuperSafeChat(false)
	player.Idled:connect(onPlayerIdled)
	
	pcall(function() player.Name = [========[<?= $_USER["username"] ?>]========] end)
	player.CharacterAppearance = "<?= $charapp ?>"

	game:SetMessage("Connecting to Server")
	client.ConnectionAccepted:connect(onConnectionAccepted)
	client.ConnectionRejected:connect(onConnectionRejected)
	connectionFailed = client.ConnectionFailed:connect(onConnectionFailed)
	client:Connect("localhost", <?= $job["port"] ?>, 0, threadSleepTime)
end)

if not success then
	reportError(err,"CreatePlayer")
end

pcall(function() game:SetScreenshotInfo("") end)
pcall(function() game:SetVideoInfo("") end)
pcall(function() game:GetService("Visit"):SetUploadUrl("") end)
-- credit to KeyboardCombination
local succ = pcall(function() --check if the metatables are already read only lol
    local canChange = getmetatable(game.Close);
    canChange.__metatable = canChange.__metatable
end)

if not succ then
    return;
end

function readonlytable(table)
    return setmetatable({}, {
        __index = table,
        __newindex = function(table, key, value)
        error("Attempt to modify read-only table")
    end,
        __metatable = false
    });
end

function readonlytablechildren(table)
    for i,v in pairs(table) do
        if type(v)=="table" and table[i]~=_G._G then
            readonlytablechildren(table[i])
            table[i] = readonlytable(table[i])
        end
        if type(v)=="userdata" then
            local mt = getmetatable(table[i])
            if mt~=nil and mt~=false then
                mt.__metatable=false
            end
        end
    end
end
_G.rawset=nil
readonlytablechildren(_G)
_G._G = readonlytable(_G)
mt = getmetatable(game.Changed)
mt.__metatable=false
mt = getmetatable("curse you roblox")
mt.__metatable=false