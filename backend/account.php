<?php

ERROR_REPORTING(E_ALL);
session_start();

require_once("login.php");
	include("lang.php");

pml_login();

if( $_SESSION['pml_userid'] == "")
  exit;

require_once("funciones.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es" dir="ltr">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="robots" content="index, follow" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <title>Administraci&oacute;n</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css"/>
  <link href="../img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
  <script type="text/javascript" src="../js/backend.js"></script>
</head>
<body>
<?php

$PARAMS = getParams();
$PARAMS_COUNT = count($PARAMS);
$TAKES = getTakes();
$TAKES_COUNT = count($TAKES);

if(isset($_POST['oldpass'])) {
  $cp = changePassword($_SESSION['pml_userid'], $_POST['oldpass'], $_POST['newpass']);

  if($cp == "")
    echo "<div class=\"submited\">La clave ha sido actualizada correctamente.</div>";
  else
    echo "<div class=\"error\">ERROR: ". $cp . "</div>";
}

?>

<div id="logo"><img src="../img/header.jpg"></div>
<div class="logout">
  <div class="button"><a href="./">Volver</a></div>
</div>

<div class="params">
<div class="paramstitle">Usuario</div>
<?php echo "<p style='color:white;'>" . $_SESSION['pml_username'] . "</p>"; ?>
<center>
</center>
</div>

<div class="params">
<div class="paramstitle">Cambio de clave</div>

<center>
<form name="pass" id="pass" method="post">
  <table>
    <tr>
      <td class="label"><label for="password"><?php echo $lang['old-password']; ?></label></td>
      <td><input type="password" id="oldpassword" name="oldpassword" class="account" /></td>
    </tr>
    <tr>
      <td class="label"><label for="password"><?php echo $lang['new-password']; ?></label></td>
      <td><input type="password" id="newpassword" name="newpassword" class="account" /></td>
    </tr>
    <tr>
      <td class="label"><label for="password"><?php echo $lang['new-password2']; ?></label></td>
      <td><input type="password" id="newpassword2" name="newpassword2" class="account" /></td>
    </tr>
    <tr>
    <td><br><br><br></td>
      <td>
        <div class="takelink"><a href="javascript:changePassword()"><?php echo $lang['save']; ?></a></div>
      </td>
    </tr>
  </table>
  <input type="hidden" id="oldpass" name="oldpass" value="" />
  <input type="hidden" id="newpass" name="newpass" value="" />
  <input type="hidden" id="newpass2" name="newpass2" value="" />
</form>
</center>
</div>
<div id="footer">2011 &copy; Departamento de F&iacute;sica Aplicada. Universidad de C&oacute;rdoba</div>

</body>
</html>
