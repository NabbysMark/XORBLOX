<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php";

if ($settings["site"]["maintenance"] === false) {
    header("Location: /Default.aspx");
    exit;
}
?>
<title>XORBLOX Maintenance</title>
<style type="text/css"> 
  .content { border: 1px solid rgb(153, 153, 153);
	width: 800px;
    margin-top: 0px;
    margin-bottom: 10px;
    background-color: rgb(255, 255, 255);
    margin-right: auto;
    margin-left: auto;
    text-align: justify;
    }
 
  .content h1 { font-family: Comic Sans MS,Geneva,Arial,Helvetica,sans-serif;
  	margin: 0px;
    padding: 3px 4px;
    font-size: 12pt;
    background-repeat: repeat-x;
    color: rgb(0, 0, 0);
    background-color: rgb(251, 242, 166);
    text-align: center;
    }
 
  .content h2 { margin: 0px 0px 0px 0px;
    padding: 1px 4px;
    background-color: rgb(191,191,191);
    font-family: Geneva,Arial,Helvetica,sans-serif;
    font-variant: small-caps;
    color: rgb(0, 0, 0);
    font-size: 16px;
    text-align: center;
    }
 
  .content p {  font-family: Comic Sans MS,Geneva,Arial,Helvetica,sans-serif;
    margin: 5px;
    font-size: 11px;
    line-height: 1.5;
    padding-left: 5px;
    text-align: center;
    padding-right: 5px;
    }
    </style>
<div align="center"> 
        <img src="/images/roblox_logo.png"> 
        <div class="content"> 
            <h1> 
                We are upgrading XORBLOX!<br> 
                Stay tuned... We'll be back online soon.
            </h1> 
            <h2> 
                You will be redirected to XORBLOX when we are back up.</h2> 
            <p> 
            <img src="/images/Maintenance.png"></p> 
            <script type="text/javascript"> window.window.setTimeout("window.location = 'http://<?= $settings["site"]["baseurl"] ?>/'", 30000);</script>
        </div> 
    </div>