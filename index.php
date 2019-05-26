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
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="treffer_0" onclick="myFunction_1()">Daten abrufen</a>
                <div class="dropdown-inhalt_0" id="auswahl_1">
                    <a href="showGraphics.php">Grafik erstellen</a>
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
        <audio id="sound" controls src="https://wiki.selfhtml.org/local/Europahymne.mp3" type="audio/mp3"></audio> 
    <center><h2>Temperatur-Projekt</h2>
        <div id="pic1"></div>
        <div id="pic2"></div>
        <script>
            var breiteCheck = screen.width >= 1680 ? true : false;
            var hoeheCheck = screen.height >= 1050 ? true : false;
            if (hoeheCheck && breiteCheck) {
                var bild = new Array();
                bild[0] = '<img id="bild1" src="img/home.jpg" alt="Picture1 not available">';
                bild[1] = '<img id="bild2" src="img/homeS.jpg" alt="Pictures2 not available">';
                document.getElementById("pic1").innerHTML = bild[0];
                document.getElementById("pic2").innerHTML = bild[1];
            }
        </script>
        <p>Dieses Projekt liest die Temperaturdaten aus meiner Datenbank aus und stellt sie grafisch dar. Sie werden folgendermaßen erstellt</p>    
        <ol>
            <li id="abc">C-Programme(Sourcecode) bilden den Treiber für einen Temperatursensor auf meinem Pi bzgl. Grad(in Celsius) und Luftfeuchtigkeit(in Prozent) meiner Wohnung.</li>
            <li>Ein Shell Script ruft ein Python-Programm auf, welches über die importierte Python-Library(Adafruit), die den C-Treiber nutzt, die Werte ausliest.</li><br>
            <li>Das Shell-Script, welches über einen CronJob alle 30 Minuten aufgerufen wird, schreibt daraufhin die über Python ermittelten Werte in eine MySQL Datenbank.</li>           
            <li>Über das Menu können die Temperatur-und Luftfeuchtigkeitswerte abgerufen werden, sowohl grafisch als auch tabellarisch.</li>
            <li>Da der CronJob doppelt aufgerufen wird, sollten die Werte über den Adminberich bereinigt werden! Im Adminbereich können Werte auch gelöscht werden.</li>
        </ol>
        <?php
        require_once 'inc/autoloader.php';
        spl_autoload_register('classAutoloader');
        $DatabaseObject = new MySQLClass('root', '', 'mysql', '192.168.1.10', 'temperatur');
        $connection = $DatabaseObject->Verbinden();
        if (!$connection) {
            print_r("MySQL-Aufbau ist gescheitert!<br>");
            die();
        }
        $sql = "SELECT count(id) FROM temperaturs";
        $query1 = $DatabaseObject->Abfragen($connection, $sql);
        ?>
        <div>
            <br><br><br><p class="pSpecial">Es wurden <?= $query1[0]['count(id)'] ?> <a class="tooltip" href="showGraphics.php">Meßdaten<span>Records grafisch anzeigen</span></a> gefunden
        </div></center>
</body>
</html>