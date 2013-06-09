<?php
session_start();
require_once('classes/CMySQL.php'); // including service class to work with database
if (isset($_GET['method'])) {
    $method = $_GET['method'];
} else $method = 'json';

$aData = $GLOBALS['MySQL']->getPlaces();

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
<td>Помещение</td>
<td>Описание</td>
</tr>
EOF;
                    foreach ($aData as $i => $aRecords) {
                        $sCode .= <<<EOF

<tr>
<td>{$aRecords['room_name']}</td>
<td>{$aRecords['room_description']}</td>
</tr>


EOF;
                    }
                    echo '</table>';
                } else {
                    $sCode = '<div>В базе нет информации о помещениях объекта</div>';
                }
                
                echo $sCode;
                
                break;
        }
?>