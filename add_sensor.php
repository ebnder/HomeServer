<?php
require_once('classes/CMySQL.php'); // including service class to work with database

if (isset($_GET['method'])) {
	if ($_GET['method'] == 'html') {
		$sCode = <<<EOF

<div id="containt" align="center">
<form action="add_sensor.php" method="get">
<div id="header"><h2 class="sansserif">Добавление датчика</h2></div>
 <table>
        <tr>
            <td>Имя датчика:</td>
            <td> <input type="text" name="name" size="20"></td>
        </tr>
             
        <tr>
            <td>Разьем подключения:*</td>
            <td><input type="text" name="temp" size="20"></td>
        </tr>

        <tr>
            <td>Тип датчика:*</td>
            <td><input type="text" name="type" size="20"></td>
        </tr>

        <tr>
            <td>Порт управления:*</td>
            <td><input type="text" name="temp" size="20"></td>
        </tr>

        <tr>
            <td>Комната:</td>
            <td><input type="text" name="temp" size="20"></td>
        </tr>

        <tr>
             <td><input type="submit" value="Добавить"></td>
        </tr>
 </table>
</form>
</div>
<br>
Поля, отмеченные * обязательны для заполнения.
EOF;
		echo $sCode;
	}
}

if (isset($_GET['type'])) {
    $sensor_type = $_GET['type'];

    if (isset($_GET['name'])) {
    	$sensor_name = $_GET['name'];
	} else $sensor_name = 'Без названия';

	if (isset($_GET['room_id'])) {
	    $sensor_room_id = $_GET['room_id'];
	} else $sensor_room_id = '0';

	$aData = $GLOBALS['MySQL']->addSensor($sensor_name, $sensor_type, $sensor_room_id);
}
?>