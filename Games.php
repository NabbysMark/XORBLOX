<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php"; ?>
<?php
$page = $_GET["p"] ?? 1;
$assets = $db->fetchAll("SELECT * FROM assets WHERE category = 9");

requireLogin();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php Component::Render("head"); ?>
    </head>
    <body>
        <div id="Container">
            <?php Component::Render("nav"); ?>
            <div id="Body">
                <div id="GamesContainer">
        
<div id="ctl00_cphRoblox_rbxGames_GamesContainerPanel">
	
    <div class="DisplayFilters">
	    <h2>Games&nbsp;<a id="ctl00_cphRoblox_rbxGames_hlNewsFeed" href="/Games.aspx?feed=rss"><img src="/images/feed-icons/feed-icon-14x14.png" alt="RSS" border="0"></a></h2>
	    <div id="BrowseMode">
		    <h4>Browse</h4>
		    <ul>
			    <li><img id="ctl00_cphRoblox_rbxGames_MostPopularBullet" class="GamesBullet" src="/images/games_bullet.png" alt="Bullet" border="0"><a id="ctl00_cphRoblox_rbxGames_hlMostPopular" href="Games.aspx?m=MostPopular&amp;t=Now"><b>Most Popular</b></a></li>
			    <li><a id="ctl00_cphRoblox_rbxGames_hlTopFavorites" href="Games.aspx?m=TopFavorites&amp;t=AllTime">Top Favorites</a></li>
			    <li><a id="ctl00_cphRoblox_rbxGames_hlRecentlyUpdated" href="Games.aspx?m=RecentlyUpdated">Recently Updated</a></li>
			    <li><a id="ctl00_cphRoblox_rbxGames_hlFeatured" href="User.aspx?id=1">Featured Games</a></li>
		    </ul>
	    </div>
	    <div id="ctl00_cphRoblox_rbxGames_pTimespan">
		
		    <div id="Timespan">
			    <h4>Time</h4>
			    <ul>
				    <li><img id="ctl00_cphRoblox_rbxGames_TimespanNowBullet" class="GamesBullet" src="/images/games_bullet.png" alt="Bullet" border="0"><a id="ctl00_cphRoblox_rbxGames_hlTimespanNow" href="Games.aspx?m=MostPopular&amp;t=Now"><b>Now</b></a></li>
				    <li><a id="ctl00_cphRoblox_rbxGames_hlTimespanPastDay" href="Games.aspx?m=MostPopular&amp;t=PastDay">Past Day</a></li>
				    <li><a id="ctl00_cphRoblox_rbxGames_hlTimespanPastWeek" href="Games.aspx?m=MostPopular&amp;t=PastWeek">Past Week</a></li>
				   <!-- <li><a id="ctl00_cphRoblox_rbxGames_hlTimespanPastMonth" href="Games.aspx?m=MostPopular&amp;t=PastMonth">Past Month</a></li> -->
				    <li><a id="ctl00_cphRoblox_rbxGames_hlTimespanAllTime" href="Games.aspx?m=MostPopular&amp;t=AllTime">All-time</a></li>
			    </ul>
		    </div>
	    
	</div>
    </div>
    <div id="Games">
        <span id="ctl00_cphRoblox_rbxGames_lGamesDisplaySet" class="GamesDisplaySet">Most Popular (Now)</span>
        <div id="ctl00_cphRoblox_rbxGames_HeaderPagerPanel" class="HeaderPager">
            
	        <span id="ctl00_cphRoblox_rbxGames_HeaderPagerLabel">Page 1 of 34:</span>
	        <a id="ctl00_cphRoblox_rbxGames_hlHeaderPager_Next" href="Games.aspx?m=MostPopular&amp;t=Now&amp;p=2">Next <span class="NavigationIndicators">&gt;&gt;</span></a>
	    </div>
        <table id="ctl00_cphRoblox_rbxGames_dlGames" cellspacing="0" align="Center" border="0" width="550">
		<tbody>
            <?php $count = 0; ?>
            <?php foreach ($assets as $asset): ?>
            <?php $count++; ?>
            <?php if ($count === 1): ?>
            <tr>
            <?php endif; ?>
                <td class="Game" valign="top">
                    <div style="padding-bottom:5px">
                        <div class="GameThumbnail">
                            <a id="ctl00_cphRoblox_rbxGames_dlGames_ctl12_ciGame" title="<?= htmlspecialchars($asset["name"]) ?>" href="/Item.aspx?ID=<?= $asset["id"] ?>" style="display:inline-block;cursor:pointer;"><img src="/Thumbs/Asset.asmx?assetId=<?= $asset["id"] ?>&x=160&y=100" border="0" alt="<?= htmlspecialchars($asset["name"]) ?>" blankurl="http://t0.roblox.com:80/blank-160x100.gif"></a>
                        </div>
                        <div class="GameDetails">
                            <div class="GameName"><a id="ctl00_cphRoblox_rbxGames_dlGames_ctl12_hlGameName" href="/Item.aspx?ID=<?= $asset["id"] ?>"><?= htmlspecialchars($asset["name"]) ?></a></div>
                            <div class="GameLastUpdate"><span class="Label">Updated:</span> <span class="Detail"><?= DateFormatter::TimeAgo($asset["updated_at"]); ?></span></div>
                            <div class="GameCreator"><span class="Label">Creator:</span> <span class="Detail"><a id="ctl00_cphRoblox_rbxGames_dlGames_ctl12_hlGameCreator" href="/User.aspx?ID=209954">Orbitor</a></span></div>
                            <div class="AssetFavorites"><span class="Label">Favorited:</span> <span class="Detail"><?= number_format($asset["favorites"]) ?> times</span></div>
                            <div class="GamePlays"><span class="Label">Played:</span> <span class="Detail">2,165 times</span></div>
                            <div id="ctl00_cphRoblox_rbxGames_dlGames_ctl12_pGameCurrentPlayers">
                                <div class="GameCurrentPlayers"><span class="DetailHighlighted">65 players online</span></div> 
                            </div>
                        </div>
                    </div>
                </td>
            <?php if ($count === 3): ?>
		    </tr>
            <?php endif; ?>
            <?php if ($count === 3) { $count = 0; }?>
            <?php endforeach; ?>
	</tbody></table>
        <div id="ctl00_cphRoblox_rbxGames_FooterPagerPanel" class="HeaderPager">
            
            <span id="ctl00_cphRoblox_rbxGames_FooterPagerLabel">Page 1 of 34:</span>
            <a id="ctl00_cphRoblox_rbxGames_hlFooterPager_Next" href="Games.aspx?m=MostPopular&amp;t=Now&amp;p=2">Next <span class="NavigationIndicators">&gt;&gt;</span></a>
        </div>
    </div>

</div>
        
<div class="Ads_WideSkyscraper" style="width: 160px;height:600px;border: 1px solid">
    
</div>

        <div style="clear: both;"></div>
    </div>
            </div>
            <?php Component::Render("footer"); ?>
        </div>
    </body>
</html>