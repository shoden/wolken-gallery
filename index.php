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
<html>
<head>
<title>Galler&iacute;a</title>
<style type="text/css">
</style>

<script type="text/javascript" src="js/jquery.1.4.2.js"></script>
<script type="text/javascript" src="js/jsDatePick.jquery.min.1.3.js"></script>

<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.css" />

    <script type="text/javascript" src="js/jquery.lightbox-0.5.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
    <!-- / fim dos arquivos utilizados pelo jQuery lightBox plugin -->
    
    <!-- Ativando o jQuery lightBox plugin -->
    <script type="text/javascript">
    $(function() {
        $('.take a').lightBox();
    });
    </script>
</head>
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
		
		g_globalObject.setOnSelectedDelegate(function(){
			var obj = g_globalObject.getSelectedDay();
			//alert("a date was just selected and the date is : " + obj.day + "/" + obj.month + "/" + obj.year);
			document.getElementById("currentdate").innerHTML = obj.day + "/" + obj.month + "/" + obj.year;
		});
		
	};
</script>
<body>

<div id="header">
  <div id="calendar"></div>

  <div id="headerdate">k
    <div id="headertxt">Fecha actual:</div>
    <div id="currentdate"></div>
  </div>

  <div id="takelist">tomas:
  <a href="#">7:00</a>&nbsp;
  <a href="#">7:00</a>&nbsp;
  <a href="#">7:00</a>&nbsp;
  <a href="#">7:00</a>&nbsp;
  <a href="#">7:00</a>&nbsp;
  <a href="#">7:00</a>&nbsp;
  </div>
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
