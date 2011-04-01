<?php
ERROR_REPORTING(E_ALL);
session_start();

require_once("../phpmylogon.php");

pml_login('include', 'test.php');

if(isset($_GET['logout'])) {
	pml_logout();
}

?>
