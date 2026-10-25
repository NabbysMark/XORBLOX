<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php";

if ($settings["site"]["maintenance"] === false) {
    header("Location: /Default.aspx");
    exit;
}
?>