<?php
require_once('classes/CMySQL.php'); // including service class to work with database

if (isset($_GET['room_name'])) {
    $name = $_GET['room_name'];
} else $name = 'Без имени';

if (isset($_GET['room_description'])) {
    $descr = $_GET['room_description'];
} else $descr = 'Без описания';

$aData = $GLOBALS['MySQL']->addPlace($name, $descr);
?>