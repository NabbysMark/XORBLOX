<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php"; ?>
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
            <?php Component::Render("nav2"); ?>
            <div id="Body">
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <h2 style="text-align: center">An Error occured! We're sorry.</h2>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
			</div>
            <?php Component::Render("footer"); ?>
        </div>
    </body>
</html>