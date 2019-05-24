<?php

session_start();
error_reporting(E_ALL ^ E_NOTICE);
// Werte
spl_autoload_register('classAutoloader');
$DatabaseObject = new MySQLClass('root', '', 'mysql', '192.168.1.10', 'temperatur');
$connection = $DatabaseObject->Verbinden();
if (!$connection) {
    print_r("MySQL-Aufbau ist gescheitert!<br>");
    die();
}
if (isset($_SESSION['pk']))
    $id = $_SESSION['pk'];
else
    $id = 100;
$sql = "SELECT id,Temperatur_Celsius,Luftfeuchtigkeit_Prozent,datum,uhrzeit FROM temperaturs WHERE id>=$id ORDER BY id ASC LIMIT 12";
$query1 = $DatabaseObject->Abfragen($connection, $sql);
$temperaturA = array();
$uhrzeitA = array();
$datumA = array();
for ($i = 0; $i < count($query1); $i++) {
    $record = $query1[$i]['Temperatur_Celsius'];
    array_push($temperaturA, $record);
    $record = $query1[$i]['uhrzeit'];
    if (strpos($record, '0') == 0)
        $record = substr($record, 1);
    array_push($uhrzeitA, $record);
    array_push($datumA, $query1[$i]['datum']);
}

// Grafik erzeugen
$im = imagecreate(400, 500);
// Farben, Schriftart
$grau = imagecolorallocate($im, 192, 192, 192);
imagefill($im, 0, 0, $grau);
$s = imagecolorallocate($im, 0, 0, 0);
$r = imagecolorallocate($im, 255, 0, 0);
$b = imagecolorallocate($im, 0, 0, 255);
$folder = getcwd();
$schriftart = $folder . "/inc/Free Hustle Hardcore.ttf";

/* die Daten, Temperatur und Feuchte (y-Achse) sowie Uhrzeit (x-Achse)
  $temperaturA = [11, 11, 11, 12, 12, 12, 12, 12, 12, 13, 13, 13];
  $feuchteA = [70, 70, 75, 75, 80, 80, 85, 85, 90, 90, 85, 85];
  $uhrzeitA = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"]; */

// Ursprung des Koordinatensystems in px festlegen
$xursprung = 20;
$yursprung = 470;

// Faktoren für Umrechnung der Indizes in px
$factorx = 30;
$factory = 30;

// Faktor um die Darstellung der Feuchte umzurechnen
$factoryhum = 10;

// Anzahl der Rasterlinien
$nrx = count($temperaturA) - 1;
$nry = count($uhrzeitA);

// x-Koordinate in px aus x-Wert ermitteln
function getx($x) {
    global $xursprung, $factorx;
    return $xursprung + $x * $factorx;
}

// y-Koordinate in px aus y-Wert ermitteln
function gety($y) {
    global $yursprung, $factory;
    return $yursprung - $y * $factory;
}

/* Gitternetz, Beschriftung
  vertikale Linien mit Beschriftung */
for ($i = 0; $i <= $nrx; $i++) {
    imageline($im, getx($i), gety(0), getx($i), gety($nry), $s);
    imagettftext($im, 11, 0, getx($i), gety(0) + 15, $s, $schriftart, $uhrzeitA[$i]);
}
// horizontale Linien mit Beschriftung
for ($j = min($temperaturA); $j <= max($temperaturA); $j++) {
    // Temperaturscala
    imageline($im, getx(0), gety($j), getx($nrx), gety($j), $s);
    imagettftext($im, 11, 0, getx($nrx) + 5, gety($j), $r, $schriftart, $j);
    /* Luftfeuchtigkeitsscala
      imagettftext($im, 11, 0, getx($nrx) + 25, gety($j), $b, $schriftart, $j * $factoryhum);
     */
}
// Temperaturwerte eintragen. Luftfeuchtigkeit folgt...
for ($k = 0; $k < $nrx; $k++) {
    imageline($im, getx($k), gety($temperaturA[$k]), getx($k + 1), gety($temperaturA[$k + 1]), $r);
    imagettftext($im, 20, 0, getx(0), gety(14), $s, $schriftart, $datumA[0]);
    //imageline($im, getx($k), gety($feuchteA[$k] / $factoryhum), getx($k + 1), gety($feuchteA[$k + 1] / $factoryhum), $b);
}
// Grafik darstellen
header("Content-Type: image/jpeg");
imagejpeg($im);
// Speicher freigeben
imagedestroy($im);
?>
<?php

function classAutoloader($class) {
    $path = "$class.php";
    if (file_exists($path)) {
        require $path;
    } else {
        print_r("Klasse exisitert nicht");
        die();
    }
}

?>