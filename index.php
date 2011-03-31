<?php
error_reporting(E_ALL);

if(!is_dir('img/thumbs')) die('thumbs directory was not found');
$file_list = array();

if ($handle = opendir('img/thumbs')) {
   while (false !== ($file = readdir($handle))) {
      if (strtolower(array_pop(explode('.',$file))) == 'jpg') {
         $file_list[] = $file;
      }
   }
   closedir($handle);
}

$count = 0;
$total = count($file_list);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es" dir="ltr">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="robots" content="index, follow" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <title>Galler&iacute;a</title>
  <script type="text/javascript" src="js/jquery.1.4.2.js"></script>
  <script type="text/javascript" src="js/jsDatePick.jquery.min.1.3.js"></script>
  <script type="text/javascript" src="js/jquery.lightbox-0.5.js"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
  <link rel="stylesheet" type="text/css" href="css/jsDatePick_ltr.css" media="all" />
  <link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
  <script type="text/javascript">
  $(function() {
      $('.take a').lightBox();
  });
  </script>
</head>
<body>
<script type="text/javascript">
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
		
		g_globalObject.setOnSelectedDelegate(function(){
			var obj = g_globalObject.getSelectedDay();
			document.getElementById("currentdate").innerHTML = obj.day + "/" + obj.month + "/" + obj.year;
		});
	};
</script>

<div id="header">
  <table>
    <tr>
      <td class="headercol1"><div id="calendar"></div></td>
      <td class="headercol2">
          <div id="headertxt">Fecha actual:</div>
          <div id="currentdate">&nbsp;</div>
          <br><br><br>
          <div id="takelist">
<?php

for($h=7; $h<22; $h++)
  for($m=0; $m<60; $m+=10){
    $h = str_pad($h, 2, "0", STR_PAD_LEFT); 
    $m = str_pad($m, 2, "0", STR_PAD_LEFT); 
    echo "<a class =\"takelink\" href=\"#{$h}{$m}\">{$h}:{$m}</a>&nbsp;\n";
  }

$h=22; $m=0;
$h = str_pad($h, 2, "0", STR_PAD_LEFT); 
$m = str_pad($m, 2, "0", STR_PAD_LEFT); 
echo "<a class=\"takelink\" href=\"#{$h}{$m}\">{$h}:{$m}</a>&nbsp;\n";

?>
          </div>
      </td>
    </tr>
  </table>
</div>

<div class="take">
<div class="taketitle">Hora: 07:00</div>
<?php
sort($file_list);
foreach($file_list as $file) {
  $path = 'img/thumbs/'.$file;
  $title = "<center><p class=\"thumbtitle\">{$file}</p></center>";
  $title .= "Par&aacute;metro 1: 23<br>";
  $title .= "Par&aacute;metro 2: 145<br>";
  $title .= "Par&aacute;metro 3: 200<br>";
  $title .= "Par&aacute;metro 4: 7<br>";
  if(!is_file('img/' . $file)) continue;
  echo "<div class=\"thumb\">";
  echo "<a rel=\"lightbox[a]\" href=\"img/{$file}\" title=\"{$file}\">";
  echo "<img src=\"{$path}\" class=\"pic\" alt=\"img/{$file}\"></a><br>\n";
  echo $title;
  echo "</div>";
}
?>
</div>

<div class="take">
<div class="taketitle">Hora: 07:00</div>
<?php
sort($file_list);
foreach($file_list as $file) {
  $path = 'img/thumbs/'.$file;
  $title = "<center><p class=\"thumbtitle\">{$file}</p></center>";
  $title .= "Par&aacute;metro 1: 23<br>";
  $title .= "Par&aacute;metro 2: 145<br>";
  $title .= "Par&aacute;metro 3: 200<br>";
  $title .= "Par&aacute;metro 4: 7<br>";
  if(!is_file('img/' . $file)) continue;
  echo "<div class=\"thumb\">";
  echo "<a rel=\"lightbox[a]\" href=\"img/{$file}\" title=\"{$file}\">";
  echo "<img src=\"{$path}\" class=\"pic\" alt=\"img/{$file}\"></a><br>\n";
  echo $title;
  echo "</div>";
}
?>
</div>

</body>
</html>
