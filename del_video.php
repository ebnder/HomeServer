<?php
session_start();
require_once('classes/CMySQL.php'); // including service class to work with database

if (isset($_GET['id'])) {
    $GLOBALS['MySQL']->delVideo($_GET['id']);
}

?>