<!Doctype html> <!-- Definition des doctype-Modus -->
<html> <!-- Definition des Stammverzeichnises -->
    <head> <!-- Definition des Kopfbereiches -->
        <meta charset="utf-8"><!-- charset[utf-8:]  definiert den deutschen Zeichensatz -->
        <meta name="msvalidate.01" content="8B12875037645A4090EE64488042FDA9" /><!--validiert die Website für Bing und Yahoo-->
        <meta name="date" content="2019-05-19T08:49:37+02:00">		<!-- Angaben, wann die Seite publiziert wurde-->
        <meta name="keywords" content="Temperatur, Analyse, Graphics">	<!-- versorgt die Spider der Suchmaschinen mit Informationen zwecks Suchbegriffen -->
        <meta name="description" content="Eine Auswertung der Datenbankdaten / Pi-Temperatursensor">	<!-- Beschreibung, die in den Suchmaschinen erscheinen soll. -->
        <meta name="robots" content="index,follow">			<!-- Links sollen mitindiziert werden //NOINDEX:Seite soll nicht aufgenommen werden//NOFOLLOW Links werden nicht verfolgt-->
        <meta name="audience" content="alle">				<!-- definiert die Zielgruppe der Website  -->
        <meta name="page-topic" content="Hobby">		<!-- Zuordnungsdefinition für die Suchmaschine -->
        <meta name="revisit-after" CONTENT="7 days">			<!-- definiert den erneuten Besuch des Spiders//hier:nach sieben Tagen  -->
        <title lang="de">Temperatur Analyse</title> 	<!-- weist dem HTML-Dokument in der Registerkarte einen Namen zu -->     
        <!--  JQuery Bibliotheken -->
        <script src="js/jquery-1.7.1.min.js"></script>
        <script src="js/jquery-ui-1.8.17.custom.min.js"></script>
        <script src="js/menus.js"></script>
        <script src="js/datetime.js"></script> 
        <script src="js/Alert.js"></script>
        <!--  CSS Bibliotheken -->
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body> <!-- Definition des Bodybereiches -->
        <div class="mainDiv">
            <div id="uhr"></div>
        </div>
        <ul>
            <li class="dropdown">
                <a href="javascript:void(0)" class="treffer_0" onclick="myFunction_0()">Home</a>
                <div class="dropdown-inhalt_0" id="auswahl_0">
                    <a href="info.php">PHP-Info</a>
                    <a href="javascript:impressum()">Impressum</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="treffer_0" onclick="myFunction_1()">Daten abrufen</a>
                <div class="dropdown-inhalt_0" id="auswahl_1">
                    <a href="showGraphics.php">Grafik erstellen</a>
                    <a href="dataAll.php">alle Daten abrufen </a>
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="treffer_0" onclick="myFunction_2()">Adminbereich</a>
                <div class="dropdown-inhalt_0" id="auswahl_2">
                    <a href="dataDelete.php">Daten löschen</a>
                    <a href="dataRemove.php">Duplikate entfernen</a>
                </div>
            </li>
        </ul>
        <script>
            function impressum() {
                alert("Programmierer &  V.i.S.d.P: Thomas Kipp\nAnschrift:\nKlein - Buchholzer - Kirchweg 25\n30659 Hannover\nMobil:0152/37389041");
            }
        </script>
    <center><h2>Daten gemäß Datum</h2>
        <?php
        ?>

