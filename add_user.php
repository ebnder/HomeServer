<?php
require_once('classes/CMySQL.php'); // including service class to work with database

if (isset($_GET['name'])) {
    $user_name = $_GET['name'];
}
if (isset($_GET['password'])) {
    $user_password = $_GET['password'];
}

if (isset($_GET['method'])) {
	if ($_GET['method'] == 'html') {
		$sCode = <<<EOF

<div id="containt" align="center">
<form action="add_user.php" method="get">
<div id="header"><h2 class="sansserif">Добавление пользователя</h2></div>
 <table>
             
        <tr>
            <td>Имя пользователя:</td>
            <td> <input type="text" name="name" size="20"></td>
        </tr>
             
        <tr>
            <td>Пароль:</td>
            <td><input type="text" name="password" size="20"></td>
        </tr>
        <tr>
             <td><input type="submit" value="Добавить"></td>
        </tr>
 </table>
</form>
</div>
EOF;
		echo $sCode;
	}
}

if (isset($user_name) and isset($user_password)) {
	
	if (isset($_GET['privilegies'])) {
	    $privilegies = $_GET['privilegies'];
	} else $privilegies = 'user';
	
	$aData = $GLOBALS['MySQL']->addUser($user_name, md5($user_password), $privilegies);
}
?>