<?php

ERROR_REPORTING(E_ALL);
session_start();

require_once("phpmylogon.php");

pml_login();

if( $_SESSION['pml_userid'] == "")
  exit;

?>
<html>
<head>
</head>
<body>
<a href="logout.php">Salir</a>
<br>

hola

</body>
</html>
