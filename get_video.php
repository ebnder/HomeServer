<?php
session_start();
require_once('classes/CMySQL.php'); // including service class to work with database

if (isset($_GET['method'])) {
    $method = $_GET['method'];
} else $method = 'json';

if (isset($_GET['action'])) {
    if ($_GET['action'] == "del") {
        if (isset($_GET['id'])) {
            $GLOBALS['MySQL']->delVideo($_GET['id']);
        }
    }
}

$aData = $GLOBALS['MySQL']->getVideo();

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
<td>Камера</td>
<td>Смотреть</td>
<td>Удалить</td>
</tr>
EOF;
                    foreach ($aData as $i => $aRecords) {
                        $sCode .= <<<EOF

<tr>
<td>{$aRecords['camera_name']}</td>
<td><input type="button" allign="right" value="Смотреть" onclick="location.href='{$aRecords['camera_address']}';"></td>
<td><input type="button" allign="right" value="Удалить камеру" onclick="location.href='get_video.php?method=html&action=del&id={$aRecords['camera_id']}';"></td>



EOF;
                    }
                    $sCode .= '</table>';
                } else {
                    $sCode = '<div>В базе нет информации об установленных камерах наблюдения</div>';
                }
                echo $sCode; ?>
<br>
<input type="button" allign="right" value="Добавить камеру" onclick="location.href='add_video.php?method=html';">
<?php
           break;
        }
?>