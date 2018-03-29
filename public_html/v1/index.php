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

  $samepath = getcwd();
  include_once("$samepath/paths.inc.php");
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
  $action = receive_variable("POST", "action", "STRING", 15); 
  $login_username = receive_variable("POST", "login_username", "STRING", 32);
  $login_password = receive_variable("POST", "login_password", "STRING", 32);
  $surc_user = receive_variable("SESSION", "surc_user", "STRING", 32);
  $surc_hash = receive_variable("SESSION", "surc_hash", "STRING", 32);

  // Intento de ingreso al sistema
  if ($action == "login") {
    $q_login  = "select * from USERS where user_username='$login_username' and user_status>='2';";
    $p_login = db_query($q_login);
    if ($p_login->num_rows == 1) {
      $us = $p_login->fetch_object();
      if ( password_verify($login_password, $us->user_password)) {
        // Crear cookies
        // 2 horas de validez (Si está idle por más de este tiempo la cookie expira)
        $expire=time()+60*60*2;
        $key = md5(microtime().rand());
        $_SESSION["surc_user"] = $us->user_id;
        $_SESSION["surc_hash"] = $key;
        // Update a la base
        $expirafecha = date("Y-m-d H:i:s", $expire);
        $q_update  = "update USERS set user_login='1', user_loginhash='$key', ";
        $q_update .= "user_loginsession='$user_session', ";
        $q_update .= "user_loginfrom='$user_ip', user_loginclient='$user_client', ";
        $q_update .= "user_logindatetime='$date $time', user_loginexpires='$expirafecha' ";
        $q_update .= "where user_id='$us->user_id' and user_status>='2';";
        $p_update = db_query($q_update);
        // Ok its logged in, lets get their info for the log
        $q_checklogin  = "select * from USERS where user_id='$us->user_id' and user_loginhash='$key' ";
        $q_checklogin .= "and user_loginsession='$user_session' ";
        $q_checklogin .= "and user_status>='2' and user_login='1' and user_loginexpires>'$date $time';";
        $p_checklogin = db_query($q_checklogin);
        if ($p_checklogin->num_rows == 1) {
          $us = $p_checklogin->fetch_object();
          $surv_user = $us->user_username;
          $surv_user_id = $us->user_id;
          $surv_user_name = $us->user_name;
          $surv_user_status = $us->user_status;
          $surv_level_id = $us->level_id;
        }
        $surc_user = $us->user_id;
        $surc_hash = $key;
        oplogs("$us->user_username", "1", "", "");
        // Listo, logueado
        $header = "Location: sistema.php";
        header($header);
        exit;
      }
    }
  }
  include_once("$pathinc/expire.inc.php");
  echo "<!DOCTYPE html>\n";
  echo "<html>\n";
  echo "  <head>\n";
  // echo "    <meta charset=\"utf-8\">\n";
  echo "    <meta charset=\"iso-8859-1\" />\n";
  echo "    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n";
  echo "    <title>.: $surp_sitename v.$surp_sitever :.</title>\n";
  echo "    <meta name=\"description\" content=\"$surp_siteslogan\">\n";
  echo "    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n";
  echo "    <meta name=\"publisher\" content=\"UPB La Paz\" />\n";
  echo "    <meta name=\"copyright\" content=\"$surp_sitecr\" />\n";
  echo "    <meta name=\"author\" content=\"Carlos Anibarro <carlosanibarro(at)lp(dot)upb(dot)edu>\" />\n";
  echo "    <meta name=\"distribution\" content=\"IU\" />\n";
  // This is a private script, don't want follows
  echo "    <meta name=\"robots\" content=\"NoIndex, NoFollow\">\n";
  // echo "    <!-- Bootstrap CSS-->\n";
  echo "    <link rel=\"stylesheet\" href=\"vendor/bootstrap/css/bootstrap.min.css\">\n";
  // echo "    <!-- Font Awesome CSS-->\n";
  echo "    <link rel=\"stylesheet\" href=\"vendor/font-awesome/css/font-awesome.min.css\">\n";
  // echo "    <!-- Custom Font Icons CSS-->\n";
  echo "    <link rel=\"stylesheet\" href=\"css/font.css\">\n";
  // echo "    <!-- Google fonts - Muli-->\n";
  echo "    <link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=Muli:300,400,700\">\n";
  // echo "    <!-- theme stylesheet-->\n";
  echo "    <link rel=\"stylesheet\" href=\"css/style.upb.css\" id=\"theme-stylesheet\">\n";
  // echo "    <!-- Custom stylesheet - for your changes-->\n";
  echo "    <link rel=\"stylesheet\" href=\"css/custom.css\">\n";
  // echo "    <!-- Favicon-->\n";
  echo "    <link rel=\"shortcut icon\" href=\"img/favicon.ico\">\n";
  echo "    <!-- Tweaks for older IEs--><!--[if lt IE 9]>\n";
  echo "        <script src=\"https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js\"></script>\n";
  echo "        <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script><![endif]-->\n";
  include_once("$pathinc/rightclick.inc.php");
  echo "  </head>\n";
  echo "  <body>\n";
  echo "    <div class=\"login-page\">\n";
  echo "      <div class=\"container d-flex align-items-center\">\n";
  echo "        <div class=\"form-holder has-shadow\">\n";
  echo "          <div class=\"row\">\n";
  // echo "            <!-- Logo & Information Panel-->\n";
  echo "            <div class=\"col-lg-6\">\n";
  echo "              <div class=\"info d-flex align-items-center\">\n";
  echo "                <div class=\"content\">\n";
  echo "                  <div class=\"logo\">\n";
  echo "                    <h1>$surp_sitename</h1>\n";
  echo "                  </div>\n";
  echo "                  <p>$surp_siteslogan</p>\n";
  echo "                </div>\n";
  echo "              </div>\n";
  echo "            </div>\n";
  // echo "            <!-- Form Panel    -->\n";
  echo "            <div class=\"col-lg-6 bg-white\">\n";
  echo "              <div class=\"form d-flex align-items-center\">\n";
  echo "                <div class=\"content\">\n";
  echo "                  <form role=\"form\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\" autocomplete=\"off\">\n";
  echo "                    <div class=\"form-group\">\n";
  echo "                      <input id=\"login-username\" type=\"text\" name=\"login_username\" required=\"\" class=\"input-material\">\n";
  echo "                      <label for=\"login-username\" class=\"label-material\">$l_username</label>\n";
  echo "                    </div>\n";
  echo "                    <div class=\"form-group\">\n";
  echo "                      <input id=\"login-password\" type=\"password\" name=\"login_password\" required=\"\" class=\"input-material\">\n";
  echo "                      <label for=\"login-password\" class=\"label-material\">$l_password</label>\n";
  echo "                      <input type=\"hidden\" name=\"action\" value=\"login\">\n";
  echo "                    </div>\n";
  // echo "                    <a id=\"login\" href=\"index.html\" class=\"btn btn-primary\">$l_login</a>\n";
  echo "                    <button type=\"submit\" class=\"btn btn-primary\">$l_login</button>\n";
  // echo "                    <!-- This should be submit button but I replaced it with <a> for demo purposes-->\n";
  echo "                  </form>\n";
  // echo "<a href=\"#\" class=\"forgot-pass\">Forgot Password?</a><br><small>Do not have an account? </small><a href=\"register.html\" class=\"signup\">Signup</a>\n";
  echo "                </div>\n";
  echo "              </div>\n";
  echo "            </div>\n";
  echo "          </div>\n";
  echo "        </div>\n";
  echo "      </div>\n";
  echo "      <div class=\"copyrights text-center\">\n";
  echo "        <p>$surp_sitecr | Dise&ntilde;o por <a href=\"https://bootstrapious.com\" class=\"external\" target=\"_new\">Bootstrapious</a></p>\n";
  // echo "        <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->\n";
  echo "      </div>\n";
  echo "    </div>\n";
  echo "    <!-- JavaScript files-->\n";
  echo "    <script src=\"https://code.jquery.com/jquery-3.2.1.min.js\"></script>\n";
  echo "    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js\"> </script>\n";
  echo "    <script src=\"vendor/bootstrap/js/bootstrap.min.js\"></script>\n";
  echo "    <script src=\"vendor/jquery.cookie/jquery.cookie.js\"> </script>\n";
  // echo "    <script src=\"vendor/chart.js/Chart.min.js\"></script>\n";
  echo "    <script src=\"js/front.js\"></script>\n";
  echo "  </body>\n";
  echo "</html>\n";
  include_once("$pathinc/dbclose.inc.php");
?>
