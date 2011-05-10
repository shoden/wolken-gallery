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
  <link href="../img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
  <link rel="stylesheet" type="text/css" media="screen" href="../css/imgareaselect-animated.css" />

  <!--[if lte IE 6]>
  <link rel="stylesheet" type="text/css" media="screen"
    href="/css/msie/ie6.css" />
  <noscript>
  <link rel="stylesheet" type="text/css" media="screen"
    href="/css/msie/ie6-nojs.css" />
  </noscript>
  <script type="text/javascript" src="/js/DD_belatedPNG_0.0.8a.js"></script>
  <![endif]-->
  <!--[if IE 7]>
  <link rel="stylesheet" type="text/css" media="screen" href="/css/msie/ie7.css" />
  <![endif]-->
</head>
<body onload="enableROI()">
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

// POST de ROI

$IMG_CHANGED = false;
if( $_FILES['refimg']['name'] != "" ){
  if( $_FILES['refimg']['error'] > 0 )
    echo "<div class=\"error\">ERROR: (Regi&oacute;n de inter&eacute;s) " . $_FILES["refimg"]["error"] . ".</div>";
  else{
    if ($_FILES["refimg"]["type"] != "image/bmp")
      echo "<div class=\"error\">ERROR: (Regi&oacute;n de inter&eacute;s) El tipo de fichero subido no es BMP.</div>";
    else{
      move_uploaded_file($_FILES["refimg"]["tmp_name"], "../img/roiref.bmp");
      echo "<div class=\"submited\">Imagen de referencia para la regi&oacute;n de inter&eacute;s actualizada correctamente.</div>";
      $IMG_CHANGED = true;
    }
  }
}
else
  echo "";

if(isset($_POST['x1'])){
  $habilitado = ($_POST['habilitar']=="on") ? 1 : 0;

  if($habilitado==0){
    setROI(0,0,0,0,0);
    echo "<div class=\"submited\">Regi&oacute;n de inter&eacute;s deshabilitada.</div>";
  }
  else{
    if(((!is_numeric($_POST['x1']) || !is_numeric($_POST['y1'])) || 
        (!is_numeric($_POST['x2']) || !is_numeric($_POST['y2'])))||
        (($_POST['x1']<0 || $_POST['y1']<0) || ($_POST['x2']<0 ||
        $_POST['y2']<0)))
      echo "<div class=\"error\">ERROR: (Regi&oacute;n de inter&eacute;s) Los campos introducidos no son v&aacute;lidos.</div>";
    else{
      setROI(1, $_POST['x1'], $_POST['y1'], $_POST['x2'], $_POST['y2']);
      echo "<div class=\"submited\">Regi&oacute;n de inter&eacute;s actualizada correctamente.</div>";
    }
  }
}

// Fin POST de ROI

// Obtener ROI de la base de datos
$roi = getROI();
$checkbox = ($roi['habilitado']==1) ? "checked" : "";
$roiop = ($roi['habilitado']) ? ", x1: {$roi['x1']}, y1: {$roi['y1']}, x2: {$roi['x2']}, y2: {$roi['y2']}" : "";

?>

<div id="logo"><img src="../img/header.jpg"></div>
<div class="logout">
  <div class="button2"><a href="logout.php">Salir</a></div>
  <div class="button"><a href="account.php">Mi cuenta</a></div>
  <div class="button"><a href="../">Galer&iacute;a</a></div>
</div>
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
include("../inc/version.php");
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


<script type="text/javascript" src="../js/jquery-1.6.min.js"></script>
<script type="text/javascript" src="../js/jquery.imgareaselect.pack.js"></script>
<script type="text/javascript">
  function preview(img, selection) {
    if (!selection.width || !selection.height){
      $('#x1').val("");
      $('#y1').val("");
      $('#x2').val("");
      $('#y2').val("");
      $('#w').val("");
      $('#h').val("");
      return;
    };

    $('#x1').val(selection.x1);
    $('#y1').val(selection.y1);
    $('#x2').val(selection.x2);
    $('#y2').val(selection.y2);
    $('#w').val(selection.width);
    $('#h').val(selection.height);    
  }

  $(function () {
    $('#photo').imgAreaSelect({ handles: true,
      fadeSpeed: 200, onSelectChange: preview<?php echo $roiop; ?> });
  });


  function updateROI()
  {
    var ias = $('#photo').imgAreaSelect({ instance: true });
    ias.setSelection($('#x1').val(), $('#y1').val(), $('#x2').val(), $('#y2').val(), true); 
    ias.update();
  }

  function updateROICoord()
  {
    var dx = parseInt($('#x2').val()) - parseInt($('#x1').val());
    var dy = parseInt($('#y2').val()) - parseInt($('#y1').val());

    $('#w').val(dx);
    $('#h').val(dy);

    updateROI();
  }

  function updateROIDim()
  {
    var x2 = parseInt($('#w').val()) + parseInt($('#x1').val());
    var y2 = parseInt($('#h').val()) + parseInt($('#y1').val());

    $('#x2').val(x2);
    $('#y2').val(y2);

    updateROI();
  }

  function enableROI()
  {
    var ias = $('#photo').imgAreaSelect({ instance: true });
    var d = "";
    if(document.getElementById('habilitar').checked){
     d = "block";
     ias.setOptions({ show: true }); 
    }
    else{
      ias.setOptions({ hide: true }); 
      d = "none";
    }
    ias.update();
    updateROI();

    document.getElementById('refimgdiv').style.display = d;
    document.getElementById('roidiv').style.display = d;
  }

  /* Arreglo para IE para provocar el evento del checkbox */
  $(document).ready(function(){
    $("form :checkbox").click(function(){
      if($.browser.msie){
        $(this).fire("change");
      }
    });
     
  });
   
  jQuery.fn.extend({
    fire: function(evttype){
      el = this.get(0);
      if (document.createEvent) {
        var evt = document.createEvent('HTMLEvents');
        evt.initEvent(evttype, false, false);
        el.dispatchEvent(evt);
      } else if (document.createEventObject) {
        el.fireEvent('on' + evttype);
      }
      return this;
    }
  });
  /* FIN: Arreglo para IE para provocar el evento del checkbox */
</script>

<div class="params">
<div class="paramstitle">Regi&oacute;n de inter&eacute;s</div>


  <form method="post"> 
    <div class="container demo">
      <div style="float: left">
        <p class="instructions">
          Habilitado. 
        </p>
        <center><input type="checkbox" id="habilitar" name="habilitar" onchange="enableROI()" <?php echo $checkbox; ?>></center>
      </div>
    </div>

    <p></p>

    <div class="container demo" id="roidiv">
      <div style="float: left">
        <p class="instructions">
          Haga clic y arrastre en la imagen. 
        </p>
        <div id="pf" class="frame" style="margin: 0 0.3em; width: 640px; height: 480px;">
          <img id="photo" src="../img/roiref.bmp" />
        </div>
      </div>

      <div style="float: left">
        <table style="margin-top: 1em;">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" style="font-size: 110%; font-weight: bold; text-align: left; padding-left: 0.1em;">
              Coordenadas
            </td>
          </tr>
          <tr>
            <td style="width: 10%;">X<sub>1</sub></td>
            <td style="width: 30%;"><input class="roiparam" type="text" id="x1" name="x1" value="<?php echo $roi['x1']; ?>" onkeyup="updateROICoord()"/></td>
          </tr>
          <tr>
            <td>Y<sub>1</sub></td>
            <td><input class="roiparam" type="text" id="y1" name="y1" value="<?php echo $roi['y1']; ?>" onkeyup="updateROICoord()"/></td>
          </tr>
          <tr>
            <td>X<sub>2</sub></td>
            <td><input class="roiparam" type="text" id="x2" name="x2" value="<?php echo $roi['x2']; ?>" onkeyup="updateROICoord()" /></td>
          </tr>
          <tr>
            <td>Y<sub>2</sub></td>
            <td><input class="roiparam" type="text" id="y2" name="y2" value="<?php echo $roi['y2']; ?>" onkeyup="updateROICoord()" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" style="font-size: 110%; font-weight: bold; text-align: left; padding-left: 0.1em;">
              Dimensiones
            </td>
          </tr>
          <tr>
            <td style="width: 20%;">Anchura</td>
            <td><input class="roiparam" type="text" id="w" value="<?php echo $roi['w']; ?>" onkeyup="updateROIDim()" /></td>
          </tr>
          <tr>
            <td>Altura</td>
            <td><input class="roiparam" type="text" id="h" value="<?php echo $roi['h']; ?>" onkeyup="updateROIDim()" /></td>
          </tr>
        </table>
      </div>
    </div>
          <center><br><input class="submit" type="submit" name="imgsubmit" value="Actualizar regi&oacute;n de inter&eacute;s" /><br><br></center>
  </form>

<?php if($IMG_CHANGED){ ?>
<script type="text/javascript">
document.getElementById('photo').src = document.getElementById('photo').src + '?' + (new Date()).getTime();
</script>
<?php } ?>
    <p></p>

    <div class="container demo" id="refimgdiv">
      <p class="instructions">
        Cambie la imagen de fondo para seleccionar la regi&oacute;n de inter&eacute;s. 
      </p>
      <center>
        <form method="post" enctype="multipart/form-data">
          <label>Imagen:</label>
          <input type="file" name="refimg" id="refimg" />
          <br />
          <br />
          <input type="submit" name="imgsubmit" value="Cambiar" class="submit"/>
        </form>
      </center>
    </div>

</div>

<div id="footer">2011 &copy; Departamento de F&iacute;sica Aplicada. Universidad de C&oacute;rdoba</div>

</body>
</html>
