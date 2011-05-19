<?php

//Este archivo se llama mediante AJAX y se le pasa por post la variable id

include("funciones.php");  
include("../backend/funciones.php");  

db_connect();

$fecha = $_POST['f'];
$params = getParams();
$nparams = count($params);
$captures = getCapturesByDay($fecha);
$ncaptures = count($captures);

if(isset($_POST['list']))
  showTakeList();
else
  for($i=0; $i<$ncaptures; $i++) {
    showTake( $fecha, $captures[$i]['hora'] );
  }

?>
