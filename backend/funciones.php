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

  //print_r($v);
  return $v;
}

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

  //print_r($v);
  return $v;
}

?>
