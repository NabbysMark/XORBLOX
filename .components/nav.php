<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php";

$unreadmsgs = 0;
?>
<div id="AdvertisingLeaderboard" style="border: 1px solid;width:728px;height:90px;margin-top:4px;">
	<!-- HI ID RECOMMEND DELETING THIS IFRAME IF YOUR ACTUALLY USING THIS FOR A WEBSITE !-->
	<iframe width="728" height="90" style="border:none" src="https://hbaguette.neocities.org/bannerlink/embed.html" name="bannerlink"></iframe>
</div>
<div id="Header">
					<div id="Banner">
						<div id="Options">
							<div id="Authentication">
								<?php if (isset($_SESSION["user_id"])): ?>
								<span id="ctl00_lsLoginStatus">Logged in as <?= $_USER["username"] ?? "" ?> | <a href="/logout.aspx">Logout</a></span>
								<?php else: ?>
								<span><a id="ctl00_lsLoginStatus" href="/Login/Default.aspx">Login</a></span>
								<?php endif; ?>
							</div>
							<div id="Settings">
								<?php if (isset($_SESSION["user_id"])): ?>
								<span id="ctl00_lSettings">Age: 13+, Chat Mode: Safe</span>
								<?php endif; ?>
							</div>
						</div>
						<div id="Logo" style="height: 58px;"><a id="ctl00_rbxImage_Logo" title="XORBLOX" href="/" style="display:inline-block;cursor:pointer;"><img src="/images/roblox_logo.png" border="0" alt="XORBLOX" blankurl="http://t6.roblox.com:80/blank-224x59.gif"></a>
						</div>
						<div id="Alerts"><table style="width:100%;height:100%"><tbody><tr>
							<?php if (isset($_SESSION["user_id"])): ?>
							<td valign="middle">
								<div id="ctl00_rbxAlerts_AlertSpacePanel">
									<div id="AlertSpace">
										<?php if ($unreadmsgs > 0): ?>
										<div id="ctl00_rbxAlerts_MessageAlertPanel">
											<div id="MessageAlert">
												<a id="ctl00_rbxAlerts_MessageAlertIconHyperLink" class="MessageAlertIcon" href="/My/Inbox.aspx"><img src="/images/Message.gif" style="border-width:0px;" /></a>&nbsp;
												<a id="ctl00_rbxAlerts_MessageAlertCaptionHyperLink" class="MessageAlertCaption" href="/My/Inbox.aspx" style="font-size: 12px;font-weight:bold"><?= $unreadmsgs ?> new messages</a>
											</div>   
										</div>
										<?php endif; ?>
										<?php if ($_USER["robux"] ?? 0 !== 0): ?>
										<div id="ctl00_rbxAlerts_RobuxAlertPanel">
											<div id="RobuxAlert">
												<a id="ctl00_rbxAlerts_TicketsAlertIconHyperLink" class="RobuxAlertIcon" href="/My/AccountBalance.aspx"><img src="/images/Robux.png" style="border-width:0px;"></a>&nbsp;
												<a id="ctl00_rbxAlerts_TicketsAlertCaptionHyperLink" class="RobuxAlertCaption" href="/My/AccountBalance.aspx" style="font-size: 12px;font-weight:bold"><?= number_format($_USER["robux"] ?? 0) ?> XORBUX</a>
											</div>
										</div>
										<?php endif; ?>
										<?php if ($_USER["tix"] ?? 0 !== 0): ?>
										<div id="ctl00_rbxAlerts_TicketsAlertPanel">
											<div id="TicketsAlert">
												<a id="ctl00_rbxAlerts_TicketsAlertIconHyperLink" class="TicketsAlertIcon" href="/My/AccountBalance.aspx"><img src="/images/Tickets.png" style="border-width:0px;"></a>&nbsp;
												<a id="ctl00_rbxAlerts_TicketsAlertCaptionHyperLink" class="TicketsAlertCaption" href="/My/AccountBalance.aspx" style="font-size: 12px;font-weight:bold"><?= number_format($_USER["tix"] ?? 0) ?> Tickets</a>
											</div>
										</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
							</div>
							</td>
							<?php else: ?>
							<td valign="middle">
								<a id="ctl00_rbxAlerts_SignupAndPlayHyperLink" class="SignUpAndPlay" text="Sign-up and Play!" href="/Login/New.aspx?ReturnUrl=%2fGames.aspx" style="display:inline-block;cursor:pointer;">
									<img src="/images/BannerPlay.png" border="0" blankurl="http://t1.roblox.com:80/blank-210x40.gif">
								</a>
							</td>
							<?php endif; ?>
							</tr></tbody></table></div>
					</div>
					<div class="Navigation">
						<span><a id="ctl00_hlMyRoblox" class="MenuItem" href="/User.aspx">My XORBLOX</a></span>
						<span class="Separator">&nbsp;|&nbsp;</span>
						<span><a id="ctl00_hlGames" class="MenuItem" href="/Games.aspx">Games</a></span>
						<span class="Separator">&nbsp;|&nbsp;</span>
						<span><a id="ctl00_hlCatalog" class="MenuItem" href="/Catalog.aspx">Catalog</a></span>
						<span class="Separator">&nbsp;|&nbsp;</span>
						<span><a id="ctl00_hlBrowse" class="MenuItem" href="/Browse.aspx">People</a></span>
						<span class="Separator">&nbsp;|&nbsp;</span>
                        <span><a id="ctl00_hlBuildersClub" class="MenuItem" href="/Upgrades/BuildersClub.aspx">Builders Club</a></span>
						<span class="Separator">&nbsp;|&nbsp;</span>
						<span><a id="ctl00_hlForum" class="MenuItem" href="/Forum/Default.aspx">Forum</a></span>
						<span class="Separator">&nbsp;|&nbsp;</span>
						<span><a id="ctl00_hlNews" class="MenuItem" href="https://web.archive.org/web/20080613193808/http://blog.roblox.com/" target="_blank">News</a>&nbsp;<a id="ctl00_hlNewsFeed" href="https://web.archive.org/web/20080613193808/http://blog.roblox.com/?feed=rss"><img src="/images/feed-icons/feed-icon-14x14.png" alt="RSS" border="0"></a></span>
						<span class="Separator">&nbsp;|&nbsp;</span>
						<span><a id="ctl00_hlParents" class="MenuItem" href="Parents.aspx">Parents</a></span>
						<span class="Separator">&nbsp;|&nbsp;</span>
						<span><a id="ctl00_hlHelp" class="MenuItem" href="https://web.archive.org/web/20080613193808/http://wiki.roblox.com/" target="_blank">Help</a></span>
 					</div>
				</div>