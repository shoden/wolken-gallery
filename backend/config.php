<?php
$xdg = parse_ini_file( '/etc/xdg/wolken/wolken.conf', 1);

$settings['imgpath']  = $xdg['Main']['imgpath'];

$settings['db_host']	= $xdg['Database']['host'];
$settings['db_user']	= $xdg['Database']['user'];
$settings['db_pass']	= $xdg['Database']['password'];
$settings['db_db']		= $xdg['Database']['bbdd'];
$settings['db_table']	= $xdg['Database']['userTable']
?>
