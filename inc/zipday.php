<?php 

error_reporting(E_ALL);
session_start();

include_once("../backend/funciones.php");
include_once("createzip.php");

db_connect();

// Fecha pasada como parámetro
$d = explode("/", $_GET['d']);
$date = $d[2] . "-";
$date .= ($d[1]<10) ? "0".$d[1] : $d[1];
$date .= "-";
$date .= ($d[0]<10) ? "0".$d[0] : $d[0];
$today = $date;

// Función recursiva para obtener el contenido de un directorio
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

// Directorio de las imágenes
$IMG_DIR="../wolken/";

// Comprobar que existe el directorio correspondiente a esa fecha
if(!is_dir($IMG_DIR . $today))
  die("Error: El día ". $today ." no tiene capturas.");

// Generar el ZIP
$cont=array();
fun_dir($IMG_DIR, $cont);
$cont["leeme.txt"]="Zip generado el día ".date("Y-m-d H:i:s");
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
