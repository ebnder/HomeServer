<?php
require_once('classes/CMySQL.php'); // including service class to work with database

if (isset($_GET['method'])) {
	if ($_GET['method'] == 'html') {
		$sCode = <<<EOF

<div id="containt" align="center">
<form action="add_video.php" method="get">
<div id="header"><h2 class="sansserif">Добавление камеры</h2></div>
 <table>
             
        <tr>
            <td>Имя камеры:</td>
            <td> <input type="text" name="camera_name" size="20"></td>
        </tr>
             
        <tr>
            <td>Адрес камеры:</td>
            <td><input type="text" name="camera_address" size="20"></td>
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

if (isset($_GET['camera_address'])) {
    $camera_address = $_GET['camera_address'];

    if (isset($_GET['camera_name'])) {
    	$camera_name = $_GET['camera_name'];
	} else $camera_name = 'Без названия';

	if (isset($_GET['room_id'])) {
	    $room_id = $_GET['room_id'];
	} else $room_id = '0';

	$aData = $GLOBALS['MySQL']->addVideo($camera_name, $camera_address, $room_id);
}
?>