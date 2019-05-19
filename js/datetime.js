function ticken() {
    var Jahr, Monat, Tag;
    var stunden, minuten, sekunden;
    var StundenZahl, MinutenZahl, SekundenZahl;
    var heute = new Date();
    Jahr = heute.getFullYear();
    Monat = heute.getMonth();
    Tag = heute.getDate();
    StundenZahl = heute.getHours();
    MinutenZahl = heute.getMinutes();
    SekundenZahl = heute.getSeconds();
    stunden = StundenZahl + ":";

    if (MinutenZahl < 10)
        minuten = "0" + MinutenZahl + ":";
    else
        minuten = MinutenZahl + ":";
    if (SekundenZahl < 10)
        sekunden = "0" + SekundenZahl + " ";
    else
        sekunden = SekundenZahl + " ";
    zeit = Tag + "/" + (Monat + 1) + "/" + Jahr + "|" + stunden + minuten + sekunden + " Uhr";
    uhr.innerHTML = zeit;
    window.setTimeout("ticken();", 1000);
}//End of ticken
window.onload = ticken;



