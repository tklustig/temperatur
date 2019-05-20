<?php

error_reporting(E_ALL ^ E_NOTICE);
// Grafik erzeugen
$im = imagecreate(400, 400);
// Farben, Schriftart
$grau = imagecolorallocate($im, 192, 192, 192);
imagefill($im, 0, 0, $grau);
$s = imagecolorallocate($im, 0, 0, 0);
$r = imagecolorallocate($im, 255, 0, 0);
$folder = getcwd();
$schriftart = $folder . "/inc/coolvetica.ttf";
// Enddatum
$ds = "28.02.2012";
$datum = mktime(0, 0, 0, substr($ds, 3, 2), substr($ds, 0, 2), substr($ds, 6, 4));
$datum = strtotime("-35 day", $datum);

// Werte
spl_autoload_register('classAutoloader');
$DatabaseObject = new MySQLClass('root', '', 'mysql', '192.168.1.10', 'temperatur');
$connection = $DatabaseObject->Verbinden();
if (!$connection)
    print_r("MySQL-Aufbau ist gescheitert!");
$sql = "SELECT id,Temperatur_Celsius,Luftfeuchtigkeit_Prozent,datum,uhrzeit FROM temperaturs WHERE id>=4989 AND MOD(id,2)=1 ORDER BY id ASC LIMIT 12";
$query1 = $DatabaseObject->Abfragen($connection, $sql);
$temperaturA = array();
$uhrzeitA = array();
for ($i = 0; $i < count($query1); $i++) {
    $record = $query1[$i]['Temperatur_Celsius'];
    array_push($temperaturA, $record);
    $record = $query1[$i]['uhrzeit'];
    array_push($uhrzeitA, $record);
}
srand((double) microtime() * 1000000);

/* $kurs[0] = 25;
  for ($i = 1; $i < 36; $i++) {
  $kurs[$i] = $kurs[$i - 1] + rand(-3, 3);
  if ($kurs[$i] < 1)
  $kurs[$i] = 1;
  }
 */
// Gitternetz, Beschriftung
for ($i = 0; $i < count($uhrzeitA); $i++) {
    $x = 30 + $i * 340 / count($uhrzeitA);
    $y = max($temperaturA) - $i;
    $z = 12 + $i * 340 / count($uhrzeitA);
    imageline($im, 30, $x, 370, $x, $s);
    imagettftext($im, 11, 0, 375, $x, $s, $schriftart, $y);
    imageline($im, $x, 30, $x, 370, $s);
    $time = date("G:i", strtotime($uhrzeitA[$i]));
    imagettftext($im, 11, 0, $z, 385, $s, $schriftart, $time);
}

// Kurs darstellen
for ($i = 1; $i < count($temperaturA)-1; $i++){
    $x=$temperaturA[$i]+12;
    $y=$temperaturA[$i]+12;
    $z=$temperaturA[$i+1]+12+$i*30;
    $xx=$temperaturA[($i+1)]+12;
    imageline($im, $x, $y,$z,$xx, $r);
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