<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php"; ?>
<?php // ok were gonna write existing php code here ?>
<!DOCTYPE html>
<html>
    <head>
        <?php Component::Render("head"); ?>
        <script src="https://unpkg.com/@ruffle-rs/ruffle"></script>
        <script type="text/javascript">
            window.RufflePlayer = window.RufflePlayer || {};

            window.RufflePlayer.config = {
                autoplay: "on",
                unmuteOverlay: "hidden",
                splashScreen: true
            };
        </script>
    </head>
    <body>
        <div id="Container">
            <?php Component::Render("nav"); ?>
            <div id="Body">
					
                <div id="SplashContainer">
                    <div id="SignInPane">
                        

                        <div id="LoginViewContainer">
                
                        <div id="LoginView">
                            <h5>Member Login</h5>
                            
                                <div class="AspNet-Login">
                                    <form class="AspNet-Login" method="post">
                                        <div class="AspNet-Login-UserPanel">
                                            <label for="username" id="ctl00_cphRoblox_rbxLoginView_lvLoginView_lSignIn_UserNameLabel" class="Label">Character Name</label>
                                            <input name="username" type="text" id="username" tabindex="1" class="Text">
                                        </div>
                                        <div class="AspNet-Login-PasswordPanel">
                                            <label for="password" id="ctl00_cphRoblox_rbxLoginView_lvLoginView_lSignIn_PasswordLabel" class="Label">Password</label>
                                            <input name="password" type="password" id="password" tabindex="2" class="Text">
                                        </div>
                                        <!--div class="AspNet-Login-RememberMePanel"-->
                                            
                                        <!--/div-->
                                        <div class="AspNet-Login-SubmitPanel" style="margin: 0;margin-top: -2px;margin-bottom: -4px;">
                                            <a id="ctl00_cphRoblox_rbxLoginView_lvLoginView_lSignIn_Login" tabindex="4" class="Button" onclick="this.closest('form').submit(); return false;">Login</a>
                                        </div>
                                        <div class="AspNet-Login-PasswordRecoveryPanel">
                                            <a id="ctl00_cphRoblox_rbxLoginView_lvLoginView_lSignIn_hlPasswordRecovery" tabindex="5" href="/Login/ResetPasswordRequest.aspx">Forgot your password?</a>
                                        </div>
                                    </form>
                                
                            </div>
                        </div>
                    </div>

                        <br>
                        
                                <div id="ctl00_cphRoblox_LoginView1_pFigure">
                
                                    <div id="Figure"><a id="ctl00_cphRoblox_LoginView1_ImageFigure" disabled="disabled" title="Figure" onclick="return false" style="display:inline-block;"><img src="/images/NewFrontPageGuy.png" border="0" alt="Figure" blankurl="http://t1.roblox.com:80/blank-115x130.gif"></a></div>
                                
            </div>  
                            
                    </div>
                    <div id="RobloxAtAGlance">
                        <h2>ROBLOX Virtual Playworld</h2>
                        <h3>ROBLOX is Free!</h3>
                        <ul id="ThingsToDo">
                            <li id="Point1">
                                <h3>Build your personal Place</h3>
                                <div>Create buildings, vehicles, scenery, and traps with thousands of virtual bricks.</div>
                            </li>
                            <li id="Point2">
                                <h3>Meet new friends online</h3>
                                <div>Visit your friend's place, chat in 3D, and build together.</div>
                            </li>
                            <li id="Point3">
                                <h3>Battle in the Brick Arenas</h3>
                                <div>Play with the slingshot, rocket, or other brick battle tools.  Be careful not to get "bloxxed".</div>
                            </li>
                        </ul>
                        <div id="Showcase">
                            <embed src="PlayTrailer.swf" width="400" height="326" id="EmbedPlayTrailer">
                        </div>
                        <div id="Install">
                            <div id="CompatibilityNote"><div id="ctl00_cphRoblox_pCompatibilityNote">
                Works with your<br>Windows PC!
            </div></div>
                            <div id="DownloadAndPlay"><a id="ctl00_cphRoblox_hlDownloadAndPlay" href="Login/New.aspx?ReturnUrl=%2fGames.aspx"><img src="/images/DownloadAndPlay.png" alt="FREE - Download and Play!" border="0"></a></div>
                        </div>
                        <div id="ctl00_cphRoblox_pForParents">
                
                            <div id="ForParents">
                                <a id="ctl00_cphRoblox_hlKidSafe" title="ROBLOX is kid-safe!" href="Parents.aspx" style="display:inline-block;"><img title="ROBLOX is kid-safe!" src="/images/COPPASeal-125x125.jpg" border="0"></a>
                            </div>
                        
            </div>
                    </div>
                    <div id="UserPlacesPane">
                        <div id="UserPlaces_Content">
                            <table id="ctl00_cphRoblox_CoolPlacesDataList" cellspacing="0" border="0" width="100%">
                <tbody><tr>
                    <td class="UserPlace">
                                    <a id="ctl00_cphRoblox_CoolPlacesDataList_ctl00_rbxContentImage" title="Burnout *READ DESC*" href="/web/20080613193808/http://www.roblox.com/Item.aspx?ID=267457" style="display:inline-block;cursor:pointer;"><img src="https://web.archive.org/web/20080613193808im_/http://t3.roblox.com:80/eb8864fcc2553d86b69e1ca2bd773981" border="0" alt="Burnout *READ DESC*" blankurl="http://t2.roblox.com:80/blank-120x70.gif"></a>
                                </td><td class="UserPlace">
                                    <a id="ctl00_cphRoblox_CoolPlacesDataList_ctl01_rbxContentImage" title="SWAT VS Terrorist ADMIN DOORS WORK! " href="/web/20080613193808/http://www.roblox.com/Item.aspx?ID=281944" style="display:inline-block;cursor:pointer;"><img src="https://web.archive.org/web/20080613193808im_/http://t4.roblox.com:80/85a3cab87d7f55880b616c5d4030e2e2" border="0" alt="SWAT VS Terrorist ADMIN DOORS WORK! " blankurl="http://t2.roblox.com:80/blank-120x70.gif"></a>
                                </td><td class="UserPlace">
                                    <a id="ctl00_cphRoblox_CoolPlacesDataList_ctl02_rbxContentImage" title="~~~Roblox Arcade [9] [10] Read The Desc.~~~" href="/web/20080613193808/http://www.roblox.com/Item.aspx?ID=118636" style="display:inline-block;cursor:pointer;"><img src="https://web.archive.org/web/20080613193808im_/http://t2.roblox.com:80/63db5fe55cbdc2cfbee69de79b1e34fd" border="0" alt="~~~Roblox Arcade [9] [10] Read The Desc.~~~" blankurl="http://t2.roblox.com:80/blank-120x70.gif"></a>
                                </td><td class="UserPlace">
                                    <a id="ctl00_cphRoblox_CoolPlacesDataList_ctl03_rbxContentImage" title="Solar system .V2(admin fight now has admin glass)" href="/web/20080613193808/http://www.roblox.com/Item.aspx?ID=344640" style="display:inline-block;cursor:pointer;"><img src="https://web.archive.org/web/20080613193808im_/http://t6.roblox.com:80/d13da61a65085a4d322931ca6be4dcfe" border="0" alt="Solar system .V2(admin fight now has admin glass)" blankurl="http://t2.roblox.com:80/blank-120x70.gif"></a>
                                </td><td class="UserPlace">
                                    <a id="ctl00_cphRoblox_CoolPlacesDataList_ctl04_rbxContentImage" title="be a family " href="/web/20080613193808/http://www.roblox.com/Item.aspx?ID=434445" style="display:inline-block;cursor:pointer;"><img src="https://web.archive.org/web/20080613193808im_/http://t6.roblox.com:80/32e7d0dbc48e5a5cac5287c035781f69" border="0" alt="be a family " blankurl="http://t2.roblox.com:80/blank-120x70.gif"></a>
                                </td>
                </tr>
            </tbody></table>
                        </div>
                        <div id="UserPlaces_Header">
                            <h3>Cool Places</h3>
                            <p>Check out some of our favorite ROBLOX places!</p>
                        </div>
                        <div id="ctl00_cphRoblox_ie6_peekaboo" style="clear: both"></div>
                    </div>
                </div>

			</div>
            <?php Component::render("footer"); ?>
        </div>
    </body>
</html>