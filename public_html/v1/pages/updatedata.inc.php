<?php
  ## ChangeLog
  oplogs("$surv_user", "5", "", "");
  container_open("$l_updatedata");
  $in_submit = receive_variable("POST", "in_submit", "INT", 1); 
  $in_confirm = receive_variable("POST", "in_confirm", "INT", 1); 
  $in_name = receive_variable("POST", "in_name", "STRING", 100);
  $in_idc = receive_variable("POST", "in_idc", "STRING", 100);
  $in_day = receive_variable("POST", "in_day", "INT", 2);
  $in_month = receive_variable("POST", "in_month", "INT", 2);
  $in_year = receive_variable("POST", "in_year", "INT", 4);
  $in_email = receive_variable("POST", "in_email", "EMAIL", 100);
  $in_phonenumber = receive_variable("POST", "in_phonenumber", "INT", 100);
  $in_city = receive_variable("POST", "in_city", "INT", 2);
  $in_department = receive_variable("POST", "in_department", "INT", 2);
  $in_address = receive_variable("POST", "in_address", "STRING", 0);

  if ($in_submit == 1) {
    $error = 0;
    $errortext = "";
    $errorgraph = "";
    eval_null("$in_email", "$l_nullmail");
    eval_null("$in_phonenumber", "$l_nullphonenumber");
    eval_null("$in_day", "$l_nullday");
    eval_null("$in_month", "$l_nullmonth");
    eval_null("$in_year", "$l_nullyear");
    eval_null("$in_idc", "$l_nullidc");
    eval_null("$in_address", "$l_nulladdress");
    eval_email("$in_email");
    eval_date("$in_year-$in_month-$in_day");
    eval_repdb("$in_email", "USERS", "user_email", "and user_id<>'$surc_user' and user_status='2'", "$l_repdbmail");

    if ($in_confirm == 1) {
      echo "<div class=\"title\"><strong>$l_ud_updatingdata</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      $quserinfo  = "select * from USERS where user_id='$surc_user' and user_status='2' limit 1;";
      $puserinfo = db_query($quserinfo);
      while ($du = $puserinfo->fetch_object()) {
        echo "  <table class=\"table table-sm table-hover\">\n";
        table_row("fa fa-th-list", "$l_verifyingvars:", "", "none", "$errorgraph");
        if ($error == 1) {
          table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
          echo "<tr><td colspan=\"2\"><center>\n";
          go_back();
          echo "</center></td></tr>\n";
        } else {
          table_row("fa fa-user", "$l_username:", "", "none", "$du->user_username", "");
          table_row("fa fa-user", "$l_name:", "", "none", "$in_name", "$l_name");
          table_row("fa fa-info-circle", "$l_idc:", "", "none", "$in_idc", "$l_idc");
          $process_dob = proc_date($in_year."-".$in_month."-".$in_day);
          table_row("fa fa-calendar", "$l_dob:", "", "none", "$process_dob");
          table_row("fa fa-envelope-o", "$l_email:", "", "none", "$in_email", "$l_email");
          table_row("fa fa-phone", "$l_phonenumber:", "", "none", "$in_phonenumber", "$l_phonenumber");
          $sel_city = "select * from CITIES where city_id='$in_city' limit 1;";
          $get_city = db_query($sel_city);
          $is_city = $get_city->fetch_object();
          $process_city = $is_city->city_name;
          table_row("fa fa-building", "$l_city:", "", "none", "$process_city");
          table_row("fa fa-map-marker", "$l_address:", "", "none", "$in_address", "$l_address");
          $sel_department = "select * from DEPARTMENTS where department_id='$in_department' limit 1;";
          $get_department = db_query($sel_department);
          $is_department = $get_department->fetch_object();
          $process_department = $is_department->department_name;
          table_row("fa fa-location-arrow", "$l_department:", "", "none", "$process_department");
          // Now, lets update the table
          $upd  = "update USERS set user_name='$in_name', user_email='$in_email', ";
          $upd .= "user_phonenumber = '$in_phonenumber', user_dateofbirth='$in_year-$in_month-$in_day', ";
          $upd .= "user_idc='$in_idc', user_address='$in_address', ";
          $upd .= "city_id='$in_city', user_city='$process_city', ";
          $upd .= "department_id='$in_department', user_department='$process_department' ";
          $upd .= "where user_id='$surc_user' and user_status='2' limit 1;";
          $doit = db_query($upd);
          if ($dblink->error == null) {
            $upd_result = $surp_labelok;
          } else {
            $upd_result = $surp_labelnook;
          }
          table_row("fa fa-check-square", "$l_ud_updatedata:", "", "none", "$upd_result");
          oplogs("$surv_user", "6", "", "");
        }
        echo "  </table>\n";
        echo "<br /><br />\n";
      }
      echo "</div>\n";
    } else {
      echo "<div class=\"title\"><strong>$l_ud_pleaseconfirm</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
      $quserinfo  = "select * from USERS where user_id='$surc_user' and user_status='2' limit 1;";
      $puserinfo = db_query($quserinfo);
      while ($du = $puserinfo->fetch_object()) {
        echo "  <table class=\"table table-sm table-hover\">\n";
        table_row("fa fa-th-list", "$l_verifyingvars:", "", "none", "$errorgraph");
        if ($error == 1) {
          table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
          echo "<tr><td colspan=\"2\"><center>\n";
          go_back();
          echo "</center></td></tr>\n";
        } else {
          table_row("fa fa-user", "$l_username:", "", "none", "$du->user_username", "");
          table_row("fa fa-user", "$l_name:", "", "none", "$in_name", "$l_name");
          echo "  <input name=\"in_name\" value=\"$in_name\" type=\"hidden\">\n";
          table_row("fa fa-info-circle", "$l_idc:", "", "none", "$in_idc", "$l_idc");
          echo "  <input name=\"in_idc\" value=\"$in_idc\" type=\"hidden\">\n";
          $process_dob = proc_date($in_year."-".$in_month."-".$in_day);
          table_row("fa fa-calendar", "$l_dob:", "", "none", "$process_dob");
          echo "  <input name=\"in_year\" value=\"$in_year\" type=\"hidden\">\n";
          echo "  <input name=\"in_month\" value=\"$in_month\" type=\"hidden\">\n";
          echo "  <input name=\"in_day\" value=\"$in_day\" type=\"hidden\">\n";
          table_row("fa fa-envelope-o", "$l_email:", "", "none", "$in_email", "$l_email");
          echo "  <input name=\"in_email\" value=\"$in_email\" type=\"hidden\">\n";
          table_row("fa fa-phone", "$l_phonenumber:", "", "none", "$in_phonenumber", "$l_phonenumber");
          echo "  <input name=\"in_phonenumber\" value=\"$in_phonenumber\" type=\"hidden\">\n";
          $sel_city = "select * from CITIES where city_id='$in_city' limit 1;";
          $get_city = db_query($sel_city);
          $is_city = $get_city->fetch_object();
          $process_city = $is_city->city_name;
          table_row("fa fa-building", "$l_city:", "", "none", "$process_city");
          echo "  <input name=\"in_city\" value=\"$in_city\" type=\"hidden\">\n";
          table_row("fa fa-map-marker", "$l_address:", "", "none", "$in_address", "$l_address");
          echo "  <input name=\"in_address\" value=\"$in_address\" type=\"hidden\">\n";
          $sel_department = "select * from DEPARTMENTS where department_id='$in_department' limit 1;";
          $get_department = db_query($sel_department);
          $is_department = $get_department->fetch_object();
          $process_department = $is_department->department_name;
          table_row("fa fa-location-arrow", "$l_department:", "", "none", "$process_department");
          echo "  <input name=\"in_department\" value=\"$in_department\" type=\"hidden\">\n";
          echo "  <input name=\"in_submit\" value=\"1\" type=\"hidden\">\n";
          echo "  <input name=\"in_confirm\" value=\"1\" type=\"hidden\">\n";
        }
        echo "  </table>\n";
        // $reset = "<a href=\"$REQUESTURI\"><button type=\"button\" class=\"btn btn-danger\">$l_no</button></a>";
        $reset = "<a href=\"$PHPSELF\"><button type=\"button\" class=\"btn btn-danger\">$l_no</button></a>";
        $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_yesconfirm</button>";
        if ($error != 1) {
          echo "$reset &nbsp;&nbsp;&nbsp; $submit";
        }
        echo "<br /><br />\n";
      }
      echo "</form>\n";
      echo "</div>\n";
    }
  } else {
    echo "<div class=\"title\"><strong>$l_ud_pleaseupdate</strong></div>\n";
    echo "<div class=\"table-responsive-sm\">\n";
    echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
    $quserinfo  = "select * from USERS where user_id='$surc_user' and user_status='2' limit 1;";
    $puserinfo = db_query($quserinfo);
    while ($du = $puserinfo->fetch_object()) {
      echo "  <table class=\"table table-sm table-hover\">\n";
      table_row("fa fa-user", "$l_username:", "", "none", "$du->user_username", "");
      table_row("fa fa-user", "$l_name:", "in_name", "text", "$du->user_name", "$l_name");
      table_row("fa fa-info-circle", "$l_idc:", "in_idc", "text", "$du->user_idc", "$l_idc");
      $process_dob  = "<select name=\"in_day\">\n";
      for ($i = 1; $i <= 31; $i++) {
        if ($i == substr($du->user_dateofbirth,8,2)) {
          $process_dob .= "<option value=\"$i\" selected>$i</option>\n";
        } else {
          $process_dob .= "<option value=\"$i\">$i</option>\n";
        }
      }    
      $process_dob .= "</select>/<select name=\"in_month\">\n";
      for ($i = 1; $i <= 12; $i++) {
        if ($i == substr($du->user_dateofbirth,5,2)) {
          $process_dob .= "<option value=\"$i\" selected>".literalmonth($i)."</option>\n";
        } else {
          $process_dob .= "<option value=\"$i\">".literalmonth($i)."</option>\n";
        }
      }
      $process_dob .= "</select>/<select name=\"in_year\">\n";
      for ($i = 1960; $i <= date("Y"); $i++) {
        if ($i == substr($du->user_dateofbirth,0,4)) {
          $process_dob .= "<option value=\"$i\" selected>$i</option>\n";
        } else {
          $process_dob .= "<option value=\"$i\">$i</option>\n";
        }
      }
      $process_dob .= "</select>\n";
      table_row("fa fa-calendar", "$l_dob:", "", "none", "$process_dob");
      table_row("fa fa-envelope-o", "$l_email:", "in_email", "text", "$du->user_email", "$l_email");
      table_row("fa fa-phone", "$l_phonenumber:", "in_phonenumber", "text", "$du->user_phonenumber", "$l_phonenumber");
      $process_city  = "<select name=\"in_city\">\n";
      $process_city .= "  <option value=\"\">--</option>\n"; 
      $sel_cities = "select * from CITIES order by city_name asc;";
      $get_cities = db_query($sel_cities);
      while ($pc = $get_cities->fetch_object()) {
        if ($pc->city_id == $du->city_id) {
          $process_city .= "  <option value=\"$pc->city_id\" selected>$pc->city_name</option>\n";
        } else {
          $process_city .= "  <option value=\"$pc->city_id\">$pc->city_name</option>\n";
        }
      }
      $process_city .= "</select>\n";
      table_row("fa fa-building", "$l_city:", "", "none", "$process_city");
      table_row("fa fa-map-marker", "$l_address:", "in_address", "textarea", "$du->user_address", "$l_address");
      $process_department  = "<select name=\"in_department\">\n";
      $process_department .= "  <option value=\"\">--</option>\n";
      $sel_departments = "select * from DEPARTMENTS order by department_name asc;";
      $get_departments = db_query($sel_departments);
      while ($pd = $get_departments->fetch_object()) {
        if ($pd->department_id == $du->department_id) {
          $process_department .= "  <option value=\"$pd->department_id\" selected>$pd->department_name</option>\n";
        } else {
          $process_department .= "  <option value=\"$pd->department_id\">$pd->department_name</option>\n";
        }
      }
      $process_department .= "</select>\n";
      table_row("fa fa-location-arrow", "$l_department:", "", "none", "$process_department");
      echo "  <input name=\"in_submit\" value=\"1\" type=\"hidden\">\n";
      echo "  </table>\n";
      $reset = "<button type=\"reset\" class=\"btn btn-danger\">$l_reset</button>";
      $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_update</button>";
      echo "$reset &nbsp;&nbsp;&nbsp; $submit";
      echo "<br /><br />\n";
    }
    echo "</form>\n";
    echo "</div>\n";
  }
  container_close();

