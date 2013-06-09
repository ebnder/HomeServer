<?php
session_start();
require_once('classes/CMySQL.php'); // including service class to work with database
if (isset($_GET['method'])) {
    $method = $_GET['method'];
} else $method = 'json';

        $aData = $GLOBALS['MySQL']->getSystem();

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

EOF;
                    foreach ($aData as $i => $aRecords) {
                        $sCode .= <<<EOF

<table class="CSSTableGenerator">
<tr>
<td>Параметр</td>
<td>Значение</td>
</tr>
<tr>
<td>Температура в доме</td>
<td>{$aRecords['current_temperature']}°C</td>
</tr>
<tr>
<td>Температура за окном</td>
<td>{$aRecords['current_outside_temperature']}°C</td>
</tr>
<tr>
<td>Влажность воздуха</td>
<td>{$aRecords['current_humidity']}%</td>
</tr>
<tr>
<td>Температура за горячей воды</td>
<td>{$aRecords['hot_running_water_temperature']}°C</td>
</tr>
<tr>
<td>Напряжение питания</td>
<td>{$aRecords['input_voltage']}В</td>
</tr>
<tr>
<td>Текущее состояние</td>
EOF;
$message = "<td>";
switch ($aRecords['server_status']) {
    case '1':
        $status = "Норма";
        break;
    case '2':
        $status = "Сервер оффлайн";
        break;
    case '3':
        $status = "Авария";
        break;
    case '4':
        $status = "Проникновение";
        break;
    default:
        $status = "Статус не задан";
        break;
}
$message .= $status . "</td>";
$sCode .= $message;
$sCode .=<<<EOF
</tr>
</table>
EOF;

                    }
                    echo '</table>';
                } else {
                    $sCode = '<div>В базе нет информации о системе</div>';
                }
                
                echo $sCode;
                
                break;
        }
?>

