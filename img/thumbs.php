<?php
//if($_GET['pass'] != 'password') die('access denied');
error_reporting(E_ALL);
if(!is_dir('thumbs')) mkdir('thumbs') or die('can\' create thumbs directory');
$file_list = array();

if ($handle = opendir('.')) {
   while (false !== ($file = readdir($handle))) {
      if (strtolower(array_pop(explode('.',$file))) == 'jpg') {
         $file_list[] = $file;
      }
   }
   closedir($handle);
}

$count = 0;
$total = count($file_list);
foreach($file_list as $file) {
   $save_path = getcwd().'/thumbs/';
   $im = imagecreatefromjpeg($file);
   // $new_x = imagesx($im) / 10;
   // $new_y = imagesy($im) / 10;
   $new_x = 128;
   $new_y = 96;
   $small = imagecreatetruecolor($new_x,$new_y);
   imagecopyresampled($small,$im,0,0,0,0,$new_x,$new_y,imagesx($im),imagesy($im));
   imagejpeg($small,$save_path.$file,85);
   imagedestroy($im);
   imagedestroy($small);
   usleep(100);
   set_time_limit(90);
   $count++;
   echo "Working on file {$count} / {$total}<br>\n";
   flush();
}
?>
