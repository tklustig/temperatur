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
        <script src="js/jquery-1.7.1.min.js"></script>
        <script src="js/jquery-ui-1.8.17.custom.min.js"></script>
        <script src="js/menus.js"></script>
        <script src="js/datetime.js"></script>      
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
                    <a href="index.php">Startseite</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="treffer_0" onclick="myFunction_1()">Daten abrufen</a>
                <div class="dropdown-inhalt_0" id="auswahl_1">
                    <a href="showGraphics.php">Grafik erstellen</a>
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
    <center><h2>Temperatur-Projekt</h2></center>
    <p>Diese Seite zeigt zunächst die ersten 50 Records ab erster Aufzeichnung an. Nach Betätigung des SubmitButtons werden die nächsten Records, abhängig von der DropDwonBox angezeigt.</p>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <center>
            <div id="dropdown">
                <?php
                require_once 'inc/anzeigen.php';
                echo auswahlStep(50, 50, 500);
                ?>
            </div>
            <div id="submitDropDown">
                <label>DropDown</label>
                <input class="button3" type="submit" name="submit0" value="Submit">
            </div>
            <br>
        </center>
    </form>
    <?php
    session_start();
    require_once 'inc/autoloader.php';
    spl_autoload_register('classAutoloader');
    $DatabaseObject = new MySQLClass('root', '', 'mysql', '192.168.1.10', 'temperatur');
    $connection = $DatabaseObject->Verbinden();
    if (!$connection) {
        print_r("MySQL-Aufbau ist gescheitert!<br>");
        die();
    }
    if (!empty($_REQUEST['submit0'])) {
        $boolQuery = true;
        $_SESSION['dropD'] += $_REQUEST["anzahlItems"];
    } else {
        $boolQuery = false;
        $_SESSION['dropD'] = 50;
    }
    if (!$boolQuery)
        $sql = "SELECT id,datum,uhrzeit,Temperatur_Celsius,Luftfeuchtigkeit_Prozent,created_at FROM temperaturs LIMIT 50";
    else {
        $id = $_SESSION['dropD'];
        $sql = "SELECT id,datum,uhrzeit,Temperatur_Celsius,Luftfeuchtigkeit_Prozent,created_at FROM temperaturs WHERE id>=$id LIMIT 50";
    }
    $query1 = $DatabaseObject->Abfragen($connection, $sql);
    if (is_array($query1)) {
        anzeigen($query1);
    } else {
        print_r('!!Error!!<br>Datenbankfehler. Abbruch!');
        die();
    }
    ?>

