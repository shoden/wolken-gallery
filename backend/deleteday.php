<?php 

error_reporting(E_ALL);
session_start();
include_once("funciones.php");

db_connect();

$d = explode("/", $_POST['f']);
$date = $d[2] . "-";
$date .= ($d[1]<10) ? "0".$d[1] : $d[1];
$date .= "-";
$date .= ($d[0]<10) ? "0".$d[0] : $d[0];

$deleted = deleteDay($date);

rrmdir("../wolken/" . $date);

if($deleted > 0)
  echo "Se han eliminado {$deleted} capturas.";
else
  echo "No se ha eliminado ninguna captura.";

?>
