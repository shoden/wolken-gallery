<?php

ERROR_REPORTING(E_ALL);
session_start();

require_once("phpmylogon.php");

pml_login();

if( $_SESSION['pml_userid'] == "")
  exit;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es" dir="ltr">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="robots" content="index, follow" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <title>Galler&iacute;a</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css"/>
  <link href="../images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
</head>
<body>
<a href="logout.php">Salir</a>
<br>

<div class="take">
<div class="taketitle">Par&aacute;metros</div>

Hola

</div>
<div id="footer">2011 &copy; Departamento de F&iacute;sica Aplicada. Universidad de C&oacute;rdoba</div>

</body>
</html>
