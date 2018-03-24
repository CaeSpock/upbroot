--
-- Table structure for table `CITIES`
--

DROP TABLE IF EXISTS `CITIES`;
CREATE TABLE `CITIES` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(100) NOT NULL,
  `city_code` varchar(3) NOT NULL,
  PRIMARY KEY (`city_id`)
);

LOCK TABLES `CITIES` WRITE;
INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (1,'La Paz','201');
INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (2,'Santa Cruz','701');
INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (3,'Cochabamba','301');
INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (4,'Sucre','101');
INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (5,'Potosi','501');
INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (6,'Beni','801');
INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (7,'Oruro','401');
INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (8,'Tarija','601');
INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (9,'Cobija','901');
INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (10,'El Alto','206');
INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (11,'Montero','703');
INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (12,'Yacuiba','605');
UNLOCK TABLES;

--
-- Table structure for table `DEPARTMENTS`
--

DROP TABLE IF EXISTS `DEPARTMENTS`;
CREATE TABLE `DEPARTMENTS` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(250) NOT NULL,
  `department_code` varchar(2) NOT NULL,
  PRIMARY KEY (`department_id`)
);

LOCK TABLES `DEPARTMENTS` WRITE;
INSERT INTO `DEPARTMENTS` (`department_id`, `department_name`, `department_code`) VALUES (1,'La Paz','01');
INSERT INTO `DEPARTMENTS` (`department_id`, `department_name`, `department_code`) VALUES (2,'Santa Cruz','03');
INSERT INTO `DEPARTMENTS` (`department_id`, `department_name`, `department_code`) VALUES (3,'Cochabamba','02');
INSERT INTO `DEPARTMENTS` (`department_id`, `department_name`, `department_code`) VALUES (4,'Chuquisaca','07');
INSERT INTO `DEPARTMENTS` (`department_id`, `department_name`, `department_code`) VALUES (5,'Potosi','05');
INSERT INTO `DEPARTMENTS` (`department_id`, `department_name`, `department_code`) VALUES (6,'Beni','08');
INSERT INTO `DEPARTMENTS` (`department_id`, `department_name`, `department_code`) VALUES (7,'Oruro','04');
INSERT INTO `DEPARTMENTS` (`department_id`, `department_name`, `department_code`) VALUES (8,'Tarija','06');
INSERT INTO `DEPARTMENTS` (`department_id`, `department_name`, `department_code`) VALUES (9,'Pando','09');
UNLOCK TABLES;

--
-- Table structure for table `OPERATIONS`
--

DROP TABLE IF EXISTS `OPERATIONS`;
CREATE TABLE `OPERATIONS` (
  `op_id` int(11) NOT NULL AUTO_INCREMENT,
  `ot_r_date` date NOT NULL,
  `ot_r_time` time NOT NULL,
  `ot_r_user` int(11) NOT NULL,
  `ot_r_username` varchar(250) NOT NULL,
  `ot_id` int(11) NOT NULL,
  `ot_d_username` varchar(250) NOT NULL,
  `ot_d_flags` varchar(250) NOT NULL,
  `ot_d_comment` text NOT NULL,
  `os_id` int(11) NOT NULL DEFAULT '0',
  `ot_d_result` text NOT NULL,
  PRIMARY KEY (`op_id`)
);

--
-- Table structure for table `OPERATIONSTATUS`
--

DROP TABLE IF EXISTS `OPERATIONSTATUS`;
CREATE TABLE `OPERATIONSTATUS` (
  `os_id` int(11) NOT NULL AUTO_INCREMENT,
  `os_value` varchar(100) NOT NULL,
  PRIMARY KEY (`os_id`)
);

LOCK TABLES `OPERATIONSTATUS` WRITE;
INSERT INTO `OPERATIONSTATUS` (`os_id`, `os_value`) VALUES (1,'Tarea Programada');
INSERT INTO `OPERATIONSTATUS` (`os_id`, `os_value`) VALUES (2,'Ejecutandose');
INSERT INTO `OPERATIONSTATUS` (`os_id`, `os_value`) VALUES (3,'Concluida');
UNLOCK TABLES;

DROP TABLE IF EXISTS `OPERATIONTYPES`;
CREATE TABLE `OPERATIONTYPES` (
  `ot_id` int(11) NOT NULL AUTO_INCREMENT,
  `ot_short` varchar(100) NOT NULL,
  `ot_value` varchar(250) NOT NULL,
  `ot_showinlogs` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`ot_id`)
);

LOCK TABLES `OPERATIONTYPES` WRITE;
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (1,'Login','Ingreso al Sistema','0');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (2,'LogOut','Salida del Sistema','0');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (3,'Forced LogOut','Salida Forzada del Sistema','0');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (4,'LoadPage','Cargar Pagina','0');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (5,'OpenPage','Pagina Abierta','0');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (6,'UpdateData','Actualizar Datos Personales','1');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (7,'UpdatePass','Actualizar Contrasena','1');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (9,'AdmUsers_AddUser','AdmUsers Adicionar usuario','1');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (10,'AdmUsers_ViewUser','AdmUsers Ver info de un usuario','1');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (11,'AdmUsers_UpdUserInfo','AdmUsers Modificar info de un usuario','1');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (12,'AdmUsers_UpdUserShell','AdmUsers Modificar shell de un usuario','1');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (13,'AdmUsers_UpdUserGroups','AdmUsers Modificar grupos de un usuario','1');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (14,'AdmUsers_UpdUserQuota','AdmUsers Modificar quota de un usuario','1');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (15,'AdmUsers_DelUser','AdmUsers Eliminar usuario','1');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (16,'AdmGroups_ViewAll','AdmGroups Ver grupos del sistema','0');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (17,'AdmGroups_ViewGroup','AdmGroups Ver info de un grupo','1');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (18,'AdmGroups_AddGroup','AdmGroups Adicionar grupo','1');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (19,'AdmGroups_DelGroup','AdmGroups Eliminar grupo','1');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (20,'ViewLogs_Search','Buscar logs','1');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (21,'ViewLogs_OpInfo','Ver Informacion de Operacion','1');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (22,'ViewLogs_OpDetail','Ver Detalle de Operacion','1');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (23,'AdmSysUsers_UpdUser','AdmSysUsers Modificar usuario de sistema','1');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (24,'AdmSysUsers_AddUser','AdmSysUsers Adicionar usuario de sistema','1');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (25, 'AdmUsers_BlockUser', 'AdmUsers Bloquear usuario', '1');
INSERT INTO `OPERATIONTYPES` (`ot_id`, `ot_short`, `ot_value`, `ot_showinlogs`) VALUES (26, 'AdmUsers_UnblockUser', 'AdmUsers Desbloquear usuario', '1');
UNLOCK TABLES;

DROP TABLE IF EXISTS `OPLOGS`;
CREATE TABLE `OPLOGS` (
  `ol_id` int(11) NOT NULL AUTO_INCREMENT,
  `ol_date` date NOT NULL,
  `ol_time` time NOT NULL,
  `ol_request_uri` text NOT NULL,
  `ol_orig_user_id` int(11) NOT NULL,
  `ol_orig_user` varchar(250) NOT NULL,
  `ol_orig_user_name` varchar(250) NOT NULL,
  `ol_orig_level_id` int(11) NOT NULL,
  `ol_orig_ip` varchar(100) NOT NULL,
  `ol_orig_client` varchar(250) NOT NULL,
  `ol_orig_hash` varchar(100) NOT NULL,
  `ol_dest_username` varchar(250) NOT NULL,
  `ot_id` int(11) NOT NULL,
  `ol_flags` varchar(250) NOT NULL,
  `ol_comment` text NOT NULL,
  `op_id` int(11) NOT NULL,
  `ol_action` varchar(100) NOT NULL,
  PRIMARY KEY (`ol_id`)
);

--
-- Table structure for table `TRANSACTIONLOG`
--

DROP TABLE IF EXISTS `TRANSACTIONLOG`;
CREATE TABLE `TRANSACTIONLOG` (
  `tl_id` int(11) NOT NULL AUTO_INCREMENT,
  `tl_date` date NOT NULL,
  `tl_time` time NOT NULL,
  `op_id` int(11) NOT NULL,
  `tl_command` varchar(250) NOT NULL,
  `tl_output` text NOT NULL,
  `tl_returnvar` varchar(250) NOT NULL,
  PRIMARY KEY (`tl_id`)
);

--
-- Table structure for table `USERLEVELS`
--

DROP TABLE IF EXISTS `USERLEVELS`;
CREATE TABLE `USERLEVELS` (
  `level_id` int(11) NOT NULL,
  `level_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`level_id`)
);

LOCK TABLES `USERLEVELS` WRITE;
INSERT INTO `USERLEVELS` (`level_id`, `level_name`) VALUES (1,'Usuario');
INSERT INTO `USERLEVELS` (`level_id`, `level_name`) VALUES (20,'Alumno');
INSERT INTO `USERLEVELS` (`level_id`, `level_name`) VALUES (40,'Docente');
INSERT INTO `USERLEVELS` (`level_id`, `level_name`) VALUES (60,'Alumno Administrador');
INSERT INTO `USERLEVELS` (`level_id`, `level_name`) VALUES (80,'Docente Administrador');
INSERT INTO `USERLEVELS` (`level_id`, `level_name`) VALUES (100,'Administrador del Sistema');
UNLOCK TABLES;

--
-- Table structure for table `USERS`
--

DROP TABLE IF EXISTS `USERS`;
CREATE TABLE `USERS` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `level_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `user_username` varchar(250) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `user_idc` varchar(30) NOT NULL,
  `user_dateofbirth` date NOT NULL DEFAULT '0000-00-00',
  `user_email` varchar(250) NOT NULL,
  `user_phonenumber` varchar(100) NOT NULL,
  `user_city` varchar(250) NOT NULL DEFAULT '',
  `user_address` text NOT NULL,
  `user_department` varchar(250) NOT NULL DEFAULT '',
  `user_latitude` varchar(15) NOT NULL,
  `user_longitude` varchar(15) NOT NULL,
  `user_createdbyid` int(11) NOT NULL,
  `user_createdbyname` varchar(150) NOT NULL,
  `user_createdip` varchar(100) NOT NULL,
  `user_createddate` datetime NOT NULL,
  `user_modbyid` int(11) NOT NULL,
  `user_modbyname` varchar(150) NOT NULL,
  `user_modip` varchar(100) NOT NULL,
  `user_moddate` datetime NOT NULL,
  `user_status` enum('0','1','2','3') NOT NULL DEFAULT '0',
  `user_statusbyid` int(11) NOT NULL,
  `user_statusbyname` varchar(150) NOT NULL,
  `user_statusip` varchar(250) NOT NULL,
  `user_statusdate` datetime NOT NULL,
  `user_login` enum('0','1') NOT NULL DEFAULT '0',
  `user_loginhash` varchar(250) NOT NULL,
  `user_loginsession` varchar(250) NOT NULL,
  `user_loginfrom` varchar(150) NOT NULL,
  `user_loginclient` varchar(250) NOT NULL,
  `user_logindatetime` datetime NOT NULL,
  `user_loginexpires` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
);

LOCK TABLES `USERS` WRITE;
INSERT INTO `USERS` (`user_id`, `level_id`, `city_id`, `department_id`, `user_username`, `user_password`, `user_name`, `user_idc`, `user_dateofbirth`, `user_email`, `user_phonenumber`, `user_city`, `user_address`, `user_department`, `user_latitude`, `user_longitude`, `user_createdbyid`, `user_createdbyname`, `user_createdip`, `user_createddate`, `user_modbyid`, `user_modbyname`, `user_modip`, `user_moddate`, `user_status`, `user_statusbyid`, `user_statusbyname`, `user_statusip`, `user_statusdate`, `user_login`, `user_loginhash`, `user_loginsession`, `user_loginfrom`, `user_loginclient`, `user_logindatetime`, `user_loginexpires`) VALUES (1,100,1,1,'admin','$2y$12$sKtw9cp/AJsGdMB0kE9k0OBdB/KBRn9ETCEhMF/GPcbYlwx26oOee','Administrador del Sistema','11223344 LP','1973-01-01','admin@lp.upb.edu','70000000','La Paz','Kanuma Camino a Achocalla Km 3.5','La Paz','-16.498483','-68.1327452',1,'Administrador de Sistema','192.168.100.225','2013-09-24 19:20:34',1,'Administrador de Sistema','192.168.46.1','2017-10-11 08:13:38','2',1,'admin','192.168.100.100','2013-09-24 19:20:34','1','62145fe3caa41dfa1c6ed85d6110c6ee','n8vs2kd9hie66clofrst4m6pqn','192.168.100.200','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:58.0) Gecko/20100101 Firefox/58.0','2018-03-03 20:56:21','2018-03-04 01:32:55');
INSERT INTO `USERS` (`user_id`, `level_id`, `city_id`, `department_id`, `user_username`, `user_password`, `user_name`, `user_idc`, `user_dateofbirth`, `user_email`, `user_phonenumber`, `user_city`, `user_address`, `user_department`, `user_latitude`, `user_longitude`, `user_createdbyid`, `user_createdbyname`, `user_createdip`, `user_createddate`, `user_modbyid`, `user_modbyname`, `user_modip`, `user_moddate`, `user_status`, `user_statusbyid`, `user_statusbyname`, `user_statusip`, `user_statusdate`, `user_login`, `user_loginhash`, `user_loginsession`, `user_loginfrom`, `user_loginclient`, `user_logindatetime`, `user_loginexpires`) VALUES (4,60,1,1,'user','$2y$12$Wrj9hQLHBGaTU2AksEDnTeWGzGJSp4Q3IHNtKT9L5iDydVvMtVKJy','User 1234','123456 LP','1979-01-01','user@upb.edu','3122323','La Paz','Kañuma en la U','La Paz','','',1,'Administrador de Sistema','192.168.100.200','2017-10-11 18:40:01',0,'','','0000-00-00 00:00:00','2',1,'Administrador de Sistema','192.168.100.200','2017-10-11 18:40:01','1','9db9bef1c6a5434cd102488fd428e7ae','ie9osjr3nnf7b92nujehglft0i','192.168.100.210','Mozilla/5.0 (Linux; Android 7.0; SAMSUNG SM-G925I Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/6.4 Chrome/56.0.2924.87 Mobile Safari/537.36','2018-02-27 18:10:16','2018-02-27 21:11:01');
UNLOCK TABLES;

DROP TABLE IF EXISTS `USERSTATUS`;
CREATE TABLE `USERSTATUS` (
  `us_id` int(11) NOT NULL,
  `us_name` varchar(100) NOT NULL,
  PRIMARY KEY (`us_id`)
);

LOCK TABLES `USERSTATUS` WRITE;
INSERT INTO `USERSTATUS` (`us_id`, `us_name`) VALUES (0,'Creado');
INSERT INTO `USERSTATUS` (`us_id`, `us_name`) VALUES (1,'Inactivo');
INSERT INTO `USERSTATUS` (`us_id`, `us_name`) VALUES (2,'Activo');
INSERT INTO `USERSTATUS` (`us_id`, `us_name`) VALUES (3,'Activo/Clave Expirada');
UNLOCK TABLES;

