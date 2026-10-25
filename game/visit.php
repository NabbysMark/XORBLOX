<?php
header("Content-Type: text/plain");

$charapp = "";
?>
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

visit = game:GetService("Visit")

local message = Instance.new("Message")
message.Parent = workspace
message.archivable = false

pcall(function() game:SetScreenshotInfo("") end)
pcall(function() game:SetVideoInfo("") end)

pcall(function() settings().Rendering.EnableFRM = true end)
pcall(function() settings()["Task Scheduler"].PriorityMethod = Enum.PriorityMethod.AccumulatedError end)

workspace:SetPhysicsThrottleEnabled(true)

function doVisit()
	message.Text = "Running"
	game:GetService("RunService"):Run()

	message.Text = "Creating Player"
	player = game:GetService("Players"):CreateLocalPlayer(0)
	player.CharacterAppearance = "<?php echo $charapp ?>"
    player:LoadCharacter()
    characterRessurection(player)
	player.Changed:connect(function(name)
		if name=="Character" then
			characterRessurection(player)
		end
	end)

	message.Text = "Setting GUI"
	player:SetSuperSafeChat(false)
	pcall(function() player:SetUnder13(false) end)
end

success, err = pcall(doVisit)

if success then
	message.Parent = nil
else
	print(err)
	wait(5)
	message.Text = "Error on visit: " .. err
end