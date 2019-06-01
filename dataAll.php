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
        <script src="js/menus.js"></script>
        <script src="js/datetime.js"></script> 
        <script src="js/Alert.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="crossorigin="anonymous"></script>
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
                    <a href="index.php">Startseite</a>
                </div>
            </li>
        </ul>
        <script>
            function impressum() {
                alert("Programmierer &  V.i.S.d.P: Thomas Kipp\nAnschrift:\nKlein - Buchholzer - Kirchweg 25\n30659 Hannover\nMobil:0152/37389041");
            }
        </script>
    <center><h2>Daten ohne Filter</h2></center>
    <p>Diese Seite zeigt zunächst die ersten 50 Records ab erster Aufzeichnung an. Nach Betätigung des SubmitButtons werden die nächsten Records angezeigt. Die Id hat Vorrang!</p>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <center>
            <div id="dropdown">
                <?php
                require_once 'inc/anzeigen.php';
                echo auswahlStep(48, 48, 1500);
                ?>
            </div>
            <div id="textbox1">
                <?php
                require_once 'inc/autoloader.php';
                spl_autoload_register('classAutoloader');
                $DatabaseObject = new MySQLClass('root', '', 'mysql', '192.168.1.10', 'temperatur');
                $connection = $DatabaseObject->Verbinden();
                if (!$connection) {
                    print_r("MySQL-Aufbau ist gescheitert!<br>");
                    die();
                }
                $sql = "SELECT max(id) AS max FROM temperaturs";
                $query1 = $DatabaseObject->Abfragen($connection, $sql);
                if (is_array($query1))
                    $maxId = $query1[0]['max'];
                else {
                    print_r('!!Error!!<br>Datenbankfehler. Abbruch!');
                    die();
                }
                ?>
                <label>Ab Id:</label>
                <input type="text" name="startId" size="30" maxlength="30" placeholder="maximal bis zu ID: <?= $maxId ?>">
            </div>
            <div id="submitDropDown">
                <label>Abfeuern!</label>
                <input class="button3" type="submit" name="submit0" value="Submit">
            </div>
            <div>
                <input type="radio" name="rad" id="dummy1" value="frontOf">vor
                <input type="radio" name="rad" id="dummy2" value="back">zurück
            </div>
            <br>
        </center>
    </form>
    <script>
        function saveContents() {
            var rbIsClicked = $("input[type='radio'][name='rad']:checked");
            if (rbIsClicked.length != 0)
                localStorage['rbIsClicked'] = rbIsClicked.attr("id");
        }
        function restoreContents() {
            var rbIsClicked = localStorage['rbIsClicked'];
            if (rbIsClicked != undefined) {
                $('#' + rbIsClicked).attr('checked', true);
            }
        }
        $("input[type='radio'][name='rad']").on("change", saveContents);
        restoreContents();
    </script>
    <?php
    $folder = getcwd();
    $datei = $folder . '/txt/dropDownID.txt';
    require_once 'inc/autoloader.php';
    spl_autoload_register('classAutoloader');
    $DatabaseObject = new MySQLClass('root', '', 'mysql', '192.168.1.10', 'temperatur');
    $connection = $DatabaseObject->Verbinden();
    if (!$connection) {
        print_r("MySQL-Aufbau ist gescheitert!<br>");
        die();
    }
    $sql = "SELECT max(id) AS max FROM temperaturs";
    $query1 = $DatabaseObject->Abfragen($connection, $sql);
    if (is_array($query1))
        $maxId = $query1[0]['max'];
    else {
        print_r('!!Error!!<br>Datenbankfehler. Abbruch!');
        die();
    }
    if (!empty($_REQUEST['submit0'])) {
        if (!empty($_REQUEST['startId'])) {
            $id = $_REQUEST['startId'];
            if (!is_numeric($id)) {
                ?>
                <script>
                    alertWidth = 250;
                    alertHeight = 200;
                    xAlertStart = 650;
                    yAlertStart = 200;
                    alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
                    alertText = "<p class='pAlert'>Nur Zahlen werden bzgl. der Primärschlüsselabfrage akzeptiert!</p>";
                    showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                </script>
                <?php
                die();
            }
            $sql = "SELECT id,datum,uhrzeit,Temperatur_Celsius,Luftfeuchtigkeit_Prozent,created_at FROM temperaturs WHERE id>=$id LIMIT 49";
            $query2 = $DatabaseObject->Abfragen($connection, $sql);
            if (is_array($query2))
                anzeigen($query2);
            else {
                print_r('!!Error!!<br>Datenbankfehler. Abbruch!');
                die();
            }
            file_put_contents($datei, $id);
            die();
        }
        $boolQuery2 = true;
        //Da Sessions hier aus unerklärlichen Gründen nicht funktionieren, wird die DropDown-Id in eine Textdatei geschrieben bzw. ausgelesen      
        $id = file_get_contents($datei);
        if (isset($_REQUEST['rad'])) {
            if ($_REQUEST['rad'] == 'frontOf') {
                $dummy = $id;
                $id += $_REQUEST["anzahlItems"];
                if ($id > $maxId) {
                    ?>
                    <script>
                        alertWidth = 250;
                        alertHeight = 200;
                        xAlertStart = 650;
                        yAlertStart = 200;
                        alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
                        alertText = "<p class='pAlert'>Sie befinden sich am oberen Ende der Meßwerte.<br>Bitte reduzieren, anstatt erhöhen!</p>";
                        showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                    </script>
                    <?php
                    $id = $dummy;
                } else
                    file_put_contents($datei, $id);
            } else if ($_REQUEST['rad'] == 'back') {
                $dummy = $id;
                $id -= $_REQUEST["anzahlItems"];
                if ($id < 0) {
                    ?>
                    <script>
                        alertWidth = 250;
                        alertHeight = 200;
                        xAlertStart = 650;
                        yAlertStart = 200;
                        alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
                        alertText = "<p class='pAlert'>Sie befinden sich am unteren Ende der Meßwerte.<br>Bitte erhöhen, anstatt reduzieren!</p>";
                        showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                    </script>
                    <?php
                    $id = $dummy;
                } else
                    file_put_contents($datei, $id);
            }
        } else
            print_r('!!ERROR!! Abbruch');
    } else {
        if (file_exists($datei))
            unlink($folder . '/txt/dropDownID.txt');
        $boolQuery2 = false;
        file_put_contents($datei, '50');
    }
    if (!$boolQuery2)
        $sql = "SELECT id,datum,uhrzeit,Temperatur_Celsius,Luftfeuchtigkeit_Prozent,created_at FROM temperaturs LIMIT 49";
    else
        $sql = "SELECT id,datum,uhrzeit,Temperatur_Celsius,Luftfeuchtigkeit_Prozent,created_at FROM temperaturs WHERE id>=$id LIMIT 49";
    $query2 = $DatabaseObject->Abfragen($connection, $sql);
    if (is_array($query2))
        anzeigen($query2);
    else {
        print_r('!!Error!!<br>Datenbankfehler. Abbruch!');
        die();
    }
    ?>

