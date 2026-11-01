function activateTab(hideTab, showTab) {
    $("#" + hideTab).hide();
    $("#" + showTab).show();

    $(".ajax__tab").removeClass("ajax__tab_active");
    $(".ajax__tab_tab").removeClass("ajax__tab_active");

    if (showTab.indexOf("GamesTab") !== -1) {
        $("#tab11").addClass("ajax__tab_active");
    } else {
        $("#tab22").addClass("ajax__tab_active");
    }

    window.location.hash = "tab=" + (showTab.indexOf("GamesTab") !== -1 ? "Games" : "Comments");

    $("#" + "__tab_" + showTab.replace("ctl00_cphRoblox_", "")).addClass("ajax__tab_active");
}

$(document).ready(function () {
    var tab = window.location.hash;

    if (tab === "#tab=Games") {
        activateTab("ctl00_cphRoblox_TabbedInfo_CommentaryTab", "ctl00_cphRoblox_TabbedInfo_GamesTab");
    } else if (tab === "#tab=Comments") {
        activateTab("ctl00_cphRoblox_TabbedInfo_GamesTab", "ctl00_cphRoblox_TabbedInfo_CommentaryTab");
    }
});