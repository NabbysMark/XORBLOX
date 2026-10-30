<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php"; ?>
<?php requireLogin(); ?>
<!DOCTYPE html>
<html>
    <head>
        <?php Component::Render("head"); ?>
    </head>
    <body>
        <div id="Container">
            <?php Component::Render("nav"); ?>
            <div id="Body">
            </div>
            <?php Component::Render("footer"); ?>
        </div>
    </body>
</html>