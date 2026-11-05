if (!!window.ActiveXObject || "ActiveXObject" in window) {
    window.onerror = function() {
        return true;
    };
    window.location.href = "/Login/Default.aspx";
}