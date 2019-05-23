<?php

session_start();
error_reporting(E_ALL ^ E_NOTICE);
// Grafik erzeugen
$im = imagecreate(400, 400);
// Farben, Schriftart
$grau = imagecolorallocate($im, 192, 192, 192);
imagefill($im, 0, 0, $grau);
$s = imagecolorallocate($im, 0, 0, 0);
$r = imagecolorallocate($im, 255, 0, 0);
$folder = getcwd();
$schriftart = $folder . "/inc/Free Hustle Hardcore.ttf";
// Werte
spl_autoload_register('classAutoloader');
$DatabaseObject = new MySQLClass('root', '', 'mysql', '192.168.1.10', 'temperatur');
$connection = $DatabaseObject->Verbinden();
if (!$connection)
    print_r("MySQL-Aufbau ist gescheitert!");
if (isset($_SESSION['pk']))
    $id = $_SESSION['pk'];
else
    $id = 100;
$sql = "SELECT id,Temperatur_Celsius,Luftfeuchtigkeit_Prozent,datum,uhrzeit FROM temperaturs WHERE id>=$id ORDER BY id ASC LIMIT 12";
$query1 = $DatabaseObject->Abfragen($connection, $sql);
$temperaturA = array();
$uhrzeitA = array();
for ($i = 0; $i < count($query1); $i++) {
    $record = $query1[$i]['Temperatur_Celsius'];
    array_push($temperaturA, $record);
    $record = $query1[$i]['uhrzeit'];
    array_push($uhrzeitA, $record);
}
// Gitternetz, Beschriftung
for ($i = 0; $i < count($uhrzeitA); $i++) {
    imageline($im, 30, 30 + $i * 340 / count($uhrzeitA), 370, 30 + $i * 340 / count($uhrzeitA), $s);
    imagettftext($im, 11, 0, 375, 30 + $i * 340 / count($uhrzeitA), $s, $schriftart, max($temperaturA) - $i);
    imageline($im, 30 + $i * 340 / count($uhrzeitA), 30, 30 + $i * 340 / count($uhrzeitA), 370, $s);
    $time = date("G:i", strtotime($uhrzeitA[$i]));
    imagettftext($im, 11, 0, 25 + $i * 340 / count($uhrzeitA), 380, $s, $schriftart, $time);
}

// Temperatur darstellen:11,11,11,12,12,12,12,12,12,13,13,13
for ($i = 0; $i < count($temperaturA) - 1; $i++) {
    imageline($im, ($i + 1) * 300 / 10, 130 - $temperaturA[$i] * 130 / 50, ($i + 2) * 300 / 10, 130 - $temperaturA[$i + 1] * 130 / 50, $r);
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