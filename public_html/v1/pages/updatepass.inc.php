<?php
  ## ChangeLog
  oplogs("$surv_user", "5", "", "");
  container_open("$l_updatepass");
  $in_submit = receive_variable("POST", "in_submit", "INT", 1);
  $in_confirm = receive_variable("POST", "in_confirm", "INT", 1);
  $in_currentpass = receive_variable("POST", "in_currentpass", "STRING", 32);
  $in_newpass = receive_variable("POST", "in_newpass", "STRING", 32);
  $in_newpass2 = receive_variable("POST", "in_newpass2", "STRING", 32);

  if ($in_submit == 1) { 
    $error = 0;
    $errortext = "";
    $errorgraph = "";
    eval_null("$in_currentpass", $l_nullpassword);
    eval_null("$in_newpass", $l_nullnewpassword);
    eval_null("$in_newpass2", $l_nullnewpassword2);
    eval_equal("$in_newpass", "$in_newpass2", $l_unmatchedpasswords);
    $sel_userpass = "select * from USERS where user_id='$surc_user' and user_status>='2' limit 1;";
    $get_userpass = db_query($sel_userpass);
    $up=$get_userpass->fetch_object();
    if (!password_verify($in_currentpass, $up->user_password)) {
      $error = 1;
      $errortext .= $l_up_nomatchpass;
      $errorgraph .= $surp_labelnook;
    } else {
      $errorgraph .= $surp_labelok;
    }
    $strengthpassword = testPassword($in_newpass);
    echo "<div class=\"title\"><strong>$l_up_updatingpass</strong></div>\n";
    echo "<div class=\"table-responsive-sm\">\n";
    echo "  <table class=\"table table-sm table-hover\">\n";
    table_row("fa fa-lock", $l_up_qualitypass.":", "", "none", "$strengthpassword/10");
    table_row("fa fa-th-list", $l_verifyingvars.":", "", "none", "$errorgraph");
    if ($error == 1) {
      table_row("fa fa-exclamation-triangle", $l_errorsfound.":", "", "none", "$errortext");
      echo "<tr><td colspan=\"2\">\n";
      go_back();
      echo "</td></tr>\n";
    } else {
      $passoptions = [ 'cost' => 12, ];
      $hash = password_hash($in_newpass, PASSWORD_DEFAULT, $passoptions);
      $p_upd  = "update USERS set user_password='$hash', user_status='2' ";
      $p_upd .= "where user_id='$surc_user' and user_status>='2' limit 1;";
      $q_upd = db_query($p_upd);
      if ($dblink->error == null) {
        $upd_result = $surp_labelok;
      } else {
        $upd_result = $surp_labelnook;
      }
      table_row("fa fa-check-square", $l_up_updatepass.":", "", "none", "$upd_result");
      oplogs("$surv_user", "7", "", "$strengthpassword");
    }
    echo "  </table>\n";
    echo "<br /><br />\n";
    echo "</form>\n";
    echo "</div>\n";
  } else { 
    // Password update
    if ($surv_user_status == 3) {
      echo "<div class=\"alert alert-warning\">\n";
      echo "  $l_up_onlychangepass\n";
      echo "</div>\n";
    }
    echo "<div class=\"title\"><strong>$l_up_pleaseupdate</strong></div>\n";
    echo "<div class=\"table-responsive-sm\">\n";
    echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
    echo "<input name=\"in_submit\" value=\"1\" type=\"hidden\">\n";
    form_line("fa fa-key", "", "in_currentpass", "password", "", $l_up_currentpass);
    form_line("fa fa-key", "", "in_newpass", "password", "", $l_up_newpass);
    form_line("fa fa-key", "", "in_newpass2", "password", "", $l_up_newpass2);
    $reset = "";
    $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_update</button>";
    echo "$reset &nbsp;&nbsp;&nbsp; $submit";
    echo "<br /><br />\n";
    echo "</form>\n";
    echo "</div>\n";
  }
  container_close();

