<?php

//Este archivo se llama mediante AJAX y se le pasa por post la variable id

include "conectar.php";  
include "funciones.php";  
include "backend/funciones.php";  

$fecha = $_POST['f'];

//sleep(1);

db_connect();

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
