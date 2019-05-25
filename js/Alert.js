nn6 = (document.getElementById && !document.all) ? 1 : 0;
op5 = (document.getElementById && document.all && !document.styleSheets) ? 1 : 0;

// Alertbox erstellen
if (nn6 || op5) {
    if (nn6)
        cp = 2, cs = 0, th = 22, bh = 35;
    else
        cp = 0, cs = 1, th = 15, bh = 20; //wg. Layout
}
function okAlert() {
    document.getElementById("alert").style.visibility = "hidden";
}

// Box anzeigen
function showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText) {
    document.write(
            "<div style='position:absolute;top:" + yAlertStart + "px;left:" + xAlertStart + "px;z-index:100' id='alert'>" +
            "<table style='border-style:outset;border-width:2;border-color:#E6E6CD;background-color:#F5F5DC' cellpadding='" + cp + "' cellspacing='" + cs + "' width='" + alertWidth + "' height='" + alertHeight + "''>" +
            "<tr><td height='" + th + "' bgcolor='#DEDEC5'>" + alertTitle + "</td></tr>" +
            "<tr><td>" + alertText + "</td></tr>" +
            "<tr align='center'><td height='" + bh + "'>" +
            "<input style='background-color:#E9E9CF;border-width:1;font-weight:bold' type='button' value='&nbsp; &nbsp; OK &nbsp; &nbsp;' onclick='okAlert()' onfocus='if(this.blur)this.blur()'>" +
            "</td></tr>" +
            "</table>" +
            "</div>"
            );
}