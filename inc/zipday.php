<?php 

error_reporting(E_ALL);
session_start();

include_once("../backend/funciones.php");
include_once("createzip.php");

db_connect();

// Fecha pasada como parámetro
$d = explode("/", $_GET['d']);
$date = $d[2] . "-";
$date .= (strlen($d[1])<2) ? "0".$d[1] : $d[1];
$date .= "-";
$date .= (strlen($d[0])<2) ? "0".$d[0] : $d[0];
$today = $date;

// Función recursiva para obtener el contenido de un directorio
/*
function fun_dir($dir,&$A,$path=0)
{
  $d = dir($dir);
  $path=$path?$path:$dir;

  while($df=$d->read()){ 
    if($df=="." || $df==".." || $df=="thumbs")
      continue;

    if(is_file($d->path.$df)){
      $A[str_replace($path,"",$d->path.$df)]=file_get_contents($d->path.$df);
    }
    else{
      $A[str_replace($path,"",$d->path.$df)."/"]=""; 
      fun_dir($d->path.$df."/",$A,$path); 
     }
  }
  $d->close();   
}
*/

// Directorio de las imágenes
$IMG_DIR="../wolken/";

// Comprobar que existe el directorio correspondiente a esa fecha
if(!is_dir($IMG_DIR . $today))
  die("Error: El día ". $today ." no tiene capturas.");

$cont=array();
$takes = array();
$takes = getCapturesByDay($today);

// Para cada toma de ese día
for($i=0; $i<count($takes); $i++){
  $time = $takes[$i]['hora'];
  $timedir = str_replace(":", "", $time);
  $log = "Capturas realizadas el día $today a las $time\n\n";
  $take = getTake($today, $time);

  // Para cada imagen de esa toma
  for($j=0; $j<count($take); $j++){
    $t = $take[$j]['toma'];
    $t = (strlen($t)<2) ? "0".$t : $t;
    $bmp = "{$t}.bmp";

    $log .= $bmp . "\n";
    $log .= "   Agudeza:    " . $take[$j]['agudeza'] . "\n";
    $log .= "   Brillo:     " . $take[$j]['brillo'] . "\n";
    $log .= "   Contraste:  " . $take[$j]['contraste'] . "\n";
    $log .= "   Exposición: " . $take[$j]['exposicion'] . "\n";
    $log .= "   Gamma:      " . $take[$j]['gamma'] . "\n";
    $log .= "   Ganancia:   " . $take[$j]['ganancia'] . "\n";
    $log .= "   Saturación: " . $take[$j]['saturacion'] . "\n";
    $log .= "   Tonalidad:  " . $take[$j]['tonalidad'] . "\n";
    $log .= "\n";

    // Añadir fichero al ZIP
    $cont["{$today}/{$timedir}/{$bmp}"] = file_get_contents($IMG_DIR . "{$today}/{$timedir}/{$bmp}");
  }
  // Añadir el fichero de parámetros al ZIP
  $cont["{$today}/{$timedir}/leeme.txt"] = $log;
}

// Generar el ZIP
$data = createzip($cont) or die("Error: al construir el ZIP.");

// Forzar la descarga del ZIP
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Content-Description: File Transfer"); 
header("Content-Type: application/force-download"); 
header("Content-Length: " . strlen($data)); 
header("Content-Disposition: attachment; filename=wolken_". $today .".zip"); 
echo $data;

?>
