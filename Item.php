<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php"; ?>
<?php 
$id = $_GET["ID"] ?? $_GET["id"] ?? null;

if (empty($id)) {
    http_response_code(404);
    header("Location: /Error/Default.aspx");
    exit;
}

$asset = $db->fetch("SELECT * FROM assets WHERE id = ?", [$id]);

if (empty($asset)) {
    http_response_code(404);
    header("Location: /Error/Default.aspx");
    exit;
}

$creator = $db->fetch("SELECT * FROM users WHERE id = ?", [$asset["creatorid"]]);
$isPlace = $asset["category"] == 9;
$assetTitle = null;

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

if ($asset["category"] == 9) {
    $assetTitle = "Place";
}

$comments = $db->fetchAll("SELECT * FROM comments WHERE assetid = ? LIMIT ? OFFSET ?", [$asset["id"], $limit, $offset]);
$commentsCount = $db->fetch("SELECT COUNT(*) AS count FROM comments WHERE assetid = ?", [$asset["id"]]);
$commentsCount = (int)$commentsCount["count"];

$totalPages = ceil($commentsCount / $limit);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? null;

    if (!isset($_USER)) {
        http_response_code(403);
        header("Location: /Error/Default.aspx");
        exit;
    }

    if ($action === "comment") {
        $content = $_POST["content"] ?? null;
        if (empty($content)) {
            http_response_code(400);
            header("Location: /Error/Default.aspx");
            exit;
        }

        $db->insert("INSERT INTO comments (creatorid, assetid, content) VALUES (?, ?, ?)", [$_USER["id"], $asset["id"], $content]);
        header("Location: /Item.aspx?ID=".$asset["id"]."#tab=Comments");
    }
}
requireLogin(); 
?>
<!DOCTYPE html>
<html>
    <head>
        <?php Component::Render("head", ["title" => $asset["name"] . " by " . $creator["username"] . " - XORBLOX " . $assetTitle . "s"]); ?>
        <script type="text/javascript" src="/JS/Tabs.js?v=<?= rand(1,999) ?>"></script>
    </head>
    <body>
        <div id="Container">
            <?php Component::Render("nav"); ?>
            <div id="Body">
                <div id="ItemContainer">
		<div id="Item">
		    <h2><?= htmlspecialchars($asset["name"]) ?></h2>
		    <div id="Details">
		        
		                <div id="Thumbnail_Place">
				            <a id="ctl00_cphRoblox_AssetThumbnailImage_Place" disabled="disabled" title="Build to Survive ≈ Tsunami™" onclick="return false" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t7.roblox.com:80/81ef111a574fe5f5b973e3fc5da3cbaf" border="0" alt="Build to Survive ≈ Tsunami™" blankurl="http://t1.roblox.com:80/blank-420x230.gif"></a>
			            </div>
			            <div id="Actions_Place">
			                <a id="ctl00_cphRoblox_FavoriteThisPlaceButton" disabled="disabled">Favorite</a>
			            </div>
		                <div id="ctl00_cphRoblox_PlayGames" class="PlayGames">
		                    <div style="text-align: center; margin: 1em 5px;">
                                <span id="ctl00_cphRoblox_PlaceAccessIndicator_FriendsOnlyLocked" style="display: none"><img id="ctl00_cphRoblox_PlaceAccessIndicator_iFriendsOnly_Locked" src="/images/locked.png" alt="Locked" border="0">&nbsp;Friends-only</span>
                                <span id="ctl00_cphRoblox_PlaceAccessIndicator_FriendsOnlyUnlocked" style="display: none"><img id="ctl00_cphRoblox_PlaceAccessIndicator_iFriendsOnly_Unlocked" src="/web/20080614231840im_/http://www.roblox.com/images/unlocked.png" alt="Unlocked" border="0">&nbsp;Friends-only: You have access</span>
                                <span id="ctl00_cphRoblox_PlaceAccessIndicator_Public" style="display:inline;"><img id="ctl00_cphRoblox_PlaceAccessIndicator_iPublic" src="/images/public.png" alt="Public" border="0">&nbsp;Public</span>

                                                                <img id="ctl00_cphRoblox_CopyLockedIcon" src="/images/CopyLocked.png" alt="CopyLocked" border="0">
                                                                Copy Protection: CopyLocked
                                                            </div>
                                                            <div id="ctl00_cphRoblox_VisitButtons_VisitMPButton" style="display:inline">
                                    
                                <div id="ctl00_cphRoblox_VisitButtons_rbxPlaceLauncher_Panel1" class="modalPopup" style="display: none">
                                    
                                    <div style="margin: 1.5em">
                                        <div id="Spinner" style="float:left;margin:0 1em 1em 0">
                                            <img id="ctl00_cphRoblox_VisitButtons_rbxPlaceLauncher_Image1" src="/web/20080614231840im_/http://www.roblox.com/images/ProgressIndicator2.gif" alt="Progress" border="0"></div>
                                        <div id="Requesting" style="display: inline">
                                            Requesting a server</div>
                                        <div id="Waiting" style="display: none">
                                            Waiting for a server</div>
                                        <div id="Loading" style="display: none">
                                            A server is loading the game</div>
                                        <div id="Joining" style="display: none">
                                            The server is ready. Joining the game...</div>
                                        <div id="Error" style="display: none">
                                            An error occured. Please try again later</div>
                                        <div id="Expired" style="display: none">
                                            There are no game servers available at this time. Please try again later</div>
                                        <div id="GameEnded" style="display: none">
                                            The game you requested has ended</div>
                                        <div id="GameFull" style="display: none">
                                            The game you requested is full. Please try again later</div>
                                        <div style="text-align: center; margin-top: 1em">
                                            <input id="Cancel" type="button" class="Button" value="Cancel"></div>
                                    </div>

                                </div>
                                <input type="hidden" name="ctl00$cphRoblox$VisitButtons$rbxPlaceLauncher$HiddenField1" id="ctl00_cphRoblox_VisitButtons_rbxPlaceLauncher_HiddenField1">


                                    <button id="ctl00_cphRoblox_VisitButtons_hlMultiplayerVisit" class="Button" onclick="window.location = '/Login/Default.aspx?ReturnUrl=http%3a%2f%2fwww.roblox.com%2fItem.aspx%3fID%3d402172'; return false;">Visit Online</button>
                                </div>
                                <div id="ctl00_cphRoblox_VisitButtons_VisitButton" style="display:inline">
                                    &nbsp;&nbsp;&nbsp;<button id="ctl00_cphRoblox_VisitButtons_hlSoloVisit" class="Button" onclick="window.location = '/Login/Default.aspx?ReturnUrl=http%3a%2f%2fwww.roblox.com%2fItem.aspx%3fID%3d402172'; return false;">Visit Solo</button>
                                </div>

                                                        </div>
                                                    
                                                <div id="Summary" >
                                                    <h3>XORBLOX <?= $assetTitle ?></h3>
                                                    
                                                    
                                                    
                                                    <div id="Creator" class="Creator">
                                                        <div class="Avatar">
                                                            <a id="ctl00_cphRoblox_AvatarImage" title="<?= $creator["username"] ?>" href="/User.aspx?ID=<?= $creator["id"] ?>" style="display:inline-block;cursor:pointer;"><img src="/Thumbs/Avatar.ashx?username=<?= $creator["username"] ?>&x=100&y=100&format=Png" border="0" alt="<?= $creator["username"] ?>" blankurl="http://t6.roblox.com:80/blank-100x100.gif"></a>
                                                        </div>
                                                        Creator: <a id="ctl00_cphRoblox_CreatorHyperLink" href="User.aspx?ID=<?= $creator["id"] ?>"><?= htmlspecialchars($creator["username"]) ?></a>
                                                    </div>
                                                    <div id="LastUpdate">Updated: <?= DateFormatter::TimeAgo($asset["created_at"]) ?></div>
                                                    <div id="Favorited">Favorited: 1,819 times</div>
                                                    <div id="ctl00_cphRoblox_VisitedPanel" class="Visited">Visited: 42,469 times</div>
                                                    <?php if (!empty($asset["description"])): ?>
                                                    <div id="ctl00_cphRoblox_DescriptionPanel">
                                                        <div id="DescriptionLabel">Description:</div>
                                                        <div id="Description"><?= nl2br(htmlspecialchars($asset["description"])) ?>h</div>
                                                    </div>
                                                    <?php endif; ?>
                                                    <div id="ReportAbuse"><div id="ctl00_cphRoblox_AbuseReportButton1_AbuseReportPanel" class="ReportAbusePanel">
                                    
                                    <span class="AbuseIcon"><a id="ctl00_cphRoblox_AbuseReportButton1_ReportAbuseIconHyperLink" href="AbuseReport/AssetVersion.aspx?ID=3298297&amp;ReturnUrl=http%3a%2f%2fwww.roblox.com%2fItem.aspx%3fID%3d402172"><img src="/images/abuse.PNG" alt="Report Abuse" border="0"></a></span>
                                    <span class="AbuseButton"><a id="ctl00_cphRoblox_AbuseReportButton1_ReportAbuseTextHyperLink" href="AbuseReport/AssetVersion.aspx?ID=3298297&amp;ReturnUrl=http%3a%2f%2fwww.roblox.com%2fItem.aspx%3fID%3d402172">Report Abuse</a></span>

                                </div></div>
                                                </div>
                                                
                                                
                                                <div style="clear: both;"></div>
                                            </div>
                                            <div style="margin: 10px; width: 703px;">
                                                <div class="ajax__tab_xp ajax__tab_container ajax__tab_default" id="ctl00_cphRoblox_TabbedInfo">
                                                    <div id="ctl00_cphRoblox_TabbedInfo_header" class="ajax__tab_header">
                                                        <?php if ($isPlace): ?>
                                                        <span id="tab11" class="ajax__tab ajax__tab_active">
                                                            <span class="ajax__tab_outer">
                                                                <span class="ajax__tab_inner">
                                                                    <a class="ajax__tab_tab ajax__tab ajax__tab_active" id="__tab_TabbedInfo_GamesTab" onclick="activateTab('ctl00_cphRoblox_TabbedInfo_CommentaryTab','ctl00_cphRoblox_TabbedInfo_GamesTab');" style="cursor: pointer;">
                                                                        <h3>Games</h3>
                                                                    </a>
                                                                </span>
                                                            </span>
                                                        </span>
                                                        <?php endif; ?>
                                                        <span id="tab22" class="ajax__tab <?= $isPlace ? "" : "ajax__tab_active" ?>">
                                                            <span class="ajax__tab_outer">
                                                                <span class="ajax__tab_inner">
                                                                    <a class="ajax__tab_tab ajax__tab" id="__tab_TabbedInfo_CommentaryTab" onclick="activateTab('ctl00_cphRoblox_TabbedInfo_GamesTab','ctl00_cphRoblox_TabbedInfo_CommentaryTab');" style="cursor: pointer;">
                                                                        <h3>Commentary</h3>
                                                                    </a>
                                                                </span>
                                                            </span>
                                                        </span>

                                                    </div>
                                                <div id="ctl00_cphRoblox_TabbedInfo_body" class="ajax__tab_body">
                                        <div id="ctl00_cphRoblox_TabbedInfo_GamesTab">
                                            
                                                            <div id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesUpdatePanel">
                                                
                                                                    
                                                                    <table id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList" cellspacing="0" border="0" width="100%">
                                                    <tbody><tr>
                                                        <td>
                                                                            <div class="GameInstance" style="margin: 3px 0">
                                                                                <div style="float: right;">
                                                                                    
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl00_PlayersRepeater_ctl00_PlayerImage" disabled="disabled" title="bogyman36" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=417333" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t7.roblox.com:80/8c798bec4e354d835e3096af22ca1c35" border="0" alt="bogyman36"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl00_PlayersRepeater_ctl01_PlayerImage" disabled="disabled" title="fregry" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=492796" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t4.roblox.com:80/0b206cd4ce99796069a2191595a56886" border="0" alt="fregry"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl00_PlayersRepeater_ctl02_PlayerImage" disabled="disabled" title="rho531" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=328055" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t6.roblox.com:80/e5be5396c849f892680042e72a568b51" border="0" alt="rho531"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl00_PlayersRepeater_ctl03_PlayerImage" disabled="disabled" title="babycat205" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=379646" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t0.roblox.com:80/f8b48efb210a35581dd1e8a666e3996e" border="0" alt="babycat205"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl00_PlayersRepeater_ctl04_PlayerImage" disabled="disabled" title="thebloodman3" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=405382" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t1.roblox.com:80/a72f31f57d12c3bfd3971e0423a99c03" border="0" alt="thebloodman3"></a>
                                                                                        
                                                                                </div>
                                                                                <div style="text-align: left;">
                                                                                    5 players of 6 max<br>
                                                                                    &nbsp;
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                    </tr><tr>
                                                        <td>
                                                                            <div class="GameInstance" style="margin: 3px 0">
                                                                                <div style="float: right;">
                                                                                    
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl01_PlayersRepeater_ctl00_PlayerImage" disabled="disabled" title="dronkey15" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=129143" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t5.roblox.com:80/192f8030806ae40048f8a6d26bbc6cb2" border="0" alt="dronkey15"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl01_PlayersRepeater_ctl01_PlayerImage" disabled="disabled" title="sirflamingbut" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=462205" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t3.roblox.com:80/0290cd3b871a5f8b512b19d71ffdab5c" border="0" alt="sirflamingbut"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl01_PlayersRepeater_ctl02_PlayerImage" disabled="disabled" title="cheeselad36" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=516875" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t6.roblox.com:80/7d7dd2f8b3c2e2167a27e3d05dc7e7f9" border="0" alt="cheeselad36"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl01_PlayersRepeater_ctl03_PlayerImage" disabled="disabled" title="Saroos" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=506328" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t4.roblox.com:80/a73b868b788ac4fc6489b8127443b585" border="0" alt="Saroos"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl01_PlayersRepeater_ctl04_PlayerImage" disabled="disabled" title="MXrules" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=512467" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t5.roblox.com:80/085dc491f79048ae379be38b0949a211" border="0" alt="MXrules"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl01_PlayersRepeater_ctl05_PlayerImage" disabled="disabled" title="batmanrules" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=516029" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t5.roblox.com:80/b02cce5c7c1fddc063dc4a3acb664c3a" border="0" alt="batmanrules"></a>
                                                                                        
                                                                                </div>
                                                                                <div style="text-align: left;">
                                                                                    6 players of 6 max<br>
                                                                                    &nbsp;
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                    </tr><tr>
                                                        <td>
                                                                            <div class="GameInstance" style="margin: 3px 0">
                                                                                <div style="float: right;">
                                                                                    
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl02_PlayersRepeater_ctl00_PlayerImage" disabled="disabled" title="BillBashem" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=514918" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t4.roblox.com:80/9459aef9c0c3671ef1b30628da10d418" border="0" alt="BillBashem"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl02_PlayersRepeater_ctl01_PlayerImage" disabled="disabled" title="boombox23" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=514313" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t0.roblox.com:80/d67b1b01821f3abdd143a9104a75809f" border="0" alt="boombox23"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl02_PlayersRepeater_ctl02_PlayerImage" disabled="disabled" title="spy1220me" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=83940" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t2.roblox.com:80/3420d3a8f79d7820c1269721b162152e" border="0" alt="spy1220me"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl02_PlayersRepeater_ctl03_PlayerImage" disabled="disabled" title="wario12321" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=509037" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t3.roblox.com:80/562195948db665a9ffbdfc5ed016829e" border="0" alt="wario12321"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl02_PlayersRepeater_ctl04_PlayerImage" disabled="disabled" title="zenphar" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=171969" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t6.roblox.com:80/5ba3b1563c71d9033c8357a7c4fd6e58" border="0" alt="zenphar"></a>
                                                                                        
                                                                                </div>
                                                                                <div style="text-align: left;">
                                                                                    4 players of 6 max<br>
                                                                                    &nbsp;
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                    </tr><tr>
                                                        <td>
                                                                            <div class="GameInstance" style="margin: 3px 0">
                                                                                <div style="float: right;">
                                                                                    
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl03_PlayersRepeater_ctl00_PlayerImage" disabled="disabled" title="zach839" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=256516" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t0.roblox.com:80/43bcc6480b081707d44428b6f48c5504" border="0" alt="zach839"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl03_PlayersRepeater_ctl01_PlayerImage" disabled="disabled" title="shayneegirl" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=164145" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t6.roblox.com:80/bbe05b758f993e42bbfacb48f057dc3e" border="0" alt="shayneegirl"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl03_PlayersRepeater_ctl02_PlayerImage" disabled="disabled" title="Mikool" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=186162" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t7.roblox.com:80/5681bf104484529e07c3579bc2d69949" border="0" alt="Mikool"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl03_PlayersRepeater_ctl03_PlayerImage" disabled="disabled" title="spartin1117" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=502260" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t4.roblox.com:80/c68dbf6abb80262f4a8d7df86597c63f" border="0" alt="spartin1117"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl03_PlayersRepeater_ctl04_PlayerImage" disabled="disabled" title="Derthmonuter" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=177542" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t6.roblox.com:80/77971ac747c0b81e3459a3da651518af" border="0" alt="Derthmonuter"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl03_PlayersRepeater_ctl05_PlayerImage" disabled="disabled" title="ronniedude" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=356282" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t0.roblox.com:80/0271a84ed4fb0722ea6346cc5a830d2b" border="0" alt="ronniedude"></a>
                                                                                        
                                                                                </div>
                                                                                <div style="text-align: left;">
                                                                                    6 players of 6 max<br>
                                                                                    &nbsp;
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                    </tr><tr>
                                                        <td>
                                                                            <div class="GameInstance" style="margin: 3px 0">
                                                                                <div style="float: right;">
                                                                                    
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl04_PlayersRepeater_ctl00_PlayerImage" disabled="disabled" title="awesome95" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=513537" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t2.roblox.com:80/c9fcf1e1d03f52558de8ba52c413d7d0" border="0" alt="awesome95"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl04_PlayersRepeater_ctl01_PlayerImage" disabled="disabled" title="deano321" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=407141" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t3.roblox.com:80/1a36d033b907856ee1276aaae1346ad9" border="0" alt="deano321"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl04_PlayersRepeater_ctl02_PlayerImage" disabled="disabled" title="brockbuilder" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=86766" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t7.roblox.com:80/b32bd521fea2b225c0063fa2d3ece8f5" border="0" alt="brockbuilder"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl04_PlayersRepeater_ctl03_PlayerImage" disabled="disabled" title="Ravenedgarpoe" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=371231" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t1.roblox.com:80/022c1f4c99ec5239276fdcbabdb7b94c" border="0" alt="Ravenedgarpoe"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl04_PlayersRepeater_ctl04_PlayerImage" disabled="disabled" title="noobkiller63" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=514750" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t7.roblox.com:80/8a9014817cd575cd39c84346ef2c91c9" border="0" alt="noobkiller63"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl04_PlayersRepeater_ctl05_PlayerImage" disabled="disabled" title="Holol" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=144192" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t2.roblox.com:80/4e0730188c34e7052389e17784ea033f" border="0" alt="Holol"></a>
                                                                                        
                                                                                </div>
                                                                                <div style="text-align: left;">
                                                                                    6 players of 6 max<br>
                                                                                    &nbsp;
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                    </tr><tr>
                                                        <td>
                                                                            <div class="GameInstance" style="margin: 3px 0">
                                                                                <div style="float: right;">
                                                                                    
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl05_PlayersRepeater_ctl00_PlayerImage" disabled="disabled" title="LuigiTornado123" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=517856" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t0.roblox.com:80/32526405a6f4e66eaab7fb70328d72da" border="0" alt="LuigiTornado123"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl05_PlayersRepeater_ctl01_PlayerImage" disabled="disabled" title="sisori" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=492924" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t1.roblox.com:80/602cf4af80a3796086c8587322b6e737" border="0" alt="sisori"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl05_PlayersRepeater_ctl02_PlayerImage" disabled="disabled" title="Crazy3101" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=64393" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t4.roblox.com:80/44f0baa8fdb5b6c2d1efdf8684a8c89b" border="0" alt="Crazy3101"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl05_PlayersRepeater_ctl03_PlayerImage" disabled="disabled" title="actor20" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=263578" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t2.roblox.com:80/fe0dccf677436fe4a0152c61d59da323" border="0" alt="actor20"></a>
                                                                                        
                                                                                </div>
                                                                                <div style="text-align: left;">
                                                                                    5 players of 6 max<br>
                                                                                    &nbsp;
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                    </tr><tr>
                                                        <td>
                                                                            <div class="GameInstance" style="margin: 3px 0">
                                                                                <div style="float: right;">
                                                                                    
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl06_PlayersRepeater_ctl00_PlayerImage" disabled="disabled" title="azamyth" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=414963" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t6.roblox.com:80/01cdc51841bed7e2ee02010fad7f0d83" border="0" alt="azamyth"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl06_PlayersRepeater_ctl01_PlayerImage" disabled="disabled" title="Angel072096" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=409649" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t4.roblox.com:80/3604dbf75c5787e02e35f0119eefbbba" border="0" alt="Angel072096"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl06_PlayersRepeater_ctl02_PlayerImage" disabled="disabled" title="funkster" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=360858" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t4.roblox.com:80/73b2a7f30033ca2144d188f119bbcafc" border="0" alt="funkster"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl06_PlayersRepeater_ctl03_PlayerImage" disabled="disabled" title="peter1998" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=513917" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t1.roblox.com:80/2377a48c55e55ac2cc144317d2dd5003" border="0" alt="peter1998"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl06_PlayersRepeater_ctl04_PlayerImage" disabled="disabled" title="Aquadraco" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=385309" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t3.roblox.com:80/11984df7972fb1599b9c3b4efe4ccd5f" border="0" alt="Aquadraco"></a>
                                                                                        
                                                                                </div>
                                                                                <div style="text-align: left;">
                                                                                    5 players of 6 max<br>
                                                                                    &nbsp;
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                    </tr><tr>
                                                        <td>
                                                                            <div class="GameInstance" style="margin: 3px 0">
                                                                                <div style="float: right;">
                                                                                    
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl07_PlayersRepeater_ctl00_PlayerImage" disabled="disabled" title="vt360" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=509368" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t1.roblox.com:80/6f055f73d6e56979cf2c4568dcb510e8" border="0" alt="vt360"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl07_PlayersRepeater_ctl01_PlayerImage" disabled="disabled" title="WILL76" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=252321" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t6.roblox.com:80/0280f847c8ed6e39b38f456c408d74c6" border="0" alt="WILL76"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl07_PlayersRepeater_ctl02_PlayerImage" disabled="disabled" title="Kadara" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=507028" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t2.roblox.com:80/2b34c7c0c9ed6f82b8d5dcd4f57177d9" border="0" alt="Kadara"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl07_PlayersRepeater_ctl03_PlayerImage" disabled="disabled" title="lazuras1" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=507047" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t5.roblox.com:80/eb230ac2f17eb836decbc257027d9159" border="0" alt="lazuras1"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl07_PlayersRepeater_ctl04_PlayerImage" disabled="disabled" title="megadude9" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=209040" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t5.roblox.com:80/fe65ab946218f1f89aaa0f585f2896b7" border="0" alt="megadude9"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl07_PlayersRepeater_ctl05_PlayerImage" disabled="disabled" title="08alex08" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=423641" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t6.roblox.com:80/fc36e126eb5885a363b8a65f04fd7079" border="0" alt="08alex08"></a>
                                                                                        
                                                                                </div>
                                                                                <div style="text-align: left;">
                                                                                    6 players of 6 max<br>
                                                                                    &nbsp;
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                    </tr><tr>
                                                        <td>
                                                                            <div class="GameInstance" style="margin: 3px 0">
                                                                                <div style="float: right;">
                                                                                    
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl08_PlayersRepeater_ctl00_PlayerImage" disabled="disabled" title="luke43" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=275559" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t6.roblox.com:80/46491dcd98da9f2e6dd2666bc0d72310" border="0" alt="luke43"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl08_PlayersRepeater_ctl01_PlayerImage" disabled="disabled" title="tomchris" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=469812" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t5.roblox.com:80/c843405718f99910461ce6d2534429b5" border="0" alt="tomchris"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl08_PlayersRepeater_ctl02_PlayerImage" disabled="disabled" title="nickrules" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=448202" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t0.roblox.com:80/cd2741da9b413f72113dbb547ca32e26" border="0" alt="nickrules"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl08_PlayersRepeater_ctl03_PlayerImage" disabled="disabled" title="wats0up" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=410524" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t0.roblox.com:80/c5c44e148943ba0c65963735310bbc92" border="0" alt="wats0up"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl08_PlayersRepeater_ctl04_PlayerImage" disabled="disabled" title="patrickl10132" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=117642" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t3.roblox.com:80/2699e834c969d12b2164b4d03ee856ed" border="0" alt="patrickl10132"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl08_PlayersRepeater_ctl05_PlayerImage" disabled="disabled" title="EMB" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=516260" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t5.roblox.com:80/b02cce5c7c1fddc063dc4a3acb664c3a" border="0" alt="EMB"></a>
                                                                                        
                                                                                </div>
                                                                                <div style="text-align: left;">
                                                                                    6 players of 6 max<br>
                                                                                    &nbsp;
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                    </tr><tr>
                                                        <td>
                                                                            <div class="GameInstance" style="margin: 3px 0">
                                                                                <div style="float: right;">
                                                                                    
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl09_PlayersRepeater_ctl00_PlayerImage" disabled="disabled" title="BlueSoda4U" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=509926" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t5.roblox.com:80/8b8f586ca223e5c0fbed2bff09a86bf0" border="0" alt="BlueSoda4U"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl09_PlayersRepeater_ctl01_PlayerImage" disabled="disabled" title="WinCamVista" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=508684" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t1.roblox.com:80/6e627f87a534d3f770c98e3d1dffb497" border="0" alt="WinCamVista"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl09_PlayersRepeater_ctl02_PlayerImage" disabled="disabled" title="Slayer2000" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=355696" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t5.roblox.com:80/a67c1c05127d1b09912fb42dfab0b438" border="0" alt="Slayer2000"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl09_PlayersRepeater_ctl03_PlayerImage" disabled="disabled" title="ANDRIC" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=339432" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t0.roblox.com:80/5f92df49096446883cd47bd41c0e606c" border="0" alt="ANDRIC"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl09_PlayersRepeater_ctl04_PlayerImage" disabled="disabled" title="danyaal" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=444453" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t1.roblox.com:80/0a90d25276ff8553a8bf7beda3c4d76d" border="0" alt="danyaal"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl09_PlayersRepeater_ctl05_PlayerImage" disabled="disabled" title="DarkOblivion" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=300871" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t1.roblox.com:80/d2efb9007bbef26ddf2fdd9dd6092d20" border="0" alt="DarkOblivion"></a>
                                                                                        
                                                                                </div>
                                                                                <div style="text-align: left;">
                                                                                    6 players of 6 max<br>
                                                                                    &nbsp;
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                    </tr><tr>
                                                        <td>
                                                                            <div class="GameInstance" style="margin: 3px 0">
                                                                                <div style="float: right;">
                                                                                    
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl10_PlayersRepeater_ctl00_PlayerImage" disabled="disabled" title="njr" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=517550" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t0.roblox.com:80/779e02afaf824ec5b6fee55ad0a87cb4" border="0" alt="njr"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl10_PlayersRepeater_ctl01_PlayerImage" disabled="disabled" title="urmomlolz" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=262578" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t3.roblox.com:80/d500b5e87d8716bfffe6894e54bb4107" border="0" alt="urmomlolz"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl10_PlayersRepeater_ctl02_PlayerImage" disabled="disabled" title="emoking" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=279651" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t0.roblox.com:80/2b1a16a29429163fdd33ab94bb4b0cc7" border="0" alt="emoking"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl10_PlayersRepeater_ctl03_PlayerImage" disabled="disabled" title="flare1997" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=475606" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t2.roblox.com:80/3fd46ae74311610359608461bdafc665" border="0" alt="flare1997"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl10_PlayersRepeater_ctl04_PlayerImage" disabled="disabled" title="Eskavuska" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=30540" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t4.roblox.com:80/39f073635a7d76b1f8c3b22210fa21ff" border="0" alt="Eskavuska"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl10_PlayersRepeater_ctl05_PlayerImage" disabled="disabled" title="claudeee" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=108963" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t5.roblox.com:80/dc0c95816a07fd01c5b6c7b95fbd5cb4" border="0" alt="claudeee"></a>
                                                                                        
                                                                                </div>
                                                                                <div style="text-align: left;">
                                                                                    6 players of 6 max<br>
                                                                                    &nbsp;
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                    </tr><tr>
                                                        <td>
                                                                            <div class="GameInstance" style="margin: 3px 0">
                                                                                <div style="float: right;">
                                                                                    
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl11_PlayersRepeater_ctl00_PlayerImage" disabled="disabled" title="Nilz" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=374456" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t2.roblox.com:80/92fc1d79cfb974704d16fd978a0d57ce" border="0" alt="Nilz"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl11_PlayersRepeater_ctl01_PlayerImage" disabled="disabled" title="gunslidincarrotjeff" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=497810" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t5.roblox.com:80/dd254f8fd09325b6f5bd08918a6dbe3f" border="0" alt="gunslidincarrotjeff"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl11_PlayersRepeater_ctl02_PlayerImage" disabled="disabled" title="Ace413740" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=508572" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t0.roblox.com:80/1c4ae2eb506100371243d8073783758d" border="0" alt="Ace413740"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl11_PlayersRepeater_ctl03_PlayerImage" disabled="disabled" title="kris122" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=146918" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t6.roblox.com:80/d1364cae189b008d9911652b102c1af9" border="0" alt="kris122"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl11_PlayersRepeater_ctl04_PlayerImage" disabled="disabled" title="GarraTheLegoKilla" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=230955" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t1.roblox.com:80/c016d82586880508927bf568cfc70484" border="0" alt="GarraTheLegoKilla"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl11_PlayersRepeater_ctl05_PlayerImage" disabled="disabled" title="shadowleeSP" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=441110" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t3.roblox.com:80/709a701e9b89dcbcf8455134d93c0b34" border="0" alt="shadowleeSP"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl11_PlayersRepeater_ctl06_PlayerImage" disabled="disabled" title="jmam" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=361417" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t3.roblox.com:80/4cd2d2799b08ddca05479e6027659924" border="0" alt="jmam"></a>
                                                                                        
                                                                                </div>
                                                                                <div style="text-align: left;">
                                                                                    6 players of 6 max<br>
                                                                                    &nbsp;
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                    </tr><tr>
                                                        <td>
                                                                            <div class="GameInstance" style="margin: 3px 0">
                                                                                <div style="float: right;">
                                                                                    
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl12_PlayersRepeater_ctl00_PlayerImage" disabled="disabled" title="zemagris" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=245039" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t2.roblox.com:80/cc96263b098b09584840c1ecc903ce74" border="0" alt="zemagris"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl12_PlayersRepeater_ctl01_PlayerImage" disabled="disabled" title="genodragon" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=80069" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t7.roblox.com:80/bdeb8aacc313e95b0446876b89db71cd" border="0" alt="genodragon"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl12_PlayersRepeater_ctl02_PlayerImage" disabled="disabled" title="MrChubbles" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=509944" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t6.roblox.com:80/6cd809833171243c27891d523a5dceba" border="0" alt="MrChubbles"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl12_PlayersRepeater_ctl03_PlayerImage" disabled="disabled" title="ClaudeSpeed" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=489915" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t1.roblox.com:80/e997c0c4b49f36b82335da75231a3914" border="0" alt="ClaudeSpeed"></a>
                                                                                        
                                                                                </div>
                                                                                <div style="text-align: left;">
                                                                                    4 players of 6 max<br>
                                                                                    &nbsp;
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                    </tr><tr>
                                                        <td>
                                                                            <div class="GameInstance" style="margin: 3px 0">
                                                                                <div style="float: right;">
                                                                                    
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl13_PlayersRepeater_ctl00_PlayerImage" disabled="disabled" title="jasonrockstheworld" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=126543" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t5.roblox.com:80/a6cb8fce6e90f401a69ab8aa5f0a239b" border="0" alt="jasonrockstheworld"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl13_PlayersRepeater_ctl01_PlayerImage" disabled="disabled" title="warlord2" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=397205" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t5.roblox.com:80/0482aea1a60b1b353212de47738d3ed2" border="0" alt="warlord2"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl13_PlayersRepeater_ctl02_PlayerImage" disabled="disabled" title="TrainMaster4" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=232519" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t3.roblox.com:80/e4111a153e70870a71bebf2ad02b0268" border="0" alt="TrainMaster4"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl13_PlayersRepeater_ctl03_PlayerImage" disabled="disabled" title="peewee22" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=455082" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t2.roblox.com:80/5e3b6f74b1e03abdc3148f56a4214258" border="0" alt="peewee22"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl13_PlayersRepeater_ctl04_PlayerImage" disabled="disabled" title="awesomeman85" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=236060" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t4.roblox.com:80/ac6b807ada670a1c2827ab4129261b98" border="0" alt="awesomeman85"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl13_PlayersRepeater_ctl05_PlayerImage" disabled="disabled" title="zack9090" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=328365" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t4.roblox.com:80/78a88bc7e897080ecea89ebdedc3cb3c" border="0" alt="zack9090"></a>
                                                                                        
                                                                                </div>
                                                                                <div style="text-align: left;">
                                                                                    6 players of 6 max<br>
                                                                                    &nbsp;
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                    </tr><tr>
                                                        <td>
                                                                            <div class="GameInstance" style="margin: 3px 0">
                                                                                <div style="float: right;">
                                                                                    
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl14_PlayersRepeater_ctl00_PlayerImage" disabled="disabled" title="3392901" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=443887" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t0.roblox.com:80/0c4a41eb6dd9387780ef7e340c898663" border="0" alt="3392901"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl14_PlayersRepeater_ctl01_PlayerImage" disabled="disabled" title="larry065" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=402015" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t7.roblox.com:80/c6cdee576135c9b311dcf03974b7b6c8" border="0" alt="larry065"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl14_PlayersRepeater_ctl02_PlayerImage" disabled="disabled" title="funk482" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=243097" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t4.roblox.com:80/69cb8ca85c5a01e715e4bca8a80a81ac" border="0" alt="funk482"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl14_PlayersRepeater_ctl03_PlayerImage" disabled="disabled" title="Ian909" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=177569" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t1.roblox.com:80/65274b176877adf75a5bc5c94ed455e9" border="0" alt="Ian909"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl14_PlayersRepeater_ctl04_PlayerImage" disabled="disabled" title="Blake11499" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=48175" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t5.roblox.com:80/54ec742872c02cc2673a6b49a299fec3" border="0" alt="Blake11499"></a>
                                                                                        
                                                                                </div>
                                                                                <div style="text-align: left;">
                                                                                    5 players of 6 max<br>
                                                                                    &nbsp;
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                    </tr><tr>
                                                        <td>
                                                                            <div class="GameInstance" style="margin: 3px 0">
                                                                                <div style="float: right;">
                                                                                    
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl15_PlayersRepeater_ctl00_PlayerImage" disabled="disabled" title="brock456456" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=503251" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t3.roblox.com:80/a07af31a4790dc72784f2c7f06a9635e" border="0" alt="brock456456"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl15_PlayersRepeater_ctl01_PlayerImage" disabled="disabled" title="renceda" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=482879" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t5.roblox.com:80/3216b1852cee225ae98ab4826e8e0ca2" border="0" alt="renceda"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl15_PlayersRepeater_ctl02_PlayerImage" disabled="disabled" title="bnm159" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=393886" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t5.roblox.com:80/2d73be1902fec729b4b7c16b5b604ffa" border="0" alt="bnm159"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl15_PlayersRepeater_ctl03_PlayerImage" disabled="disabled" title="masterzombie" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=430204" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t3.roblox.com:80/757b708bb7a01be084c2eb8158d0747b" border="0" alt="masterzombie"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl15_PlayersRepeater_ctl04_PlayerImage" disabled="disabled" title="megrohungry" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=454387" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t5.roblox.com:80/0b862b5672c1f1b61363de4a1a476a68" border="0" alt="megrohungry"></a>
                                                                                        
                                                                                </div>
                                                                                <div style="text-align: left;">
                                                                                    6 players of 6 max<br>
                                                                                    &nbsp;
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                    </tr><tr>
                                                        <td>
                                                                            <div class="GameInstance" style="margin: 3px 0">
                                                                                <div style="float: right;">
                                                                                    
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl16_PlayersRepeater_ctl00_PlayerImage" disabled="disabled" title="NICKY758" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=158265" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t4.roblox.com:80/4f699b5937fa292381f40c5b3531d74d" border="0" alt="NICKY758"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl16_PlayersRepeater_ctl01_PlayerImage" disabled="disabled" title="wisdom52" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=76529" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t6.roblox.com:80/56dd76710fa79f025c9cb7dcfcba48bf" border="0" alt="wisdom52"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl16_PlayersRepeater_ctl02_PlayerImage" disabled="disabled" title="banana5" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=343493" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t6.roblox.com:80/6f62466de77c7798ffcb6414e3dddefe" border="0" alt="banana5"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl16_PlayersRepeater_ctl03_PlayerImage" disabled="disabled" title="gaurdman" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=517493" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t0.roblox.com:80/779e02afaf824ec5b6fee55ad0a87cb4" border="0" alt="gaurdman"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl16_PlayersRepeater_ctl04_PlayerImage" disabled="disabled" title="OCharlies" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=118066" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t0.roblox.com:80/9d31310d4dca1414d769b718c2e22dc7" border="0" alt="OCharlies"></a>
                                                                                        
                                                                                </div>
                                                                                <div style="text-align: left;">
                                                                                    6 players of 6 max<br>
                                                                                    &nbsp;
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                    </tr><tr>
                                                        <td>
                                                                            <div class="GameInstance" style="margin: 3px 0">
                                                                                <div style="float: right;">
                                                                                    
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl17_PlayersRepeater_ctl00_PlayerImage" disabled="disabled" title="matey98" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=300141" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t0.roblox.com:80/4ff0f7112413e462cda654f5d7618de4" border="0" alt="matey98"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl17_PlayersRepeater_ctl01_PlayerImage" disabled="disabled" title="joshthegreat" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=406478" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t2.roblox.com:80/c9fcf1e1d03f52558de8ba52c413d7d0" border="0" alt="joshthegreat"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl17_PlayersRepeater_ctl02_PlayerImage" disabled="disabled" title="dcswim14" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=485777" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t4.roblox.com:80/a4df14f2b5a691ba99dd8d3acf232790" border="0" alt="dcswim14"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl17_PlayersRepeater_ctl03_PlayerImage" disabled="disabled" title="nickelback" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=82361" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t1.roblox.com:80/f74102c59223962b4e97ffff1e83aa2a" border="0" alt="nickelback"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl17_PlayersRepeater_ctl04_PlayerImage" disabled="disabled" title="erikfonsec0" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=489011" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t1.roblox.com:80/afe2ddbf2ccfaa4784a6479e4c30117b" border="0" alt="erikfonsec0"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl17_PlayersRepeater_ctl05_PlayerImage" disabled="disabled" title="barraki78" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=494726" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t2.roblox.com:80/8c0425e4f1c0626e1bc6ee959c82b7a9" border="0" alt="barraki78"></a>
                                                                                        
                                                                                </div>
                                                                                <div style="text-align: left;">
                                                                                    6 players of 6 max<br>
                                                                                    &nbsp;
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                    </tr><tr>
                                                        <td>
                                                                            <div class="GameInstance" style="margin: 3px 0">
                                                                                <div style="float: right;">
                                                                                    
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl18_PlayersRepeater_ctl00_PlayerImage" disabled="disabled" title="c0dy" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=512864" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t2.roblox.com:80/51afab1c00de647c3839e9b029e1d68b" border="0" alt="c0dy"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl18_PlayersRepeater_ctl01_PlayerImage" disabled="disabled" title="pudgyweasle" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=517589" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t3.roblox.com:80/a655e34cfa0d3b8c9055f7c8936715dc" border="0" alt="pudgyweasle"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl18_PlayersRepeater_ctl02_PlayerImage" disabled="disabled" title="soap217" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=513046" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t6.roblox.com:80/68a40370e8bc0f8f5bf0235981cdd8a5" border="0" alt="soap217"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl18_PlayersRepeater_ctl03_PlayerImage" disabled="disabled" title="fiercetiger37" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=7164" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t6.roblox.com:80/9e3f0e70d849440b7aae3f5cee1cf9ad" border="0" alt="fiercetiger37"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl18_PlayersRepeater_ctl04_PlayerImage" disabled="disabled" title="Lucy1111" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=236097" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t4.roblox.com:80/c0c66bfab4a477ff0b9d00cdf8957918" border="0" alt="Lucy1111"></a>
                                                                                        
                                                                                            <a id="ctl00_cphRoblox_TabbedInfo_GamesTab_RunningGamesDataList_ctl18_PlayersRepeater_ctl05_PlayerImage" disabled="disabled" title="DarthPie" href="/web/20080614231840/http://www.roblox.com/User.aspx?id=329764" style="display:inline-block;"><img src="https://web.archive.org/web/20080614231840im_/http://t7.roblox.com:80/0b20ce82f672b55a944608cd835483c8" border="0" alt="DarthPie"></a>
                                                                                        
                                                                                </div>
                                                                                <div style="text-align: left;">
                                                                                    6 players of 6 max<br>
                                                                                    &nbsp;
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                    </tr>
                                                </tbody></table>
                                                                    <div class="RefreshRunningGames">
                                                                        <input type="submit" name="ctl00$cphRoblox$TabbedInfo$GamesTab$RefreshRunningGamesButton" value="Refresh" id="ctl00_cphRoblox_TabbedInfo_GamesTab_RefreshRunningGamesButton" class="Button">
                                                                    </div>
                                                                
                                            </div>
                                                        
                                        </div><div id="ctl00_cphRoblox_TabbedInfo_CommentaryTab" style="display:none;">
                                            
                                                            <div id="ctl00_cphRoblox_TabbedInfo_CommentaryTab_CommentsPane_CommentsUpdatePanel">
                                                
                                        <div class="CommentsContainer">
                                            
                                                    <h3>Comments (<?= $commentsCount ?>)</h3>
                                                    <div id="ctl00_cphRoblox_TabbedInfo_CommentaryTab_CommentsPane_CommentsRepeater_ctl11_FooterPagerPanel" class="HeaderPager">
                                                        <?php if ($page != 1): ?>
                                                        <a id="ctl00_cphRoblox_TabbedInfo_CommentaryTab_CommentsPane_CommentsRepeater_ctl11_FooterPageSelector_Next" href="&page=<?= $page - 1 ?>">
                                                            <span class="NavigationIndicators"><<</span> Previous
                                                        </a>
                                                        <?php endif; ?>
                                                        <span id="ctl00_cphRoblox_TabbedInfo_CommentaryTab_CommentsPane_CommentsRepeater_ctl11_FooterPagerLabel">Page 1 of <?= $totalPages ?></span>
                                                        <?php if ($page < $totalPages): ?>
                                                        <a id="ctl00_cphRoblox_TabbedInfo_CommentaryTab_CommentsPane_CommentsRepeater_ctl11_FooterPageSelector_Next" href="&page=<?= $page + 1 ?>">
                                                            Next <span class="NavigationIndicators">&gt;&gt;</span>
                                                        </a>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="Comments">
                                                    <?php if (empty($comments)): ?>
                                                    <p style="padding:0px; text-align:left; margin-left:10px;">No comments yet. Be the first!</p>
                                                    <?php else: ?>
                                                    <?php foreach ($comments as $index => $comment): ?>
                                                    <?php $commentcreator = $db->fetch("SELECT * FROM users WHERE id = ?", [$comment["creatorid"]]); ?>
                                                    <div class="<?= $index % 2 ? 'AlternateComment' : 'Comment' ?>">
                                                        <div class="Commenter">
                                                            <div class="Avatar">
                                                                <a id="ctl00_cphRoblox_TabbedInfo_CommentaryTab_CommentsPane_CommentsRepeater_ctl01_AvatarImage" title="<?= htmlspecialchars($commentcreator["username"]) ?>" href="/web/20080614231840/http://www.roblox.com/User.aspx?ID=493323" style="display:inline-block;cursor:pointer;"><img src="https://web.archive.org/web/20080614231840im_/http://t2.roblox.com:80/c76a164a94dcde62e72ea50383269061" border="0" alt="<?= htmlspecialchars($commentcreator["username"]) ?>" blankurl="http://t6.roblox.com:80/blank-64x64.gif"></a></div>
                                                        </div>
                                                        <div class="Post">
                                                            <div class="Audit">
                                                                Posted
                                                                <?= DateFormatter::TimeAgo($comment["created_at"]) ?>
                                                                by
                                                                <a id="ctl00_cphRoblox_TabbedInfo_CommentaryTab_CommentsPane_CommentsRepeater_ctl01_UsernameHyperLink" href="/User.aspx?ID=<?= $comment["creatorid"] ?>"><?= htmlspecialchars($commentcreator["username"]) ?></a>
                                                            </div>
                                                            <div class="Content"><?= nl2br(htmlspecialchars($comment["content"])) ?></div>
                                                            
                                                        </div>
                                                        <div style="clear: both;"></div>
                                                    </div>
                                                    <?php endforeach; ?>
                                                    <?php endif; ?>
                                                    </div>
                                                    <div id="ctl00_cphRoblox_TabbedInfo_CommentaryTab_CommentsPane_CommentsRepeater_ctl11_FooterPagerPanel" class="FooterPager">
                                                        <?php if ($page != 1): ?>
                                                        <a id="ctl00_cphRoblox_TabbedInfo_CommentaryTab_CommentsPane_CommentsRepeater_ctl11_FooterPageSelector_Next" href="&page=<?= $page - 1 ?>">
                                                            <span class="NavigationIndicators"><<</span> Previous
                                                        </a>
                                                        <?php endif; ?>
                                                        <span id="ctl00_cphRoblox_TabbedInfo_CommentaryTab_CommentsPane_CommentsRepeater_ctl11_FooterPagerLabel">Page 1 of <?= $totalPages ?></span>
                                                        <?php if ($page < $totalPages): ?>
                                                        <a id="ctl00_cphRoblox_TabbedInfo_CommentaryTab_CommentsPane_CommentsRepeater_ctl11_FooterPageSelector_Next" href="&page=<?= $page + 1 ?>">
                                                            Next <span class="NavigationIndicators">&gt;&gt;</span>
                                                        </a>
                                                        <?php endif; ?>
                                                    </div>
                                                
                                            
                                        </div>
                                        <?php if (isset($_USER["id"])): ?>
                                        <h3>Comment on this <?= $assetTitle ?></h3>
                                        <div id="PostComment">
                                            <form method="POST">
                                                <input type="hidden" value="comment" name="action">
                                                <textarea name="content" maxlength="2000" rows="3" cols="40" class="MultilineTextBox" required style="width:400px; height:80px;"></textarea>
                                                <br><br>

                                                <button type="submit" class="Button">Post Comment</button>
                                            </form>
                                        </div>
                                        <?php endif; ?>
                                    
                                            </div>
                                                            
                                                        
                                        </div>
                                    </div>
                                </div>
                                            </div>
                                        </div>
                                        
                                <div class="Ads_WideSkyscraper" style="width: 160px;height:600px;border:1px solid;">
                                
                                </div>

                                        <div style="clear: both;">
                                    </div>
                                    
                                    <div id="ctl00_cphRoblox_ItemPurchasePopupPanel" class="modalPopup" style="display: none">
                                    
                                        <div id="ctl00_cphRoblox_ItemPurchasePopupUpdatePanel">
                                        
                                                
                                            
                                    </div>
                                    
                                </div>
                                    
                                    <input type="hidden" name="ctl00$cphRoblox$HiddenField1" id="ctl00_cphRoblox_HiddenField1">
                                    <input type="hidden" name="ctl00$cphRoblox$HiddenField2" id="ctl00_cphRoblox_HiddenField2">
                                    <input type="hidden" name="ctl00$cphRoblox$HiddenField3" id="ctl00_cphRoblox_HiddenField3">
                                    

				</div>
            </div>
            <?php Component::Render("footer"); ?>
        </div>
    </body>
</html>