<?php 
session_start();
require_once('classes/CMySQL.php');
$username = $_POST["username"];
$password = $_POST["password"];
$num_rows = $GLOBALS['MySQL']->checkLogin($_POST['username'], $_POST['password']);

if ($num_rows <= 0) { 
	echo "<meta charset='utf-8'> ";
	echo "В системе нет пользователя $username с указанным паролем.";
	echo "<br>";
	echo "Попробуйте еще раз";
	exit; 
} else {
	$_SESSION['LAST_ACTIVITY'] = time();
	$_SESSION['name'] = $_POST["username"];
	$_SESSION['priv'] = $_POST["username"];
	header("location:index.php");
  }
?>