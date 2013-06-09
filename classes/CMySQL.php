<?php

class CMySQL {

    // variables
    var $sDbName;
    var $sDbUser;
    var $sDbPass;

    var $vLink;

    // constructor
    function CMySQL() {
        $this->sDbName = 'my_db';
        $this->sDbUser = 'root';
        $this->sDbPass = 'pockerface1';

        // create db link
        $this->vLink = mysql_connect("localhost", $this->sDbUser, $this->sDbPass);

        //select the database
        mysql_select_db($this->sDbName, $this->vLink);

        mysql_query("SET names UTF8");
    }

    // executing sql
    function res($query, $error_checking = true) {
        if(!$query)
            return false;
        $res = mysql_query($query, $this->vLink);
        if (!$res)
            $this->error('Database query error', false, $query);
        return $res;
    }

    // return table of records as result
    function getAll($query, $arr_type = MYSQL_ASSOC) {
        if (! $query)
            return array();

        if ($arr_type != MYSQL_ASSOC && $arr_type != MYSQL_NUM && $arr_type != MYSQL_BOTH)
            $arr_type = MYSQL_ASSOC;

        $res = $this->res($query);
        $arr_res = array();
        if ($res) {
            while ($row = mysql_fetch_array($res, $arr_type))
                $arr_res[] = $row;
            mysql_free_result($res);
        }
        return $arr_res;
    }

    function checkLogin($login, $password) {
        $query = "SELECT user_id FROM `users` WHERE `user_name` = '".$login."'
                                            AND `user_password` = '".md5($password)."'";
        return mysql_num_rows(mysql_query($query));
    }

    function getSystem() {
        $arr_type = MYSQL_ASSOC;
        $res = $this->res("SELECT * FROM `main_data`");
        $arr_res = array();
        if ($res) {
            while ($row = mysql_fetch_array($res, $arr_type))
                $arr_res[] = $row;
            mysql_free_result($res);
        }
        return $arr_res;
    }

    function getPlaces() {
        $arr_type = MYSQL_ASSOC;
        $res = $this->res("SELECT * FROM `places` ORDER BY `room_id`");
        $arr_res = array();
        if ($res) {
            while ($row = mysql_fetch_array($res, $arr_type))
                $arr_res[] = $row;
            mysql_free_result($res);
        }
        return $arr_res;
    }

    function getLight($room_id) {
        $arr_type = MYSQL_ASSOC;
        $query = "SELECT * FROM sensor_element WHERE (`sensor_type` = 'analog' OR `sensor_type` = 'digital')";
        if (isset ($room_id)) {
            $query .= " AND `sensor_room_id` = '" . $room_id . "'";
        } else $query .= " ORDER BY `sensor_room_id`";
        $res = $this->res($query);
        $arr_res = array();
        if ($res) {
            while ($row = mysql_fetch_array($res, $arr_type))
                $arr_res[] = $row;
            mysql_free_result($res);
        }
        return $arr_res;
    }

    function getClimate($room_id) {
        $arr_type = MYSQL_ASSOC;
        $query = "SELECT * FROM sensor_element WHERE `sensor_type` = 'climate'";
        if (isset ($room_id)) {
            $query .= " AND `sensor_room_id` = '" . $room_id . "'";
        } else $query .= " ORDER BY `sensor_room_id`";
        $res = $this->res($query);
        $arr_res = array();
        if ($res) {
            while ($row = mysql_fetch_array($res, $arr_type))
                $arr_res[] = $row;
            mysql_free_result($res);
        }
        return $arr_res;
    }

    function getOther($room_id) {
        $arr_type = MYSQL_ASSOC;
        $query = "SELECT * FROM sensor_element WHERE NOT (`sensor_type` = 'analog' or `sensor_type` = 'digital' or `sensor_type` = 'climate')";
        if (isset ($room_id)) {
            $query .= " AND `sensor_room_id` = '" . $room_id . "'";
        } else $query .= " ORDER BY `sensor_room_id`";
        $res = $this->res($query);
        $arr_res = array();
        if ($res) {
            while ($row = mysql_fetch_array($res, $arr_type))
                $arr_res[] = $row;
            mysql_free_result($res);
        }
        return $arr_res;
    }

    function getVideo() {
        $arr_type = MYSQL_ASSOC;
        $query = "SELECT * FROM surveillance ORDER BY `camera_name`";
        $res = $this->res($query);
        $arr_res = array();
        if ($res) {
            while ($row = mysql_fetch_array($res, $arr_type))
                $arr_res[] = $row;
            mysql_free_result($res);
        }
        return $arr_res;
    }

    function getAbout() {
        $arr_type = MYSQL_ASSOC;
        $query = "SELECT `api_ver`, `andr_ver`, `system_name` FROM main_data";
        $res = $this->res($query);
        $arr_res = array();
        if ($res) {
            while ($row = mysql_fetch_array($res, $arr_type))
                $arr_res[] = $row;
            mysql_free_result($res);
        }
        return $arr_res;
    }

    function getUsers() {
        $arr_type = MYSQL_ASSOC;
        $res = $this->res("SELECT * FROM `users`");
        $arr_res = array();
        if ($res) {
            while ($row = mysql_fetch_array($res, $arr_type))
                $arr_res[] = $row;
            mysql_free_result($res);
        }
        return $arr_res;
    }

    function addPlace($room_name, $room_descr) {
        $query = "INSERT INTO `places` (`room_name`, `room_description`) VALUES ";
        $query .= "('" . $room_name . "', '" . $room_descr . "')";;
        
        $res = $this->res($query);
    }
    function delPlace($id) {
        $query = "DELETE FROM places WHERE `room_id` = '" . $id . "'";
        $this->res($query);
    }

    function addUser($user_name, $user_password, $privilegies) {
        $query = "INSERT INTO `users` (`user_name`, `user_password`, `user_privilegies`) VALUES ";
        $query .= "('" . $user_name . "', '" . $user_password . "', '" . $privilegies . "')";
        mysql_query($query);
    }
    function delUser($id) {
        $query = "DELETE FROM users WHERE `user_id` = '" . $id . "'";
        $this->res($query);
    }

    function addVideo($camera_name, $camera_address, $room_id) {
        $query = "INSERT INTO `surveillance` (`camera_name`, `camera_address`, `camera_room_id`) VALUES ";
        $query .= "('" . $camera_name . "', '" . $camera_address . "', '" . $room_id . "')";
        $res = $this->res($query);
    }
    function delVideo($id) {
        $query = "DELETE FROM surveillance WHERE `camera_id` = '" . $id . "'";
        $this->res($query);
    }

    function addSensor($sensor_name, $sensor_type, $sensor_room_id) {
        $query = "INSERT INTO `sensor_element` (`sensor_name`, `sensor_type`, `sensor_reading`, `sensor_room_id`) VALUES ";
        $query .= "('" . $sensor_name . "', '" . $sensor_type . "', '0', '" . $sensor_room_id . "')";
        
        $res = $this->res($query);
    }

    function delSensor($id) {
        $query = "DELETE FROM sensor_element WHERE `sensor_id` = '" . $id . "'";
        $this->res($query);
    }

    function setSwitch($id, $val) {
        $query = "UPDATE  `sensor_element` SET  `sensor_reading` =  '".$val."' WHERE  `sensor_element`.`sensor_id` =". $id;
        mysql_query($query);
        $query = "SELECT `assoc_switch_id` FROM `sensor_element` WHERE `sensor_id` = ".$id;
        $res = mysql_query($query);
        $row = mysql_fetch_assoc($res);
        if (!is_null($id)) {
            $query = "UPDATE  `switch_element` SET  `switch_value` =  '".$val."' WHERE  `switch_id` =". $row['assoc_switch_id'];
            mysql_query($query);
        }
        
    }

    // escape
    function escape($s) {
        return mysql_real_escape_string($s);
    }

    // get last id
    function lastId() {
        return mysql_insert_id($this->vLink);
    }

    // display errors
    function error($text, $isForceErrorChecking = false, $sSqlQuery = '') {
        echo $text; exit;
    }
}

$GLOBALS['MySQL'] = new CMySQL();
