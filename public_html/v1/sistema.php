<?php
  $user_ip      = $_SERVER['REMOTE_ADDR'];
  $user_host    = (isset($_SERVER['REMOTE_HOST']) ? $_SERVER['REMOTE_HOST'] : null); // $_SERVER['REMOTE_HOST'];
  $user_user    = (isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : null); // $_SERVER['REMOTE_USER'];
  $user_client  = $_SERVER['HTTP_USER_AGENT'];
  date_default_timezone_set('America/La_Paz');
  $date         = date("Y-m-d");
  $time         = date("H:i:s");
  $timediff     = 4*60*60;
  $datebol      = gmdate("Y-m-d", time()-$timediff);
  $timebol      = gmdate("H:i:s", time()-$timediff);
  session_start();
  $user_session = session_id();
  header('Content-Type: text/html; charset=iso-8859-1');

  $pathinc    = "inc";
  $pathimg    = "img";
  $pathlogops = "/home/upbroot/logs/operations";
  $pathlogsql = "/home/upbroot/logs/sql";
  $pathppal   = ".";

  // This include uses the full path to the file, as its loated outside of the web directory
  include_once("/home/upbroot/conf/conf.inc.php");
  include_once("$pathinc/langs/$surp_lang.inc.php");
  include_once("$pathinc/func.inc.php");
  include_once("$pathinc/dbopen.inc.php");

  // Clear the main variables and cookie values
  $surc_user        = null;
  $surc_hash        = null;
  $surv_user        = null;
  $surv_user_id     = null;
  $surv_user_name   = null;
  $surv_user_status = null;
  $surv_level_id    = null;

  // Lets receive the variables
  $action = receive_variable("GET", "action", "STRING", 15);
  $surc_user = receive_variable("SESSION", "surc_user", "STRING", 32);
  $surc_hash = receive_variable("SESSION", "surc_hash", "STRING", 32);

  // Some constants
  $PHPSELF      = $_SERVER["PHP_SELF"];
  $REQUESTURI   = $_SERVER["REQUEST_URI"];

  if ($action == "logout") {
    // Ok its logged in, lets get their info for the log and then lets log the user out
    $q_checklogin  = "select * from USERS where user_id='$surc_user' and user_loginhash='$surc_hash' ";
    $q_checklogin .= "and user_loginsession='$user_session' ";
    $q_checklogin .= "and user_status>='2' and user_login='1';";
    $p_checklogin = db_query($q_checklogin);
    if ($p_checklogin->num_rows == 1) {
      $us = $p_checklogin->fetch_object();
      $surv_user = $us->user_username;
      $surv_user_id = $us->user_id;
      $surv_user_name = $us->user_name;
      $surv_user_status = $us->user_status;
      $surv_level_id = $us->level_id;
    }

    // Forzar Logout del sistema
    oplogs("$surv_user", "2", "", "");
    // Actualizar base de datos
    $q_logout  = "update USERS set user_login='0', user_loginhash='', user_loginexpires='', ";
    $q_logout .= "user_loginsession='' where user_id='$surc_user' and user_loginhash='$surc_hash' ";
    $q_logout .= "and user_loginsession='$user_session';";
    $p_logout = db_query($q_logout);
    // Borrar variables
    $surc_user = null;
    $surc_hash = null;
    $surv_user = null;
    $surv_user_id = null;
    $surv_user_name = null;
    $surv_user_status = null;
    $surv_level_id = null;

    // Clear cookies
    unset($_SESSION["surc_user"]);
    unset($_SESSION["surc_hash"]);

    // OK, restart
    // session_destroy();
    // session_start();
    // session_regenerate_id(true);
    $header = "Location: ../";
    header($header);
    exit;
  }

  if ($surc_user!= null && $surc_hash != null && $user_session != null) {
    $q_checklogin  = "select * from USERS where user_id='$surc_user' and user_loginhash='$surc_hash' ";
    $q_checklogin .= "and user_loginsession='$user_session' ";
    $q_checklogin .= "and user_status>='2' and user_login='1' and user_loginexpires>'$date $time';";
    $p_checklogin = db_query($q_checklogin);
    if ($p_checklogin->num_rows == 1) {
      // Hay usuario, renovar tiempos y setear variables
      $us = $p_checklogin->fetch_object();
      // Resetear cookies con nuevo tiempo de expiración
      $expire=time()+60*60*3;
      $_SESSION["surc_user"] = $surc_user;
      $_SESSION["surc_hash"] = $surc_hash;
      // Actualizar Base
      $expirafecha = date("Y-m-d H:i:s", $expire);
      $q_updbase  = "update USERS set user_loginexpires='$expirafecha' ";
      $q_updbase .= "where user_id='$us->user_id' and user_status>='2';";
      $p_updbase = db_query($q_updbase);
      // Lets create user data
      $surv_user = $us->user_username;
      $surv_user_id = $us->user_id;
      $surv_user_name = $us->user_name;
      $surv_user_status = $us->user_status;
      $surv_level_id = $us->level_id;
      
      oplogs("$us->user_username", "4", "", "");
    } else {
      // NO hay usuario o ha expirado todo, borrar cookies, y reiniciar
      oplogs("$surv_user", "3", "$surv_user", "");
      $surc_user = null;
      $surc_hash = null;
      $surv_user = null;
      $surv_user_id = null;
      $surv_user_name = null;
      $surv_user_status = null;
      $surv_level_id = null;
      // Clear cookies
      unset($_SESSION["surc_user"]);
      unset($_SESSION["surc_hash"]);
      // Ready, restart
      $header = "Location: ../";
      header($header);
      exit;
    }
  } else {
    // NO hay usuario o ha expirado todo, borrar cookies y reiniciar
    oplogs("$surv_user", "3", "$surv_user", "");
    $surc_user = null;
    $surc_hash = null;
    $surv_user = null;
    $surv_user_id = null;
    $surv_user_name = null;
    $surv_user_status = null;
    $surv_level_id = null;

    // Borrar cookies
    unset($_SESSION["surc_user"]);
    unset($_SESSION["surc_hash"]);
    // OK, restart
    $header = "Location: ../";
    header($header);
    exit;
  }
  // OK Estamos adentro ahora si leemos las paginas a mostrar
  // echo "<font size=\"1\">&nbsp;<br /></font>";
  if ($action == null) { $action = "dashboard"; }
  if ($surv_user_status==3) { $action = "updatepass"; }
  include_once("$pathinc/header.inc.php");
  include_once("$pathinc/permits.inc.php");
  include_once("$pathinc/footer.inc.php");
  include_once("$pathinc/dbclose.inc.php");
?>
