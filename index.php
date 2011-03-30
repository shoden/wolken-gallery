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
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="js/lightbox.js"></script>
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>

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
</body>
</html>
