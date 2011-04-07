<?php

ERROR_REPORTING(E_ALL);
session_start();

require_once("login.php");

pml_login();

if( $_SESSION['pml_userid'] == "")
  exit;

require_once("funciones.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es" dir="ltr">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="robots" content="index, follow" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <title>Administraci&oacute;n</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css"/>
  <link href="../images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
</head>
<body>
<?php

$PARAMS = getParams();
$PARAMS_COUNT = count($PARAMS);
$TAKES = getTakes();
$TAKES_COUNT = count($TAKES);

if(isset($_POST['1-1'])) {

  // Comprobación de los parámetros
  $error = "";
  for($i=1; $i<=$TAKES_COUNT; $i++){
    if( isset($_POST["enable-".$i]) )
      for($j=0; $j<$PARAMS_COUNT; $j++){
        $new = (int)$_POST[$i."-".$j];
        $min = (int)$PARAMS[$j]['min'];
        $max = (int)$PARAMS[$j]['max'];

        if($new < $min || $new > $max){
          $error .= "ERROR: El valor de " . htmlentities($PARAMS[$j]['es']) . " en la toma {$i} tiene un valor fuera de rango.<br>\n";
        }
      }
  }

  if($error != "")
    echo "<div class=\"error\">{$error}<br> Los cambios no han podido ser guardados.</div>";
  else
  {
    // Actualizar tomas una a una
    for($i=1; $i<=$TAKES_COUNT; $i++){
      if( isset($_POST["enable-".$i]) ){
        enableTake($i, 1);
        for($j=0; $j<$PARAMS_COUNT; $j++){
          $values[$PARAM_ID[$j]] = (int)$_POST[$i."-".$j];
        }
        setTake($i, $values);
      }
      else{
        enableTake($i, 0);
      }
    }

    // Actualizar vectores para mostrar
    $PARAMS = getParams();
    $PARAMS_COUNT = count($PARAMS);
    $TAKES = getTakes();
    $TAKES_COUNT = count($TAKES);

    echo "<div class=\"submited\">Par&aacute;metros guardados correctamente.</div>";
  }
}

?>

<div id="logo"><img src="../images/header.jpg"></div>
<div class="logout"><a href="logout.php"><img alt="Salir" border="0" src="../images/exit.png"></a></div>
<div class="params">
<div class="paramstitle">Informaci&oacute;n del servidor</div>

<?php

$data = shell_exec('uptime');
$uptime = explode(' up ', $data);
$uptime = explode(',', $uptime[1]);
$uptime = $uptime[0];
$load = sys_getloadavg();

define("DISK","/"); 
$total = round(disk_total_space(DISK)/1024/1024/1024,2);
$free = round(disk_free_space(DISK)/1024/1024/1024,2);

echo "<table width='100%'>\n";
echo "<tr>\n";
echo "<td class='paramstableheader'>Tiempo encencido</td>\n";
echo "<td class='paramstableheader'>Espacio libre</td>\n";
echo "<td class='paramstableheader'>Carga media de CPU</td>\n";
echo "<td class='paramstableheader'>Espacio de las capturas</td>\n";
echo "<td class='paramstableheader'>Versi&oacute;n</td>\n";
echo "<td class='paramstableheader'>M&aacute;s informaci&oacute;n</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td class='enabled'>" . $uptime . "</td>\n";
echo "<td class='enabled'>{$free} GB de {$total} GB </td>\n";
echo "<td class='enabled'>" . $load[0]. "</td>\n";
echo "<td class='enabled'>" . exec("du -hs /home/juan/img/wolken/ | awk '{print $1}'") . "</td>\n";
echo "<td class='enabled'>";
include("../version.php");
echo "</td>\n";
echo "<td class='enabled'><a class='sysinfo' href='http://localhost/phpsysinfo/'>Ver</a></td>\n";
echo "</table>\n";
?>
</div>

<div class="params">
<div class="paramstitle">Par&aacute;metros de las tomas</div>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<table id="paramstable">
<tr>
  <td class="paramstableheader">Toma</td>
  <td class="paramstableheader"></td>
<?php
  for($p=0; $p<$PARAMS_COUNT; $p++){
    echo "<td class=\"paramstableheader\">". htmlentities($PARAMS[$p]['es']) ."<br>\n";
    echo "[" . htmlentities($PARAMS[$p]['min']) . " : " . htmlentities($PARAMS[$p]['max']) ."]</td>\n";
  }
?>
</tr>
<tr>
<?php
  for($i=0; $i<$TAKES_COUNT; $i++){
    $checked = ($TAKES[$i]['habilitado']=="1") ? "checked" : "";
    $tdclass= ($TAKES[$i]['habilitado']=="1") ? "enabled" : "disabled";

    echo "<tr>\n";
    echo "<td class=\"paramstableheader\">". ($i+1) ."</td>\n";

    echo "<td class=\"{$tdclass}\"><input type=\"checkbox\" name=\"enable-". ($i+1) . "\" value=\"\" {$checked}></a></td>\n";

    for($j=0; $j<$PARAMS_COUNT; $j++){
      echo "<td class=\"{$tdclass}\"><input class=\"{$tdclass}\" name=\"". ($i+1) . "-{$j}\" type=\"text\" value=\"". $TAKES[$i][$PARAM_ID[$j]] ."\"/></td>\n";
    }

    echo "</tr>\n";
  }

?>
</table>
					<input type="submit" id="submit" name="submit" value="Guardar" />
</form>
</div>
<div id="footer">2011 &copy; Departamento de F&iacute;sica Aplicada. Universidad de C&oacute;rdoba</div>

</body>
</html>
