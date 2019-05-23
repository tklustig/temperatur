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
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body> <!-- Definition des Bodybereiches -->
        <div class="mainDiv">
            <div id="uhr"></div>
        </div>
        <img src="counter.php" title="Pic1" alt="Picture1">
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
                    <a href="graphics.php">Grafik erstellen</a>
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
    <center><h2>Temperatur-Projekt</h2>
        <p>Diese Seite löscht alle doppelten Einträge in der Datenbank. Dazu betätigen Sie bitte den Submitbutton.</p></center>
    <?php
    include_once 'inc/autoloader.php';
    error_reporting(E_ALL ^ E_NOTICE);
    spl_autoload_register('classAutoloader');
    $DatabaseObject = new MySQLClass('root', '', 'mysql', '192.168.1.10', 'temperatur');
    $connection = $DatabaseObject->Verbinden();
    if (!$connection)
        print_r("MySQL-Aufbau ist gescheitert!");
    $sql = "SELECT id,uhrzeit FROM temperaturs WHERE id>48284;";
    $query1 = $DatabaseObject->Abfragen($connection, $sql);
    for ($i = 0; $i < count($query1); $i++) {
        if ($query1[$i]['uhrzeit'] == $query1[$i + 1]['uhrzeit']) {
            $StartIdForDeleting = $query1[$i]['id'];
            break;
        }
    }
    ?>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <center><p class="pSpecial">StartId: <?php if (!empty($StartIdForDeleting))
        echo $StartIdForDeleting;
    else
        echo "Unknown";
    ?> </p>
            <input class="button2" type="submit" name="submit0" value="Submit">
        </center>
    </form>
        <?php
        if (empty($StartIdForDeleting) || $StartIdForDeleting == null) {
            ?> 
        <center><p>Es wurden keine doppelten Einträge gefunden.</p>
            <?php
        }
        if (!empty($_REQUEST['submit0'])) {
            if (!empty($StartIdForDeleting) && $StartIdForDeleting != null) {
                $sql = "DELETE FROM temperaturs WHERE MOD(id,2)=1 AND id>=$StartIdForDeleting;";
                $query1 = $DatabaseObject->Abfragen($connection, $sql);
                if (!is_array($query1) && $query1) {
                    ?> 
                    <center><p class="pSpecial">Alle doppelten Einträge ab Id: <?= $StartIdForDeleting ?> wurden aus der Datenbank entfernt!</p>
                        <?php
                    }
                } else {
                    ?>
                    <center><p class="pSpecial">Da keine doppelten Einträge gefunden wurden, bleibt der Request wirkungslos.</p>  
                        <?php
                    }
                }
                ?>
                </body>
                </html>


