<?php
error_reporting(E_ALL);

include_once("funciones.php");

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
  <script type="text/javascript" src="ajax.js"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
  <link rel="stylesheet" type="text/css" href="css/jsDatePick_ltr.css" media="all" />
  <link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
  <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
  <script type="text/javascript">
  $(function() {
      $('.take a').lightBox();
  });
  </script>
</head>
<body>
<noscript>
<div class="error">Necesita activar Javascript en su navegador para poder ver esta p&aacute;gina correctamente.</div>
</noscript>
<script type="text/javascript">

  function fill(year, month, day){
    var d = year + "-";
    d += (month<10) ? "0" + month : month;
    d += (day<10) ? "-0" + day : "-" + day;

    return d;
  }

  function updateLightBox()
  {
    $('.take a').lightBox();
  }

	window.onload = function(){		
		
		g_globalObject = new JsDatePick({
			useMode:1,
			isStripped:true,
			target:"calendar",
			yearsRange:[2010,2013]
			/*selectedDate:{				This is an example of what the full configuration offers.
				day:5,						For full documentation about these settings please see the full version of the code.
				month:9,
				year:2006
			},
			yearsRange:[1978,2020],
			limitToToday:false,
			cellColorScheme:"beige",
			dateFormat:"%m-%d-%Y",
			imgPath:"img/",
			weekStartDay:1*/
		});

    //alert( g_globalObject.toSource() );
    
    document.getElementById("currentdate").innerHTML = g_globalObject.currentDay 
      + "/" + g_globalObject.currentMonth
      + "/" + g_globalObject.currentYear;
			document.getElementById("takes").innerHTML="<img src='images/cargando.png'>";
    ajax(fill(g_globalObject.currentYear, g_globalObject.currentMonth, g_globalObject.currentDay));
		
		g_globalObject.setOnSelectedDelegate(function(){
			var obj = g_globalObject.getSelectedDay();
			document.getElementById("currentdate").innerHTML = obj.day + "/" + obj.month + "/" + obj.year;
			document.getElementById("takes").innerHTML="<img src='images/cargando.png'>";
      ajax(fill(obj.year, obj.month, obj.day));
		});
	};
</script>
<div id="logo"><img src="images/header.jpg"></div>
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
          <div id="takelist">
<?php

for($h=7; $h<22; $h++)
  for($m=0; $m<60; $m+=10){
    $h = str_pad($h, 2, "0", STR_PAD_LEFT); 
    $m = str_pad($m, 2, "0", STR_PAD_LEFT); 
    echo "<div class=\"takelink\"><a href=\"#{$h}{$m}\">{$h}:{$m}</a></div>\n";
  }

?>
          </div>
      </td>
    </tr>
  </table>
</div>

<div id="takes"><div>

<div id="footer">2011 &copy; Departamento de F&iacute;sica Aplicada. Universidad de C&oacute;rdoba</div>
</body>
</html>
