<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php";
requireLogin();

if (!isset($_USER)) {
    header("Location: /Login/Default.aspx?ReturnUrl=%2fMy%2fCharacter.aspx");
    exit;
}

$type = isset($_GET["type"]) ? intval($_GET["type"]) : 8;

$brickColors = [
    "1" => "#F2F3F3",
    "208" => "#E5E4DF",
    "194" => "#A3A2A5",
    "199" => "#635F62",
    "26" => "#1B2A35",
    "21" => "#C4281C",
    "24" => "#F5CD30",
    "226" => "#FDEA8D",
    "23" => "#0D69AC",
    "107" => "#008F9C",
    "102" => "#6E99CA",
    "11" => "#80BBDC",
    "45" => "#B4D2E4",
    "135" => "#74869D",
    "106" => "#DA8541",
    "105" => "#E29B40",
    "141" => "#27462D",
    "28" => "#287F47",
    "37" => "#4B974B",
    "119" => "#A4BD47",
    "29" => "#A1C48C",
    "151" => "#789082",
    "38" => "#A05F35",
    "192" => "#694028",
    "104" => "#6B327C",
    "9" => "#E8BAC8",
    "101" => "#DA867A",
    "5" => "#D7C59A",
    "153" => "#957977",
    "217" => "#7C5C46",
    "18" => "#CC8E69",
    "125" => "#EAB892",
];

$bodycolors = explode(";", $_USER["bodycolors"]);
function selectedCategory($currentType, $categoryType) {
    return $currentType == $categoryType ? "AttireCategorySelector AttireCategorySelector_Selected" : "AttireCategorySelector";
}

$page = max(1, intval($_GET["page"] ?? 1));
$perPage = 8;
$offset = ($page - 1) * $perPage;

$wearPage = max(1, intval($_GET["wearpage"] ?? 1));
$wearPerPage = 8;
$wearOffset = ($wearPage - 1) * $wearPerPage;

$wardrobeItems = $db->fetch("SELECT inventory.*, assets.name FROM inventory INNER JOIN assets ON inventory.assetid = assets.id WHERE inventory.equipped = 0 AND inventory.userid = ?", [$_USER["id"]]);
$wearingItems = $db->fetch("SELECT inventory.*, assets.name FROM inventory INNER JOIN assets ON inventory.assetid = assets.id WHERE inventory.equipped = 1 AND inventory.userid = ?", [$_USER["id"]]);

$totalItems = $db->fetch("SELECT COUNT(*) as count FROM inventory WHERE equipped = 0 AND userid = ?", [$_USER["id"]])["count"];
$totalWearingItems = $db->fetch("SELECT COUNT(*) as count FROM inventory WHERE equipped = 1 AND userid = ?", [$_USER["id"]])["count"];

$totalPages = max(1, ceil($totalItems / $perPage));
$wearTotalPages = max(1, ceil($totalWearingItems / $wearPerPage));
?>
<!DOCTYPE html >
<html>
    <head>
        <?php Component::Render("head"); ?>
        <script src="https://unpkg.com/@ruffle-rs/ruffle"></script>
    </head>
    <body>
        <div id="MasterContainer">
        <div id="Container">
            <?php Component::Render("nav"); ?>
            <div id="Body">			
		<div class="MyRobloxContainer">
            <div id="ctl00_ctl00_cphRoblox_cphMyRobloxContent_CustomizeCharacterUpdatePanel"></div>
            <div class="CharacterViewer2">
                <div style="border: black solid thin;">
                    <h4>My Character</h4>
                    <div class="StandardBox">
                        <div style="position: relative;">
                            <img id="spinner" class="spinner" style="display: none;" src="/images/ProgressIndicator2.gif">
                            <a title="<?= htmlspecialchars($_USER["username"]) ?>" onclick="return false" style="display:inline-block;height:352px;width:352px;">
                                <img id="character" src="/Thumbs/Avatar.ashx?userId=<?= $_USER["id"] ?>" width="352" height="352" border="0" alt="<?= htmlspecialchars($_USER["username"]) ?>">
                            </a>
                        </div>
                    </div>
                </div>
                <br>
                <center>
                    <div style="border: black solid thin;">
                        <h4>Color Chooser</h4>
                        <div class="StandardBox">
                            <div>
                                <p>Click a body part to change its color:</p>
                            </div>
                            <div class="ColorChooserFrame" style="height:236px;width:176px;text-align:center;">
                                <div style="position: relative; margin: 11px 11px; height: 200px;">
                                    <div style="position: absolute; left: 120px; top: 44px; cursor: pointer">
                                        <div id="LeftArmSelector" style="height:72px;width:32px; background-color: <?= $brickColors[$bodycolors[2]] ?>; border: 1px solid #ccc;" onclick="togglepopup('4');"></div>
                                    </div>
                                    <div style="position: absolute; left: 40px; top: 44px; cursor: pointer">
                                        <div id="TorsoSelector" style="height:72px;width:72px; background-color: <?= $brickColors[$bodycolors[1]] ?>; border: 1px solid #ccc;" onclick="togglepopup('3');"></div>
                                    </div>
                                    <div style="position: absolute; left: 0px; top: 44px; cursor: pointer">
                                        <div id="RightArmSelector" style="height:72px;width:32px; background-color: <?= $brickColors[$bodycolors[3]] ?>; border: 1px solid #ccc;" onclick="togglepopup('5');"></div>
                                    </div>
                                    <div style="position: absolute; left: 58px; top: 0px; cursor: pointer">
                                        <div id="HeadSelector" style="height:36px;width:36px; background-color: <?= $brickColors[$bodycolors[0]] ?>; border: 1px solid #ccc;" onclick="togglepopup('2');"></div>
                                    </div>
                                    <div style="position: absolute; left: 40px; top: 124px; cursor: pointer">
                                        <div id="RightLegSelector" style="height:72px;width:32px; background-color: <?= $brickColors[$bodycolors[5]] ?>; border: 1px solid #ccc;" onclick="togglepopup('1');"></div>
                                    </div>
                                    <div style="position: absolute; left: 80px; top: 124px; cursor: pointer">
                                        <div id="LeftLegSelector" style="height:72px;width:32px; background-color: <?= $brickColors[$bodycolors[4]] ?>; border: 1px solid #ccc;" onclick="togglepopup('6');"></div>
                                    </div>
                                </div>
                    </div>
                </center>
            </div>
            <div id="CustomizeCharacterContainer">
                <div class="AttireChooser" style="border: 0;">
                    <div class="AttireChooser">
                    <h4>My Wardrobe</h4>
                    <div class="HeaderPager">
                        <div class="AttireCategory">
                            <center>
                                <a id="cat_tshirts" class="<?= selectedCategory($type, 2) ?>" href="?type=2&page=1">T-Shirts</a>
                                &nbsp;|&nbsp;
                                <a id="cat_shirts" class="<?= selectedCategory($type, 11) ?>" href="?type=11&page=1">Shirts</a>
                                &nbsp;|&nbsp;
                                <a id="cat_pants" class="<?= selectedCategory($type, 12) ?>" href="?type=12&page=1">Pants</a>
                                &nbsp;|&nbsp;
                                <a id="cat_hats" class="<?= selectedCategory($type, 8) ?>" href="?type=8&page=1">Hats</a>
                                <br>
                                <a href="/Catalog.aspx?m=ForSale&c=<?= $type ?>&d=All">Shop</a>
                                &nbsp;
                                <a href="ContentBuilder.aspx?ContentType=2">Create</a>
                            </center>
                        </div>
                        <div class="AttireContent" id="wardrobeItems">
                        <?php foreach ($wardrobeItems ?? [] as $item): ?>
                            <?php $creator = $db->fetch("SELECT * FROM users WHERE id = ?", [$item["creatorId"]]); ?>

                            <div class="Asset" id="wardrobe-item-<?= $item["id"] ?>">
                                <div class="AssetThumbnail">
                                    <a style="display:inline-block;height:110px;width:110px;cursor:pointer;">
                                        <img src="/Thumbs/Asset.ashx?assetId=<?= $item["id"] ?>" style="height:110px;width:110px" onerror="this.src = '/images/unavail.png'">
                                    </a>

                                    <a class="DeleteButtonOverlay"
                                    href="javascript:void(0);"
                                    style="top:-4px"
                                    onclick="wearItem(<?= $item["id"] ?>, <?= $type ?>)">
                                        [ wear ]
                                    </a>
                                </div>

                                <div class="AssetDetails">
                                    <div class="AssetName">
                                        <a href="/Item.aspx?id=<?= $item["id"] ?>">
                                            <?= htmlspecialchars($item["name"]) ?>
                                        </a>
                                    </div>

                                    <div class="AssetCreator">
                                        <span class="Label">Creator:</span>
                                        <span class="Detail">
                                            <a href="/User.aspx?ID=<?= $creator["id"] ?>">
                                                <?= htmlspecialchars($creator["username"]) ?>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="FooterPager" style="border-top:1px solid">
                    <?php if ($page > 1): ?>
                        <a href="?type=<?= $type ?>&page=1">First</a>
                        <a href="?type=<?= $type ?>&page=<?= $page-1 ?>">Previous</a>
                    <?php else: ?>
                        <span class="disabled">First</span>
                        <span class="disabled">Previous</span>
                    <?php endif; ?>


                    <?php

                    $start = max(1, $page - 2);
                    $end = min($totalPages, $start + 4);

                    if ($end - $start < 4) {
                        $start = max(1, $end - 4);
                    }

                    if ($start > 1) {
                        echo '<a href="?type='.$type.'&page=1">1</a>';
                        if ($start > 2) {
                            echo ' ... ';
                        }
                    }


                    for ($i = $start; $i <= $end; $i++) {
                        if ($i == $page) {
                            echo '<span>'.$i.'</span>';
                        } else {
                            echo '<a href="?type='.$type.'&page='.$i.'">'.$i.'</a>';
                        }
                    }


                    if ($end < $totalPages) {
                        if ($end < $totalPages - 1) {
                            echo ' ... ';
                        }
                        echo '<a href="?type='.$type.'&page='.$totalPages.'">'.$totalPages.'</a>';
                    }

                    ?>


                    <?php if ($page < $totalPages): ?>
                        <a href="?type=<?= $type ?>&page=<?= $page+1 ?>">Next</a>
                        <a href="?type=<?= $type ?>&page=<?= $totalPages ?>">Last</a>
                    <?php else: ?>
                        <span class="disabled">Next</span>
                        <span class="disabled">Last</span>
                    <?php endif; ?>
                    </div>
                </div>
                <div class="AttireChooser" style="margin-top: 8px;border: 1px solid">
                    <h4>Currently Wearing</h4>
                    <div class="HeaderPager">
                        <div class="AttireContent" id="wearingItems">
                            <?php foreach ($wearingItems ?? [] as $item): ?>
                                <?php $creator = $db->fetch("SELECT * FROM users WHERE id = ?", [$item["creatorId"]]) ?>

                                <div class="Asset" id="wearing-item-<?= $item["id"] ?>">
                                    <div class="AssetThumbnail">
                                        <a title="click to remove"
                                        style="display:inline-block;height:110px;width:110px;cursor:pointer;">
                                            <img style="height:110px;width:110px" onerror="this.src = '/images/unavail.png'"
                                                src="/Thumbs/Asset.ashx?assetId=<?= $item["id"] ?>"
                                                border="0">
                                        </a>

                                        <a class="DeleteButtonOverlay"
                                        href="javascript:void(0);"
                                        style="top:-4px"
                                        onclick="removeItem(<?= $item["id"] ?>)">
                                            [ remove ]
                                        </a>
                                    </div>

                                    <div class="AssetDetails">
                                        <div class="AssetName">
                                            <?= htmlspecialchars($item["name"]) ?>
                                        </div>

                                        <div class="AssetCreator">
                                            <span class="Label">Creator:</span>
                                            <span class="Detail">
                                                <a href="/User.aspx?ID=<?= $creator["id"] ?>">
                                                    <?= htmlspecialchars($creator["username"]) ?>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            </div>
                    </div>
                    <div class="FooterPager" style="border-top:1px solid">
                    <?php if ($wearPage > 1): ?>
                        <a href="?type=<?= $type ?>&page=<?= $page ?>&wearpage=1">First</a>
                        <a href="?type=<?= $type ?>&page=<?= $page ?>&wearpage=<?= $wearPage-1 ?>">Previous</a>
                    <?php else: ?>
                        <span class="disabled">First</span>
                        <span class="disabled">Previous</span>
                    <?php endif; ?>


                    <?php
                    $start = max(1, $wearPage - 2);
                    $end = min($wearTotalPages, $start + 4);

                    if ($end - $start < 4) {
                        $start = max(1, $end - 4);
                    }

                    for ($i = $start; $i <= $end; $i++) {
                        if ($i == $wearPage) {
                            echo "<span>$i</span>";
                        } else {
                            echo '<a href="?type='.$type.'&page='.$page.'&wearpage='.$i.'">'.$i.'</a>';
                        }
                    }
                    ?>


                    <?php if ($wearPage < $wearTotalPages): ?>
                        <a href="?type=<?= $type ?>&page=<?= $page ?>&wearpage=<?= $wearPage+1 ?>">Next</a>
                        <a href="?type=<?= $type ?>&page=<?= $page ?>&wearpage=<?= $wearTotalPages ?>">Last</a>
                    <?php else: ?>
                        <span class="disabled">Next</span>
                        <span class="disabled">Last</span>
                    <?php endif; ?>

                    </div>
                </div>
            </div>
            <br clear="all">
            <?php
            $bodyParts = [
                1 => "RightLeg",
                2 => "Head",
                3 => "Torso",
                4 => "LeftArm",
                5 => "RightArm",
                6 => "LeftLeg"
            ];

            foreach ($bodyParts as $partId => $partName) {
            ?>
                <div id="Popup<?= $partName ?>" class="popupControl" style="top: 435px; right: 165px; visibility: hidden;">
                    <div style="display: flex; flex-wrap: wrap; gap: 4px; width: 280px; background: white; padding: 10px;">
                        <?php foreach ($brickColors as $colorId => $color) { ?>
                            <div class="ColorPickerItem" onclick="changebcolor('<?= $partId ?>', '<?= $colorId ?>');" style="background-color: <?= $color ?>; width: 32px; height: 32px;"></div>
                        <?php } ?>
                    </div>
                </div>
            <?php
            }
            ?>
            </div>
            <div style="clear: both;"></div>
        </div>
	</div>

            <?php Component::Render("footer"); ?>
        </div>
        </div>
    </body>
    <script type="text/javascript">
    var brickColors = <?= json_encode($brickColors) ?>;
    var canRerender = true;
    function hidePopups() {
        $(".popupControl").css("visibility", "hidden");
    }

    function rerender() {
        if (!canRerender) {
            return;
        }

        canRerender = false;

        $("#spinner").show();
        $("#character").attr("src", "/images/unavail.png");
        $("#character").attr("width", 352);
        $("#character").attr("height", 352);

        $.post("/api/rerender.php", {}, function(response) {
            setTimeout(function() {
                $("#character")
                    .one("load", function() {
                        $("#spinner").hide();
                        canRerender = true;
                    })
                    .attr("src", "/Thumbs/Avatar.ashx?userId=<?= $_USER["id"] ?>&x=352&y=352&r=" + Date.now());
            }, 500);
        });
    }

    function togglepopup(part) {
        hidePopups();

        var popupMap = {
            "1": "#PopupRightLeg",
            "2": "#PopupHead",
            "3": "#PopupTorso",
            "4": "#PopupLeftArm",
            "5": "#PopupRightArm",
            "6": "#PopupLeftLeg"
        };

        $(popupMap[part]).css("visibility", "visible");
    }

    function setPose(pose) {
        if (!canRerender) {
            return;
        }

        canRerender = false;

        $("#spinner").show();
        $("#character").attr("src", "/images/unavail.png");
        $("#character").attr("width", 352);
        $("#character").attr("height", 352);

        $.post("/api/setpose.php", {
            pose: pose
        }, function(response) {
            setTimeout(function() {
                $("#character")
                    .one("load", function () {
                        $("#spinner").hide();
                        canRerender = true;
                    })
                    .attr("src", "/Thumbs/Avatar.ashx?userId=<?= $_USER["id"] ?>&x=352&y=352&r=" + Date.now());
            }, 500);
        });
    }

    function changebcolor(part, color) {
        if (!canRerender) {
            return;
        }

        canRerender = false;

        $("#spinner").show();
        $("#character").attr("src", "/images/unavail.png");
        $("#character").attr("width", 352);
        $("#character").attr("height", 352);

        var selectorMap = {
            "1": "#RightLegSelector",
            "2": "#HeadSelector",
            "3": "#TorsoSelector",
            "4": "#LeftArmSelector",
            "5": "#RightArmSelector",
            "6": "#LeftLegSelector"
        };

        $(selectorMap[part]).css(
            "background-color",
            brickColors[color]
        );

        $.post("/api/bodycolor.php", {
            part: part,
            color: color
        }, function() {
            setTimeout(function() {
                $("#character")
                    .one("load", function () {
                        $("#spinner").hide();
                        canRerender = true;
                    })
                    .attr("src", "/Thumbs/Avatar.ashx?userId=<?= $_USER["id"] ?>&x=352&y=352&r=" + Date.now());
            }, 500);

            hidePopups();
        });
    }

    function wearItem(assetid) {
        if (!canRerender) {
            return;
        }

        canRerender = false;

        $("#spinner").show();
        $("#character").attr("src", "/images/unavail.png");
        $("#character").attr("width", 352);
        $("#character").attr("height", 352);

        $.post("/api/wearitem.php", {
            assetid: assetid
        }, function(response) {
            if (response.removed) {
                var old = $("#wearing-item-" + response.removed);
                old.find(".DeleteButtonOverlay").text("[ wear ]").attr("onclick", "wearItem(" + response.removed + ")");
                $("#wardrobeItems").append(old);
                old.attr("id", "wardrobe-item-" + response.removed);
            }

            var item = $("#wardrobe-item-" + assetid);

            item.find(".DeleteButtonOverlay")
                .text("[ remove ]")
                .attr("onclick", "removeItem(" + assetid + ")");

            $("#wearingItems").append(item);
            item.attr("id", "wearing-item-" + assetid);

            setTimeout(function() {
                $("#character")
                    .one("load", function() {
                        $("#spinner").hide();
                        canRerender = true;
                    })
                    .attr("src", "/Thumbs/Avatar.ashx?userId=<?= $_USER["id"] ?>&x=352&y=352&r=" + Date.now());
            }, 500);

        }, "json");
    }

    function removeItem(assetid) {
        if (!canRerender) {
            return;
        }

        canRerender = false;

        $("#spinner").show();
        $("#character").attr("src", "/images/unavail.png");
        $("#character").attr("width", 352);
        $("#character").attr("height", 352);

        $.post("/api/removeitem.php", {
            assetid: assetid
        }, function() {
            var item = $("#wearing-item-" + assetid);
            item.find(".DeleteButtonOverlay").text("[ wear ]").attr("onclick", "wearItem(" + assetid + ")");
            $("#wardrobeItems").append(item);
            item.attr("id", "wardrobe-item-" + assetid);

            setTimeout(function() {
                $("#character")
                    .one("load", function () {
                        $("#spinner").hide();
                        canRerender = true;
                    })
                    .attr("src", "/Thumbs/Avatar.ashx?userId=<?= $_USER["id"] ?>&x=352&y=352&r=" + Date.now());
            }, 500);
        });
    }
    </script>
    <style>
        h4 {
            background-color: #ccc;
            border-bottom: solid 1px #000;
            color: #333;
            font-family: Comic Sans MS,Verdana,Sans-Serif;
            margin: 0;
            text-align: center;
        }

        .CharacterViewer2 {
            float: right;
            width: 354px;
        }
        .spinner {
            position: absolute;
            width: 30px;
            height: 30px;
            pointer-events: none;
        }
         .popupControl {
            position: absolute;
            background: white;
            border: 1px solid black;
            padding: 5px;
            z-index: 1000;
            visibility: hidden;
        }
       .ColorPickerItem {
            cursor: pointer;
            border: 1px solid #ccc;
            display: inline-block;
            height: 32px;
            width: 32px;
        }
        .ColorPickerItem:hover {
            border: 2px solid #000;
        }
        .disabled {
            color: gray;
            pointer-events: none;
        }
        .FooterPager {
            text-align: center;
            margin: 15px 0;
            padding: 10px;
        }
        .FooterPager a {
            margin: 0 2px;
            text-decoration: none;
        }
        .FooterPager span {
            margin: 0 2px;
        }

        .AttireContent {
            width: 100%;
            overflow: hidden;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
        }
        
        .Asset {
            width: 110px;
            margin: 10px;
            display: inline-block;
            vertical-align: top;
        }
        
        .AssetThumbnail {
            text-align: center;
        }
        
        .AssetDetails {
            text-align: center;
            font-size: 11px;
        }
        
        .DeleteButtonOverlay {
            display: block;
            text-align: center;
            margin-top: 5px;
        }
        </style>
</html>