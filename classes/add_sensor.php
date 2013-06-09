<?php
require_once('classes/CMySQL.php'); // including service class to work with database

if (isset($_GET['type'])) {
    $sensor_type = $_GET['type'];

    if (isset($_GET['name'])) {
    	$sensor_name = $_GET['name'];
	} else $sensor_name = 'Без названия';

	if (isset($_GET['room_id'])) {
	    $sensor_room_id = $_GET['room_id'];
	} else $sensor_room_id = '0';

	$aData = $GLOBALS['MySQL']->addVideo($sensor_name, $sensor_type, $sensor_room_id);
}
?>