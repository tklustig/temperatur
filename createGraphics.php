<?php
session_start();
//Damit die Bilderzeugung funktioniert, darf keine PHP Datei eingebunden werden. Deshalb muss der Autoloader aus dem Script geladen werden.
spl_autoload_register('classAutoloader');
$DatabaseObject = new MySQLClass('root', '1918rott', 'mysql', '127.0.0.1', 'temperaturs');
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
$sql = "SELECT id,Temperatur_Celsius,ROUND(611.2 * EXP((17.62*Luftfeuchtigkeit_Prozent)/(243.12+Luftfeuchtigkeit_Prozent))/100,2) AS Luftfeuchtigkeit_Prozent,datum,uhrzeit FROM temperaturs WHERE id>=$id ORDER BY id ASC LIMIT 12";
$query1 = $DatabaseObject->Abfragen($connection, $sql);
// Initialisiere vier Arrays
$temperaturA = array();
$uhrzeitA = array();
$datumA = array();
$luftFeuchtigkeitA = array();
//Verfrachte die gefundenen Datenbankwerte in die initialisierten Arrays
if(is_array($query1)){
	for ($i = 0; $i < count($query1); $i++) {
		$record = $query1[$i]['Temperatur_Celsius'];
		array_push($temperaturA, $record);
		$record = $query1[$i]['uhrzeit'];
		if (strpos($record, '0') == 0)
			$record = substr($record, 1);
		array_push($uhrzeitA, $record);
		$record = $query1[$i]['datum'];
		array_push($datumA, $record);
		$record = $query1[$i]['Luftfeuchtigkeit_Prozent'];
		array_push($luftFeuchtigkeitA, $record);
	}
}else{
	print_r("Fehler. Die Datenbankabfrage ergab $query1. Abbruch");
	die();
}
$folder = getcwd();
require_once $folder . '/inc/graphicsLibrary/jpgraph.php';
require_once $folder . '/inc/graphicsLibrary/jpgraph_line.php';
// Instanziere ein Objekt der importierten Klasse
$graph = new Graph(600, 500);
$graph->SetMargin(40, 150, 40, 30);
$graph->SetMarginColor('white');

// Hier wird der Max-Wert fuer das Datum festgelegt
$graph->SetScale('intlin', 0, 100);
$graph->yscale->ticks->Set(10);
$graph->title->Set(max($datumA));
$graph->title->SetFont(FF_ARIAL, FS_NORMAL, 14);
$graph->xgrid->Show();
$graph->ygrid->Show();
$graph->xgrid->SetLineStyle("solid");
$graph->xgrid->SetColor('#E3E3E3');
$graph->xaxis->SetTickLabels($uhrzeitA);
$graph->SetYScale(0, 'lin', -20, 30);
$graph->yaxis->SetColor('blue');
$graph->legend->SetLayout(LEGEND_VERT);
$graph->legend->SetPos(0, 0.50, 'right', 'top');
$feuchtigkeitObject = new LinePlot($luftFeuchtigkeitA);
$graph->Add($feuchtigkeitObject);
$feuchtigkeitObject->SetColor('blue');
$feuchtigkeitObject->SetLegend('Sättigung');

$tempObject = new LinePlot($temperaturA);
$graph->AddY(0, $tempObject);
$tempObject->SetColor('red');
$tempObject->SetLegend('Temperatur', 4);
$graph->ynscale[0]->ticks->Set(5);
$graph->ynaxis[0]->SetColor('red');

// Stelle den Graphen dar
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

