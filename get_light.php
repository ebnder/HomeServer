<?php
session_start();
require_once('classes/CMySQL.php'); // including service class to work with database
if (isset($_GET['method'])) {
    $method = $_GET['method'];
} else $method = 'json';
if (isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];
}

$aData = $GLOBALS['MySQL']->getLight($room_id);

       switch ($method) {
            case 'json': // gen JSON result
                if (count($aData)) {
                    echo json_encode(array('data' => $aData));

                } else {
                    echo json_encode(array('data' => 'Nothing found'));
                }
                break;

            case 'html': // gen HTML result
            if ($_SESSION['name'] == null) {
                header("location:auth.php");
            }
                $sCode = '';
                if (count($aData)) {
                    $sCode .= <<<EOF
<table class="CSSTableGenerator">
<tr>
<td>Датчик</td>
<td>Значение</td>
<td>Управление</td>
<td>Удалить</td>
</tr>
EOF;
                    foreach ($aData as $i => $aRecords) {
                        $sType = '';
                        $sVal = '';
                        switch ($aRecords['sensor_type']) {
                            case 'digital':
                                switch ($aRecords['sensor_reading']) {
                                    case '0':
                                        $sVal = '<img src="img/circle_red.png" alt="Smiley face" height="22" width="22">';
                                        $sType .=<<<EOF

<input type="button" value="Включить" onclick="location.href='set_value.php?from=light&sensor_id={$aRecords[sensor_id]}&value=1';">
EOF;
                                        break;
                                    
                                    case '1':
                                        $sVal = '<img src="img/circle_green.png" alt="Smiley face" height="22" width="22">';
                                        $sType .=<<<EOF

<input type="button" value="Выключить" onclick="location.href='set_value.php?from=light&sensor_id={$aRecords[sensor_id]}&value=0';">
EOF;
                                        break;

                                    default:
                                        # code...
                                        break;
                                }
                                
                                break;
                            
                            case 'analog':
                                $sVal = $aRecords['sensor_reading'].'%';
                                $subVal = $aRecords['sensor_reading']-10;
                                if ($subVal < 0) $subVal = 0;
                                $addVal = $aRecords['sensor_reading']+10;
                                if ($addVal > 100) $addVal = 100;
                                $sType .=<<<EOF

<input type="button" value=" - " onclick="location.href='set_value.php?from=light&sensor_id={$aRecords[sensor_id]}&value={$subVal}';">
<input type="button" value=" + " onclick="location.href='set_value.php?from=light&sensor_id={$aRecords[sensor_id]}&value={$addVal}';">
<input type="button" value="Выкл" onclick="location.href='set_value.php?from=light&sensor_id={$aRecords[sensor_id]}&value=0';">
EOF;
                                break;
                        }
                        $sCode .= <<<EOF

<tr>
<td>{$aRecords['sensor_name']}</td>
<td>{$sVal}</td>
<td>{$sType}</td>
<td><input type="button" value="Удалить датчик" onclick="location.href='del_sensor.php?from=light&id={$aRecords[sensor_id]}';"></td>
</tr>


EOF;
                    }
                    $sCode .= '</table>';
                } else {
                    $sCode = '<div>В базе нет информации об установленных датчиках света</div>';
                }
?>
<head>
    <meta charset="utf-8" />
    <link href="/css/TableCSSCode.css" rel="stylesheet" type="text/css">
</head>
<?php echo $sCode; ?>
<br>
<input type="button" allign="right" value="Добавить датчик" onclick="location.href='add_sensor.php?method=html';">
<?php
                break;
        }
?>