<?php

function showTake($day, $time)
{
  global $params, $nparams;

  $tim = str_replace(":", "", $time);
  $_DIR ="wolken/{$day}/{$tim}/";
  $_THUMBS = $_DIR . "thumbs/";

  if(!is_dir($_THUMBS)) {
    echo "";//<div class='error'>El directorio <b>{$_DIR}</b> no existe.</div>";
    return 1;
  };

  $file_list = array();

  if ($handle = opendir($_THUMBS)) {
     while (false !== ($file = readdir($handle))) {
        if (strtolower(array_pop(explode('.',$file))) == 'bmp') {
           $file_list[] = $file;
        }
     }
     closedir($handle);
  }

  $count = 0;
  $total = count($file_list);

?>
  <div class="ancla"><a name="<?php echo $tim; ?>" id="<?php echo $tim; ?>"></a></div>
  <div class="take">
    <div class="taketitle"><?php echo $time; ?></div>

<?php
  $caps =getCapturesByTake($day,$time);
  sort($file_list);
  $i=0;
  foreach($file_list as $file) {
    $path = $_THUMBS.$file;
    if(!is_file($_DIR . $file)) continue;
    echo "<div class=\"thumb\">";
    echo "<a rel=\"lightbox[a]\" href=\"{$_DIR}{$file}\" title=\"{$file}\">";
    echo "<img src=\"{$path}\" class=\"pic\" alt=\"{$_DIR}{$file}\"></a><br>\n";
    echo $title;

    echo "<center><p class=\"thumbtitle\">{$file}</p></center>";
    echo "<table";
    for($p=0; $p<$nparams; $p++){
      echo "<tr><td class='paramname'>" . htmlentities($params[$p]['es']) . "</td><td class='paramvalue'>" . $caps[$i][$params[$p]['id']] . "</td></tr>\n";
    }
    echo "</table";

    echo "</div>";
    $i++;
  }
?>
  </div>

<?php
}

function showTakeList()
{
  global $captures, $ncaptures;

  for($i=0; $i<$ncaptures; $i++){
    echo "<div class=\"takelink\"><a href=\"#". str_replace( ":", "", $captures[$i]['hora']) ."\">". $captures[$i]['hora'] ."</a></div>\n";
  }
}

?>
