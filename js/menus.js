function myFunction_0() {
    document.getElementById("auswahl_0").classList.toggle("zeigen");
}
function myFunction_1() {
    document.getElementById("auswahl_1").classList.toggle("zeigen");
}
function myFunction_2() {
    document.getElementById("auswahl_2").classList.toggle("zeigen");
}
window.onclick = function (x) {
    if (!x.target.matches('.treffer_0')) {
        var dropdowns_0 = document.getElementsByClassName("dropdown-inhalt_0");
        var dropdowns_1 = document.getElementsByClassName("dropdown-inhalt_0");

        for (var i = 0; i < dropdowns_0.length; i++) {
            var openDropdown_0 = dropdowns_0[i];
            if (openDropdown_0.classList.contains('zeigen'))
                openDropdown_0.classList.remove('zeigen');
        }

        for (var j = 0; j < dropdowns_1.length; j++) {
            var openDropdown_1 = dropdowns_1[j];
            if (openDropdown_1.classList.contains('zeigen'))
                openDropdown_1.classList.remove('zeigen');
        }
    } // Ende der Hauptkondition

} //Ende der Funktion