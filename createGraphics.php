<?php

session_start();
/* Damit die Bilderzeugung funktioniert, darf keine PHP Datei eingebunden werden. Deshalb muss der Autoloader aus dem Script geladen werden.
  Auch die Errormeldungen können nicht eingebunden werden, sondern müssen an Ort und Stelle codiert werden. Desweiteren müssen im Ordner
  .\Temperatur\inc\graphicsLibrary\fonts\*.* die beiden trueType-Schriften arial.ttf und DejaVuSans.ttf vorhanden sein, da die Library ansonsten auf nicht
  zugreifbare Ordner zugreift
 */
spl_autoload_register('classAutoloader');
define('prefix', 'k158364_');
define('OPS', 'WINNT');
if (PHP_OS == OPS) {
    $username = 'root';
    $server = 'localhost';
    $password = '';
    $database = 'temperaturs';
    //DatenbankErzeugen($dsn, $username, $password);
    //dieser else-Zweig kann dekommentiert werden, sofern auch für LINUX eine Datenbank angelegt werden soll. Dazu werden allerdings die Parameter benötigt
} else {
    $username = "k158364_kipp"; //für LINUX muss hier der Benutzer...
    $server = 'mysql2efb.netcup.net';
    $password = "xyz"; //und hier das Passwort angegegeben werden
    $database = prefix . 'tklustig';
    //DatenbankErzeugen($dsn, $username, $password);
}
$DatabaseObject = new MySQLClass($username, $password, 'mysql', $server, $database);
$connection = $DatabaseObject->Verbinden();
if (!$connection) {
    print_r("MySQL-Aufbau ist gescheitert!<br>");
    die();
}
if (isset($_SESSION['pk']))
    $id = $_SESSION['pk'];
else {
    $_SESSION['pk'] = 1;
    $id = $_SESSION['pk'];
}
$sql = "SELECT id,Temperatur_Celsius,Luftfeuchtigkeit_Prozent,datum,uhrzeit FROM temperaturs WHERE id>=$id ORDER BY id ASC LIMIT 12";
$query1 = $DatabaseObject->Abfragen($connection, $sql);
$temperaturA = array();
$uhrzeitA = array();
$datumA = array();
$luftFeuchtigkeitA = array();
for ($i = 0; $i < count($query1); $i++) {
    $record = $query1[$i]['Temperatur_Celsius'];
    array_push($temperaturA, $record);
    $record = $query1[$i]['uhrzeit'];
    if (strpos($record, '0') === 0)
        $record = substr($record, 1);
    if (strlen($record) > 5) {
        $record = substr($record, 0, -3);
    }
    array_push($uhrzeitA, $record);
    array_push($datumA, $query1[$i]['datum']);
    $record = $query1[$i]['Luftfeuchtigkeit_Prozent'];
    array_push($luftFeuchtigkeitA, $record);
}
$folder = getcwd();
require_once $folder . '/inc/graphicsLibrary/jpgraph.php';
require_once $folder . '/inc/graphicsLibrary/jpgraph_line.php';
/* $path2Library="https://jpgraph.net/";
  require_once $path2Library . 'jpgraph/jpgraph.php'; */

// Setup the graph
$graph = new Graph(600, 500);
$graph->SetMargin(40, 150, 40, 30);
$graph->SetMarginColor('white');

// Hier wird der Min- und Max-Wert fuer die Feuchtigkeit festgelegt
$graph->SetScale('intlin', 0, 100);
$graph->yscale->ticks->Set(10);
$graph->title->Set(max($datumA));
$graph->title->SetFont(FF_ARIAL, FS_NORMAL, 14);
$graph->xgrid->Show();
$graph->ygrid->Show();
$graph->xgrid->SetLineStyle("solid");
$graph->xgrid->SetColor('#E3E3E3');
$graph->xaxis->SetTickLabels($uhrzeitA);

// Hier wird der Min- und Max-Wert fuer die Temperatur festgelegt
$graph->SetYScale(0, 'lin', -20, 30);

$graph->yaxis->SetColor('blue');
$graph->legend->SetLayout(LEGEND_VERT);
$graph->legend->SetPos(0, 0.50, 'right', 'top');
$feuchtigkeitObject = new LinePlot($luftFeuchtigkeitA);
$graph->Add($feuchtigkeitObject);
$feuchtigkeitObject->SetColor('blue');
$feuchtigkeitObject->SetLegend('Luftfeuchtigkeit');

$tempObject = new LinePlot($temperaturA);
$graph->AddY(0, $tempObject);
$tempObject->SetColor('red');
$tempObject->SetLegend('Temperatur', 4);
$graph->ynscale[0]->ticks->Set(5);
$graph->ynaxis[0]->SetColor('red');

// Output line
$graph->Stroke();

//Kann nicht ausgelagert werden(s.o.)
function classAutoloader($class) {
    $path = "inc/$class.php";
    if (file_exists($path)) {
        require $path;
    } else {
        print_r("Klasse exisitert nicht");
        die();
    }
}
?>

