<?php
  ## Admin system users
  oplogs("$surv_user", "5", "", "");
  container_open("$l_admsysusers");
  // Receive variables
  $in_new       = receive_variable("POST", "in_new", "INT", 1);
  $in_view      = receive_variable("POST", "in_view", "INT", 1);
  $in_upd       = receive_variable("POST", "in_upd", "INT", 1);
  $in_doit      = receive_variable("POST", "in_doit", "INT", 1);
  $in_confirm   = receive_variable("POST", "in_confirm", "INT", 1);
  $in_user      = receive_variable("POST", "in_user", "INT", 5);

  $in_name        = receive_variable("POST", "in_name", "STRING", 200);
  $in_idc         = receive_variable("POST", "in_idc", "STRING", 200);
  $in_year        = receive_variable("POST", "in_year", "INT", 4);
  $in_month       = receive_variable("POST", "in_month", "INT", 2);
  $in_day         = receive_variable("POST", "in_day", "INT", 2);
  $in_year        = str_pad($in_year,4,"0", STR_PAD_LEFT);
  $in_month       = str_pad($in_month,2,"0", STR_PAD_LEFT);
  $in_day         = str_pad($in_day,2,"0", STR_PAD_LEFT);
  $in_email       = receive_variable("POST", "in_email", "STRING", 200);
  $in_phonenumber = receive_variable("POST", "in_phonenumber", "STRING", 200);
  $in_city        = receive_variable("POST", "in_city", "INT", 2);
  $in_address     = receive_variable("POST", "in_address", "STRING", 1000);
  $in_department  = receive_variable("POST", "in_department", "INT", 2);
  $in_status      = receive_variable("POST", "in_status", "INT", 2);

  if ($in_upd == 1) {
    if ($in_doit == 1) {
      $error = 0;
      $errortext = "";
      $errorgraph = "";
      eval_null("$in_name", "$l_nullname");
      eval_null("$in_idc", "$l_nullidc");
      eval_null("$in_year", "$l_nullyear");
      eval_null("$in_month", "$l_nullmonth");
      eval_null("$in_day", "$l_nullday");
      eval_null("$in_email", "$l_nullmail");
      eval_null("$in_phonenumber", "$l_nullphonenumber");
      eval_null("$in_city", "$l_nullcity");
      eval_null("$in_address", "$l_nulladdress");
      eval_null("$in_department", "$l_nulldepartment");
      eval_null("$in_status", "$l_nullstatus");
      echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
      if ($in_confirm == 1) {
        echo "<div class=\"title\"><strong>Modificando datos de usuario ...</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n";
        echo "  <tbody>\n";
        $so  = "select * from USERS u, USERSTATUS s where ";
        $so .= "binary u.user_status=s.us_id and u.user_id='$in_user' order by user_id limit 1;";
        $qo = db_query($so);
        while ($po=$qo->fetch_object()) {
          table_row("fa fa-th-list", "$l_verifyingvars:", "", "none", "$errorgraph");
          if ($error == 1) {
            table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
            echo "<tr><td colspan=\"2\"><center>\n";
            go_back();
            echo "</center></td></tr>\n";
          } else {
            $logflags  = "";
            table_row("fa fa-info", "ID:", "", "none", "$po->user_id");
            $logflags .= "$po->user_id|";
            table_row("fa fa-user", "Username:", "", "none", "$po->user_username");
            $logflags .= "$po->user_username|";
            $sel_c = "select * from CITIES where city_id='$in_city' limit 1;";
            $get_c = db_query($sel_c);
            $row_c = $get_c->fetch_object();
            $sel_d = "select * from DEPARTMENTS where department_id='$in_department' limit 1;";
            $get_d = db_query($sel_d);
            $row_d = $get_d->fetch_object();
            $upd  = "update USERS set user_name='$in_name', user_idc='$in_idc', ";
            $upd .= "user_dateofbirth='$in_year-$in_month-$in_day', ";
            $upd .= "user_email='$in_email', user_phonenumber='$in_phonenumber', ";
            $upd .= "city_id='$in_city', user_city='$row_c->city_name', ";
            $upd .= "user_address='$in_address', department_id='$in_department', ";
            $upd .= "user_department='$row_d->department_name', ";
            $logflags .= "$in_name|$in_idc|$in_year-$in_month-$in_day|";
            $logflags .= "$in_email|$in_phonenumber|$in_city|$row_c->city_name|";
            $logflags .= "$in_address|$in_department|$row_d->department_name|";
            $logflags .= "$surc_user|$surv_user_name|$user_ip|$date $time|";
            if ($po->user_status != $in_status) {
              $upd .= "user_status='$in_status', user_statusbyid='$surc_user', ";
              $upd .= "user_statusbyname='$surv_user_name', user_statusip='$user_ip', ";
              $upd .= "user_statusdate='$date $time', ";
              $logflags .= "$in_status|$surc_user|$surv_user_name|$user_ip|$date $time|";
            }
            $upd .= "user_modbyid='$surc_user', user_modbyname='$surv_user_name', ";
            $upd .= "user_modip='$user_ip', user_moddate='$date $time' ";
            $upd .= "where user_id='$in_user' limit 1;";
            table_row("fa fa-user", "SQL:", "", "none", "$upd");
            table_row("fa fa-user", "Log:", "", "none", "$logflags");
            // oplogs("po->user_username", "23", "$logflags", "");
          }
          echo "  </tbody>\n";
        }
        echo "  </table>\n";
      } else {
        echo "<div class=\"title\"><strong>Por favor confirme la siguiente modificaci&oacute;n:</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n";
        echo "  <tbody>\n";
        $so  = "select * from USERS u, USERSTATUS s where ";
        $so .= "binary u.user_status=s.us_id and u.user_id='$in_user' order by user_id limit 1;";
        $qo = db_query($so);
        while ($po=$qo->fetch_object()) {
          table_row("fa fa-th-list", "$l_verifyingvars:", "", "none", "$errorgraph");
          if ($error == 1) {
            table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
            echo "<tr><td colspan=\"2\"><center>\n";
            go_back();
            echo "</center></td></tr>\n";
          } else {
            table_row("fa fa-info", "ID:", "", "none", "$po->user_id");
            echo "<input type=\"hidden\" name=\"in_user\" value=\"$in_user\">\n";
            table_row("fa fa-user", "Username:", "", "none", "$po->user_username");
            $show_name = $in_name;
            if ($po->user_name != $in_name) {
              $show_name .= " <span class=\"small\"><font color=\"#009966\">[$po->user_name]</font></span>";
            }
            table_row("fa fa-file-text-o", "Nombre:", "", "none", "$show_name");
            echo "<input type=\"hidden\" name=\"in_name\" value=\"$in_name\">\n";
            $show_idc = $in_idc;
            if ($po->user_idc != $in_idc) {
              $show_idc .= " <span class=\"small\"><font color=\"#009966\">[$po->user_idc]</font></span>";
            }
            table_row("fa fa-id-card", "C&eacute;dula de Identidad:", "", "none", "$show_idc");
            echo "<input type=\"hidden\" name=\"in_idc\" value=\"$in_idc\">\n";
            $show_dob = proc_date4("$in_year-$in_month-$in_day");
            if ($show_dob != proc_date4($po->user_dateofbirth)) {
              $show_dob .= " <span class=\"small\"><font color=\"#009966\">[".proc_date4($po->user_dateofbirth)."]</font></span>";
            }
            table_row("fa fa-calendar", "Fecha de Nacimiento:", "", "none", "$show_dob");
            echo "<input type=\"hidden\" name=\"in_year\" value=\"$in_year\">\n";
            echo "<input type=\"hidden\" name=\"in_month\" value=\"$in_month\">\n";
            echo "<input type=\"hidden\" name=\"in_day\" value=\"$in_day\">\n";
            $show_email = $in_email;
            if ($po->user_email != $in_email) {
              $show_email .= " <span class=\"small\"><font color=\"#009966\">[$po->user_email]</font></span>";
            }
            table_row("fa fa-envelope-o", "E-Mail:", "", "none", "$show_email");
            echo "<input type=\"hidden\" name=\"in_email\" value=\"$in_email\">\n";
            $show_phonenumber = $in_phonenumber;
            if ($po->user_phonenumber != $in_phonenumber) {
              $show_phonenumber .= " <span class=\"small\"><font color=\"#009966\">[$po->user_phonenumber]</font></span>";
            }
            table_row("fa fa-phone", "Tel&eacute;fono:", "", "none", "$show_phonenumber");
            echo "<input type=\"hidden\" name=\"in_phonenumber\" value=\"$in_phonenumber\">\n";
            $sel_c = "select * from CITIES where city_id='$in_city' limit 1;";
            $get_c = db_query($sel_c);
            $row_c = $get_c->fetch_object();
            $show_city = $row_c->city_name;
            if ($po->city_id != $in_city) {
              $show_city .= " <span class=\"small\"><font color=\"#009966\">[$po->user_city]</font></span>";
            }
            table_row("fa fa-map-pin", "Ciudad:", "", "none", "$show_city");
            echo "<input type=\"hidden\" name=\"in_city\" value=\"$in_city\">\n";
            $show_address = $in_address;
            if ($po->user_address != $in_address) {
              $show_address .= " <span class=\"small\"><font color=\"#009966\">[$po->user_address]</font></span>";
            }
            table_row("fa fa-street-view", "Direcci&oacute;n:", "", "none", "$show_address");
            echo "<input type=\"hidden\" name=\"in_address\" value=\"$in_address\">\n";
            $sel_d = "select * from DEPARTMENTS where department_id='$in_department' limit 1;";
            $get_d = db_query($sel_d);
            $row_d = $get_d->fetch_object();
            $show_department = $row_d->department_name;
            if ($po->department_id != $in_department) {
              $show_department .= " <span class=\"small\"><font color=\"#009966\">[$po->user_department]</font></span>";
            }
            table_row("fa fa-map-marker", "Departamento:", "", "none", "$show_department");
            echo "<input type=\"hidden\" name=\"in_department\" value=\"$in_department\">\n";
            $sel_s = "select * from USERSTATUS where us_id='$in_status' limit 1;";
            $get_s = db_query($sel_s);
            $row_s = $get_s->fetch_object();
            $show_status = $row_s->us_name;
            if ($po->us_id != $in_status) {
              $show_status .= " <span class=\"small\"><font color=\"#009966\">[$po->us_name]</font></span>";
            }
            table_row("fa fa-chevron-right", "Estado:", "", "none", "$show_status");
            echo "<input type=\"hidden\" name=\"in_status\" value=\"$in_status\">\n";
            echo "<input name=\"in_upd\" value=\"1\" type=\"hidden\">\n";
            echo "<input name=\"in_doit\" value=\"1\" type=\"hidden\">\n";
            echo "<input name=\"in_confirm\" value=\"1\" type=\"hidden\">\n";
            $reset = "<a href=\"$REQUESTURI\"><button type=\"button\" class=\"btn btn-danger\">$l_no</button></a>";
            $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_yesconfirm</button>";
            table_row("", "$reset", "", "none", "$submit");
          }
          echo "  </tbody>\n";
        }
        echo "  </table>\n";
      }
      echo "  <br /><br />\n";
      echo "</div>\n";
      echo "</form>";
    } else {
      echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
      echo "<div class=\"title\"><strong>Modificaci&oacute;n de usuario:</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      echo "  <table class=\"table table-sm table-hover\">\n";
      echo "  <tbody>\n";
      $so  = "select * from USERS u, USERSTATUS s where ";
      $so .= "binary u.user_status=s.us_id and u.user_id='$in_user' order by user_id limit 1;";
      $qo = db_query($so);
      while ($po=$qo->fetch_object()) {
        table_row("fa fa-info", "ID:", "", "none", "$po->user_id");
        table_row("fa fa-user", "Username:", "", "none", "$po->user_username");
        table_row("fa fa-file-text-o", "Nombre:", "in_name", "text", "$po->user_name", "Nombre");
        table_row("fa fa-id-card", "C&eacute;dula de Identidad:", "in_idc", "text", "$po->user_idc", "C&eacute;dula de Identidad");
        $process_dob  = "<select name=\"in_day\">\n";
        for ($i = 1; $i <= 31; $i++) {
          if ($i == substr($po->user_dateofbirth,8,2)) {
            $process_dob .= "<option value=\"$i\" selected>$i</option>\n";
          } else {
            $process_dob .= "<option value=\"$i\">$i</option>\n";
          }
        }    
        $process_dob .= "</select> de <select name=\"in_month\">\n";
        for ($i = 1; $i <= 12; $i++) {
          if ($i == substr($po->user_dateofbirth,5,2)) {
            $process_dob .= "<option value=\"$i\" selected>".literalmonth($i)."</option>\n";
          } else {
            $process_dob .= "<option value=\"$i\">".literalmonth($i)."</option>\n";
          }
        }
        $process_dob .= "</select> de <select name=\"in_year\">\n";
        for ($i = 1940; $i <= date("Y"); $i++) {
          if ($i == substr($po->user_dateofbirth,0,4)) {
            $process_dob .= "<option value=\"$i\" selected>$i</option>\n";
          } else {
            $process_dob .= "<option value=\"$i\">$i</option>\n";
          }
        }
        $process_dob .= "</select>\n";
        table_row("fa fa-calendar", "Fecha de Nacimiento:", "", "none", "$process_dob");
        table_row("fa fa-envelope-o", "E-Mail:", "in_email", "text", "$po->user_email", "E-Mail");
        table_row("fa fa-phone", "Tel&eacute;fono:", "in_phonenumber", "text", "$po->user_phonenumber", "Tel&eacute;fono");
        $process_city  = "<select name=\"in_city\">\n";
        $process_city .= "  <option value=\"\">--</option>\n"; 
        $sel_cities = "select * from CITIES order by city_name asc;";
        $get_cities = db_query($sel_cities);
        while ($pc = $get_cities->fetch_object()) {
          if ($pc->city_id == $po->city_id) {
            $process_city .= "  <option value=\"$pc->city_id\" selected>$pc->city_name</option>\n";
          } else {
            $process_city .= "  <option value=\"$pc->city_id\">$pc->city_name</option>\n";
          }
        }
        $process_city .= "</select>\n";
        table_row("fa fa-map-pin", "Ciudad:", "", "none", "$process_city");
        table_row("fa fa-street-view", "Direcci&oacute;n:", "in_address", "textarea", "$po->user_address", "Direcci&oacute;n");
        $process_department  = "<select name=\"in_department\">\n";
        $process_department .= "  <option value=\"\">--</option>\n";
        $sel_departments = "select * from DEPARTMENTS order by department_name asc;";
        $get_departments = db_query($sel_departments);
        while ($pd = $get_departments->fetch_object()) {
          if ($pd->department_id == $po->department_id) {
            $process_department .= "  <option value=\"$pd->department_id\" selected>$pd->department_name</option>\n";
          } else {
            $process_department .= "  <option value=\"$pd->department_id\">$pd->department_name</option>\n";
          }
        }
        $process_department .= "</select>\n";
        table_row("fa fa-map-marker", "Departamento:", "", "none", "$process_department");
        table_row("fa fa-user-circle-o", "Creado por:", "", "none", "$po->user_createdbyname [$po->user_createdbyid]");
        table_row("fa fa-calendar-o", "Creado el:", "", "none", proc_date4(substr($po->user_createddate,0,10))." - ".substr($po->user_createddate,11,8));
        if ($po->user_moddate != "0000-00-00 00:00:00") {
          table_row("fa fa-user-circle-o", "Modificado por:", "", "none", "$po->user_modbyname [$po->user_modbyid]");
          table_row("fa fa-calendar-o", "Modificado el:", "", "none", proc_date4(substr($po->user_moddate,0,10))." - ".substr($po->user_moddate,11,8));
        }
        $process_status  = "<select name=\"in_status\">\n";
        $process_status .= "  <option value=\"\">---</option>\n";
        $sel_status = "select * from USERSTATUS where us_id>0 and us_id<3 order by us_id asc;";
        $get_status = db_query($sel_status);
        while ($ps = $get_status->fetch_object()) {
          if ($ps->us_id == $ps->us_id) {
            $process_status .= "  <option value=\"$ps->us_id\" selected>$ps->us_name</option>\n";
          } else {
            $process_status .= "  <option value=\"$ps->us_id\">$ps->us_name</option>\n";
          }
        }
        $process_status .= "</select>\n";
        table_row("fa fa-chevron-right", "Estado:", "", "none", "$process_status");
        table_row("fa fa-user-circle-o", "Estado por:", "", "none", "$po->user_statusbyname [$po->user_statusbyid]");
      }
      echo "<input name=\"in_upd\" value=\"1\" type=\"hidden\">\n";
      echo "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
      echo "<input name=\"in_doit\" value=\"1\" type=\"hidden\">\n";
      $reset = "<a href=\"$REQUESTURI\"><button type=\"button\" class=\"btn btn-danger\">$l_reset</button></a>";
      $submit = "<button type=\"submit\" class=\"btn btn-success\">Actualizar</button>";
      table_row("", "$reset", "", "none", "$submit");
      echo "  </tbody>\n";
      echo "  </table>\n";
      echo "  <br /><br />\n";
      echo "</div>\n";
      echo "</form>\n";
    }
  } elseif ($in_view == 1) {
    echo "<div class=\"title\"><strong>Informaci&oacute;n de usuario:</strong></div>\n";
    echo "<div class=\"table-responsive-sm\">\n";
    echo "  <table class=\"table table-sm table-hover\">\n";
    echo "  <tbody>\n";
    $so  = "select * from USERS u, USERSTATUS s where ";
    $so .= "binary u.user_status=s.us_id and u.user_id='$in_user' order by user_id limit 1;";
    $qo = db_query($so);
    while ($po=$qo->fetch_object()) {
      table_row("fa fa-info", "ID:", "", "none", "$po->user_id");
      table_row("fa fa-user", "Username:", "", "none", "$po->user_username");
      table_row("fa fa-file-text-o", "Nombre:", "", "none", "$po->user_name");
      table_row("fa fa-id-card", "C&eacute;dula de Identidad:", "", "none", "$po->user_idc");
      table_row("fa fa-calendar", "Fecha de Nacimiento:", "", "none", proc_date4($po->user_dateofbirth));
      table_row("fa fa-envelope-o", "E-Mail:", "", "none", "$po->user_email");
      table_row("fa fa-phone", "Tel&eacute;fono:", "", "none", "$po->user_phonenumber");
      table_row("fa fa-map-pin", "Ciudad:", "", "none", "$po->user_city");
      table_row("fa fa-street-view", "Direcci&oacute;n:", "", "none", "$po->user_address");
      table_row("fa fa-map-marker", "Departamento:", "", "none", "$po->user_department");
      table_row("fa fa-user-circle-o", "Creado por:", "", "none", "$po->user_createdbyname [$po->user_createdbyid]");
      table_row("fa fa-calendar-o", "Creado el:", "", "none", proc_date4(substr($po->user_createddate,0,10))." - ".substr($po->user_createddate,11,8));
      if ($po->user_moddate != "0000-00-00 00:00:00") {
        table_row("fa fa-user-circle-o", "Modificado por:", "", "none", "$po->user_modbyname [$po->user_modbyid]");
        table_row("fa fa-calendar-o", "Modificado el:", "", "none", proc_date4(substr($po->user_moddate,0,10))." - ".substr($po->user_moddate,11,8));
      }
      table_row("fa fa-chevron-right", "Estado:", "", "none", "$po->us_name [$po->us_id]");
      table_row("fa fa-user-circle-o", "Estado por:", "", "none", "$po->user_statusbyname [$po->user_statusbyid]");
      table_row("fa fa-calendar-o", "Estado el:", "", "none", proc_date4(substr($po->user_statusdate,0,10))." - ".substr($po->user_statusdate,11,8));
      table_row("fa fa-info-circle", "En el sistema:", "", "none", "$po->user_login");
      table_row("fa fa-info-circle", "Logueado desde:", "", "none", "$po->user_loginfrom");
      table_row("fa fa-info-circle", "Logueado usando:", "", "none", "$po->user_loginclient");
      table_row("fa fa-info-circle", "Logueado en fecha:", "", "none", proc_date4(substr($po->user_logindatetime,0,10))." - ".substr($po->user_logindatetime,11,8));
      table_row("fa fa-info-circle", "Login expira:", "", "none", proc_date4(substr($po->user_loginexpires,0,10))." - ".substr($po->user_loginexpires,11,8));
      $usermodification  = "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admsysusers\">\n";
      $usermodification .= "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
      $usermodification .= "<input name=\"in_upd\" value=\"1\" type=\"hidden\">\n";
      $usermodification .= "<button type=\"submit\" class=\"btn btn-sm btn-link\"><i class=\"fa fa-times\"></i> Presione ac&aacute; para modificar el usuario</button>\n";
      $usermodification .= "</form>\n";
      table_row("fa fa-user-o", "Modificar usuario:", "", "none", "$usermodification");
    }
    echo "  </tbody>\n";
    echo "  </table>\n";
    echo "  <br /><br />\n";
    echo "</div>\n";
  } else {
    echo "<div class=\"title\"><strong>Usuarios actuales del sistema:</strong></div>\n";
    echo "<div class=\"table-responsive-sm\">\n";
    echo "  <table class=\"table table-sm table-hover\">\n";
    echo "  <theader>\n";
    echo "  <tr class=\"bg-success text-light font-weight-bold\">\n";
    echo "   <td>Usuario</td>\n";
    echo "   <td>Nombre</td>\n";
    echo "   <td>$l_ag_operations</td>\n";
    echo "  </tr>\n";
    echo "  </theader>\n";
    echo "  <tbody>\n";
    $so  = "select * from USERS u, USERSTATUS s where binary u.user_status=s.us_id order by user_id;";
    $qo = db_query($so);
    while ($po=$qo->fetch_object()) {
      echo "  <tr>\n";
      echo "    <td><small>$po->user_username</small></td>\n";
      echo "    <td>$po->user_name</td>\n";
      echo "    <td>\n";
      echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admsysusers\">\n";
      echo "<input name=\"in_user\" value=\"$po->user_id\" type=\"hidden\">\n";
      echo "<input name=\"in_view\" value=\"1\" type=\"hidden\">\n";
      echo "<button type=\"submit\" class=\"btn btn-sm btn-link\"><i class=\"fa fa-eye\"></i></button>\n";
      echo "</form>\n";
      echo "    </td>\n";
      echo "  </tr>\n";
    }
    echo "  </tbody>\n";
    echo "  </table>\n";
    echo "  <form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admsysusers\">\n";
    echo "  <input name=\"in_new\" value=\"1\" type=\"hidden\">\n";
    echo "  <button type=\"submit\" class=\"btn btn-sm btn-link\"><i class=\"fa fa-user-plus\"></i></button>\n";
    echo "  </form>\n";
    echo "  <br /><br />\n";
    echo "</div>\n";
  }
  container_close();
