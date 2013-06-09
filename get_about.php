<?php
session_start();
require_once('classes/CMySQL.php'); // including service class to work with database

if (isset($_GET['method'])) {
    $method = $_GET['method'];
} else $method = 'json';

$aData = $GLOBALS['MySQL']->getAbout();

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
                    foreach ($aData as $i => $aRecords) {
                    $sCode .= <<<EOF
Система: {$aRecords['system_name']} <br> Версия API: {$aRecords['api_ver']} <br>
<br> Методы API: <br><br>
get_system <br>
get_light <br>
get_climate <br>
get_other <br>
get_video <br>
get_about <br>
get_users <br>
get_places <br><br>
add_user <br>
add_place <br>
add_sensor <br>
add_video <br><br>
del_user <br>
del_place <br>
del_sensor <br>
del_video <br><br>
set_value

EOF;
    }            } else {
                    $sCode = '<div>Nothing found</div>';
                }
                
                echo $sCode;
                break;                
        }

?>