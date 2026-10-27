<?php
$id = $_GET["id"] ?? null;

if (empty($id)) {
    http_response_code(403);
    header("Location: /Error/Default.aspx");
    exit;
}

header("Location: /asset/?id=".$id);