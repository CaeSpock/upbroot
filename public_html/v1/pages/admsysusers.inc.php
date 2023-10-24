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
  $in_email       = receive_variable("POST", "in_email", "EMAIL", 200);
  $in_phonenumber = receive_variable("POST", "in_phonenumber", "STRING", 200);
  $in_city        = receive_variable("POST", "in_city", "INT", 2);
  $in_address     = receive_variable("POST", "in_address", "STRING", 1000);
  $in_department  = receive_variable("POST", "in_department", "INT", 2);
  $in_status      = receive_variable("POST", "in_status", "INT", 2);
  $in_level       = receive_variable("POST", "in_level", "INT", 3);
  $in_username    = receive_variable("POST", "in_username", "STRING", 32);
  $in_password    = receive_variable("POST", "in_password", "STRING", 100);
  
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
      eval_null("$in_level", "$l_nulllevel");
      echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
      if ($in_confirm == 1) {
        echo "<div class=\"title\"><strong>$l_asu_modification</strong></div>\n";
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
            echo "  </tbody>\n";
            echo "  </table>\n";
            echo "  <br /><br />\n";
            echo "</div>\n";
          } else {
            $logflags  = "";
            table_row("fa fa-info", "$l_asu_id:", "", "none", "$po->user_id");
            $logflags .= "$po->user_id|";
            table_row("fa fa-user", "$l_asu_username:", "", "none", "$po->user_username");
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
            $upd .= "level_id='$in_level', ";
            $logflags .= "$in_name|$in_idc|$in_year-$in_month-$in_day|";
            $logflags .= "$in_email|$in_phonenumber|$in_city|$row_c->city_name|";
            $logflags .= "$in_address|$in_department|$row_d->department_name|$in_level|";
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
            echo "  </tbody>\n";
            echo "  </table>\n";
            echo "  <br /><br />\n";
            echo "</div>\n";
            $doop = db_query($upd);
            oplogs("$po->user_username", "23", "$logflags", "");
            echo "<div class=\"card\">\n";
            echo "  <h5 class=\"card-header\"><i class=\"fa fa-exclamation-circle\"></i> $l_au_important</h5>\n";
            echo "  <div class=\"card-body\">\n";
            echo "    <h5 class=\"card-title\">$l_asu_jobexecuted</h5>\n";
            echo "  </div>\n";
            echo "</div>\n";
          }
        }
      } else {
        echo "<div class=\"title\"><strong>$l_asu_modconfirm</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n";
        echo "  <tbody>\n";
        $so  = "select * from USERS u, USERSTATUS s, USERLEVELS l where ";
        $so .= "binary u.user_status=s.us_id and binary u.level_id=l.level_id and ";
        $so .= "u.user_id='$in_user' order by user_id limit 1;";
        $qo = db_query($so);
        while ($po=$qo->fetch_object()) {
          table_row("fa fa-th-list", "$l_verifyingvars:", "", "none", "$errorgraph");
          if ($error == 1) {
            table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
            echo "<tr><td colspan=\"2\"><center>\n";
            go_back();
            echo "</center></td></tr>\n";
          } else {
            table_row("fa fa-info", "$l_asu_id:", "", "none", "$po->user_id");
            echo "<input type=\"hidden\" name=\"in_user\" value=\"$in_user\">\n";
            table_row("fa fa-user", "$l_asu_username:", "", "none", "$po->user_username");
            $show_name = $in_name;
            if ($po->user_name != $in_name) {
              $show_name .= " <span class=\"small\"><font color=\"#009966\">[$po->user_name]</font></span>";
            }
            table_row("fa fa-file-text-o", "$l_asu_name:", "", "none", "$show_name");
            echo "<input type=\"hidden\" name=\"in_name\" value=\"$in_name\">\n";
            $show_idc = $in_idc;
            if ($po->user_idc != $in_idc) {
              $show_idc .= " <span class=\"small\"><font color=\"#009966\">[$po->user_idc]</font></span>";
            }
            table_row("fa fa-id-card", "$l_asu_idc:", "", "none", "$show_idc");
            echo "<input type=\"hidden\" name=\"in_idc\" value=\"$in_idc\">\n";
            $show_dob = proc_date4("$in_year-$in_month-$in_day");
            if ($show_dob != proc_date4($po->user_dateofbirth)) {
              $show_dob .= " <span class=\"small\"><font color=\"#009966\">[".proc_date4($po->user_dateofbirth)."]</font></span>";
            }
            table_row("fa fa-calendar", "$l_asu_dob:", "", "none", "$show_dob");
            echo "<input type=\"hidden\" name=\"in_year\" value=\"$in_year\">\n";
            echo "<input type=\"hidden\" name=\"in_month\" value=\"$in_month\">\n";
            echo "<input type=\"hidden\" name=\"in_day\" value=\"$in_day\">\n";
            $show_email = $in_email;
            if ($po->user_email != $in_email) {
              $show_email .= " <span class=\"small\"><font color=\"#009966\">[$po->user_email]</font></span>";
            }
            table_row("fa fa-envelope-o", "$l_asu_email:", "", "none", "$show_email");
            echo "<input type=\"hidden\" name=\"in_email\" value=\"$in_email\">\n";
            $show_phonenumber = $in_phonenumber;
            if ($po->user_phonenumber != $in_phonenumber) {
              $show_phonenumber .= " <span class=\"small\"><font color=\"#009966\">[$po->user_phonenumber]</font></span>";
            }
            table_row("fa fa-phone", "$l_asu_phonenumber:", "", "none", "$show_phonenumber");
            echo "<input type=\"hidden\" name=\"in_phonenumber\" value=\"$in_phonenumber\">\n";
            $sel_c = "select * from CITIES where city_id='$in_city' limit 1;";
            $get_c = db_query($sel_c);
            $row_c = $get_c->fetch_object();
            $show_city = $row_c->city_name;
            if ($po->city_id != $in_city) {
              $show_city .= " <span class=\"small\"><font color=\"#009966\">[$po->user_city]</font></span>";
            }
            table_row("fa fa-map-pin", "$l_asu_city:", "", "none", "$show_city");
            echo "<input type=\"hidden\" name=\"in_city\" value=\"$in_city\">\n";
            $show_address = $in_address;
            if ($po->user_address != $in_address) {
              $show_address .= " <span class=\"small\"><font color=\"#009966\">[$po->user_address]</font></span>";
            }
            table_row("fa fa-street-view", "$l_asu_address:", "", "none", "$show_address");
            echo "<input type=\"hidden\" name=\"in_address\" value=\"$in_address\">\n";
            $sel_d = "select * from DEPARTMENTS where department_id='$in_department' limit 1;";
            $get_d = db_query($sel_d);
            $row_d = $get_d->fetch_object();
            $show_department = $row_d->department_name;
            if ($po->department_id != $in_department) {
              $show_department .= " <span class=\"small\"><font color=\"#009966\">[$po->user_department]</font></span>";
            }
            table_row("fa fa-map-marker", "$l_asu_department:", "", "none", "$show_department");
            echo "<input type=\"hidden\" name=\"in_department\" value=\"$in_department\">\n";
            $sel_l = "select * from USERLEVELS where level_id='$in_level' limit 1;";
            $get_l = db_query($sel_l);
            $row_l = $get_l->fetch_object();
            $show_level = $row_l->level_name;
            if ($po->level_id != $in_level) {
              $show_level .= " <span class=\"small\"><font color=\"#009966\">[$po->level_name]</font></span>";
            }
            table_row("fa fa-chevron-up", "$l_asu_level:", "", "none", "$show_level");
            echo "<input type=\"hidden\" name=\"in_level\" value=\"$in_level\">\n";
            $sel_s = "select * from USERSTATUS where us_id='$in_status' limit 1;";
            $get_s = db_query($sel_s);
            $row_s = $get_s->fetch_object();
            $show_status = $row_s->us_name;
            if ($po->us_id != $in_status) {
              $show_status .= " <span class=\"small\"><font color=\"#009966\">[$po->us_name]</font></span>";
            }
            table_row("fa fa-chevron-right", "$l_asu_status:", "", "none", "$show_status");
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
      echo "<div class=\"title\"><strong>$l_asu_moduser</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      echo "  <table class=\"table table-sm table-hover\">\n";
      echo "  <tbody>\n";
      $so  = "select * from USERS u, USERSTATUS s, USERLEVELS l where ";
      $so .= "binary u.user_status=s.us_id and binary u.level_id=l.level_id and ";
      $so .= "u.user_id='$in_user' order by user_id limit 1;";
      $qo = db_query($so);
      while ($po=$qo->fetch_object()) {
        table_row("fa fa-info", "$l_asu_id:", "", "none", "$po->user_id");
        table_row("fa fa-user", "$l_asu_username:", "", "none", "$po->user_username");
        table_row("fa fa-file-text-o", "$l_asu_name:", "in_name", "text", "$po->user_name", "$l_asu_name");
        table_row("fa fa-id-card", "$l_asu_idc:", "in_idc", "text", "$po->user_idc", "$l_asu_idc");
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
        table_row("fa fa-calendar", "$l_asu_dob:", "", "none", "$process_dob");
        table_row("fa fa-envelope-o", "$l_asu_email:", "in_email", "text", "$po->user_email", "$l_asu_email");
        table_row("fa fa-phone", "$l_asu_phonenumber:", "in_phonenumber", "text", "$po->user_phonenumber", "$l_asu_phonenumber");
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
        table_row("fa fa-map-pin", "$l_asu_city:", "", "none", "$process_city");
        table_row("fa fa-street-view", "$l_asu_address:", "in_address", "textarea", "$po->user_address", "$l_asu_address");
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
        table_row("fa fa-map-marker", "$l_asu_department:", "", "none", "$process_department");
        table_row("fa fa-user-circle-o", "Creado por:", "", "none", "$po->user_createdbyname [$po->user_createdbyid]");
        table_row("fa fa-calendar-o", "Creado el:", "", "none", proc_date4(substr($po->user_createddate,0,10))." - ".substr($po->user_createddate,11,8));
        if ($po->user_moddate != "0000-00-00 00:00:00") {
          table_row("fa fa-user-circle-o", "Modificado por:", "", "none", "$po->user_modbyname [$po->user_modbyid]");
          table_row("fa fa-calendar-o", "Modificado el:", "", "none", proc_date4(substr($po->user_moddate,0,10))." - ".substr($po->user_moddate,11,8));
        }
        $process_level  = "<select name=\"in_level\">\n";
        $process_level .= "  <option value=\"\">--</option>\n";
        $sel_levels = "select * from USERLEVELS order by level_id asc;";
        $get_levels = db_query($sel_levels);
        while ($pl = $get_levels->fetch_object()) {
          if ($pl->level_id == $po->level_id) {
            $process_level .= "  <option value=\"$pl->level_id\" selected>$pl->level_name [$pl->level_id]</option>\n";
          } else {
            $process_level .= "  <option value=\"$pl->level_id\">$pl->level_name [$pl->level_id]</option>\n";
          }
        }
        $process_level .= "</select>\n";
        table_row("fa fa-chevron-up", "$l_asu_level:", "", "none", "$process_level");
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
        table_row("fa fa-chevron-right", "$l_asu_status:", "", "none", "$process_status");
        table_row("fa fa-user-circle-o", "$l_asu_statusby:", "", "none", "$po->user_statusbyname [$po->user_statusbyid]");
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
  } elseif ($in_new == 1) {
    if ($in_doit == 1) {
      $error = 0;
      $errortext = "";
      $errorgraph = "";
      $in_username = strtolower($in_username);
      eval_null("$in_username", "$l_nullusername");
      eval_repdb("$in_username", "USERS", "user_username", "", "$l_nullusername");
      eval_null("$in_password", "$l_nullpassword");
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
      eval_null("$in_level", "$l_nulllevel");
      echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
      if ($in_confirm == 1) {
        echo "<div class=\"title\"><strong>$l_asu_addition</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n";
        echo "  <tbody>\n";
        table_row("fa fa-th-list", "$l_verifyingvars:", "", "none", "$errorgraph");
        if ($error == 1) {
          table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
          echo "<tr><td colspan=\"2\"><center>\n";
          go_back();
          echo "</center></td></tr>\n";
        } else {
          table_row("fa fa-user", "$l_asu_username:", "", "none", "$in_username");
          table_row("fa fa-key", "$l_asu_password:", "", "none", "$in_password");
          $show_name = $in_name;
          table_row("fa fa-file-text-o", "$l_asu_name:", "", "none", "$show_name");
          $show_idc = $in_idc;
          table_row("fa fa-id-card", "$l_asu_idc:", "", "none", "$show_idc");
          $show_dob = proc_date4("$in_year-$in_month-$in_day");
          table_row("fa fa-calendar", "$l_asu_dob:", "", "none", "$show_dob");
          $show_email = $in_email;
          table_row("fa fa-envelope-o", "$l_asu_email:", "", "none", "$show_email");
          $show_phonenumber = $in_phonenumber;
          table_row("fa fa-phone", "$l_asu_phonenumber:", "", "none", "$show_phonenumber");
          $sel_c = "select * from CITIES where city_id='$in_city' limit 1;";
          $get_c = db_query($sel_c);
          $row_c = $get_c->fetch_object();
          $show_city = $row_c->city_name;
          table_row("fa fa-map-pin", "$l_asu_city:", "", "none", "$show_city");
          $show_address = $in_address;
          table_row("fa fa-street-view", "$l_asu_address:", "", "none", "$show_address");
          $sel_d = "select * from DEPARTMENTS where department_id='$in_department' limit 1;";
          $get_d = db_query($sel_d);
          $row_d = $get_d->fetch_object();
          $show_department = $row_d->department_name;
          table_row("fa fa-map-marker", "$l_asu_department:", "", "none", "$show_department");
          $sel_l = "select * from USERLEVELS where level_id='$in_level' limit 1;";
          $get_l = db_query($sel_l);
          $row_l = $get_l->fetch_object();
          $show_level = $row_l->level_name;
          table_row("fa fa-chevron-up", "$l_asu_level:", "", "none", "$show_level");
        }
        echo "  </tbody>\n";
        echo "  </table>\n";
        echo "  <br /><br />\n";
        echo "</div>\n";
        $passoptions = [ 'cost' => 12, ];
        $ins_password = password_hash($in_password, PASSWORD_DEFAULT, $passoptions);
        $ins  = "insert into USERS (level_id, city_id, department_id, ";
        $ins .= "user_username, user_password, ";
        $ins .= "user_name, user_idc, user_dateofbirth, user_email, user_phonenumber, ";
        $ins .= "user_city, user_address, user_department, user_createdbyid, ";
        $ins .= "user_createdbyname, user_createdip, user_createddate, user_status, ";
        $ins .= "user_statusbyid, user_statusbyname, user_statusip, user_statusdate) values(";
        $ins .= "'$in_level', '$in_city', '$in_department', ";
        $ins .= "'$in_username', '$ins_password', ";
        $ins .= "'$in_name', '$in_idc', '$in_year-$in_month-$in_day', '$in_email', '$in_phonenumber', ";
        $ins .= "'$row_c->city_name', '$in_address', '$row_d->department_name', '$surc_user', ";
        $ins .= "'$surv_user_name', '$user_ip', '$date $time', '3', ";
        $ins .= "'$surc_user', '$surv_user_name', '$user_ip', '$date $time');";
        $doop = db_query($ins);
        $insert_id=$dblink->insert_id;
        $logflags  = "";
        $logflags .= "$insert_id|$in_level|$in_city|$in_department|$in_username|$in_password|";
        $logflags .= "$in_name|$in_idc|$in_year-$in_month-$in_day|$in_email|$in_phonenumber|";
        $logflags .= "$row_c->city_name|$in_address|$row_d->department_name|$surc_user|";
        $logflags .= "$surv_user_name|$user_ip|$date $time|3|";
//        oplogs("$in_username", "24", "$logflags", "");
        echo "<div class=\"card\">\n";
        echo "  <h5 class=\"card-header\"><i class=\"fa fa-exclamation-circle\"></i> $l_au_important</h5>\n";
        echo "  <div class=\"card-body\">\n";
        echo "    <h5 class=\"card-title\">$l_asu_jobexecuted</h5>\n";
        echo "    <p class=\"card-text\">$l_asu_addid: $insert_id</p>\n";
        echo "  </div>\n";
        echo "</div>\n";
      } else {
        echo "<div class=\"title\"><strong>$l_asu_addconfirm</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n";
        echo "  <tbody>\n";
        table_row("fa fa-th-list", "$l_verifyingvars:", "", "none", "$errorgraph");
        if ($error == 1) {
          table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
          echo "<tr><td colspan=\"2\"><center>\n";
          go_back();
          echo "</center></td></tr>\n";
        } else {
          table_row("fa fa-user", "$l_asu_username:", "", "none", "$in_username");
          echo "<input type=\"hidden\" name=\"in_username\" value=\"$in_username\">\n";
          table_row("fa fa-key", "$l_asu_password:", "", "none", "$in_password");
          echo "<input type=\"hidden\" name=\"in_password\" value=\"$in_password\">\n";
          $show_name = $in_name;
          table_row("fa fa-file-text-o", "$l_asu_name:", "", "none", "$show_name");
          echo "<input type=\"hidden\" name=\"in_name\" value=\"$in_name\">\n";
          $show_idc = $in_idc;
          table_row("fa fa-id-card", "$l_asu_idc:", "", "none", "$show_idc");
          echo "<input type=\"hidden\" name=\"in_idc\" value=\"$in_idc\">\n";
          $show_dob = proc_date4("$in_year-$in_month-$in_day");
          table_row("fa fa-calendar", "$l_asu_dob:", "", "none", "$show_dob");
          echo "<input type=\"hidden\" name=\"in_year\" value=\"$in_year\">\n";
          echo "<input type=\"hidden\" name=\"in_month\" value=\"$in_month\">\n";
          echo "<input type=\"hidden\" name=\"in_day\" value=\"$in_day\">\n";
          $show_email = $in_email;
          table_row("fa fa-envelope-o", "$l_asu_email:", "", "none", "$show_email");
          echo "<input type=\"hidden\" name=\"in_email\" value=\"$in_email\">\n";
          $show_phonenumber = $in_phonenumber;
          table_row("fa fa-phone", "$l_asu_phonenumber:", "", "none", "$show_phonenumber");
          echo "<input type=\"hidden\" name=\"in_phonenumber\" value=\"$in_phonenumber\">\n";
          $sel_c = "select * from CITIES where city_id='$in_city' limit 1;";
          $get_c = db_query($sel_c);
          $row_c = $get_c->fetch_object();
          $show_city = $row_c->city_name;
          table_row("fa fa-map-pin", "$l_asu_city:", "", "none", "$show_city");
          echo "<input type=\"hidden\" name=\"in_city\" value=\"$in_city\">\n";
          $show_address = $in_address;
          table_row("fa fa-street-view", "$l_asu_address:", "", "none", "$show_address");
          echo "<input type=\"hidden\" name=\"in_address\" value=\"$in_address\">\n";
          $sel_d = "select * from DEPARTMENTS where department_id='$in_department' limit 1;";
          $get_d = db_query($sel_d);
          $row_d = $get_d->fetch_object();
          $show_department = $row_d->department_name;
          table_row("fa fa-map-marker", "$l_asu_department:", "", "none", "$show_department");
          echo "<input type=\"hidden\" name=\"in_department\" value=\"$in_department\">\n";
          $sel_l = "select * from USERLEVELS where level_id='$in_level' limit 1;";
          $get_l = db_query($sel_l);
          $row_l = $get_l->fetch_object();
          $show_level = $row_l->level_name;
          table_row("fa fa-chevron-up", "$l_asu_level:", "", "none", "$show_level");
          echo "<input type=\"hidden\" name=\"in_level\" value=\"$in_level\">\n";
          echo "<input name=\"in_new\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"in_doit\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"in_confirm\" value=\"1\" type=\"hidden\">\n";
          $reset = "<a href=\"$REQUESTURI\"><button type=\"button\" class=\"btn btn-danger\">$l_no</button></a>";
          $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_yesconfirm</button>";
          table_row("", "$reset", "", "none", "$submit");
        }
        echo "  </tbody>\n";
        echo "  </table>\n";
        echo "  <br /><br />\n";
        echo "</div>\n";
      }
      echo "</form>";
    } else {
      echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
      echo "<div class=\"title\"><strong>$l_asu_adduser</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      echo "  <table class=\"table table-sm table-hover\">\n";
      echo "  <tbody>\n";
      table_row("fa fa-user", "$l_asu_username:", "in_username", "text", "", "$l_asu_username");
      table_row("", "", "", "none", "<small>$l_asu_addloginwarn</small>", "");
      table_row("fa fa-key", "$l_asu_password:", "in_password", "text", "", "$l_asu_password");
      table_row("", "", "", "none", "<small>$l_asu_passwordwarn</small>", "");
      table_row("fa fa-file-text-o", "$l_asu_name:", "in_name", "text", "", "$l_asu_name");
      table_row("fa fa-id-card", "$l_asu_idc:", "in_idc", "text", "", "$l_asu_idc");
      $process_dob  = "<select name=\"in_day\">\n";
      for ($i = 1; $i <= 31; $i++) {
        $process_dob .= "<option value=\"$i\">$i</option>\n";
      }    
      $process_dob .= "</select> de <select name=\"in_month\">\n";
      for ($i = 1; $i <= 12; $i++) {
        $process_dob .= "<option value=\"$i\">".literalmonth($i)."</option>\n";
      }
      $process_dob .= "</select> de <select name=\"in_year\">\n";
      for ($i = 1940; $i <= date("Y"); $i++) {
        $process_dob .= "<option value=\"$i\">$i</option>\n";
      }
      $process_dob .= "</select>\n";
      table_row("fa fa-calendar", "$l_asu_dob:", "", "none", "$process_dob");
      table_row("fa fa-envelope-o", "$l_asu_email:", "in_email", "text", "", "$l_asu_email");
      table_row("fa fa-phone", "$l_asu_phonenumber:", "in_phonenumber", "text", "", "$l_asu_phonenumber");
      $process_city  = "<select name=\"in_city\">\n";
      $process_city .= "  <option value=\"\">--</option>\n"; 
      $sel_cities = "select * from CITIES order by city_name asc;";
      $get_cities = db_query($sel_cities);
      while ($pc = $get_cities->fetch_object()) {
        $process_city .= "  <option value=\"$pc->city_id\">$pc->city_name</option>\n";
      }
      $process_city .= "</select>\n";
      table_row("fa fa-map-pin", "$l_asu_city:", "", "none", "$process_city");
      table_row("fa fa-street-view", "$l_asu_address:", "in_address", "textarea", "", "$l_asu_address");
      $process_department  = "<select name=\"in_department\">\n";
      $process_department .= "  <option value=\"\">--</option>\n";
      $sel_departments = "select * from DEPARTMENTS order by department_name asc;";
      $get_departments = db_query($sel_departments);
      while ($pd = $get_departments->fetch_object()) {
        $process_department .= "  <option value=\"$pd->department_id\">$pd->department_name</option>\n";
      }
      $process_department .= "</select>\n";
      table_row("fa fa-map-marker", "$l_asu_department:", "", "none", "$process_department");
      $process_level  = "<select name=\"in_level\">\n";
      $process_level .= "  <option value=\"\">--</option>\n";
      $sel_levels = "select * from USERLEVELS where level_id<=$surv_level_id order by level_id asc;";
      $get_levels = db_query($sel_levels);
      while ($pl = $get_levels->fetch_object()) {
        $process_level .= "  <option value=\"$pl->level_id\">$pl->level_name [$pl->level_id]</option>\n";
      }
      $process_level .= "</select>\n";
      table_row("fa fa-chevron-up", "$l_asu_level:", "", "none", "$process_level");
      echo "<input name=\"in_new\" value=\"1\" type=\"hidden\">\n";
      echo "<input name=\"in_doit\" value=\"1\" type=\"hidden\">\n";
      $reset = "<a href=\"$REQUESTURI\"><button type=\"button\" class=\"btn btn-danger\">$l_reset</button></a>";
      $submit = "<button type=\"submit\" class=\"btn btn-success\">Adicionar</button>";
      table_row("", "$reset", "", "none", "$submit");
      echo "  </tbody>\n";
      echo "  </table>\n";
      echo "  <br /><br />\n";
      echo "</div>\n";
      echo "</form>\n";
    }
  } elseif ($in_view == 1) {
    echo "<div class=\"title\"><strong>$l_asu_userinfo</strong></div>\n";
    echo "<div class=\"table-responsive-sm\">\n";
    echo "  <table class=\"table table-sm table-hover\">\n";
    echo "  <tbody>\n";
    $so  = "select * from USERS u, USERSTATUS s, USERLEVELS l where ";
    $so .= "binary u.user_status=s.us_id and binary u.level_id=l.level_id and ";
    $so .= "u.user_id='$in_user' order by user_id limit 1;";
    $qo = db_query($so);
    while ($po=$qo->fetch_object()) {
      table_row("fa fa-info", "$l_asu_id:", "", "none", "$po->user_id");
      table_row("fa fa-user", "$l_asu_username:", "", "none", "$po->user_username");
      table_row("fa fa-file-text-o", "$l_asu_name:", "", "none", "$po->user_name");
      table_row("fa fa-id-card", "$l_asu_idc:", "", "none", "$po->user_idc");
      table_row("fa fa-calendar", "$l_asu_dob:", "", "none", proc_date4($po->user_dateofbirth));
      table_row("fa fa-envelope-o", "$l_asu_email:", "", "none", "$po->user_email");
      table_row("fa fa-phone", "$l_asu_phonenumber:", "", "none", "$po->user_phonenumber");
      table_row("fa fa-map-pin", "$l_asu_city:", "", "none", "$po->user_city");
      table_row("fa fa-street-view", "$l_asu_address:", "", "none", "$po->user_address");
      table_row("fa fa-map-marker", "$l_asu_department:", "", "none", "$po->user_department");
      table_row("fa fa-user-circle-o", "$l_asu_createdon:", "", "none", "$po->user_createdbyname [$po->user_createdbyid]");
      table_row("fa fa-calendar-o", "$l_asu_createdby:", "", "none", proc_date4(substr($po->user_createddate,0,10))." - ".substr($po->user_createddate,11,8));
      if ($po->user_moddate != "0000-00-00 00:00:00") {
        table_row("fa fa-user-circle-o", "$l_asu_modon:", "", "none", "$po->user_modbyname [$po->user_modbyid]");
        table_row("fa fa-calendar-o", "$l_asu_modby:", "", "none", proc_date4(substr($po->user_moddate,0,10))." - ".substr($po->user_moddate,11,8));
      }
      table_row("fa fa-chevron-up", "$l_asu_level:", "", "none", "$po->level_name [$po->level_id]");
      table_row("fa fa-chevron-right", "$l_asu_status:", "", "none", "$po->us_name [$po->us_id]");
      table_row("fa fa-user-circle-o", "$l_asu_statusby:", "", "none", "$po->user_statusbyname [$po->user_statusbyid]");
      table_row("fa fa-calendar-o", "$l_asu_statuson:", "", "none", proc_date4(substr($po->user_statusdate,0,10))." - ".substr($po->user_statusdate,11,8));
      table_row("fa fa-info-circle", "$l_asu_loggedin:", "", "none", "$po->user_login");
      table_row("fa fa-info-circle", "$l_asu_loggedfrom:", "", "none", "$po->user_loginfrom");
      table_row("fa fa-info-circle", "$l_asu_loggedusing:", "", "none", "$po->user_loginclient");
      if ($po->user_logindatetime != "0000-00-00 00:00:00") {
        table_row("fa fa-info-circle", "$l_asu_loggedon:", "", "none", proc_date4(substr($po->user_logindatetime,0,10))." - ".substr($po->user_logindatetime,11,8));
        table_row("fa fa-info-circle", "$l_asu_loginexpires:", "", "none", proc_date4(substr($po->user_loginexpires,0,10))." - ".substr($po->user_loginexpires,11,8));
      }
      $usermodification  = "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admsysusers\">\n";
      $usermodification .= "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
      $usermodification .= "<input name=\"in_upd\" value=\"1\" type=\"hidden\">\n";
      $usermodification .= "<button type=\"submit\" class=\"btn btn-sm btn-link btn-glink\"><i class=\"fa fa-times\"></i> $l_asu_phmodifyuser</button>\n";
      $usermodification .= "</form>\n";
      table_row("fa fa-user-o", "$l_asu_modifyuser:", "", "none", "$usermodification");
    }
    echo "  </tbody>\n";
    echo "  </table>\n";
    echo "  <br /><br />\n";
    echo "</div>\n";
  } else {
    echo "<div class=\"title\"><strong>$l_asu_usersinsystem</strong></div>\n";
    echo "<div class=\"table-responsive-sm\">\n";
    echo "  <table class=\"table table-sm table-hover\">\n";
    echo "  <theader>\n";
    echo "  <tr class=\"bg-success text-light font-weight-bold\">\n";
    echo "   <td>$l_asu_username</td>\n";
    echo "   <td>$l_asu_name</td>\n";
    echo "   <td>$l_asu_level</td>\n";
    echo "   <td>$l_ag_operations</td>\n";
    echo "  </tr>\n";
    echo "  </theader>\n";
    echo "  <tbody>\n";
    $so  = "select * from USERS u, USERSTATUS s, USERLEVELS l where binary u.user_status=s.us_id and binary u.level_id=l.level_id order by user_id;";
    $qo = db_query($so);
    while ($po=$qo->fetch_object()) {
      echo "  <tr>\n";
      echo "    <td><small>$po->user_username</small></td>\n";
      echo "    <td>$po->user_name</td>\n";
      echo "    <td>$po->level_name</td>\n";
      echo "    <td>\n";
      echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admsysusers\">\n";
      echo "<input name=\"in_user\" value=\"$po->user_id\" type=\"hidden\">\n";
      echo "<input name=\"in_view\" value=\"1\" type=\"hidden\">\n";
      echo "<button type=\"submit\" class=\"btn btn-sm btn-link btn-glink\"><i class=\"fa fa-eye\"></i></button>\n";
      echo "</form>\n";
      echo "    </td>\n";
      echo "  </tr>\n";
    }
    echo "  </tbody>\n";
    echo "  </table>\n";
    echo "  <form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admsysusers\">\n";
    echo "  <input name=\"in_new\" value=\"1\" type=\"hidden\">\n";
    echo "  <button type=\"submit\" class=\"btn btn-sm btn-link btn-glink\"><i class=\"fa fa-user-plus\"></i></button>\n";
    echo "  </form>\n";
    echo "  <br /><br />\n";
    echo "</div>\n";
  }
  container_close();
