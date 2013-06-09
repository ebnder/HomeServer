<?php
session_start();
require_once('classes/CMySQL.php'); // including service class to work with database

if (isset($_GET['method'])) {
    $method = $_GET['method'];
} else $method = 'json';
if (isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];
}

$aData = $GLOBALS['MySQL']->getOther($room_id);

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
                $sCode .= <<<EOF
<head>
    <link href="/css/TableCSSCode.css" rel="stylesheet" type="text/css">
</head>
EOF;
                if (count($aData)) {
                    $sCode .= <<<EOF
<table class="CSSTableGenerator">
<tr>
<td>Датчик</td>
<td>Состояние</td>
<td>Удалить</td>
</tr>
EOF;
                    foreach ($aData as $i => $aRecords) {
                        switch ($aRecords['sensor_type']) {
                            case 'smoke':
                            case 'security':
                            case 'water':
                            case 'switch':
                                switch ($aRecords['sensor_reading']) {
                                    case '1':
                                        $aReading = '<img src="img/circle_red.png" alt="Smiley face" height="22" width="22">';
                                        break;
                                    case '0':
                                        $aReading = '<img src="img/circle_green.png" alt="Smiley face" height="22" width="22">';
                                        break;
                                    default:
                                        $aReading = '<img src="img/circle_red.png" alt="Smiley face" height="22" width="22">';
                                        break;
                                }
                                break;
                            
                            case 'level':
                                $aReading = $aRecords['sensor_reading'].'%';
                                break;
                            
                            
                            default:
                                $aReading = $aRecords['sensor_reading'];
                                break;
                        }
                        $sCode .= <<<EOF
<tr>
<td>{$aRecords['sensor_name']}</td>
<td>{$aReading}</td>
<td><input type="button" value="Удалить датчик" onclick="location.href='del_sensor.php?from=other&id={$aRecords[sensor_id]}';"></td>
</tr>
EOF;
                    }
                    $sCode .= '</table>';
                } else {
                    $sCode = '<div>В базе нет информации о других датчиках</div>';
                }
                
                echo $sCode; ?>
<br>
<input type="button" allign="right" value="Добавить датчик" onclick="location.href='add_sensor.php?method=html';">
<?php
                break;        
        }
?>