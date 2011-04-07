<?php

//Este archivo se llama mediante AJAX y se le pasa por post la variable id

include "conectar.php";  
include "funciones.php";  

$fecha = $_POST['f'];

for($i=0; $i<91;$i++)
  showTake( $fecha, "09:27" );

//parse_str($row[0], $a);
//echo utf8_encode($row[0])."$".$a'dia'];
//



?>
