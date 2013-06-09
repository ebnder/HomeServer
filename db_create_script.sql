DROP TABLE IF EXISTS `main_data`;
CREATE TABLE `main_data` (
  `current_temperature` int(10),
  `current_outside_temperature` int(10),
  `current_humidity` int(10),
  `hot_running_water_temperature` int(10),
  `input_voltage` int(10) NOT NULL DEFAULT 0,
  `server_address` varchar(15) NOT NULL DEFAULT '127.0.0.1',
  `server_status` int(10),
  `api_ver` varchar(5),
  `andr_ver` varchar(5),
  `system_name` varchar(50)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `main_data`(`current_temperature`, `current_outside_temperature`, `current_humidity`, `hot_running_water_temperature`, 
  `input_voltage`, `server_address`, `server_status`, `api_ver`, `andr_ver`, `system_name`) 
VALUES ('20', '10', '40', '60', '232', '10.0.0.4', '1', '0.1', '0.1', 'Термоядерная хурма');

DROP TABLE IF EXISTS `surveillance`;
CREATE TABLE `surveillance` (
  `camera_id` int(5) NOT NULL AUTO_INCREMENT,
  `camera_name` varchar(25) NOT NULL,
  `camera_type` varchar(15) NOT NULL,
  `camera_address` varchar(85) NOT NULL,
  `camera_room_id` int(10),
  `camera_state` varchar(15) NOT NULL,
  PRIMARY KEY (`camera_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `surveillance`(`camera_name`, `camera_type`, `camera_address`, `camera_room_id`, `camera_state`) 
VALUES ('Периметр сад','hd','172.168.10.1','0','online'),
        ('Гараж','sd','172.168.10.2','5','online'),
        ('Периметр ворота','hd','172.168.10.3','0','online'),
        ('Периметр бассейн','hd','172.168.10.4','0','offline'),
        ('Кладовая','sd','172.168.10.5','6','online'),
        ('Western Ambassador Inn', 'sd', 'http://75.149.177.241/mjpg/video.mjpg', '0', 'online'),
        ('Белогорск', 'sd', 'http://cam1.belogorsk.net/mjpg/video.mjpg', '0', 'online'),
        ('Белый дом запад', 'sd', 'http://avocam3.avo.ru/axis-cgi/mjpg/video.cgi', '0', 'online'),
        ('Белый дом тест', 'sd', 'http://avocam3.avo.ru/', '0', 'online');

DROP TABLE IF EXISTS `sensor_element`;
CREATE TABLE `sensor_element` (
  `sensor_id` int(5) NOT NULL AUTO_INCREMENT,
  `sensor_name` varchar(25) NOT NULL,
  `sensor_type` varchar(15) NOT NULL,
  `sensor_reading` int(10) NOT NULL DEFAULT 0,
  `sensor_room_id` int(10) NOT NULL DEFAULT 0,
  `assoc_switch_id` int(2),
  PRIMARY KEY  (`sensor_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `sensor_element` (`sensor_name`, `sensor_type`, `sensor_reading`, `sensor_room_id`, `assoc_switch_id`) 
VALUES ('Кухня свет','analog','86','7', '1'),
        ('Кухня кондиционер','climate','86','7', '2'),
        ('Гостинная теплый пол','climate','86','4', '3'),
        ('Гостинная свет','analog','86','4', '4'),
        ('Спальня свет','analog','65','3', '5'),
        ('Зал свет','analog','44','2', '6'),
        ('Прихожая свет','analog','44','1', '7'),
        ('Прихожая дверь','security','0','1', NULL),
        ('Гостинная окна','security','0','4', NULL),
        ('Кухня дым','smoke','0','7', NULL),
        ('Гостинная дым','smoke','0','4', NULL),
        ('Топливо генератор','level','21','6', '9'),
        ('Насос','switch','0','6', '10'),
        ('Гараж свет','digital','1','5', '11'),
        ('Гараж ворота','security','0','5', '12'),
        ('Гараж затопление','water','0','5', NULL);

DROP TABLE IF EXISTS `switch_element`;
CREATE TABLE `switch_element` (
  `switch_id` int(5) NOT NULL AUTO_INCREMENT,
  `switch_type` varchar(15) NOT NULL,
  `switch_value` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY  (`switch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `switch_element` (`switch_type`) 
VALUES ('analog'),('analog'),('analog'),('analog'),('analog'),('analog'),('analog'),('analog'),
('digital'),('digital'),('digital'),('digital'),('digital'),('digital'),('digital'),('digital');

DROP TABLE IF EXISTS `places`;
CREATE TABLE `places` (
  `room_id` int(5) NOT NULL AUTO_INCREMENT,
  `room_name` varchar(25) NOT NULL,
  `room_description` varchar(80),
  PRIMARY KEY  (`room_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `places` (`room_name`, `room_description`) VALUES
('прихожая', 'описание 1'),
('зал', 'описание 2'),
('спальня', 'описание 3'),
('гостинная', 'описание 4'),
('гараж', 'описание 5'),
('подвал', 'описание 6');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(5) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(28) NOT NULL,
  `user_password` varchar(64),
  `user_privilegies` varchar(15) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `users`(`user_name`, `user_password`, `user_privilegies`) VALUES 
('sam','5f4dcc3b5aa765d61d8327deb882cf99','admin'),
('user','ee11cbb19052e40b07aac0ca060c23ee','user'),
('admin','21232f297a57a5a743894a0e4a801fc3','admin')