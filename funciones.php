<?php

function showTake($day, $time)
{
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
  <a name="<?php echo $tim; ?>" id="<?php echo $tim; ?>"></a>
  <div class="take">
    <div class="taketitle"><?php echo $time; ?></div>

<?php
  sort($file_list);
  foreach($file_list as $file) {
    $path = $_THUMBS.$file;
    $title = "<center><p class=\"thumbtitle\">{$file}</p></center>";
    $title .= "Par&aacute;metro 1: 23<br>";
    $title .= "Par&aacute;metro 2: 145<br>";
    $title .= "Par&aacute;metro 3: 200<br>";
    $title .= "Par&aacute;metro 4: 7<br>";
    $title .= "Par&aacute;metro 5: 23<br>";
    $title .= "Par&aacute;metro 6: 145<br>";
    $title .= "Par&aacute;metro 7: 200<br>";
    $title .= "Par&aacute;metro 8: 7<br>";
    if(!is_file($_DIR . $file)) continue;
    echo "<div class=\"thumb\">";
    echo "<a rel=\"lightbox[a]\" href=\"{$_DIR}{$file}\" title=\"{$file}\">";
    echo "<img src=\"{$path}\" class=\"pic\" alt=\"{$_DIR}{$file}\"></a><br>\n";
    echo $title;
    echo "</div>";
  }
?>
  </div>

<?php
}
?>
