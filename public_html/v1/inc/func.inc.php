<?php
  // Functions
  // 
  // Receive variables
  // 
  function receive_variable($var_method, $var_name, $var_filter="", $var_length=60) {
    $var_intname = null;
    if ($var_method == "SESSION") {
      $var_intname = (isset($_SESSION[$var_name]) ? $_SESSION[$var_name] : null);
    } elseif ($var_method == "POST") {
      $var_intname = (isset($_POST[$var_name]) ? $_POST[$var_name] : null);
    } elseif ($var_method == "GET") {
      $var_intname = (isset($_GET[$var_name]) ? $_GET[$var_name] : null);
    } elseif ($var_method == "REQUEST") {
      $var_intname = (isset($_REQUEST[$var_name]) ? $_REQUEST[$var_name] : null);
    }
    if (!is_array($var_intname)) {
      if ($var_filter == "STRING") {
        $var_intname = filter_var($var_intname, FILTER_SANITIZE_STRING);
      } elseif ($var_filter == "INT") {
        $var_intname = filter_var($var_intname, FILTER_SANITIZE_NUMBER_INT);
      } elseif ($var_filter == "FLOAT") {
        $var_intname = filter_var($var_intname, FILTER_SANITIZE_NUMBER_FLOAT);
      } elseif ($var_filter == "EMAIL") {
        $var_intname = filter_var($var_intname, FILTER_SANITIZE_EMAIL);
      } else {
        $var_intname = filter_var($var_intname, FILTER_DEFAULT);
      }
      if ($var_length != 0) {
        $var_intname = substr($var_intname, 0, $var_length);
      }
    }
    return $var_intname;
  }

  // Container functions
  function container_open($open_text = "") {
    echo "        <div class=\"page-header\">\n";
    echo "          <div class=\"container-fluid\">\n";
    echo "            <h2 class=\"h5 no-margin-bottom\">$open_text</h2>\n";
    echo "          </div>\n";
    echo "        </div>\n";
    echo "        <section class=\"no-padding-top no-padding-bottom\">\n";
    echo "          <div class=\"container-fluid\">\n";
  }
  function container_close() {
    echo "          </div>\n";
    echo "        </section>\n";
  }

  //
  // Date Management functions
  // 
  function proc_date($local_datesent) {
    global $l_m01, $l_m02, $l_m03, $l_m04, $l_m05, $l_m06, $l_m07, $l_m08, $l_m09, $l_m10, $l_m11, $l_m12;
    list($localyear, $localmonth, $localday) = explode("-", $local_datesent);
    global $l_procdate_sep;
    if ( ( $localmonth == 1 ) || ($localmonth == "01") ) { $literalmonth = $l_m01; };
    if ( ( $localmonth == 2 ) || ($localmonth == "02") ) { $literalmonth = $l_m02; };
    if ( ( $localmonth == 3 ) || ($localmonth == "03") ) { $literalmonth = $l_m03; };
    if ( ( $localmonth == 4 ) || ($localmonth == "04") ) { $literalmonth = $l_m04; };
    if ( ( $localmonth == 5 ) || ($localmonth == "05") ) { $literalmonth = $l_m05; };
    if ( ( $localmonth == 6 ) || ($localmonth == "06") ) { $literalmonth = $l_m06; };
    if ( ( $localmonth == 7 ) || ($localmonth == "07") ) { $literalmonth = $l_m07; };
    if ( ( $localmonth == 8 ) || ($localmonth == "08") ) { $literalmonth = $l_m08; };
    if ( ( $localmonth == 9 ) || ($localmonth == "09") ) { $literalmonth = $l_m09; };
    if ( ( $localmonth == 10) || ($localmonth == "10") ) { $literalmonth = $l_m10; };
    if ( ( $localmonth == 11) || ($localmonth == "11") ) { $literalmonth = $l_m11; };
    if ( ( $localmonth == 12) || ($localmonth == "12") ) { $literalmonth = $l_m12; };
    $local_strtoreturn = $localday.$l_procdate_sep.$literalmonth.$l_procdate_sep.$localyear;
    if ( $localday == "00" || $localday == "0" || $localday == "" ) {
      $local_strtoreturn = $literalmonth.$l_procdate_sep.$localyear;
    }
    if ( $localmonth == "00" || $localmonth == "0" || $localmonth = "" ) {
      $local_strtoreturn = "$localyear";
    }
    if ( $localyear == "0000") {
      $local_strtoreturn = "";
    }
    return $local_strtoreturn;
  }
  function proc_date2($local_datesent) {
    global $l_m01, $l_m02, $l_m03, $l_m04, $l_m05, $l_m06, $l_m07, $l_m08, $l_m09, $l_m10, $l_m11, $l_m12;
    global $l_procdate2_sep;
    list($localyear, $localmonth, $localday) = explode("-", $local_datesent);
    if ( ( $localmonth == 1 ) || ($localmonth == "01") ) { $literalmonth = $l_m01; };
    if ( ( $localmonth == 2 ) || ($localmonth == "02") ) { $literalmonth = $l_m02; };
    if ( ( $localmonth == 3 ) || ($localmonth == "03") ) { $literalmonth = $l_m03; };
    if ( ( $localmonth == 4 ) || ($localmonth == "04") ) { $literalmonth = $l_m04; };
    if ( ( $localmonth == 5 ) || ($localmonth == "05") ) { $literalmonth = $l_m05; };
    if ( ( $localmonth == 6 ) || ($localmonth == "06") ) { $literalmonth = $l_m06; };
    if ( ( $localmonth == 7 ) || ($localmonth == "07") ) { $literalmonth = $l_m07; };
    if ( ( $localmonth == 8 ) || ($localmonth == "08") ) { $literalmonth = $l_m08; };
    if ( ( $localmonth == 9 ) || ($localmonth == "09") ) { $literalmonth = $l_m09; };
    if ( ( $localmonth == 10) || ($localmonth == "10") ) { $literalmonth = $l_m10; };
    if ( ( $localmonth == 11) || ($localmonth == "11") ) { $literalmonth = $l_m11; };
    if ( ( $localmonth == 12) || ($localmonth == "12") ) { $literalmonth = $l_m12; };
    $local_strtoreturn = $localday.$l_procdate2_sep.$literalmonth.$l_procdate2_sep.$localyear;
    if ( $localday == "00" || $localday == "0" || $localday == "" ) {
      $local_strtoreturn = $literalmonth.$l_procdate2_sep.$localyear;
    }
    if ( $localmonth == "00" || $localmonth == "0" || $localmonth == "" ) {
      $local_strtoreturn = "$localyear";
    }
    if ( $localyear == "0000") {
      $local_strtoreturn = "";
    }
    return $local_strtoreturn;
  }
  function proc_date3($local_datesent) {
    global $l_sm01, $l_sm02, $l_sm03, $l_sm04, $l_sm05, $l_sm06, $l_sm07, $l_sm08, $l_sm09, $l_sm10, $l_sm11, $l_sm12;
    global $l_procdate3_sep;
    list($localyear, $localmonth, $localday) = explode("-", $local_datesent);
    if ( ( $localmonth == 1 ) || ($localmonth == "01") ) { $literalmonth = $l_sm01; };
    if ( ( $localmonth == 2 ) || ($localmonth == "02") ) { $literalmonth = $l_sm02; };
    if ( ( $localmonth == 3 ) || ($localmonth == "03") ) { $literalmonth = $l_sm03; };
    if ( ( $localmonth == 4 ) || ($localmonth == "04") ) { $literalmonth = $l_sm04; };
    if ( ( $localmonth == 5 ) || ($localmonth == "05") ) { $literalmonth = $l_sm05; };
    if ( ( $localmonth == 6 ) || ($localmonth == "06") ) { $literalmonth = $l_sm06; };
    if ( ( $localmonth == 7 ) || ($localmonth == "07") ) { $literalmonth = $l_sm07; };
    if ( ( $localmonth == 8 ) || ($localmonth == "08") ) { $literalmonth = $l_sm08; };
    if ( ( $localmonth == 9 ) || ($localmonth == "09") ) { $literalmonth = $l_sm09; };
    if ( ( $localmonth == 10) || ($localmonth == "10") ) { $literalmonth = $l_sm10; };
    if ( ( $localmonth == 11) || ($localmonth == "11") ) { $literalmonth = $l_sm11; };
    if ( ( $localmonth == 12) || ($localmonth == "12") ) { $literalmonth = $l_sm12; };
    $local_strtoreturn = $localday.$l_procdate3_sep.$literalmonth.$l_procdate3_sep.$localyear;
    $localyear = substr($localyear,2,2);
    if ( $localday == "00" || $localday == "0" || $localday == "" ) {
      $local_strtoreturn = $literalmonth.$l_procdate3_sep.$localyear;
    }
    if ( $localmonth == "00" || $localmonth == "0" || $localmonth == "" ) {
      $local_strtoreturn = "$localyear";
    }
    if ( $localyear == "0000") {
      $local_strtoreturn = "";
    }
    return $local_strtoreturn;
  }
  function proc_date4($local_datesent) {
    global $l_m01, $l_m02, $l_m03, $l_m04, $l_m05, $l_m06, $l_m07, $l_m08, $l_m09, $l_m10, $l_m11, $l_m12;
    global $l_procdate2_sep;
    list($localyear, $localmonth, $localday) = explode("-", $local_datesent);
    if ( ( $localmonth == 1 ) || ($localmonth == "01") ) { $literalmonth = $l_m01; };
    if ( ( $localmonth == 2 ) || ($localmonth == "02") ) { $literalmonth = $l_m02; };
    if ( ( $localmonth == 3 ) || ($localmonth == "03") ) { $literalmonth = $l_m03; };
    if ( ( $localmonth == 4 ) || ($localmonth == "04") ) { $literalmonth = $l_m04; };
    if ( ( $localmonth == 5 ) || ($localmonth == "05") ) { $literalmonth = $l_m05; };
    if ( ( $localmonth == 6 ) || ($localmonth == "06") ) { $literalmonth = $l_m06; };
    if ( ( $localmonth == 7 ) || ($localmonth == "07") ) { $literalmonth = $l_m07; };
    if ( ( $localmonth == 8 ) || ($localmonth == "08") ) { $literalmonth = $l_m08; };
    if ( ( $localmonth == 9 ) || ($localmonth == "09") ) { $literalmonth = $l_m09; };
    if ( ( $localmonth == 10) || ($localmonth == "10") ) { $literalmonth = $l_m10; };
    if ( ( $localmonth == 11) || ($localmonth == "11") ) { $literalmonth = $l_m11; };
    if ( ( $localmonth == 12) || ($localmonth == "12") ) { $literalmonth = $l_m12; };
    $local_strtoreturn = "$literalmonth $localday,$localyear";
    if ( ($localday == "00") || ($localday == "0") ) {
      $local_strtoreturn = "$literalmonth,$localyear";
    }
    if ( ($localmonth == "00") || ($localmonth == "0") ) {
      $local_strtoreturn = "$localyear";
    }
    if ( $localyear == "0000") {
      $local_strtoreturn = "";
    }
    return $local_strtoreturn;
  }
  function proc_date5($local_datesent) {
    global $l_sm01, $l_sm02, $l_sm03, $l_sm04, $l_sm05, $l_sm06, $l_sm07, $l_sm08, $l_sm09, $l_sm10, $l_sm11, $l_sm12;
    // Esta usamos para los reportes o las tablas grandes
    list($localyear, $localmonth, $localday) = explode("-", $local_datesent);
    if ( ( $localmonth == 1 ) || ($localmonth == "01") ) { $literalmonth = $l_sm01; };
    if ( ( $localmonth == 2 ) || ($localmonth == "02") ) { $literalmonth = $l_sm02; };
    if ( ( $localmonth == 3 ) || ($localmonth == "03") ) { $literalmonth = $l_sm03; };
    if ( ( $localmonth == 4 ) || ($localmonth == "04") ) { $literalmonth = $l_sm04; };
    if ( ( $localmonth == 5 ) || ($localmonth == "05") ) { $literalmonth = $l_sm05; };
    if ( ( $localmonth == 6 ) || ($localmonth == "06") ) { $literalmonth = $l_sm06; };
    if ( ( $localmonth == 7 ) || ($localmonth == "07") ) { $literalmonth = $l_sm07; };
    if ( ( $localmonth == 8 ) || ($localmonth == "08") ) { $literalmonth = $l_sm08; };
    if ( ( $localmonth == 9 ) || ($localmonth == "09") ) { $literalmonth = $l_sm09; };
    if ( ( $localmonth == 10) || ($localmonth == "10") ) { $literalmonth = $l_sm10; };
    if ( ( $localmonth == 11) || ($localmonth == "11") ) { $literalmonth = $l_sm11; };
    if ( ( $localmonth == 12) || ($localmonth == "12") ) { $literalmonth = $l_sm12; };
    $local_strtoreturn = "$localday/$literalmonth";
    $localyear = substr($localyear,2,2);
    if ( ($localday == "00") || ($localday == "0") ) {
      $local_strtoreturn = "$literalmonth/$localyear";
    }
    if ( ($localmonth == "00") || ($localmonth == "0") ) {
      $local_strtoreturn = "$localyear";
    }
    if ( $localyear == "0000") {
      $local_strtoreturn = "";
    }
    return $local_strtoreturn;
  }
  function literalmonth($local_num_month) {
    global $l_m01, $l_m02, $l_m03, $l_m04, $l_m05, $l_m06, $l_m07, $l_m08, $l_m09, $l_m10, $l_m11, $l_m12;
    if ( ( $local_num_month == 1 ) || ($local_num_month == "01") ) { $literalmonth = $l_m01; };
    if ( ( $local_num_month == 2 ) || ($local_num_month == "02") ) { $literalmonth = $l_m02; };
    if ( ( $local_num_month == 3 ) || ($local_num_month == "03") ) { $literalmonth = $l_m03; };
    if ( ( $local_num_month == 4 ) || ($local_num_month == "04") ) { $literalmonth = $l_m04; };
    if ( ( $local_num_month == 5 ) || ($local_num_month == "05") ) { $literalmonth = $l_m05; };
    if ( ( $local_num_month == 6 ) || ($local_num_month == "06") ) { $literalmonth = $l_m06; };
    if ( ( $local_num_month == 7 ) || ($local_num_month == "07") ) { $literalmonth = $l_m07; };
    if ( ( $local_num_month == 8 ) || ($local_num_month == "08") ) { $literalmonth = $l_m08; };
    if ( ( $local_num_month == 9 ) || ($local_num_month == "09") ) { $literalmonth = $l_m09; };
    if ( ( $local_num_month == 10) || ($local_num_month == "10") ) { $literalmonth = $l_m10; };
    if ( ( $local_num_month == 11) || ($local_num_month == "11") ) { $literalmonth = $l_m11; };
    if ( ( $local_num_month == 12) || ($local_num_month == "12") ) { $literalmonth = $l_m12; };
    return $literalmonth;
  }

  //
  // Data Base functions
  //
  /*
   *  db_query( $queryString ) Execute query on MySQL and report any errors
   *
   *  If $debug flag is set in config/general.conf.php, some debugging
   *  information is printed such as the SQL statement sent to the back end.
   *  - Cae
   */
  function db_query( $q ) {
     global $dblink,$date,$time,$pathlogsql,$surp_logsql,$surp_extsqllog;
     global $surv_user_id, $surv_level_id, $surv_user_name;
     global $surc_user, $surc_hash;
     global $user_client, $user_ip;
     global $abspath, $surp_dbuser, $surp_dbpass, $surp_dbname;
     // Verificar que el servidor este prendido antes de hacer el query
     if (!$dblink->ping()) {
       $dblink->close();
       $dblink = new mysqli('localhost', $surp_dbuser, $surp_dbpass, $surp_dbname);
       if ($dblink->connect_error) {
        die('Error al conectar a la Base de Datos (' . $dblink->connect_errno . ') '
              . $dblink->connect_error);
       }
       if ($surp_logsql == 1) {
         $datein = date("Y-m-d");
         $timein = date("H:i:s");
         $log = "|$datein|$timein|$surc_user|$surc_hash|$surv_user_id|$surv_user_name|$surv_level_id|$user_ip|$user_client|Reiniciando Conexion a mySQL|$dblink->connect_errno|$dblink->connect_error|\n";
         $local_logdirectory = $pathlogsql."/".date("Y")."/".date("m");
         if (!is_dir($local_logdirectory)) { mkdir($local_logdirectory,0777,TRUE); chmod($local_logdirectory,0777); }
         $local_logfile = $local_logdirectory."/".$date.$surp_extsqllog;
         file_put_contents($local_logfile,$log,FILE_APPEND);
       }
     }
     $result = $dblink->query( $q );
     unset( $error );
     $error = $dblink->error;
     if( $error ) {
         echo "Error de SQL, por favor rep&oacute;rtelo a la administraci&oacute;n<br />\n";
     }
     // Antes de salir loguear
     if ($surp_logsql == 1) {
       $resultados = 0+$dblink->affected_rows;
       $datein = date("Y-m-d");
       $timein = date("H:i:s");
       $log = "|$datein|$timein|$surc_user|$surc_hash|$surv_user_id|$surv_user_name|$surv_level_id|$user_ip|$user_client|$q|$resultados|$error|\n";
       $local_logdirectory = $pathlogsql."/".date("Y")."/".date("m");
       if (!is_dir($local_logdirectory)) { mkdir($local_logdirectory,0777,TRUE); chmod($local_logdirectory,0777); }
       $local_logfile = $local_logdirectory."/".$date.$surp_extsqllog;
       file_put_contents($local_logfile,$log,FILE_APPEND);
     }
     return $result;
     $result->close();
  }

  //
  // Logging functions
  //
  /* oplogs - Funcion de logueo de operaciones
     Parametro: El texto a loguear */
  function oplogs ($dest_username, $ot_id, $ol_flags, $ol_comment) {
     global $pathlogops,$surp_logops,$surp_extopslog;
     global $action, $surv_user_id, $surv_user, $surv_user_name, $surv_level_id;
     global $user_ip, $user_client, $surc_user, $surc_hash;
     global $abspath;
     if ($surp_logops == 1) {
       $date = date("Y-m-d");
       $time = date("H:i:s");
       $insdb  = "insert into OPLOGS (ol_date, ol_time, ol_request_uri, ";
       $insdb .= "ol_orig_user_id, ol_orig_user, ";
       $insdb .= "ol_orig_user_name, ol_orig_level_id, ol_orig_ip, ol_orig_client, ";
       $insdb .= "ol_orig_hash, ol_dest_username, ot_id, ol_flags, ";
       $insdb .= "ol_comment, ol_action) VALUES('$date', '$time', '".$_SERVER["REQUEST_URI"]."', ";
       $insdb .= "'$surc_user', ";
       $insdb .= "'$surv_user', '$surv_user_name', '$surv_level_id', '$user_ip', ";
       $insdb .= "'$user_client', '$surc_hash', '$dest_username', '$ot_id', ";
       $insdb .= "'$ol_flags', '$ol_comment', '$action');";
       $insnow = db_query($insdb);
       $log = "|$date|$time|$surc_user|$surv_user|$surv_user_name|$surv_level_id|$user_ip|$user_client|$surc_hash|$dest_username|$ot_id|$ol_flags|$ol_comment|$action|\n";
       $local_logdirectory = $pathlogops."/".date("Y")."/".date("m");
       if (!is_dir($local_logdirectory)) { mkdir($local_logdirectory,0777,TRUE); chmod($local_logdirectory,0777); }
       $local_logfile = $local_logdirectory."/".$date.$surp_extopslog;
       file_put_contents($local_logfile,$log,FILE_APPEND);
     }
     return 1;
  }
  /* detlog - Funcion de logueo de detalle
     Parametro: El texto a loguear */
  function detlog ($texto_aloguear) {
     global $date,$pathlogdet,$log_det,$file_detlog;
     global $appname, $appver, $appid;
     global $abspath;
     $datelog = date("Y-m-d");
     $timelog = date("H:i:s");
     if ($log_det == 1) {
       $log = "|$datelog|$timelog|$appname|$appver|$appid|$texto_aloguear|\n";
       $local_logdirectory = $pathlogdet."/".date("Y")."/".date("m");
       if (!is_dir($local_logdirectory)) { mkdir($local_logdirectory,0777,TRUE); chmod($local_logdirectory,0777); }
       $local_logfile = $local_logdirectory."/".$date.$file_detlog;
       file_put_contents($local_logfile,$log,FILE_APPEND);
     }
     return 1;
  }

  //
  // Password function
  //
/**
 * @simple function to test password strength
 * @param string $password
 * @return int
 */
  function testPassword($password) {
    if ( strlen( $password ) == 0 ) {
        return 1;
    }
    $strength = 0;
    /*** get the length of the password ***/
    $length = strlen($password);
    /*** check if password is not all lower case ***/
    if(strtolower($password) != $password) {
        $strength += 1;
    }
    /*** check if password is not all upper case ***/
    if(strtoupper($password) == $password) {
        $strength += 1;
    }
    /*** check string length is 8 -15 chars ***/
    if($length >= 8 && $length <= 15) {
        $strength += 1;
    }
    /*** check if lenth is 16 - 35 chars ***/
    if($length >= 16 && $length <=35) {
        $strength += 2;
    }
    /*** check if length greater than 35 chars ***/
    if($length > 35) {
        $strength += 3;
    }
    /*** get the numbers in the password ***/
    preg_match_all('/[0-9]/', $password, $numbers);
    $strength += count($numbers[0]);
    /*** check for special chars ***/
    preg_match_all('/[|!@#$%&*\/=?,;.:\-_+~^\\\]/', $password, $specialchars);
    $strength += sizeof($specialchars[0]);
    /*** get the number of unique chars ***/
    $chars = str_split($password);
    $num_unique_chars = sizeof( array_unique($chars) );
    $strength += $num_unique_chars * 2;
    /*** strength is a number 1-10; ***/
    $strength = $strength > 99 ? 99 : $strength;
    $strength = floor($strength / 10 + 1);
    return $strength;
  }
  function generateRandomString($length = 10) {
    // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
  }

  //
  // Table functions
  //
  function table_header($text_value="") {
    echo "<td class=\"th\">$text_value</td>";
  }
  function table_row($left_icon="", $left_value="",$input_name="",$input_type="",$right_value="",$right_help="",$left_colspan=0, $right_colspan=0) {
    echo " <tr>\n";
    $leftcol = ""; if ($left_colspan != 0) { $leftcol = " colspan=\"$left_colspan\""; }
    $rightcol = ""; if ($right_colspan != 0) { $rightcol = " colspan=\"$right_colspan\""; }
    echo "  <td valign=\"top\"$leftcol><div align=\"right\"><strong>";
    if ($left_icon != "") { echo "<i class=\"$left_icon\"></i>"; }
    if ($left_value != "") { echo " $left_value"; }
    echo "</strong></div></td>\n";
    echo "  <td valign=\"top\"$rightcol><div align=\"left\">";
    if ($input_type=="none") {
      echo "$right_value";
    } elseif ($input_type=="textarea") {
      if ($input_name == "") {
        $right_value= str_replace("\r", "", $right_value);
        $right_value= str_replace("\n", "<br />", $right_value);
        echo "$right_value";
      } else {
        $right_value= str_replace("<br>", "\n", $right_value);
        $right_value= str_replace("<br/>", "\n", $right_value);
        $right_value= str_replace("<br />", "\n", $right_value);
        echo "<textarea name=\"$input_name\" class=\"form-control\" rows=\"5\" placeholder=\"$right_help\">$right_value</textarea>";
      }
    } else {
      echo "<input type=\"$input_type\" class=\"form-control\" name=\"$input_name\" value=\"$right_value\" placeholder=\"$right_help\">";
    }
    echo "</div></td>";
    echo " </tr>\n";
  }

  //
  // Multiple Form functions
  //   
  function go_back() {
    global $l_goback;
    echo "<a href=\"javascript:history.back()\"><button type=\"button\" class=\"btn btn-danger\"><i class=\"fa fa-backward\"></i> $l_goback</button></a>";
    return 0;
  }

  //
  // Variable evaluation funtions
  //
  function eval_email($ee_address) {
   global $errortext, $error, $errorgraph, $surp_labelok, $surp_labelnook;
   global $l_erroremailbefore, $l_erroremailafter;
   $in_error = 0;
   if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $ee_address)) {
     $in_error = 1;
     $errortext .= $l_erroremailbefore . " '". $ee_address . "' " . $l_erroremailafter . "<br />\n";
     $errorgraph .= $surp_labelnook;
   } else {
     $errorgraph .= $surp_labelok;
   }
   if ($in_error ==1) {
     $error = $in_error;
   }
   return $in_error;
  }
  function eval_equal($ei_variable1,$ei_variable2,$ei_text) {
   global $errortext, $error, $errorgraph, $surp_labelok, $surp_labelnook;
   global $l_error2before, $l_error2after;
   $in_error = 0;
   if ($ei_variable1!=$ei_variable2) {
     $in_error = 1;
     $errortext .= $l_error2before ." ". $ei_text ." ".$l_error2after."<br />\n";
     $errorgraph .= $surp_labelnook;
   } else {
     $errorgraph .= $surp_labelok;
   }
   if ($in_error ==1) {
     $error = $in_error;
   }
   return $in_error;
  }
  function eval_date($ef_fecha) {
   global $errortext, $error, $errorgraph, $surp_labelok, $surp_labelnook;
   global $l_errordatebefore, $l_errordateafter;
   $ei_error = 0;
   list($ef_ano, $ef_mes, $ef_dia)=explode("-", $ef_fecha);
   if ( ($ef_ano == "") || ($ef_ano == "") || ($ef_dia == "") ) {
     $ei_error = 1;
     $errortext .= $l_errordatebefore . " '". $ef_fecha . "' " . $l_errordateafter. "<br />\n";
     $errorgraph .= $surp_labelnook;
   } else {
     if (!checkdate($ef_mes, $ef_dia, $ef_ano)) {
       $ei_error = 1;
       $errortext .= $l_errordatebefore . " '". $ef_fecha . "' " . $l_errordateafter. "<br />\n";
       $errorgraph .= $surp_labelnook;
     } else {
       $errorgraph .= $surp_labelok;
     }
   }
   if ($ei_error ==1) {
     $error = $ei_error;
   }
   return $ei_error;
  }
  function eval_repdb($in_variable, $en_tabla, $en_campo, $en_condicion, $in_texto) {
    global $errortext, $error, $errorgraph, $surp_labelok, $surp_labelnook;
    global $l_dbexist2before, $l_dbexist2after;
    $in_error = 0;
    $selrepetido = "select * from $en_tabla where BINARY $en_campo='$in_variable' $en_condicion ;";
    $getrepetido = db_query($selrepetido);
    if ($getrepetido->num_rows !=0) {
      $in_error = 1;
      $errortext .= $l_dbexist2before ." ". $in_texto ." ". $l_dbexist2after ."<br />\n";
      $errorgraph .= $surp_labelnook;
    } else {
      $errorgraph .= $surp_labelok;
    }
    if ($in_error == 1) {
      $error = $in_error;
    }
    return $in_error;
  }
  function eval_existsdb($in_variable, $en_tabla, $en_campo, $en_condicion, $in_texto) {
    global $errortext, $error, $errorgraph, $surp_labelok, $surp_labelnook;
    global $l_dbexistbefore, $l_dbexistafter;
    $in_error = 0;
    $selrepetido = "select * from $en_tabla where $en_campo='$in_variable' $en_condicion ;";
    $getrepetido = db_query($selrepetido);
    if ($getrepetido->num_rows !=1) {
      $in_error = 1;
      $errortext .= $l_dbexistbefore . " " . $in_texto . " " . $l_dbexistafter . "<br />\n";
      $errorgraph .= $surp_labelnook;
    } else {
      $errorgraph .= $surp_labelok;
    }
    if ($in_error == 1) {
      $error = $in_error;
    }
    return $in_error;
  }
  function eval_null($in_variable,$in_text) {
    global $errortext, $error, $errorgraph, $surp_labelok, $surp_labelnook;
    global $l_errorbefore, $l_errorafter;
    $in_error = 0;
    if (empty($in_variable) || ($in_variable == "") ) {
      $in_error = 1;
      $errortext .= $l_errorbefore . " " . $in_text . " " . $l_errorafter . "<br />\n";
      $errorgraph .= $surp_labelnook;
    } else {
      $errorgraph .= $surp_labelok;
    }
    if ($in_error == 1) {
      $error = $in_error;
    }
    return $in_error;
  }
  function eval_zero($in_variable,$in_text) {
    global $errortext, $error, $errorgraph, $surp_labelok, $surp_labelnook;
    global $l_errorbefore, $l_errorafter;
    $in_error = 0;
    if ($in_variable == 0) {
      $in_error = 1;
      $errortext .= $l_errorbefore ." ". $in_text ." ". $l_errorafter . "<br />\n";
      $errorgraph .= $surp_labelnook;
    } else {
      $errorgraph .= $surp_labelok;
    }
    if ($in_error == 1) {
      $error = $in_error;
    }
    return $in_error;
  }
  function eval_numeric($in_variable,$in_text) {
    global $errortext, $error, $errorgraph, $surp_labelok, $surp_labelnook;
    global $l_errornumericbefore, $l_errornumericafter;
    $in_error = 0;
    if ( !ctype_digit($in_variable) ) {
      $in_error = 1;
      $errortext .= $l_errornumericbefore . " " . $in_text . " " . $l_errornumericafter . "<br />\n";
      $errorgraph .= $surp_labelnook;
    } else {
      $errorgraph .= $surp_labelok;
    }
    if ($in_error == 1) {
      $error = $in_error;
    }
    return $in_error;
  }
  function eval_range($in_variable,$en_minimo,$en_maximo,$in_text) {
    global $errortext, $error, $errorgraph, $surp_labelok, $surp_labelnook;
    global $l_errorrangebefore, $l_errorrangeafter;
    $in_error = 0;
    if ( ($en_minimo > $in_variable) || ($en_maximo < $in_variable) ) {
      $in_error = 1;
      $errortext .= $l_errorrangebefore . " " .  $in_text . " " . $l_errorrangeafter . " [$en_minimo><$en_maximo]<br />\n";
      $errorgraph .= $surp_labelnook;
    } else {
      $errorgraph .= $surp_labelok;
    }
    if ($in_error == 1) {
      $error = $in_error;
    }
    return $in_error;
  }

  //
  // Other functions
  // 
  function agebydate($date_sent) {
    // list($iDay, $iMonth, $iYear) = explode("-", $date_sent);
    list($iYear, $iMonth, $iDay) = explode("-", $date_sent);
    $iTimeStamp = (mktime() - 86400) - mktime(0, 0, 0, $iMonth, $iDay, $iYear); 
    $iDays = $iTimeStamp / 86400;  
    $iYears = floor($iDays / 365 );
    return $iYears; 
  }
  function DownloadSize($bytes) {
    $size = $bytes;
    $sizes = Array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB');
    $ext = $sizes[0];
    for ($i=1; (($i < count($sizes)) && ($size >= 1024)); $i++) {
     $size = $size / 1024;
     $ext  = $sizes[$i];
    }
    return round($size, 2).$ext;
  }
  function form_line($left_icon = "", $left_name = "", $right_name = "", $right_type = "", $right_value = "", $right_help = "") {
    echo "<div class=\"form-group input-group\"> \n";
    echo "  <span class=\"input-group-addon\"><strong>";
    if ($left_icon != "") { echo "<i class=\"$left_icon\"></i>"; }
    if ($left_name != "") { echo " $left_name"; }
    echo "</strong></span>\n";
    if ($right_type == "none") {
      $right_value= str_replace("<br>", "\n", $right_value);
      $right_value= str_replace("<br/>", "\n", $right_value);
      $right_value= str_replace("<br />", "\n", $right_value);
      echo "  <span class=\"list-group-item\">$right_value</span>";
    } elseif ($right_type == "textarea") {
      $right_value= str_replace("<br>", "\n", $right_value);
      $right_value= str_replace("<br/>", "\n", $right_value);
      $right_value= str_replace("<br />", "\n", $right_value);
      echo "  <textarea class=\"form-control\" rows=\"5\" name=\"$right_name\" placeholder=\"$right_help\">$right_value</textarea>";
    } else {
      echo "  <input type=\"$right_type\" class=\"form-control\" placeholder=\"$right_help\" name=\"$right_name\" value=\"$right_value\" />\n";
    }
    echo "</div>\n";
  }
  function normalize_date($datenorm= "") {
    if ((strlen($datenorm) > 4) && (!preg_match('/[a-zA-Z]/',$datenorm)) ) {
      if (strpos($datenorm,"/") !== false) {
        $datenorm = str_replace("/", "-", $datenorm);
      }
      $datenorm = date("d/m/Y", strtotime("$datenorm"));
    }
    return $datenorm;
  }
  // Email encoding function
  function ss_email(
    $email, //email address to be encoded
    $title="", //title, or what to show to the visitor <a href='blah'>IT WILL BE HERE</a>
    $enc_mode="t",//how to encode 't'-- just text 'j'--use java script (most secure)
    $ret_mode="f",//what to return? 
      //  'e'--just encoded email, title is ignored
      //  't' -- just encoded title, email is ignored
      //  'm' --just encoded string 'mailto:encodedemail'
      //  'f' -- full email link like 
      //  <a href="encoded href here">encoded title here</a>
    $addon=""// additional data, it will be inserted just after '<a ', 
      //you can use it to specify CSS, target, etc 
  ){
    //check and prepare input parameters
    $enc_mode=strtoupper(trim($enc_mode));
    if(!$enc_mode)$enc_mode="T";
    
    $ret_mode=strtoupper(trim($ret_mode));
    if(!$ret_mode)$ret_mode="F";


    $code="";  
    switch($ret_mode){
      case "E":
        $code= cd("$email");
        break;
      case "M":
        $code = cd("mailto:",true).cd("$email");
        break;
      case "T":
        $code = cd($title,true);
        break;
      case "F":
        $code = '<a '
          .$addon
          .' href="'.cd("mailto:",true).cd("$email").'">'.cd($title,true).'</a>';
        break;
    }
    if($enc_mode == "T"){
      return $code;

    }else{
      //java script encryption
      $javacode='<script language="JavaScript" type="text/JavaScript">';
      $i=0;
      while ($i<strlen($code)){
        //get next part of code with random length from 15 to 20
        $len =rand(15,20);
        if($i+$len>strlen($code)) $len = strlen($code)-$i;
        $part = substr($code, $i,$len);
        //insert java code to output this part
        $javacode .="document.write('$part');";
        $i += $len;
      }
      $javacode .="</script>";
      return $javacode;
    }
  }
  //encoder function
  //it can convert text ($s) to hex or dec codes depending on $dec parameter
  function cd($s, $dec=false){
   $s = bin2hex($s);
   $res ='';
   for($i=0;$i<strlen($s); $i=$i+2){
    if($dec){
      $res = $res.'&#'.hexdec($s{$i}.$s{$i+1}).';';
    }
    else{
      $res=$res.'%'.$s{$i}.$s{$i+1};
    }
   }
   return $res;
  }
  function drawline() {
    echo "  <hr class=\"clear-contentunit\" />\n";
  }
  function returndate($dv_anio, $dv_mes, $dv_dia ) {
    global $l_dow0, $l_dow1, $l_dow2, $l_dow3, $l_dow4, $l_dow5, $l_dow6;
    global $l_m01, $l_m02, $l_m03, $l_m04, $l_m05, $l_m06, $l_m07, $l_m08, $l_m09, $l_m10, $l_m11, $l_m12;
    $dv_string = "$dv_anio-$dv_mes-$dv_dia";
    $ts_fecha = mktime(0, 0, 0, $dv_mes, $dv_dia, $dv_anio);
    $dv_dia = date("w", $ts_fecha);
    if ($dv_dia == 0) {
      $dv_string = $l_dow0. ", ";
    } elseif ($dv_dia == 1) {
      $dv_string = $l_dow1. ", ";
    } elseif ($dv_dia == 2) {
      $dv_string = $l_dow2. ", ";
    } elseif ($dv_dia == 3) {
      $dv_string = $l_dow3. ", ";
    } elseif ($dv_dia == 4) {
      $dv_string = $l_dow4. ", ";
    } elseif ($dv_dia == 5) {
      $dv_string = $l_dow5. ", ";
    } elseif ($dv_dia == 6) {
      $dv_string = $l_dow6. ", ";
    }
    $dv_string .= date("j", $ts_fecha);
    $dv_string .= " de ";
    $dv_mes = date("m", $ts_fecha);
    if ( ($dv_mes == "01") || ($dv_mes == 1)) {
      $dv_string .= $l_m01. ", ";
    } elseif ( ($dv_mes == "02") || ($dv_mes == 2)) {
      $dv_string .= $l_m02. ", ";
    } elseif ( ($dv_mes == "03") || ($dv_mes == 3)) {
      $dv_string .= $l_m03. ", ";
    } elseif ( ($dv_mes == "04") || ($dv_mes == 4)) {
      $dv_string .= $l_m04. ", ";
    } elseif ( ($dv_mes == "05") || ($dv_mes == 5)) {
      $dv_string .= $l_m05. ", ";
    } elseif ( ($dv_mes == "06") || ($dv_mes == 6)) {
      $dv_string .= $l_m06. ", ";
    } elseif ( ($dv_mes == "07") || ($dv_mes == 7)) {
      $dv_string .= $l_m07. ", ";
    } elseif ( ($dv_mes == "08") || ($dv_mes == 8)) {
      $dv_string .= $l_m08. ", ";
    } elseif ( ($dv_mes == "09") || ($dv_mes == 9)) {
      $dv_string .= $l_m09. ", ";
    } elseif ($dv_mes == "10") {
      $dv_string .= $l_m10. ", ";
    } elseif ($dv_mes == "11") {
      $dv_string .= $l_m11. ", ";
    } elseif ($dv_mes == "12") {
      $dv_string .= $l_m12. ", ";
    }
    $dv_string .= date("Y", $ts_fecha);
    return $dv_string;
  }

  function secondstohuman($ss) {
    $s = $ss%60;
    $m = floor(($ss%3600)/60);
    $h = floor(($ss%86400)/3600);
    $d = floor(($ss%2592000)/86400);
    $M = floor($ss/2592000);
    $str_ret = "";
    if ($M > 0) { $str_ret .= "$M"."m, "; }
    if ($d > 0) { $str_ret .= "$d"."d "; }
    $str_ret .= str_pad($h, 2, "0",STR_PAD_LEFT).":".str_pad($m, 2, "0",STR_PAD_LEFT);
    // $str_ret .= ":$s";
    return $str_ret;
  }
  /*
  Funcion getAllDatesBetweenTwoDates
  $fromDate = '2012-08-21';
  $toDate = '2012-08-30';
  $dateArray = getAllDatesBetweenTwoDates($fromDate, $toDate);
  echo  "<pre>";
    print_r($dateArray);
  echo "</pre>";
  */
  function getAllDatesBetweenTwoDates($strDateFrom,$strDateTo) {
    $aryRange=array();
    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2), substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2), substr($strDateTo,8,2),substr($strDateTo,0,4));
    if ($iDateTo>=$iDateFrom) {
      array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
      while ($iDateFrom<$iDateTo) {
        $iDateFrom+=86400; // add 24 hours
        array_push($aryRange,date('Y-m-d',$iDateFrom));
      }
    }
    return $aryRange;
  }
  // funcion de numero a palabras
  function num_char($num, $fem = false, $dec = true) {
    if ($num == 1) {
      return "Un 00/100";
    } else {
       $matuni[1] = "un";
       $matuni[2] = "dos";
       $matuni[3] = "tres";
       $matuni[4] = "cuatro";
       $matuni[5] = "cinco";
       $matuni[6] = "seis";
       $matuni[7] = "siete";
       $matuni[8] = "ocho";
       $matuni[9] = "nueve";
      $matuni[10] = "diez";
      $matuni[11] = "once";
      $matuni[12] = "doce";
      $matuni[13] = "trece";
      $matuni[14] = "catorce";
      $matuni[15] = "quince";
      $matuni[16] = "dieciseis";
      $matuni[17] = "diecisiete";
      $matuni[18] = "dieciocho";
      $matuni[19] = "diecinueve";
      $matuni[20] = "veinte";
    $matunisub[2] = "dos";
    $matunisub[3] = "tres";
    $matunisub[4] = "cuatro";
    $matunisub[5] = "quin";
    $matunisub[6] = "seis";
    $matunisub[7] = "sete";
    $matunisub[8] = "ocho";
    $matunisub[9] = "nove";
       $matdec[2] = "veint";
       $matdec[3] = "treinta";
       $matdec[4] = "cuarenta";
       $matdec[5] = "cincuenta";
       $matdec[6] = "sesenta";
       $matdec[7] = "setenta";
       $matdec[8] = "ochenta";
       $matdec[9] = "noventa";
       $matsub[3] = "mill";
       $matsub[5] = "bill";
       $matsub[7] = "mill";
       $matsub[9] = "trill";
      $matsub[11] = "mill";
      $matsub[13] = "bill";
      $matsub[15] = "mill";
       $matmil[4] = "millones";
       $matmil[6] = "billones";
       $matmil[7] = "de billones";
       $matmil[8] = "millones de billones";
      $matmil[10] = "trillones";
      $matmil[11] = "de trillones";
      $matmil[12] = "millones de trillones";
      $matmil[13] = "de trillones";
      $matmil[14] = "billones de trillones";
      $matmil[15] = "de billones de trillones";
      $matmil[16] = "millones de billones de trillones";

    $num = trim((string)@$num);
    if ($num[0] == "-") {
      $neg = 'menos ';
      $num = substr($num, 1);
    } else {
      $neg = '';
    }
    while ($num[0] == '0') $num = substr($num, 1);
    if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num;
    $zeros = true;
    $punt = false;
    $ent = '';
    $fra = '';
    for ($c = 0; $c < strlen($num); $c++) {
      $n = $num[$c];
      if (! (strpos(".,'''", $n) === false)) {
         if ($punt) break;
         else {
           $punt = true;
           continue;
         }
      } elseif (! (strpos('0123456789', $n) === false)) {
        if ($punt) {
          if ($n != '0') $zeros = false;
          $fra .= $n;
        } else
          $ent .= $n;
      } else
        break;
    }
    $ent = '     ' . $ent;
    // if ($dec and $fra and ! $zeros) {
    if ($dec and $fra) {
      $fin = " $fra/100";
/*
      $fin = ' coma';
      for ($n = 0; $n < strlen($fra); $n++) {
        if (($s = $fra[$n]) == '0')
          $fin .= ' cero';
        elseif ($s == '1')
          $fin .= $fem ? ' una' : ' un';
        else
          $fin .= ' ' . $matuni[$s];
      }
*/
    } else
      $fin = '';
    if ((int)$ent === 0) return 'Cero ' . $fin;
    $tex = '';
    $sub = 0;
    $mils = 0;
    $neutro = false;
    while ( ($num = substr($ent, -3)) != '   ') {
      $ent = substr($ent, 0, -3);
      if (++$sub < 3 and $fem) {
         $matuni[1] = 'una';
         $subcent = 'as';
      } else {
         $matuni[1] = $neutro ? 'un' : 'uno';
         $subcent = 'os';
      }
      $t = '';
      $n2 = substr($num, 1);
      if ($n2 == '00') {
      } elseif ($n2 < 21)
         $t = ' ' . $matuni[(int)$n2];
       elseif ($n2 < 30) {
         $n3 = $num[2];
         if ($n3 != 0) $t = 'i' . $matuni[$n3];
         $n2 = $num[1];
         $t = ' ' . $matdec[$n2] . $t;
       } else {
         $n3 = $num[2];
         if ($n3 != 0) $t = ' y ' . $matuni[$n3];
         $n2 = $num[1];
         $t = ' ' . $matdec[$n2] . $t;
       }
       $n = $num[0];
       if ($n == 1) {
         $t = ' ciento' . $t;
       } elseif ($n == 5){
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
       } elseif ($n != 0){
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
       }
       if ($t == " ciento") { $t = " cien"; }
       if ($sub == 1) {
       } elseif (! isset($matsub[$sub])) {
         if ($num == 1) {
            $t .= ' mil';
         } elseif ($num > 1){
            $t .= ' mil';
         }
       } elseif ($num == 1) {
         $t .= ' ' . $matsub[$sub] . 'on';
       } elseif ($num > 1){
         $t .= ' ' . $matsub[$sub] . 'ones';
       }
       if ($num == '000') $mils ++;
       elseif ($mils != 0) {
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub];
         $mils = 0;
       }
       $neutro = true;
       $tex = $t . $tex;
    }
    $tex = $neg . substr($tex, 1) . $fin;
    return ucfirst($tex);
    }
  }

  // Funcion para envio de emails con attachment
  function mailAttachments($to, $from, $subject, $message, $attachments = array(), $headers = array(), $additional_parameters = '') {
	$headers['From'] = $from;

	// Define the boundray we're going to use to separate our data with.
	$mime_boundary = '==MIME_BOUNDARY_' . md5(time());

	// Define attachment-specific headers
	$headers['MIME-Version'] = '1.0';
	$headers['Content-Type'] = 'multipart/mixed; boundary="' . $mime_boundary . '"';

	// Convert the array of header data into a single string.
	$headers_string = '';
	foreach($headers as $header_name => $header_value) {
		if(!empty($headers_string)) {
			$headers_string .= PHP_EOL;
		}
		$headers_string .= $header_name . ': ' . $header_value;
	}

	// Message Body
	$message_string  = '--' . $mime_boundary;
	$message_string .= PHP_EOL;
	$message_string .= 'Content-Type: text/plain; charset="iso-8859-1"';
	$message_string .= PHP_EOL;
	$message_string .= 'Content-Transfer-Encoding: 7bit';
	$message_string .= PHP_EOL;
	$message_string .= PHP_EOL;
	$message_string .= $message;
	$message_string .= PHP_EOL;
	$message_string .= PHP_EOL;

	// Add attachments to message body
	foreach($attachments as $local_filename => $attachment_filename) {
		if(is_file($local_filename)) {
			$message_string .= '--' . $mime_boundary;
			$message_string .= PHP_EOL;
			$message_string .= 'Content-Type: application/octet-stream; name="' . $attachment_filename . '"';
			$message_string .= PHP_EOL;
			$message_string .= 'Content-Description: ' . $attachment_filename;
			$message_string .= PHP_EOL;

			$fp = @fopen($local_filename, 'rb'); // Create pointer to file
			$file_size = filesize($local_filename); // Read size of file
			$data = @fread($fp, $file_size); // Read file contents
			$data = chunk_split(base64_encode($data)); // Encode file contents for plain text sending

			$message_string .= 'Content-Disposition: attachment; filename="' . $attachment_filename . '"; size=' . $file_size.  ';';
			$message_string .= PHP_EOL;
			$message_string .= 'Content-Transfer-Encoding: base64';
			$message_string .= PHP_EOL;
			$message_string .= PHP_EOL;
			$message_string .= $data;
			$message_string .= PHP_EOL;
			$message_string .= PHP_EOL;
		}
	}

	// Signal end of message
	$message_string .= '--' . $mime_boundary . '--';

	// Send the e-mail.
	return mail($to, $subject, $message_string, $headers_string, $additional_parameters);
  }
?>
