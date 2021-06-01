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
        <!--  JQuery Bibliotheken -->
        <script src="js/jquery-1.7.1.min.js"></script>
        <script src="js/jquery-ui-1.8.17.custom.min.js"></script>
        <script src="js/menus.js"></script>
        <script src="js/datetime.js"></script> 
        <script src="js/Alert.js"></script>
        <!--  CSS Bibliotheken -->
        <link href="css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="css/jquery-ui-1.8.17.custom.css">
        <style type="text/css">p{font-family:verdana,arial;font-size:80%}</style>
    </head>

    <body> <!-- Definition des Bodybereiches -->
        <script>
            $(document).ready(function () {
                $('#date').datepicker({
                    showOn: 'button',
                    buttonImage: 'calendar.png',
                    buttonImageOnly: true,
                    numberOfMonths: 2,
                    showButtonPanel: true,
                    autoSize: true,
                    monthNames: ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"],
                    dateFormat: 'dd-mm-yy'
                });
            });
        </script>
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
                alert("Programmierer &  V.i.S.d.P: Thomas Kipp\nAnschrift:\nDebberoder Str.61\n30659 Hannover\nMobil:0152/37301327");
            }
        </script>
    <center><h1>Schaubilder</h1>
        <p class="pSpecialo">Graphische Darstellung der Temperatur-und Luftfeuchtigkeitswerte</p>
    </center>
    <?php
    require_once 'inc/connect.php';
    $connection = $DatabaseObject->Verbinden();
    if (!$connection) {
        print_r("MySQL-Aufbau ist gescheitert!<br>");
        die();
    }
    $sql = "SELECT max(id) AS max,min(id) AS min FROM temperaturs;";
    $query1 = $DatabaseObject->Abfragen($connection, $sql);
    if (is_array($query1)) {
        $valueMax = $query1[0]['max'];
        $valueMin = $query1[0]['min'];
        $DatabaseObject->closeConnection($connection);
    } else {
        print_r("Fehler bei der Datenbankabfrage!");
        die();
    }
    if (isset($_GET['query'])) {
        if ($_GET['query'] == 1 && isset($_SESSION['pk'])) {
            $_SESSION['pk'] -= 2;
        } else if ($_GET['query'] == 2 && isset($_SESSION['pk'])) {
            //+11, da 10 Werte angezeigt werden
            if ($_SESSION['pk'] + 11 >= $valueMax) {
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
            } else
                $_SESSION['pk'] += 2;
        } else if ($_GET['query'] == 3 && isset($_SESSION['pk']))
            $_SESSION['pk'] = mt_rand($valueMin, $valueMax);
    }
    if (isset($_SESSION['pk']) && $_SESSION['pk'] < 0 && $_SESSION['pk'] != -2) {
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
        $_SESSION['pk'] = 1;
    }
    ?>
    <div>
        <center>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div>
                    <input class="feld" type=text name="date0" id="date" placeholder="Datum:" value="<?php
                    if (!empty($_REQUEST['date0'])) {
                        echo $_REQUEST['date0'];
                    }
                    ?>">
                </div>
                <br>
                <img src="createGraphics.php" alt="not available">  
                <br>
                <a href="?query=1">früher</a>
                <a href="?query=2">später</a>
                <a href="?query=3">zufällig</a> 
                <div>
                    <br>
                    <label>Id zurücksetzen</label>
                    <input class="button3" type="submit" name="submit0" value="Submit">
                </div>
                <div>
                    <br>
                    <label>gemäß Datum anzeigen</label>
                    <input class="button3" type="submit" name="submit1" value="Submit">
                </div>
            </form>
        </center>
    </div>
</body>
</html>
<?php
//wurde ein SetbackId-Request abgefeuert?
if (!empty($_REQUEST['submit0'])) {
    $_SESSION['pk'] = 1;
    ?>
    <script>
        var alertWidth = 300;
        var alertHeight = 150;
        var xAlertStart = window.screen.availWidth / 2 - alertWidth;
        var yAlertStart = window.screen.availHeight / 2 - alertHeight;
        var alertTitle = "<p class='pTitle'><b>! Information !</b></p>";
        var alertText = "<p class='pAlert'>Sie befinden sich jetzt am unteren Ende der Meßwerte!</p>";
        showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
    </script>
    <?php
    //wurde ein Datumrequest abgefeuert?
} else if (!empty($_REQUEST['submit1'])) {
    //das Datumfeld ist nicht leer?
    if (!empty($_REQUEST['date0'])) {
        $strDatum = '';
        //splitte das Datumfeld anhand des Trenners(-) in ein Array
        $arrayOfDate = explode('-', $_REQUEST['date0']);
        //iteriere über das Array und setze den Datumstring so zusammen, dass die Datenbank ihn erkennt
        for ($i = 0; $i < count($arrayOfDate); $i++) {
            if ($i != count($arrayOfDate) - 1)
                $strDatum .= $arrayOfDate[count($arrayOfDate) - $i - 1] . '-';
            else
                $strDatum .= $arrayOfDate[0];
        }
        //jetzt enthalt die Variable strDatum das Datum so, wie ihn die Datenbank mitunter enthält. Initialisere Datenbankabfrage
        require_once 'inc/connect.php';
        $connection = $DatabaseObject->Verbinden();
        if (!$connection) {
            print_r("MySQL-Aufbau ist gescheitert!<br>");
            die();
        }
        $sql = "SELECT id,datum FROM temperaturs;";
        $query1 = $DatabaseObject->Abfragen($connection, $sql);
        if (is_array($query1)) {
            //Iteriere über das Array(query1) und überprüfe, ob strDatum in der Datenbank enthalten ist
            for ($i = 0; $i < count($query1); $i++) {
                //Sofern der Wert gefunden wurde, weise ihn der Session zu und verlasse die Schleife
                if ($strDatum == $query1[$i]['datum']) {
                    $_SESSION['pk'] = $query1[$i]['id'];
                    break;
                    //andernfalls setze die Session auf -1
                } else {
                    $_SESSION['pk'] = -2;
                }
            }
        } else {
            print_r("Fehler bei der Datenbankabfrage!");
            die();
        }
        //Sofern der Wert nicht gefunden wurde, benachrichtige den User
        if ($_SESSION['pk'] == -2) {
            ?>
            <script>
                var alertWidth = 300;
                var alertHeight = 150;
                var xAlertStart = window.screen.availWidth / 2 - alertWidth;
                var yAlertStart = window.screen.availHeight / 2 - alertHeight;
                var alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
                var alertText = "<p class='pAlert'>Das angeforderte Datum konnte nicht gefunden werden. Suchen sie ggf. erneut mit einem anderen Datum!</p>";
                showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
            </script>
            <?php
        }
        //das Datumfeld ist leer
    } else {
        ?>
        <script>
            var alertWidth = 300;
            var alertHeight = 150;
            var xAlertStart = window.screen.availWidth / 2 - alertWidth;
            var yAlertStart = window.screen.availHeight / 2 - alertHeight;
            var alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
            var alertText = "<p class='pAlert'>Bitte wählen Sie über das Kalendersymbol ein Datum aus, bevor Sie das nächste mal einen Request abfeuern!</p>";
            showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
        </script>
        <?php
    }
}
?>
<?php
if ($DatabaseObject != null)
    $DatabaseObject->closeConnection($connection);
?>