<?php
error_reporting(E_ALL);
include_once("inc/funciones.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es" dir="ltr">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="robots" content="index, follow" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <title>Galer&iacute;a</title>
  <script type="text/javascript" src="js/jquery.1.4.2.js"></script>
  <script type="text/javascript" src="js/jsDatePick.jquery.min.1.3.js"></script>
  <script type="text/javascript" src="js/jquery.lightbox-0.5.js"></script>
  <script type="text/javascript" src="js/ajax.js"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
  <link rel="stylesheet" type="text/css" href="css/jsDatePick_ltr.css" media="all" />
  <link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
  <link href="img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
</head>
<body>
<noscript>
<div class="error">Necesita activar Javascript en su navegador para poder ver esta p&aacute;gina correctamente.</div>
</noscript>
<script type="text/javascript" src="js/body.js"></script>
<div id="logo"><img src="img/header.jpg"></div>
<div id="header">
  <table>
    <tr>
      <td class="headercol1"><div id="calendar"></div></td>
      <td class="headercol2">
        <div id="headertxt">Fecha actual:</div>
        <div id="currentdate">&nbsp;</div>
        <div class="webcam"><a href="backend/">Configuraci&oacute;n</a></div>
        <div class="webcam"><a href="#">Webcam 2</a></div>
        <div class="webcam"><a href="#">Webcam 1</a></div>
        <br><br><br>
        <div id="takelist"></div>
      </td>
    </tr>
  </table>
</div>
<div id="takes"><div>
<div id="footer">2011 &copy; Departamento de F&iacute;sica Aplicada. Universidad de C&oacute;rdoba</div>
</body>
</html>
