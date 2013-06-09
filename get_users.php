<?php
session_start();
require_once('classes/CMySQL.php'); // including service class to work with database
if (isset($_GET['method'])) {
    $method = $_GET['method'];
} else $method = 'json';

        $aData = $GLOBALS['MySQL']->getUsers();

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
<head>
    <link href="/css/TableCSSCode.css" rel="stylesheet" type="text/css">
</head>
<table class="CSSTableGenerator">
<tr>
<td>Имя пользователя</td>
<td>Привилегии</td>
<td>Удалить</td>
</tr>
EOF;
                    foreach ($aData as $i => $aRecords) {
                        $sCode .= <<<EOF

<tr>
<td>{$aRecords['user_name']}</td>
<td>{$aRecords['user_privilegies']}</td>
<td><input type="button" value="Удалить пользователя" onclick="location.href='del_user.php?method=html&id={$aRecords['user_id']}';"></td>
</tr>


EOF;
                    }
                    $sCode .= '</table>';
                } else {
                    $sCode = '<div>Нет пользователей в базе</div>';
                }
                
                echo $sCode; ?>
<br>
<input type="button" value="Добавить пользователя" onclick="location.href='add_user.php?method=html';">                
<?php                
                break;
        }
?>