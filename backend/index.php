<?php

ERROR_REPORTING(E_ALL);
session_start();

require_once("login.php");

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
<div id="logo"><img src="../images/header.jpg"></div>
<div class="logout"><a href="logout.php"><img alt="Salir" border="0" src="../images/exit.png"></a></div>
<div class="params">
<div class="paramstitle">Par&aacute;metros de las tomas</div>


<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<table id="paramstable">
<tr>
  <td class="paramstableheader">Toma</td>
<?php
  for($p=1; $p<=10; $p++){
    echo "<td class=\"paramstableheader\">Parametro {$p}</td>";
  }
?>
</tr>
<tr>
<?php
  for($i=1; $i<=10; $i++){
    echo "<tr>";
    echo "<td class=\"takeid\">{$i}</td>";

    for($j=1; $j<=10; $j++){
    echo "<td><input class=\"param\" name=\"\" type\"text\" value=\"{$j}\"/></td>";
    }

    echo "</tr>";

  }

?>
</table>
					<input type="submit" id="submit" name="submit" value="Guardar" />
</form>
</div>
<div id="footer">2011 &copy; Departamento de F&iacute;sica Aplicada. Universidad de C&oacute;rdoba</div>

</body>
</html>
