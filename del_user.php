<?php
require_once('classes/CMySQL.php'); // including service class to work with database

if (isset($_GET['id'])) {
    $GLOBALS['MySQL']->delUser($_GET['id']);
}

if (isset($_GET['method'])) {
	if ($_GET['method'] == 'html') {
		header("location:get_users.php?method=html");
	}
}
?>