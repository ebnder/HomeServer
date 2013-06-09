<?php
require_once('classes/CMySQL.php'); // including service class to work with database

if (isset($_GET['id'])) {
    $GLOBALS['MySQL']->delPlace($_GET['id']);
}

?>