<html><head>
<meta name="viewport" content="width=device-width, user-scalable=no">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>CheesecakePortal Install</title>
	<link rel="stylesheet" type="text/css" href="include/style/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="include/style/template.css">
	<script src="include/style/jquery.js"></script>
	<script src="include/style/bootstrap.js"></script>
<?php
	error_reporting(E_ALL); ini_set('display_errors', 1);
require_once('include/scripts/keys.php');
require_once('include/scripts/install.php');
global $Keys;
$installer = new cheeseInstall;

if(!isset($_GET['mode'])){
$installer->information();
}

if(isset($_GET['mode']) && ($_GET['mode'] === 'configRepair')){
$installer->configRepair();
}



?>
</html>