<?php
session_start();

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 10)) {
    session_unset();
    session_destroy();
}

$_SESSION['LAST_ACTIVITY'] = time();

if ($_SESSION['name'] == null) {
    header("location:auth.php");
}

?>
<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="utf-8" />
        <title>Home Automation Web Client</title>
        <link href="/menu_assets/styles.css" rel="stylesheet" type="text/css">
        <link href="css/main.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <header>
            <h2>Home Automation Web Client</h2>
        </header>
        <div class="container">
            <table>
                <tr>
                    <td valign="top">
                    <br>
                    <div id='cssmenu'>
                        <ul>
                           <li><a target="results" href='get_system?method=html'><span>Общие</span></a></li>
                           <li><a target="results" href='get_light?method=html'><span>Свет</span></a></li>
                           <li><a target="results" href='get_climate?method=html'><span>Климат</span></a></li>
                           <li><a target="results" href='get_other?method=html'><span>Другие датчики</span></a></li>
                           <li><a target="results" href='get_video?method=html'><span>Охрана</span></a></li>
                           <li><a target="results" href='get_users?method=html'><span>Пользователи</span></a></li>
                           <li><a target="results" href='get_about?method=html'><span>О системе</span></a></li>
                           <li class='last'><a href='logout.php'><span>Выход</span></a></li>
                        </ul>
                    </div>
                    </td>

                    <td>
                        <div class="contr">
                            <iframe src="get_system?method=html" name="results" style="width:600px;height:480px" frameBorder="0">
                            </iframe>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>