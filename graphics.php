<?php
session_start();
?>
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
        <!-- Online JQuery Bibliotheken. Werden zwar nicht benötigt, können aber auch nicht schaden... -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.17.0/jquery.validate.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/menus.js"></script>
        <script src="js/datetime.js"></script> 
        <script src="js/Alert.js"></script>
        <link href="css/style.css" rel="stylesheet">
        <style type="text/css">p{font-family:verdana,arial;font-size:80%}</style>
    </head>

    <body> <!-- Definition des Bodybereiches -->
        <div class="mainDiv">
            <div id="uhr" class="borderLeft"></div>
        </div>
        <ul>
            <li class="dropdown">
                <a href="javascript:void(0)" class="treffer_0" onclick="myFunction_0()">Home</a>
                <div class="dropdown-inhalt_0" id="auswahl_0">
                    <a href="info.php">PHP-Info</a>
                    <a href="javascript:impressum()">Impressum</a>
                    <a href="index.php">Startseite</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="treffer_0" onclick="myFunction_1()">Daten abrufen</a>
                <div class="dropdown-inhalt_0" id="auswahl_1">
                    <a href="dataAll.php">alle Daten abrufen </a>
                    <a href="dataTime.php">bestimmte Daten abrufen </a>
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
    <center><h2>Temperatur-Projekt</h2>
        <?php
        if (isset($_GET['query'])) {
            if ($_GET['query'] == 1) {
                $_SESSION['pk'] -= 2;
            } else if ($_GET['query'] == 2) {
                $_SESSION['pk'] += 2;
            } else if ($_GET['query'] == 3)
                $_SESSION['pk'] = random_int(100, 33000);
        }
        if (isset($_SESSION['pk']) && $_SESSION['pk'] < 0) {
            ?>
            <script>
                alertWidth = 300;
                alertHeight = 200;
                xAlertStart = 650;
                yAlertStart = 200;
                alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
                alertText = "<p class='pAlert'>Sie befinden sich am unteren Ende der Meßwerte. Bitte erhöhen, anstatt reduzieren!</p>";
                showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                // alert("Sie befinden sich am unteren Ende der Meßwerte. Bitte erhöhen, anstatt reduzieren!");
            </script>
            <?php
            $_SESSION['pk'] = 1;
        }
        ?>
        <div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <p>Graphische Darstellung der Temperatur-und Luftfeuchtigkeitswerte</p>
                <img src="createGraphics.php" alt="not available">  
                <center>
                    <a href="?query=1">früher</a>
                    <a href="?query=2">später</a>
                    <a href="?query=3">zufällig</a>
                    <div><br>
                        <label>Id zurück setzen</label>
                        <input class="button3" type="submit" name="submit0" value="Submit">
                    </div>                  
                </center>
            </form>
        </div>
    </center>
</body>
</html>
<?php
if (!empty($_REQUEST['submit0'])) {
    $_SESSION['pk'] = 1;
}
?>