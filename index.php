<?php
	error_reporting(E_ALL); ini_set('display_errors', 1);
	define("CCore", true);
	session_start();
	//Load files...
	require_once('include/scripts/settings.php');
	require_once('include/scripts/version.php');
	require('include/scripts/core.class.php');
	require('include/scripts/nbbc_main.php');
	$parser = new BBCode;
	$core = new core;
	$admin = new admin;
	require_once('include/scripts/layout.php');
	require_once('include/scripts/page.php');
	//Set Variables...
	global $dbc, $parser, $layout, $main, $settings, $core;
	$page = new pageGeneration;
	$page->Generate();
	
	
	
?>