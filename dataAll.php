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
                alert("Programmierer &  V.i.S.d.P: Thomas Kipp\nAnschrift:\nDebberoder Str.61\n30659 Hannover\nMobil:0152/37301327");
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
                require_once 'inc/connect.php';
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
                    foreach ($connection->errorInfo() as $item) {
                        print_r('<br>' . $item);
                    }
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
    $sql = "SELECT max(id) AS max FROM temperaturs";
    $query1 = $DatabaseObject->Abfragen($connection, $sql);
    if (is_array($query1))
        $maxId = $query1[0]['max'];
    else {
        print_r('!!Error!!<br>Datenbankfehler. Abbruch!');
        foreach ($connection->errorInfo() as $item) {
            print_r('<br>' . $item);
        }
        die();
    }
    if (!empty($_REQUEST['submit0'])) {
        if (!empty($_REQUEST['startId'])) {
            $id = $_REQUEST['startId'];
            if (!is_numeric($id)) {
                ?>
                <script>
                    var alertWidth = 250;
                    var alertHeight = 200;
                    var xAlertStart = window.screen.availWidth / 2 - alertWidth;
                    var yAlertStart = window.screen.availHeight / 2 - alertHeight;
                    var alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
                    var alertText = "<p class='pAlert'>Nur Zahlen werden bzgl. der Primärschlüsselabfrage akzeptiert!</p>";
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
                foreach ($connection->errorInfo() as $item) {
                    print_r('<br>' . $item);
                }
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
                if ($id <= 18000)
                    $id += $_REQUEST["anzahlItems"];
                else
                    $id += 2 * $_REQUEST["anzahlItems"];
                if ($id > $maxId) {
                    ?>
                    <script>
                        var alertWidth = 250;
                        var alertHeight = 200;
                        var xAlertStart = window.screen.availWidth / 2 - alertWidth;
                        var yAlertStart = window.screen.availHeight / 2 - alertHeight;
                        var alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
                        var alertText = "<p class='pAlert'>Sie befinden sich am oberen Ende der Meßwerte.<br>Bitte reduzieren, anstatt erhöhen!</p>";
                        showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                    </script>
                    <?php
                    $id = $dummy;
                } else
                    file_put_contents($datei, $id);
            } else if ($_REQUEST['rad'] == 'back') {
                $dummy = $id;
                if ($id <= 18000)
                    $id -= $_REQUEST["anzahlItems"];
                else
                    $id -= 2 * $_REQUEST["anzahlItems"];
                if ($id < 0) {
                    ?>
                    <script>
                        var alertWidth = 250;
                        var alertHeight = 200;
                        var xAlertStart = window.screen.availWidth / 2 - alertWidth;
                        var yAlertStart = window.screen.availHeight / 2 - alertHeight;
                        var alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
                        var alertText = "<p class='pAlert'>Sie befinden sich am unteren Ende der Meßwerte.<br>Bitte erhöhen, anstatt reduzieren!</p>";
                        showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                    </script>
                    <?php
                    $id = $dummy;
                } else
                    file_put_contents($datei, $id);
            }
        } else
            echo('<p><font color="red">!!ERROR!! Bitte einer der Radio-Buttons aktivieren</p></font>');
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
        foreach ($connection->errorInfo() as $item) {
            print_r('<br>' . $item);
        }
        die();
    }
    ?>
    <?php
    if ($DatabaseObject != null)
        $DatabaseObject->closeConnection($connection);
    ?>

