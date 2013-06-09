<?php
require_once('classes/CMySQL.php'); // including service class to work with database

if (isset($_GET['name'])) {
    $user_name = $_GET['name'];
}
if (isset($_GET['password'])) {
    $user_password = $_GET['password'];
}

if (isset($user_name) and isset($user_password)) {
	
	if (isset($_GET['privilegies'])) {
	    $privilegies = $_GET['privilegies'];
	} else $privilegies = 'user';
	if (isset($_GET['comment'])) {
	    $comment = $_GET['comment'];
	} else $comment = 'Без комментария';
	
	$aData = $GLOBALS['MySQL']->addUser($user_name, $user_password, $privilegies, $comment);
}

?>