<?php

function db_connect() {
	include("lang.php");
	include("config.php");
	
	$connect = mysql_connect($settings['db_host'],$settings['db_user'],$settings['db_pass']);
	if($connect == TRUE) {
		$selectdb = mysql_select_db($settings['db_db']);
		if($selectdb == TRUE ) {
			// OK
		}else{
			exit($lang['selectdberror']);
		}
	}else{
		exit($lang['connecterror']);
	}
}

function getParams()
{
  $sql ="SELECT * FROM parametros;";
  
  $res = mysql_query($sql);
  if(mysql_num_rows($res) > 0) {
    $i=0;
    while ($row = mysql_fetch_assoc($res)) {
         $v[$i++] = $row;
    }
  }
  mysql_free_result($res);

  return $v;
}

$PARAM_ID = array( "agudeza", "brillo", "contraste", "exposicion", "gamma", "ganancia", "saturacion", "tonalidad");

function getTakes()
{
  $sql ="SELECT * FROM tomas;";
  
  $res = mysql_query($sql);
  if(mysql_num_rows($res) > 0) {
    $i=0;
    while ($row = mysql_fetch_assoc($res)) {
         $v[$i++] = $row;
    }
  }
  mysql_free_result($res);

  return $v;
}

function enableTake($id, $enabled)
{
  $sql ="UPDATE tomas SET habilitado={$enabled} WHERE id={$id};";
  $res = mysql_query($sql);

  return $res;
}

function setTake($id, $values)
{

  global $PARAM_ID;

  $PARAMS = getParams();
  $PARAMS_COUNT = count($PARAMS);

  $v="";
  for($i=0; $i<$PARAMS_COUNT; $i++) {
    $v .= $PARAM_ID[$i] . "=" . $values[$PARAM_ID[$i]] . ", ";
  }

  $sql = "UPDATE tomas SET " . substr($v,0,-2) . " WHERE id={$id};";
  $res = mysql_query($sql);

  return $res;
}

function getCapturesByDay($day)
{
  $sql ="SELECT DATE_FORMAT( hora, '%H:%i' ) AS hora FROM capturas WHERE dia=\"{$day}\" GROUP BY hora;";
  
  $res = mysql_query($sql);
  if(mysql_num_rows($res) > 0) {
    $i=0;
    while ($row = mysql_fetch_assoc($res)) {
         $v[$i++] = $row;
    }
  }
  mysql_free_result($res);

  return $v;
}

function getCapturesByTake($day, $time)
{
  $sql ="SELECT * FROM capturas WHERE dia=\"{$day}\" AND hora LIKE \"{$time}:%\";";
  
  $res = mysql_query($sql);
  if(mysql_num_rows($res) > 0) {
    $i=0;
    while ($row = mysql_fetch_assoc($res)) {
         $v[$i++] = $row;
    }
  }
  mysql_free_result($res);

  return $v;
}

function deleteDay($day)
{
  $sql = "DELETE FROM capturas WHERE dia ='". $day . "'";
  mysql_query($sql);
  return mysql_affected_rows();
}
function rrmdir($directory, $empty=FALSE)
{
  if(substr($directory,-1) == '/')
  {
    $directory = substr($directory,0,-1);
  }
  if(!file_exists($directory) || !is_dir($directory))
  {
    return FALSE;
  }elseif(is_readable($directory))
  {
    $handle = opendir($directory);
    while (FALSE !== ($item = readdir($handle)))
    {
      if($item != '.' && $item != '..')
      {
        $path = $directory.'/'.$item;
        if(is_dir($path)) 
        {
          rrmdir($path);
        }else{
          unlink($path);
        }
      }
    }
    closedir($handle);
    if($empty == FALSE)
    {
      if(!rmdir($directory))
      {
        return FALSE;
      }
    }
  }
  return TRUE;
}

function getDays()
{
  $sql ="SELECT DISTINCT dia FROM capturas;";
  
  $res = mysql_query($sql);
  if(mysql_num_rows($res) > 0) {
    $i=0;
    while ($row = mysql_fetch_assoc($res)) {
      $d = explode("-", $row['dia']);
      $day = $d[2] . "/" . $d[1] . "/" . $d[0];
      $o .= "<option value='". $row['dia'] ."'>" . $day . "<br>\n";
    }
  }

  mysql_free_result($res);

  return $o;
}

function changePassword($userid, $oldpass, $newpass)
{
  $sql ="SELECT password FROM usuarios WHERE id=". $userid .";";
  
  $res = mysql_query($sql);
  if(mysql_num_rows($res) <= 0)
    return "No se pudo conseguir la clave anterior";

  $row = mysql_fetch_assoc($res);
  if($oldpass != $row['password'])
    return "La clave actual introducida no es correcta";

  $sql = "UPDATE usuarios SET password='". $newpass . "' WHERE id=". $userid .";";
  $res = mysql_query($sql);

  mysql_free_result($res);

  return "";
}

?>
