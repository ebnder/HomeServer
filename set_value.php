<?php
require_once('classes/CMySQL.php'); // including service class to work with database

if (isset($_GET['sensor_id']) and isset($_GET['value'])) {
    $id = $_GET['sensor_id'];
    $val = $_GET['value'];
	$GLOBALS['MySQL']->setSwitch($id, $val);
}
if (isset($_GET['from'])) {
	switch ($_GET['from']) {
		case 'light':
			header("location:get_light.php?method=html");
			break;
		case 'climate':
			header("location:get_climate.php?method=html");
			break;
		case 'other':
			header("location:get_other.php?method=html");
			break;
	}
}
?>