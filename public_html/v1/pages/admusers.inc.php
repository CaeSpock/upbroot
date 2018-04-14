<?php
  // ## Admin Server Users
  oplogs("$surv_user", "5", "", "");
  container_open("$l_admusers");
  // Receive Variables
  $in_new       = receive_variable("POST", "in_new", "INT", 1);
  $in_view      = receive_variable("POST", "in_view", "INT", 1);
  $in_deluser   = receive_variable("POST", "in_deluser", "INT", 1);
  $in_user      = receive_variable("POST", "in_user", "INT", 5);
  $in_modinfo   = receive_variable("POST", "in_modinfo", "INT", 1);
  $in_modshell  = receive_variable("POST", "in_modshell", "INT", 1);
  $in_modgroups = receive_variable("POST", "in_modgroups", "INT", 1);
  $in_modquota  = receive_variable("POST", "in_modquota", "INT", 1);
  $in_summary   = receive_variable("POST", "in_summary", "INT", 1);
  $in_accpass   = receive_variable("POST", "in_accpass", "INT", 1);
  $in_dbupass   = receive_variable("POST", "in_dbupass", "INT", 1);
  $in_block     = receive_variable("POST", "in_block", "INT", 1);
  $in_unblock   = receive_variable("POST", "in_unblock", "INT", 1);
  $in_doit      = receive_variable("POST", "in_doit", "INT", 1);
  $in_confirm   = receive_variable("POST", "in_confirm", "INT", 1);
  $in_username  = receive_variable("POST", "in_username", "STRING", 250);
  $in_password  = receive_variable("POST", "in_password", "STRING", 32);
  $in_info      = receive_variable("POST", "in_info", "STRING", 250);
  $in_home      = receive_variable("POST", "in_home", "STRING", 250);
  $in_shell     = receive_variable("POST", "in_shell", "STRING", 250);
  $in_quota     = receive_variable("POST", "in_quota", "STRING", 250);
  $in_quotasb   = receive_variable("POST", "in_quotasb", "INT", 15);
  $in_quotahb   = receive_variable("POST", "in_quotahb", "INT", 15);
  $in_quotasi   = receive_variable("POST", "in_quotasi", "INT", 15);
  $in_quotahi   = receive_variable("POST", "in_quotahi", "INT", 15);
  $in_groups    = receive_variable("POST", "in_groups", "STRING", 250);
  
  if ($in_dbupass == 1) {
    echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
    // Lets find the user
    $command = "/usr/bin/cat /etc/passwd";
    $counter = 0;
    exec($command, $results);
    while ($counter < count($results)) {
      $line = $results[$counter];
      list($au_username,$au_x,$au_uid,$au_gid,$au_info, $au_home, $au_shell)=explode(":",$line);
      if ($au_uid>=$surp_ugmin and $au_uid<$surp_ugmax) {
        if ($au_uid == $in_user) {
          $aup_username = $au_username;
          $aup_uid = $au_uid;
          $aup_gid = $au_gid;
          $aup_info = $au_info;
          $aup_home = $au_home;
          $aup_shell = $au_shell;
        }
      }
      $counter++;
    }
    unset($results);
    if ($in_doit == 1) {
      $error = 0;
      $errortext = "";
      $errorgraph = "";
      eval_null("$in_password", "$l_nullpassword");
      if ($in_confirm == 1 ) {
        echo "<div class=\"title\"><strong>Modificaci&oacute;n de la contrase&ntilde;a del acces a la base de datos:</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n";
        if ($error == 1) {
          table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
          echo "<tr><td colspan=\"2\"><center>\n";
          go_back();
          echo "</center></td></tr>\n";
          echo "  </table>\n";
        } else {
          table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
          table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
          table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
          table_row("fa fa-key", "$l_up_newpass:", "", "none", "$in_password");
          echo "  </table>\n";
          // Lets create the operation and insert it
          $optxt  = "insert into OPERATIONS (ot_r_date, ot_r_time, ";
          $optxt .= "ot_r_user, ot_r_username, ot_id, ot_d_username, ot_d_flags, ot_d_comment, os_id) values(";
          $optxt .= "'$date', '$time', '$surc_user', '$surv_user', 31, ";
          $optxt .= "'$aup_username', '$in_password', '', '1');";
          $doop = db_query($optxt);
          $op_id=$dblink->insert_id;
          oplogs("$aup_username", "31", "$in_password", "", "$op_id");
          echo "<div class=\"card\">\n";
          echo "  <h5 class=\"card-header\"><i class=\"fa fa-exclamation-circle\"></i> $l_au_important</h5>\n";
          echo "  <div class=\"card-body\">\n";
          echo "    <h5 class=\"card-title\">$l_au_taskscheduled</h5>\n";
          echo "    <p class=\"card-text\">$l_au_taskid: $op_id</p>\n";
          echo "  </div>\n";
          echo "</div>\n";
        }
      } else {
        echo "<div class=\"title\"><strong>$l_au_usermodconf</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n";
        if ($error == 1) {
          table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
          echo "<tr><td colspan=\"2\"><center>\n";
          go_back();
          echo "</center></td></tr>\n";
          echo "  </table>\n";
        } else {
          table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
          table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
          table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
          table_row("fa fa-key", "$l_up_newpass:", "", "none", "$in_password");
          echo "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
          echo "<input name=\"in_password\" value=\"$in_password\" type=\"hidden\">\n";
          echo "<input name=\"in_dbupass\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"in_doit\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"in_confirm\" value=\"1\" type=\"hidden\">\n";
          $reset = "<a href=\"$REQUESTURI\"><button type=\"button\" class=\"btn btn-danger\">$l_no</button></a>";
          $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_yesconfirm</button>";
          table_row("", "$reset", "", "none", "$submit");
          echo "  </table>\n";
          echo "<br /><br />\n";
        }
        echo "</div>\n";
      }
    } else {
      echo "<div class=\"title\"><strong>Modificaci&oacute;n de la contrase&ntilde;a de acceso a la base de datos:</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      echo "  <table class=\"table table-sm table-hover\">\n";
      table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
      table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
      table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
      table_row("fa fa-key", "$l_password:", "in_password", "text", "", "$l_password");
      echo "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
      echo "<input name=\"in_dbupass\" value=\"1\" type=\"hidden\">\n";
      echo "<input name=\"in_doit\" value=\"1\" type=\"hidden\">\n";
      $reset = "<button type=\"reset\" class=\"btn btn-danger\">$l_reset</button>";
      $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_update</button>";
      table_row("", "$reset", "", "none", "$submit");
      echo "  </table>\n";
      echo "<br /><br />\n";
      echo "</div>\n";
    }
    echo "</form>\n";
  } elseif ($in_accpass == 1) {
    echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
    // Lets find the user
    $command = "/usr/bin/cat /etc/passwd";
    $counter = 0;
    exec($command, $results);
    while ($counter < count($results)) {
      $line = $results[$counter];
      list($au_username,$au_x,$au_uid,$au_gid,$au_info, $au_home, $au_shell)=explode(":",$line);
      if ($au_uid>=$surp_ugmin and $au_uid<$surp_ugmax) {
        if ($au_uid == $in_user) {
          $aup_username = $au_username;
          $aup_uid = $au_uid;
          $aup_gid = $au_gid;
          $aup_info = $au_info;
          $aup_home = $au_home;
          $aup_shell = $au_shell;
        }
      }
      $counter++;
    }
    unset($results);
    if ($in_doit == 1) {
      $error = 0;
      $errortext = "";
      $errorgraph = "";
      eval_null("$in_password", "$l_nullpassword");
      if ($in_confirm == 1 ) {
        echo "<div class=\"title\"><strong>Modificaci&oacute;n de la contrase&ntilde;a del usuario:</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n";
        if ($error == 1) {
          table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
          echo "<tr><td colspan=\"2\"><center>\n";
          go_back();
          echo "</center></td></tr>\n";
          echo "  </table>\n";
        } else {
          table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
          table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
          table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
          table_row("fa fa-key", "$l_up_newpass:", "", "none", "$in_password");
          echo "  </table>\n";
          // Lets create the operation and insert it
          $optxt  = "insert into OPERATIONS (ot_r_date, ot_r_time, ";
          $optxt .= "ot_r_user, ot_r_username, ot_id, ot_d_username, ot_d_flags, ot_d_comment, os_id) values(";
          $optxt .= "'$date', '$time', '$surc_user', '$surv_user', 30, ";
          $optxt .= "'$aup_username', '$in_password', '', '1');";
          $doop = db_query($optxt);
          $op_id=$dblink->insert_id;
          oplogs("$aup_username", "30", "$in_password", "", "$op_id");
          echo "<div class=\"card\">\n";
          echo "  <h5 class=\"card-header\"><i class=\"fa fa-exclamation-circle\"></i> $l_au_important</h5>\n";
          echo "  <div class=\"card-body\">\n";
          echo "    <h5 class=\"card-title\">$l_au_taskscheduled</h5>\n";
          echo "    <p class=\"card-text\">$l_au_taskid: $op_id</p>\n";
          echo "  </div>\n";
          echo "</div>\n";
        }
      } else {
        echo "<div class=\"title\"><strong>$l_au_usermodconf</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n";
        if ($error == 1) {
          table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
          echo "<tr><td colspan=\"2\"><center>\n";
          go_back();
          echo "</center></td></tr>\n";
          echo "  </table>\n";
        } else {
          table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
          table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
          table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
          table_row("fa fa-key", "$l_up_newpass:", "", "none", "$in_password");
          echo "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
          echo "<input name=\"in_password\" value=\"$in_password\" type=\"hidden\">\n";
          echo "<input name=\"in_accpass\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"in_doit\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"in_confirm\" value=\"1\" type=\"hidden\">\n";
          $reset = "<a href=\"$REQUESTURI\"><button type=\"button\" class=\"btn btn-danger\">$l_no</button></a>";
          $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_yesconfirm</button>";
          table_row("", "$reset", "", "none", "$submit");
          echo "  </table>\n";
          echo "<br /><br />\n";
        }
        echo "</div>\n";
      }
    } else {
      echo "<div class=\"title\"><strong>Modificaci&oacute;n de la contrase&ntilde;a del usuario:</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      echo "  <table class=\"table table-sm table-hover\">\n";
      table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
      table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
      table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
      table_row("fa fa-key", "$l_password:", "in_password", "text", "", "$l_password");
      echo "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
      echo "<input name=\"in_accpass\" value=\"1\" type=\"hidden\">\n";
      echo "<input name=\"in_doit\" value=\"1\" type=\"hidden\">\n";
      $reset = "<button type=\"reset\" class=\"btn btn-danger\">$l_reset</button>";
      $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_update</button>";
      table_row("", "$reset", "", "none", "$submit");
      echo "  </table>\n";
      echo "<br /><br />\n";
      echo "</div>\n";
    }
    echo "</form>\n";
  } elseif ($in_summary == 1) {
    echo "<div class=\"title\"><strong>$l_au_summaryv</strong></div>\n";
    echo "<div class=\"table-responsive-sm\">\n";
    // Lets find the user
    $command = "/usr/bin/cat /etc/passwd";
    $counter = 0;
    exec($command, $results);
    while ($counter < count($results)) {
      $line = $results[$counter];
      list($au_username,$au_x,$au_uid,$au_gid,$au_info, $au_home, $au_shell)=explode(":",$line);
      if ($au_uid>=$surp_ugmin and $au_uid<$surp_ugmax) {
        if ($au_uid == $in_user) {
          $aup_username = $au_username;
          $aup_uid = $au_uid;
          $aup_gid = $au_gid;
          $aup_info = $au_info;
          $aup_home = $au_home;
          $aup_shell = $au_shell;
        }
      }
      $counter++;
    }
    unset($results);
    echo "<a id=\"top\"></a>";
    oplogs("$aup_username", "29", "", "", "");
    echo "<ul>\n";
    echo "<li><a href=\"#status\">$l_au_summary_s</a></li>\n";
    echo "<li><a href=\"#home\">$l_au_summary_h</a></li>\n";
    echo "<li><a href=\"#crontab\">$l_au_summary_c</a></li>\n";
    echo "<li><a href=\"#database\">$l_au_summary_d</a></li>\n";
    echo "<li><a href=\"#processes\">$l_au_summary_p</a></li>\n";
    echo "</ul>\n";
    echo "<br />\n";
    echo "<blockquote>\n";
    $filetoopen = $pathtouserdata . "/".$aup_username.".txt";
    if (file_exists($filetoopen)) {
      $openfile = @fopen($filetoopen, "r");
      if ($openfile) {
        while (($fileline = fgets($openfile, 4096)) !== false) {
          echo $fileline;
        }
        if (!feof($openfile)) {
          echo "$l_au_summaryfailed.<br />\n";
        }
        fclose($openfile);
      }
    } else {
      echo "$l_au_summarynoexists<br />\n";
    }
    echo "</blockquote>\n";
    echo "</div>\n";
  } elseif ($in_unblock == 1) {
    if ($in_confirm == 1) {
      echo "<div class=\"title\"><strong>$l_au_unblockuserop</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      // Lets find the user
      $command = "/usr/bin/cat /etc/passwd";
      $counter = 0;
      exec($command, $results);
      while ($counter < count($results)) {
        $line = $results[$counter];
        list($au_username,$au_x,$au_uid,$au_gid,$au_info, $au_home, $au_shell)=explode(":",$line);
        if ($au_uid>=$surp_ugmin and $au_uid<$surp_ugmax) {
          if ($au_uid == $in_user) {
            $aup_username = $au_username;
            $aup_uid = $au_uid;
            $aup_gid = $au_gid;
            $aup_info = $au_info;
            $aup_home = $au_home;
            $aup_shell = $au_shell;
          }
        }
        $counter++;
      }
      unset($results);
      echo "  <table class=\"table table-sm table-hover\">\n"; 
      table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
      table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
      table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
      table_row("fa fa-info-circle", "$l_au_info:", "", "none", "$aup_info");
      table_row("fa fa-home", "$l_au_home:", "", "none", "$aup_home");
      table_row("fa fa-terminal", "$l_au_shell:", "", "none", "$aup_shell");
      $command = "/usr/bin/id -Gn $aup_username";
      $aup_groups = "";
      exec($command, $results);
      $aup_groups = $results[0];
      unset($results);
      table_row("fa fa-users", "$l_au_groups:", "", "none", "$aup_groups");
      $command = "/usr/bin/sudo /usr/bin/quota -vs --show-mntpoint -u $aup_username";
      $aup_quota = "";
      exec($command, $results);
      $counter = 0;
      while ($counter < count($results)) {
        if (!preg_match('/\Disk quotas for user\b/',$results[$counter])) {
          $aup_quota .= $results[$counter]."\n";
        }
        $counter++;
      }
      unset($results);
      table_row("fa fa-hdd-o", "$l_au_quota:", "", "none", "<pre>$aup_quota</pre>");
      echo "  </table>\n";
      echo "</div>\n";
      // Lets create the operation and insert it
      $optxt  = "insert into OPERATIONS (ot_r_date, ot_r_time, ";
      $optxt .= "ot_r_user, ot_r_username, ot_id, ot_d_username, ot_d_flags, ot_d_comment, os_id) values(";
      $optxt .= "'$date', '$time', '$surc_user', '$surv_user', 26, ";
      $optxt .= "'$aup_username', '', '', '1');";
      $doop = db_query($optxt);
      $op_id=$dblink->insert_id;
      oplogs("$aup_username", "26", "", "", "$op_id");
      echo "<div class=\"card\">\n";
      echo "  <h5 class=\"card-header\"><i class=\"fa fa-exclamation-circle\"></i> $l_au_important</h5>\n";
      echo "  <div class=\"card-body\">\n";
      echo "    <h5 class=\"card-title\">$l_au_taskscheduled</h5>\n";
      echo "    <p class=\"card-text\">$l_au_taskid: $op_id</p>\n";
      echo "  </div>\n";
      echo "</div>\n";
    } else {
      echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
      echo "<div class=\"title\"><strong>$l_au_unblockuserconf</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      // Lets find the user
      $command = "/usr/bin/cat /etc/passwd";
      $counter = 0;
      exec($command, $results);
      while ($counter < count($results)) {
        $line = $results[$counter];
        list($au_username,$au_x,$au_uid,$au_gid,$au_info, $au_home, $au_shell)=explode(":",$line);
        if ($au_uid>=$surp_ugmin and $au_uid<$surp_ugmax) {
          if ($au_uid == $in_user) {
            $aup_username = $au_username;
            $aup_uid = $au_uid;
            $aup_gid = $au_gid;
            $aup_info = $au_info;
            $aup_home = $au_home;
            $aup_shell = $au_shell;
          }
        }
        $counter++;
      }
      unset($results);
      echo "  <table class=\"table table-sm table-hover\">\n"; 
      table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
      table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
      table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
      table_row("fa fa-info-circle", "$l_au_info:", "", "none", "$aup_info");
      table_row("fa fa-home", "$l_au_home:", "", "none", "$aup_home");
      table_row("fa fa-terminal", "$l_au_shell:", "", "none", "$aup_shell");
      $command = "/usr/bin/id -Gn $aup_username";
      $aup_groups = "";
      exec($command, $results);
      $aup_groups = $results[0];
      unset($results);
      table_row("fa fa-users", "$l_au_groups:", "", "none", "$aup_groups");
      $command = "/usr/bin/sudo /usr/bin/quota -vs --show-mntpoint -u $aup_username";
      $aup_quota = "";
      exec($command, $results);
      $counter = 0;
      while ($counter < count($results)) {
        if (!preg_match('/\Disk quotas for user\b/',$results[$counter])) {
          $aup_quota .= $results[$counter]."\n";
        }
        $counter++;
      }
      unset($results);
      table_row("fa fa-hdd-o", "$l_au_quota:", "", "none", "<pre>$aup_quota</pre>");
      echo "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
      echo "<input name=\"in_unblock\" value=\"1\" type=\"hidden\">\n";
      echo "<input name=\"in_confirm\" value=\"1\" type=\"hidden\">\n";
      $reset = "<a href=\"$PHPSELF\"><button type=\"button\" class=\"btn btn-danger\">$l_no</button></a>";
      $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_yesconfirm</button>";
      table_row("", "$reset", "", "none", "$submit");
      echo "  </table>\n";
      echo "</div>\n";
      echo "</form>\n";
    }
  } elseif ($in_block == 1) {
    if ($in_confirm == 1) {
      echo "<div class=\"title\"><strong>$l_au_blockuserop</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      // Lets find the user
      $command = "/usr/bin/cat /etc/passwd";
      $counter = 0;
      exec($command, $results);
      while ($counter < count($results)) {
        $line = $results[$counter];
        list($au_username,$au_x,$au_uid,$au_gid,$au_info, $au_home, $au_shell)=explode(":",$line);
        if ($au_uid>=$surp_ugmin and $au_uid<$surp_ugmax) {
          if ($au_uid == $in_user) {
            $aup_username = $au_username;
            $aup_uid = $au_uid;
            $aup_gid = $au_gid;
            $aup_info = $au_info;
            $aup_home = $au_home;
            $aup_shell = $au_shell;
          }
        }
        $counter++;
      }
      unset($results);
      echo "  <table class=\"table table-sm table-hover\">\n"; 
      table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
      table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
      table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
      table_row("fa fa-info-circle", "$l_au_info:", "", "none", "$aup_info");
      table_row("fa fa-home", "$l_au_home:", "", "none", "$aup_home");
      table_row("fa fa-terminal", "$l_au_shell:", "", "none", "$aup_shell");
      $command = "/usr/bin/id -Gn $aup_username";
      $aup_groups = "";
      exec($command, $results);
      $aup_groups = $results[0];
      unset($results);
      table_row("fa fa-users", "$l_au_groups:", "", "none", "$aup_groups");
      $command = "/usr/bin/sudo /usr/bin/quota -vs --show-mntpoint -u $aup_username";
      $aup_quota = "";
      exec($command, $results);
      $counter = 0;
      while ($counter < count($results)) {
        if (!preg_match('/\Disk quotas for user\b/',$results[$counter])) {
          $aup_quota .= $results[$counter]."\n";
        }
        $counter++;
      }
      unset($results);
      table_row("fa fa-hdd-o", "$l_au_quota:", "", "none", "<pre>$aup_quota</pre>");
      echo "  </table>\n";
      echo "</div>\n";
      // Lets create the operation and insert it
      $optxt  = "insert into OPERATIONS (ot_r_date, ot_r_time, ";
      $optxt .= "ot_r_user, ot_r_username, ot_id, ot_d_username, ot_d_flags, ot_d_comment, os_id) values(";
      $optxt .= "'$date', '$time', '$surc_user', '$surv_user', 25, ";
      $optxt .= "'$aup_username', '', '', '1');";
      $doop = db_query($optxt);
      $op_id=$dblink->insert_id;
      oplogs("$aup_username", "25", "", "", "$op_id");
      echo "<div class=\"card\">\n";
      echo "  <h5 class=\"card-header\"><i class=\"fa fa-exclamation-circle\"></i> $l_au_important</h5>\n";
      echo "  <div class=\"card-body\">\n";
      echo "    <h5 class=\"card-title\">$l_au_taskscheduled</h5>\n";
      echo "    <p class=\"card-text\">$l_au_taskid: $op_id</p>\n";
      echo "  </div>\n";
      echo "</div>\n";
    } else {
      echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
      echo "<div class=\"title\"><strong>$l_au_blockuserconf</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      // Lets find the user
      $command = "/usr/bin/cat /etc/passwd";
      $counter = 0;
      exec($command, $results);
      while ($counter < count($results)) {
        $line = $results[$counter];
        list($au_username,$au_x,$au_uid,$au_gid,$au_info, $au_home, $au_shell)=explode(":",$line);
        if ($au_uid>=$surp_ugmin and $au_uid<$surp_ugmax) {
          if ($au_uid == $in_user) {
            $aup_username = $au_username;
            $aup_uid = $au_uid;
            $aup_gid = $au_gid;
            $aup_info = $au_info;
            $aup_home = $au_home;
            $aup_shell = $au_shell;
          }
        }
        $counter++;
      }
      unset($results);
      echo "  <table class=\"table table-sm table-hover\">\n"; 
      table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
      table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
      table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
      table_row("fa fa-info-circle", "$l_au_info:", "", "none", "$aup_info");
      table_row("fa fa-home", "$l_au_home:", "", "none", "$aup_home");
      table_row("fa fa-terminal", "$l_au_shell:", "", "none", "$aup_shell");
      $command = "/usr/bin/id -Gn $aup_username";
      $aup_groups = "";
      exec($command, $results);
      $aup_groups = $results[0];
      unset($results);
      table_row("fa fa-users", "$l_au_groups:", "", "none", "$aup_groups");
      $command = "/usr/bin/sudo /usr/bin/quota -vs --show-mntpoint -u $aup_username";
      $aup_quota = "";
      exec($command, $results);
      $counter = 0;
      while ($counter < count($results)) {
        if (!preg_match('/\Disk quotas for user\b/',$results[$counter])) {
          $aup_quota .= $results[$counter]."\n";
        }
        $counter++;
      }
      unset($results);
      table_row("fa fa-hdd-o", "$l_au_quota:", "", "none", "<pre>$aup_quota</pre>");
      echo "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
      echo "<input name=\"in_block\" value=\"1\" type=\"hidden\">\n";
      echo "<input name=\"in_confirm\" value=\"1\" type=\"hidden\">\n";
      $reset = "<a href=\"$PHPSELF\"><button type=\"button\" class=\"btn btn-danger\">$l_no</button></a>";
      $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_yesconfirm</button>";
      table_row("", "$reset", "", "none", "$submit");
      echo "  </table>\n";
      echo "</div>\n";
      echo "</form>\n";
    }
  } elseif ($in_deluser == 1) {
    if ($in_confirm == 1) {
      echo "<div class=\"title\"><strong>$l_au_userremoval</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      // Lets find the user
      $command = "/usr/bin/cat /etc/passwd";
      $counter = 0;
      exec($command, $results);
      while ($counter < count($results)) {
        $line = $results[$counter];
        list($au_username,$au_x,$au_uid,$au_gid,$au_info, $au_home, $au_shell)=explode(":",$line);
        if ($au_uid>=$surp_ugmin and $au_uid<$surp_ugmax) {
          if ($au_uid == $in_user) {
            $aup_username = $au_username;
            $aup_uid = $au_uid;
            $aup_gid = $au_gid;
            $aup_info = $au_info;
            $aup_home = $au_home;
            $aup_shell = $au_shell;
          }
        }
        $counter++;
      }
      unset($results);
      echo "  <table class=\"table table-sm table-hover\">\n"; 
      table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
      table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
      table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
      table_row("fa fa-info-circle", "$l_au_info:", "", "none", "$aup_info");
      table_row("fa fa-home", "$l_au_home:", "", "none", "$aup_home");
      table_row("fa fa-terminal", "$l_au_shell:", "", "none", "$aup_shell");
      $command = "/usr/bin/id -Gn $aup_username";
      $aup_groups = "";
      exec($command, $results);
      $aup_groups = $results[0];
      unset($results);
      table_row("fa fa-users", "$l_au_groups:", "", "none", "$aup_groups");
      $command = "/usr/bin/sudo /usr/bin/quota -vs --show-mntpoint -u $aup_username";
      $aup_quota = "";
      exec($command, $results);
      $counter = 0;
      while ($counter < count($results)) {
        if (!preg_match('/\Disk quotas for user\b/',$results[$counter])) {
          $aup_quota .= $results[$counter]."\n";
        }
        $counter++;
      }
      unset($results);
      table_row("fa fa-hdd-o", "$l_au_quota:", "", "none", "<pre>$aup_quota</pre>");
      echo "  </table>\n";
      echo "</div>\n";
      // Lets create the operation and insert it
      $optxt  = "insert into OPERATIONS (ot_r_date, ot_r_time, ";
      $optxt .= "ot_r_user, ot_r_username, ot_id, ot_d_username, ot_d_flags, ot_d_comment, os_id) values(";
      $optxt .= "'$date', '$time', '$surc_user', '$surv_user', 15, ";
      $optxt .= "'$aup_username', '', '', '1');";
      $doop = db_query($optxt);
      $op_id=$dblink->insert_id;
      oplogs("$aup_username", "15", "", "", "$op_id");
      echo "<div class=\"card\">\n";
      echo "  <h5 class=\"card-header\"><i class=\"fa fa-exclamation-circle\"></i> $l_au_important</h5>\n";
      echo "  <div class=\"card-body\">\n";
      echo "    <h5 class=\"card-title\">$l_au_taskscheduled</h5>\n";
      echo "    <p class=\"card-text\">$l_au_taskid: $op_id</p>\n";
      echo "  </div>\n";
      echo "</div>\n";
    } else {
      echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
      echo "<div class=\"title\"><strong>$l_au_userremovalconf</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      // Lets find the user
      $command = "/usr/bin/cat /etc/passwd";
      $counter = 0;
      exec($command, $results);
      while ($counter < count($results)) {
        $line = $results[$counter];
        list($au_username,$au_x,$au_uid,$au_gid,$au_info, $au_home, $au_shell)=explode(":",$line);
        if ($au_uid>=$surp_ugmin and $au_uid<$surp_ugmax) {
          if ($au_uid == $in_user) {
            $aup_username = $au_username;
            $aup_uid = $au_uid;
            $aup_gid = $au_gid;
            $aup_info = $au_info;
            $aup_home = $au_home;
            $aup_shell = $au_shell;
          }
        }
        $counter++;
      }
      unset($results);
      echo "  <table class=\"table table-sm table-hover\">\n"; 
      table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
      table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
      table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
      table_row("fa fa-info-circle", "$l_au_info:", "", "none", "$aup_info");
      table_row("fa fa-home", "$l_au_home:", "", "none", "$aup_home");
      table_row("fa fa-terminal", "$l_au_shell:", "", "none", "$aup_shell");
      $command = "/usr/bin/id -Gn $aup_username";
      $aup_groups = "";
      exec($command, $results);
      $aup_groups = $results[0];
      unset($results);
      table_row("fa fa-users", "$l_au_groups:", "", "none", "$aup_groups");
      $command = "/usr/bin/sudo /usr/bin/quota -vs --show-mntpoint -u $aup_username";
      $aup_quota = "";
      exec($command, $results);
      $counter = 0;
      while ($counter < count($results)) {
        if (!preg_match('/\Disk quotas for user\b/',$results[$counter])) {
          $aup_quota .= $results[$counter]."\n";
        }
        $counter++;
      }
      unset($results);
      table_row("fa fa-hdd-o", "$l_au_quota:", "", "none", "<pre>$aup_quota</pre>");
      echo "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
      echo "<input name=\"in_deluser\" value=\"1\" type=\"hidden\">\n";
      echo "<input name=\"in_confirm\" value=\"1\" type=\"hidden\">\n";
      $reset = "<a href=\"$PHPSELF\"><button type=\"button\" class=\"btn btn-danger\">$l_no</button></a>";
      $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_yesconfirm</button>";
      table_row("", "$reset", "", "none", "$submit");
      echo "  </table>\n";
      echo "</div>\n";
      echo "</form>\n";
    }
  } elseif ($in_modquota == 1) {
    echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
    // Lets find the user
    $command = "/usr/bin/cat /etc/passwd";
    $counter = 0;
    exec($command, $results);
    while ($counter < count($results)) {
      $line = $results[$counter];
      list($au_username,$au_x,$au_uid,$au_gid,$au_info, $au_home, $au_shell)=explode(":",$line);
      if ($au_uid>=$surp_ugmin and $au_uid<$surp_ugmax) {
        if ($au_uid == $in_user) {
          $aup_username = $au_username;
          $aup_uid = $au_uid;
          $aup_gid = $au_gid;
          $aup_info = $au_info;
          $aup_home = $au_home;
          $aup_shell = $au_shell;
        }
      }
      $counter++;
    }
    unset($results);
    if ($in_doit == 1) {
      $error = 0;
      $errortext = "";
      $errorgraph = "";
      eval_null($in_quotasb, "$l_nullquotasb");
      eval_null($in_quotahb, "$l_nullquotahb");
      eval_null($in_quotasi, "$l_nullquotasi");
      eval_null($in_quotahi, "$l_nullquotahi");
      if ($in_confirm == 1 ) {
        echo "<div class=\"title\"><strong>$l_au_userquota</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n";
        if ($error == 1) {
          table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
          echo "<tr><td colspan=\"2\"><center>\n";
          go_back();
          echo "</center></td></tr>\n";
          echo "  </table>\n";
        } else {
          table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
          table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
          table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
          table_row("fa fa-hdd-o", "$l_au_quotasb:", "", "none", DownloadSize($in_quotasb));
          table_row("fa fa-hdd-o", "$l_au_quotahb:", "", "none", DownloadSize($in_quotahb));
          table_row("fa fa-hdd-o", "$l_au_quotasi:", "", "none", DownloadSize($in_quotasi));
          table_row("fa fa-hdd-o", "$l_au_quotahi:", "", "none", DownloadSize($in_quotahi));
          echo "  </table>\n";
          $quotastring = "$in_quotasb|$in_quotahb|$in_quotasi|$in_quotahi";
          // Lets create the operation and insert it
          $optxt  = "insert into OPERATIONS (ot_r_date, ot_r_time, ";
          $optxt .= "ot_r_user, ot_r_username, ot_id, ot_d_username, ot_d_flags, ot_d_comment, os_id) values(";
          $optxt .= "'$date', '$time', '$surc_user', '$surv_user', 14, ";
          $optxt .= "'$aup_username', '$quotastring', '', '1');";
          $doop = db_query($optxt);
          $op_id=$dblink->insert_id;
          oplogs("$aup_username", "14", "$quotastring", "", "$op_id");
          echo "<div class=\"card\">\n";
          echo "  <h5 class=\"card-header\"><i class=\"fa fa-exclamation-circle\"></i> $l_au_important</h5>\n";
          echo "  <div class=\"card-body\">\n";
          echo "    <h5 class=\"card-title\">$l_au_taskscheduled</h5>\n";
          echo "    <p class=\"card-text\">$l_au_taskid: $op_id</p>\n";
          echo "  </div>\n";
          echo "</div>\n";
        }
      } else {
        echo "<div class=\"title\"><strong>$l_au_usermodconf</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n";
        if ($error == 1) {
          table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
          echo "<tr><td colspan=\"2\"><center>\n";
          go_back();
          echo "</center></td></tr>\n";
          echo "  </table>\n";
        } else {
          table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
          table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
          table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
          $command = "/usr/bin/sudo /usr/bin/quota -vs --show-mntpoint -u $aup_username";
          $aup_quota = "";
          exec($command, $results);
          $counter = 0;
          while ($counter < count($results)) {
            if (!preg_match('/\Disk quotas for user\b/',$results[$counter])) {
              $aup_quota .= $results[$counter]."\n";
            }
            $counter++;
          }
          unset($results);
          table_row("fa fa-hdd-o", "$l_au_quota:", "", "none", "<pre>$aup_quota</pre>");
          table_row("fa fa-hdd-o", "$l_au_quotasb:", "", "none", DownloadSize($in_quotasb));
          echo "<input name=\"in_quotasb\" value=\"$in_quotasb\" type=\"hidden\">\n";
          table_row("fa fa-hdd-o", "$l_au_quotahb:", "", "none", DownloadSize($in_quotahb));
          echo "<input name=\"in_quotahb\" value=\"$in_quotahb\" type=\"hidden\">\n";
          table_row("fa fa-hdd-o", "$l_au_quotasi:", "", "none", DownloadSize($in_quotasi));
          echo "<input name=\"in_quotasi\" value=\"$in_quotasi\" type=\"hidden\">\n";
          table_row("fa fa-hdd-o", "$l_au_quotahi:", "", "none", DownloadSize($in_quotahi));
          echo "<input name=\"in_quotahi\" value=\"$in_quotahi\" type=\"hidden\">\n";
          echo "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
          echo "<input name=\"in_modquota\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"in_doit\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"in_confirm\" value=\"1\" type=\"hidden\">\n";
          $reset = "<a href=\"$PHPSELF\"><button type=\"button\" class=\"btn btn-danger\">$l_no</button></a>";
          $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_yesconfirm</button>";
          table_row("", "$reset", "", "none", "$submit");
          echo "  </table>\n";
          echo "<br /><br />\n";
        }
        echo "</div>\n";
      }
    } else {
      echo "<div class=\"title\"><strong>$l_au_userquota</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      echo "  <table class=\"table table-sm table-hover\">\n";
      table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
      table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
      table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
      $command = "/usr/bin/sudo /usr/bin/quota -vs --show-mntpoint -u $aup_username";
      $aup_quota = "";
      exec($command, $results);
      $counter = 0;
      while ($counter < count($results)) {
        if (!preg_match('/\Disk quotas for user\b/',$results[$counter])) {
          $aup_quota .= $results[$counter]."\n";
        }
        $counter++;
      }
      unset($results);
      table_row("fa fa-hdd-o", "$l_au_quota:", "", "none", "<pre>$aup_quota</pre>");
      table_row("fa fa-hdd-o", "$l_au_quotabnotice:", "", "none", "1G=1073741824");
      table_row("fa fa-hdd-o", "$l_au_quotasb:", "in_quotasb", "text", "", "$l_au_quotasb");
      table_row("fa fa-hdd-o", "$l_au_quotahb:", "in_quotahb", "text", "", "$l_au_quotahb");
      table_row("fa fa-hdd-o", "$l_au_quotasi:", "in_quotasi", "text", "", "$l_au_quotasi");
      table_row("fa fa-hdd-o", "$l_au_quotahi:", "in_quotahi", "text", "", "$l_au_quotahi");
      echo "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
      echo "<input name=\"in_modquota\" value=\"1\" type=\"hidden\">\n";
      echo "<input name=\"in_doit\" value=\"1\" type=\"hidden\">\n";
      $reset = "<button type=\"reset\" class=\"btn btn-danger\">$l_reset</button>";
      $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_update</button>";
      table_row("", "$reset", "", "none", "$submit");
      echo "  </table>\n";
      echo "<br /><br />\n";
      echo "</div>\n";
    }
    echo "</form>\n";
  } elseif ($in_modgroups == 1) {
    echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
    // Lets find the user
    $command = "/usr/bin/cat /etc/passwd";
    $counter = 0;
    exec($command, $results);
    while ($counter < count($results)) {
      $line = $results[$counter];
      list($au_username,$au_x,$au_uid,$au_gid,$au_info, $au_home, $au_shell)=explode(":",$line);
      if ($au_uid>=$surp_ugmin and $au_uid<$surp_ugmax) {
        if ($au_uid == $in_user) {
          $aup_username = $au_username;
          $aup_uid = $au_uid;
          $aup_gid = $au_gid;
          $aup_info = $au_info;
          $aup_home = $au_home;
          $aup_shell = $au_shell;
        }
      }
      $counter++;
    }
    unset($results);
    if ($in_doit == 1) {
      $error = 0;
      $errortext = "";
      $errorgraph = "";
      eval_null($in_groups, "de los grupos");
      if ($in_confirm == 1 ) {
        echo "<div class=\"title\"><strong>$l_au_groupsmod</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n";
        if ($error == 1) {
          table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
          echo "<tr><td colspan=\"2\"><center>\n";
          go_back();
          echo "</center></td></tr>\n";
          echo "  </table>\n";
        } else {
          table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
          table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
          table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
          $newgroups = "";
          $counter = 0;
          $groupstring = "";
          while ($counter < count($in_groups)) {
            $newgroups .= $in_groups[$counter]."<br />\n";
            $groupstring .= $in_groups[$counter]."|";
            echo "<input type=\"hidden\" name=\"in_groups[]\" value=\"".$in_groups[$counter]."\">\n";
            $counter++;
          }
          table_row("fa fa-users", "$l_au_groups:", "", "none", "$newgroups");
          echo "  </table>\n";
          // Lets create the operation and insert it
          $optxt  = "insert into OPERATIONS (ot_r_date, ot_r_time, ";
          $optxt .= "ot_r_user, ot_r_username, ot_id, ot_d_username, ot_d_flags, ot_d_comment, os_id) values(";
          $optxt .= "'$date', '$time', '$surc_user', '$surv_user', 13, ";
          $optxt .= "'$aup_username', '$groupstring', '', '1');";
          $doop = db_query($optxt);
          $op_id=$dblink->insert_id;
          oplogs("$aup_username", "13", "$groupstring", "", "$op_id");
          echo "<div class=\"card\">\n";
          echo "  <h5 class=\"card-header\"><i class=\"fa fa-exclamation-circle\"></i> $l_au_important</h5>\n";
          echo "  <div class=\"card-body\">\n";
          echo "    <h5 class=\"card-title\">$l_au_taskscheduled</h5>\n";
          echo "    <p class=\"card-text\">$l_au_taskid: $op_id</p>\n";
          echo "  </div>\n";
          echo "</div>\n";
        }
      } else {
        echo "<div class=\"title\"><strong>$l_au_usermodconf</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n";
        if ($error == 1) {
          table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
          echo "<tr><td colspan=\"2\"><center>\n";
          go_back();
          echo "</center></td></tr>\n";
          echo "  </table>\n";
        } else {
          table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
          table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
          table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
          $command = "/usr/bin/id -Gn $aup_username";
          $aup_groups = "";
          exec($command, $results);
          $aup_groups = $results[0];
          unset($results);
          $usergroups = explode(" ", $aup_groups);
          $counter = 0;
          $currentgroups = "";
          while ($counter < count($usergroups)) {
            $currentgroups .= $usergroups[$counter]."<br />";
            $counter++;
          }
          table_row("fa fa-users", "$l_au_groupscurrent:", "", "none", "$currentgroups");
          $newgroups = "";
          $counter = 0;
          while ($counter < count($in_groups)) {
            $newgroups .= $in_groups[$counter]."<br />\n";
            echo "<input type=\"hidden\" name=\"in_groups[]\" value=\"".$in_groups[$counter]."\">\n";
            $counter++;
          }
          table_row("fa fa-users", "$l_au_groupsnew:", "", "none", "$newgroups");
          echo "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
          echo "<input name=\"in_modgroups\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"in_doit\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"in_confirm\" value=\"1\" type=\"hidden\">\n";
          $reset = "<a href=\"$PHPSELF\"><button type=\"button\" class=\"btn btn-danger\">$l_no</button></a>";
          $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_yesconfirm</button>";
          table_row("", "$reset", "", "none", "$submit");
          echo "  </table>\n";
          echo "<br /><br />\n";
        }
        echo "</div>\n";
      }
    } else {
      echo "<div class=\"title\"><strong>$l_au_groupsmod</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      echo "  <table class=\"table table-sm table-hover\">\n";
      table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
      table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
      table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
      $proc_groups  = "";
      $command = "/usr/bin/cat /etc/group | /usr/bin/cut -d\":\" -f1,3";
      $counter = 0;
      exec($command, $results);
      while ($counter < count($results)) {
        $line = $results[$counter];
        list($au_group,$au_gid)=explode(":",$line);
        if ($au_gid>=$surp_ugmin and $au_gid<$surp_ugmax) {
          // For every system group lets see if its in the user configuration
          $command = "/usr/bin/id -Gn $aup_username";
          $au_groups = "";
          exec($command, $usergroups);
          $au_groups = explode(" ", $usergroups[0]);
          unset($usergroups);
          $counter2 = 0;
          $is_checked = "";
          while ($counter2 < count($au_groups)) {
            if ($au_groups[$counter2] == $au_group) {
              $is_checked = " checked";
            }
            $counter2++;
          }
          $proc_groups .= "<input type=\"checkbox\" name=\"in_groups[]\" value=\"$au_group\"$is_checked> $au_group<br />\n";
        }
        $counter++;
      }
      unset($results);
      $proc_groups .= "</select>\n";
      table_row("fa fa-users", "$l_au_groups:", "", "none", "$proc_groups");
      echo "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
      echo "<input name=\"in_modgroups\" value=\"1\" type=\"hidden\">\n";
      echo "<input name=\"in_doit\" value=\"1\" type=\"hidden\">\n";
      $reset = "<button type=\"reset\" class=\"btn btn-danger\">$l_reset</button>";
      $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_update</button>";
      table_row("", "$reset", "", "none", "$submit");
      echo "  </table>\n";
      echo "<br /><br />\n";
      echo "</div>\n";
    }
    echo "</form>\n";
  } elseif ($in_modshell == 1) {
    echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
    // Lets find the user
    $command = "/usr/bin/cat /etc/passwd";
    $counter = 0;
    exec($command, $results);
    while ($counter < count($results)) {
      $line = $results[$counter];
      list($au_username,$au_x,$au_uid,$au_gid,$au_info, $au_home, $au_shell)=explode(":",$line);
      if ($au_uid>=$surp_ugmin and $au_uid<$surp_ugmax) {
        if ($au_uid == $in_user) {
          $aup_username = $au_username;
          $aup_uid = $au_uid;
          $aup_gid = $au_gid;
          $aup_info = $au_info;
          $aup_home = $au_home;
          $aup_shell = $au_shell;
        }
      }
      $counter++;
    }
    unset($results);
    if ($in_doit == 1) {
      $error = 0;
      $errortext = "";
      $errorgraph = "";
      eval_null("$in_shell", "Shell");
      if ($in_confirm == 1 ) {
        echo "<div class=\"title\"><strong>$l_au_shellmod</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n";
        if ($error == 1) {
          table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
          echo "<tr><td colspan=\"2\"><center>\n";
          go_back();
          echo "</center></td></tr>\n";
          echo "  </table>\n";
        } else {
          table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
          table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
          table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
          table_row("fa fa-terminal", "$l_au_shell:", "", "none", "$in_shell");
          echo "  </table>\n";
          // Lets create the operation and insert it
          $optxt  = "insert into OPERATIONS (ot_r_date, ot_r_time, ";
          $optxt .= "ot_r_user, ot_r_username, ot_id, ot_d_username, ot_d_flags, ot_d_comment, os_id) values(";
          $optxt .= "'$date', '$time', '$surc_user', '$surv_user', 12, ";
          $optxt .= "'$aup_username', '$in_shell', '', '1');";
          $doop = db_query($optxt);
          $op_id=$dblink->insert_id;
          oplogs("$aup_username", "12", "$in_shell", "", "$op_id");
          echo "<div class=\"card\">\n";
          echo "  <h5 class=\"card-header\"><i class=\"fa fa-exclamation-circle\"></i> $l_au_important</h5>\n";
          echo "  <div class=\"card-body\">\n";
          echo "    <h5 class=\"card-title\">$l_au_taskscheduled</h5>\n";
          echo "    <p class=\"card-text\">$l_au_taskid: $op_id</p>\n";
          echo "  </div>\n";
          echo "</div>\n";
        }
      } else {
        echo "<div class=\"title\"><strong>$l_au_usermodconf</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n";
        if ($error == 1) {
          table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
          echo "<tr><td colspan=\"2\"><center>\n";
          go_back();
          echo "</center></td></tr>\n";
          echo "  </table>\n";
        } else {
          table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
          table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
          table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
          table_row("fa fa-terminal", "Shell Actual:", "", "none", "$aup_shell");
          table_row("fa fa-terminal", "Nuevo $l_au_shell:", "", "none", "$in_shell");
          echo "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
          echo "<input name=\"in_shell\" value=\"$in_shell\" type=\"hidden\">\n";
          echo "<input name=\"in_modshell\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"in_doit\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"in_confirm\" value=\"1\" type=\"hidden\">\n";
          $reset = "<a href=\"$REQUESTURI\"><button type=\"button\" class=\"btn btn-danger\">$l_no</button></a>";
          $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_yesconfirm</button>";
          table_row("", "$reset", "", "none", "$submit");
          echo "  </table>\n";
          echo "<br /><br />\n";
        }
        echo "</div>\n";
      }
    } else {
      echo "<div class=\"title\"><strong>$l_au_shellmod</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      echo "  <table class=\"table table-sm table-hover\">\n";
      table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
      table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
      table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
      $proc_shell  = "<select name=\"in_shell\">\n";
      $proc_shell .= " <option value=\"\">---</option>\n";
      $command = "/usr/bin/cat /etc/shells";
      $counter = 0;
      exec($command, $results);
      while ($counter < count($results)) {
        $line = $results[$counter];
        if ($line == $aup_shell) {
          $proc_shell .= " <option value=\"$line\" selected>$line</option>\n";
        } else {
          $proc_shell .= " <option value=\"$line\">$line</option>\n";
        }
        $counter++;
      }
      unset($results);
      $proc_shell .= "</select>\n";
      table_row("fa fa-terminal", "$l_au_shell:", "", "none", "$proc_shell");
      echo "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
      echo "<input name=\"in_modshell\" value=\"1\" type=\"hidden\">\n";
      echo "<input name=\"in_doit\" value=\"1\" type=\"hidden\">\n";
      $reset = "<button type=\"reset\" class=\"btn btn-danger\">$l_reset</button>";
      $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_update</button>";
      table_row("", "$reset", "", "none", "$submit");
      echo "  </table>\n";
      echo "<br /><br />\n";
      echo "</div>\n";
    }
    echo "</form>\n";
  } elseif ($in_modinfo == 1) {
    echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
    // Lets find the user
    $command = "/usr/bin/cat /etc/passwd";
    $counter = 0;
    exec($command, $results);
    while ($counter < count($results)) {
      $line = $results[$counter];
      list($au_username,$au_x,$au_uid,$au_gid,$au_info, $au_home, $au_shell)=explode(":",$line);
      if ($au_uid>=$surp_ugmin and $au_uid<$surp_ugmax) {
        if ($au_uid == $in_user) {
          $aup_username = $au_username;
          $aup_uid = $au_uid;
          $aup_gid = $au_gid;
          $aup_info = $au_info;
          $aup_home = $au_home;
          $aup_shell = $au_shell;
        }
      }
      $counter++;
    }
    unset($results);
    if ($in_doit == 1) {
      $error = 0;
      $errortext = "";
      $errorgraph = "";
      eval_null("$in_info", "$l_nullinfo");
      if ($in_confirm == 1 ) {
        echo "<div class=\"title\"><strong>$l_au_infomod</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n";
        if ($error == 1) {
          table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
          echo "<tr><td colspan=\"2\"><center>\n";
          go_back();
          echo "</center></td></tr>\n";
          echo "  </table>\n";
        } else {
          table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
          table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
          table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
          table_row("fa fa-info", "$l_au_info:", "", "none", "$in_info");
          echo "  </table>\n";
          // Lets create the operation and insert it
          $optxt  = "insert into OPERATIONS (ot_r_date, ot_r_time, ";
          $optxt .= "ot_r_user, ot_r_username, ot_id, ot_d_username, ot_d_flags, ot_d_comment, os_id) values(";
          $optxt .= "'$date', '$time', '$surc_user', '$surv_user', 11, ";
          $optxt .= "'$aup_username', '$in_info', '', '1');";
          $doop = db_query($optxt);
          $op_id=$dblink->insert_id;
          oplogs("$aup_username", "11", "$in_info", "", "$op_id");
          echo "<div class=\"card\">\n";
          echo "  <h5 class=\"card-header\"><i class=\"fa fa-exclamation-circle\"></i> $l_au_important</h5>\n";
          echo "  <div class=\"card-body\">\n";
          echo "    <h5 class=\"card-title\">$l_au_taskscheduled</h5>\n";
          echo "    <p class=\"card-text\">$l_au_taskid: $op_id</p>\n";
          echo "  </div>\n";
          echo "</div>\n";
        }
      } else {
        echo "<div class=\"title\"><strong>$l_au_usermodconf</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n";
        if ($error == 1) {
          table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
          echo "<tr><td colspan=\"2\"><center>\n";
          go_back();
          echo "</center></td></tr>\n";
          echo "  </table>\n";
        } else {
          table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
          table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
          table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
          table_row("fa fa-info", "$l_au_infocurrent:", "", "none", "$aup_info");
          table_row("fa fa-info", "$l_au_infonew:", "", "none", "$in_info");
          echo "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
          echo "<input name=\"in_info\" value=\"$in_info\" type=\"hidden\">\n";
          echo "<input name=\"in_modinfo\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"in_doit\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"in_confirm\" value=\"1\" type=\"hidden\">\n";
          $reset = "<a href=\"$REQUESTURI\"><button type=\"button\" class=\"btn btn-danger\">$l_no</button></a>";
          $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_yesconfirm</button>";
          table_row("", "$reset", "", "none", "$submit");
          echo "  </table>\n";
          echo "<br /><br />\n";
        }
        echo "</div>\n";
      }
    } else {
      echo "<div class=\"title\"><strong>$l_au_infomod</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      echo "  <table class=\"table table-sm table-hover\">\n";
      table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
      table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
      table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
      table_row("fa fa-info", "$l_au_info:", "in_info", "text", "$aup_info", "$l_au_info");
      echo "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
      echo "<input name=\"in_modinfo\" value=\"1\" type=\"hidden\">\n";
      echo "<input name=\"in_doit\" value=\"1\" type=\"hidden\">\n";
      $reset = "<button type=\"reset\" class=\"btn btn-danger\">$l_reset</button>";
      $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_update</button>";
      table_row("", "$reset", "", "none", "$submit");
      echo "  </table>\n";
      echo "<br /><br />\n";
      echo "</div>\n";
    }
    echo "</form>\n";
  } elseif ($in_new == 1) {
    echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
    if ($in_doit == 1) {
      $error = 0;
      $errortext = "";
      $errorgraph = "";
      eval_null("$in_username", "$l_au_username");
      $in_username=strtolower($in_username);
      // Lets check if the system already has this user
      $username_exists = 0;
      $command = "/usr/bin/cat /etc/passwd";
      $counter = 0;
      exec($command, $results);
      while ($counter < count($results)) {
        $line = $results[$counter];
        list($au_username,$au_x,$au_uid,$au_gid,$au_info, $au_home, $au_shell)=explode(":",$line);
        if ($au_username == $in_username) {
          $username_exists = 1;
        }
        $counter++;
      }
      unset($results);
      // Comprobaremos si ya existe el login en el sistema
      if ($username_exists == 1) {
          $error = 1;
          $errortext .= $l_errorusernameexists;
          $errorgraph .= $surp_labelnook;
      } else {
          $errorgraph .= $surp_labelok;
      }
      eval_null("$in_password", "$l_nullpassword");
      eval_null("$in_info", "$l_nullinfo");
      // eval_null("$in_home", "$l_nullhome");
      eval_null("$in_shell", "$l_nullshell");
      eval_null("$in_quota", "$l_nullquota");
      if ($in_confirm == 1) {
        echo "<div class=\"title\"><strong>$l_au_useradd</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n"; 
        table_row("fa fa-th-list", "$l_verifyingvars:", "", "none", "$errorgraph");
        if ($error == 1) {
          table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
          echo "<tr><td colspan=\"2\"><center>\n";
          go_back();
          echo "</center></td></tr>\n";
        } else {
          table_row("fa fa-user", "$l_au_username:", "", "none", "$in_username");
          table_row("fa fa-key", "$l_password:", "", "none", "$in_password");
          table_row("fa fa-info-circle", "$l_au_info:", "", "none", "$in_info");
          $homeshow = $in_home;
          if ($in_home == "") { $homeshow = "/home/$in_username"; }
          table_row("fa fa-home", "$l_au_home:", "", "none", "$homeshow");
          table_row("fa fa-terminal", "$l_au_shell:", "", "none", "$in_shell");
          table_row("fa fa-hdd-o", "$l_au_quota:", "", "none", DownloadSize($in_quota));
        }
        echo "  </table>\n";
        echo "<br /><br />\n";
        echo "</div>\n";
        $au_createstring = "$in_username|$in_password|$in_info|$in_home|$in_shell|$in_quota";
        // Lets create the operation and insert it
        $optxt  = "insert into OPERATIONS (ot_r_date, ot_r_time, ";
        $optxt .= "ot_r_user, ot_r_username, ot_id, ot_d_username, ot_d_flags, ot_d_comment, os_id) values(";
        $optxt .= "'$date', '$time', '$surc_user', '$surv_user', 9, ";
        $optxt .= "'$in_username', '$au_createstring', '', '1');";
        $doop = db_query($optxt);
        $op_id=$dblink->insert_id;
        oplogs("$in_username", "9", "$au_createstring", "", "$op_id");
        echo "<div class=\"card\">\n";
        echo "  <h5 class=\"card-header\"><i class=\"fa fa-exclamation-circle\"></i> $l_au_important</h5>\n";
        echo "  <div class=\"card-body\">\n";
        echo "    <h5 class=\"card-title\">$l_au_taskscheduled</h5>\n";
        echo "    <p class=\"card-text\">$l_au_taskid: $op_id</p>\n";
        echo "  </div>\n";
        echo "</div>\n";
      } else {
        echo "<div class=\"title\"><strong>$l_au_useraddconf</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n"; 
        table_row("fa fa-th-list", "$l_verifyingvars:", "", "none", "$errorgraph");
        if ($error == 1) {
          table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
          echo "<tr><td colspan=\"2\"><center>\n";
          go_back();
          echo "</center></td></tr>\n";
        } else {
          table_row("fa fa-user", "$l_au_username:", "", "none", "$in_username");
          echo "<input type=\"hidden\" name=\"in_username\" value=\"$in_username\">\n";
          table_row("fa fa-key", "$l_password:", "", "none", "$in_password");
          echo "<input type=\"hidden\" name=\"in_password\" value=\"$in_password\">\n";
          table_row("fa fa-info-circle", "$l_au_info:", "", "none", "$in_info");
          echo "<input type=\"hidden\" name=\"in_info\" value=\"$in_info\">\n";
          $homeshow = $in_home;
          if ($in_home == "") { $homeshow = "/home/$in_username"; $in_home = "/home/$in_username"; }
          table_row("fa fa-home", "$l_au_home:", "", "none", "$homeshow");
          echo "<input type=\"hidden\" name=\"in_home\" value=\"$in_home\">\n";
          table_row("fa fa-terminal", "$l_au_shell:", "", "none", "$in_shell");
          echo "<input type=\"hidden\" name=\"in_shell\" value=\"$in_shell\">\n";
          table_row("fa fa-hdd-o", "$l_au_quota:", "", "none", DownloadSize($in_quota));
          echo "<input type=\"hidden\" name=\"in_quota\" value=\"$in_quota\">\n";
          echo "<input name=\"in_new\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"in_doit\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"in_confirm\" value=\"1\" type=\"hidden\">\n";
          $reset = "<a href=\"$REQUESTURI\"><button type=\"button\" class=\"btn btn-danger\">$l_no</button></a>";
          $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_yesconfirm</button>";
          table_row("", "$reset", "", "none", "$submit");
        }
        echo "  </table>\n";
        echo "<br /><br />\n";
        echo "</div>\n";
      }
    } else {
      echo "<div class=\"title\"><strong>$l_au_useraddition</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      echo "  <table class=\"table table-sm table-hover\">\n"; 
      table_row("fa fa-user", "$l_au_username:", "in_username", "text", "", "$l_username");
      table_row("", "", "", "none", "<small>$l_au_usernamenotice</small>");
      table_row("fa fa-key", "$l_password:", "in_password", "text", "$surp_defpass", "$l_password");
      table_row("", "", "", "none", "<small>$l_au_passwdnotice</small>");
      table_row("fa fa-info-circle", "$l_au_info:", "in_info", "text", "", "$l_au_info");
      table_row("", "", "", "none", "<small>$l_au_infonotice</small>");
      if ($surp_allowenterhome == 1) {
        table_row("fa fa-home", "$l_au_home:", "in_home", "text", "", "$l_au_home");
        table_row("", "", "", "none", "<small>$l_au_homewarn</small>");
      } else {
        table_row("fa fa-home", "$l_au_home:", "in_home", "none", "<small>$l_au_homewarn2</small>", "$l_au_home");
      }
      $proc_shell  = "<select name=\"in_shell\">\n";
      $proc_shell .= " <option value=\"\">---</option>\n";
      $command = "/usr/bin/cat /etc/shells";
      $counter = 0;
      exec($command, $results);
      while ($counter < count($results)) {
        $line = $results[$counter];
        if ($line == "/bin/bash") {
          $proc_shell .= " <option value=\"$line\" selected>$line</option>\n";
        } else {
          $proc_shell .= " <option value=\"$line\">$line</option>\n";
        }
        $counter++;
      }
      unset($results);
      $proc_shell .= "</select>\n";
      table_row("fa fa-terminal", "$l_au_shell:", "", "none", "$proc_shell");
      $proc_quota  = "<select name=\"in_quota\">\n";
      $proc_quota .= "  <option value=\"\">---</option>\n";
      $proc_quota .= "  <option value=\"0\">Sin Quota</option>\n";
      $proc_quota .= "  <option value=\"536870912\">512 KB</option>\n";
      $proc_quota .= "  <option value=\"1073741824\" selected>  1 GB</option>\n";
      $proc_quota .= "  <option value=\"1610612736\">1.5 GB</option>\n";
      $proc_quota .= "  <option value=\"2147483648\">  2 GB</option>\n";
      $proc_quota .= "</select>\n";
      table_row("fa fa-hdd-o", "$l_au_quota:", "", "none", "$proc_quota");
      echo "<input name=\"in_new\" value=\"1\" type=\"hidden\">\n";
      echo "<input name=\"in_doit\" value=\"1\" type=\"hidden\">\n";
      $reset = "<button type=\"reset\" class=\"btn btn-danger\">$l_reset</button>";
      $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_add</button>";
      table_row("", "$reset", "", "none", "$submit");
      echo "  </table>\n";
      echo "</div>\n";
    }
    echo "</form>\n";
  } elseif ($in_view == 1) {
    echo "<div class=\"title\"><strong>$l_au_viewuser</strong></div>\n";
    echo "<div class=\"table-responsive-sm\">\n";
    // Lets find the user
    $command = "/usr/bin/cat /etc/passwd";
    $counter = 0;
    exec($command, $results);
    while ($counter < count($results)) {
      $line = $results[$counter];
      list($au_username,$au_x,$au_uid,$au_gid,$au_info, $au_home, $au_shell)=explode(":",$line);
      if ($au_uid>=$surp_ugmin and $au_uid<$surp_ugmax) {
        if ($au_uid == $in_user) {
          $aup_username = $au_username;
          oplogs("$au_username", "10", "", "$in_user");
          $aup_uid = $au_uid;
          $aup_gid = $au_gid;
          $aup_info = $au_info;
          $aup_home = $au_home;
          $aup_shell = $au_shell;
        }
      }
      $counter++;
    }
    unset($results);
    echo "  <table class=\"table table-sm table-hover\">\n"; 
    table_row("fa fa-user-o", "$l_au_uid:", "", "none", "$aup_uid");
    table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$aup_gid");
    table_row("fa fa-user", "$l_au_username:", "", "none", "$aup_username");
    $moduserinfo  = "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admusers\">\n";
    $moduserinfo .= "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
    $moduserinfo .= "<input name=\"in_modinfo\" value=\"1\" type=\"hidden\">\n";
    $moduserinfo .= "$aup_info <button type=\"submit\" class=\"btn btn-sm btn-link btn-glink\"><i class=\"fa fa-pencil-square-o\"></i></button>\n";
    $moduserinfo .= "</form>";
    table_row("fa fa-info-circle", "$l_au_info:", "", "none", "$moduserinfo");
    table_row("fa fa-home", "$l_au_home:", "", "none", "$aup_home");
    $modusershell  = "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admusers\">\n";
    $modusershell .= "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
    $modusershell .= "<input name=\"in_modshell\" value=\"1\" type=\"hidden\">\n";
    $modusershell .= "$aup_shell ";
    $modusershell .= "<button type=\"submit\" class=\"btn btn-sm btn-link btn-glink\"><i class=\"fa fa-pencil-square-o\"></i></button>\n";
    $modusershell .= "</form>\n";
    table_row("fa fa-terminal", "$l_au_shell:", "", "none", "$modusershell");
    $command = "/usr/bin/id -Gn $aup_username";
    $aup_groups = "";
    exec($command, $results);
    $aup_groups = $results[0];
    unset($results);
    $modusergroups  = "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admusers\">\n";
    $modusergroups .= "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
    $modusergroups .= "<input name=\"in_modgroups\" value=\"1\" type=\"hidden\">\n";
    $modusergroups .= "$aup_groups ";
    $modusergroups .= "<button type=\"submit\" class=\"btn btn-sm btn-link btn-glink\"><i class=\"fa fa-pencil-square-o\"></i></button>\n";
    $modusergroups .= "</form>\n";
    table_row("fa fa-users", "$l_au_groups:", "", "none", "$modusergroups");
    $command = "/usr/bin/sudo /usr/bin/quota -vs --show-mntpoint -u $aup_username";
    $aup_quota = "";
    exec($command, $results);
    $counter = 0;
    while ($counter < count($results)) {
      if (!preg_match('/\Disk quotas for user\b/',$results[$counter])) {
        $aup_quota .= $results[$counter]."\n";
      }
      $counter++;
    }
    unset($results);
    $moduserquota  = "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admusers\">\n";
    $moduserquota .= "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
    $moduserquota .= "<input name=\"in_modquota\" value=\"1\" type=\"hidden\">\n";
    $moduserquota .= "<button type=\"submit\" class=\"btn btn-sm btn-link btn-glink\"><i class=\"fa fa-pencil-square-o\"></i></button>\n";
    $moduserquota .= "</form>\n";
    table_row("fa fa-hdd-o", "$l_au_quota:", "", "none", "<pre>$aup_quota</pre>$moduserquota");
    $accsummary  = "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admusers\">\n";
    $accsummary .= "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
    $accsummary .= "<input name=\"in_summary\" value=\"1\" type=\"hidden\">\n";
    $accsummary .= "<button type=\"submit\" class=\"btn btn-sm btn-link btn-glink\"><i class=\"fa fa-times-circle-o\"></i> $l_au_summaryv</button>\n";
    $accsummary .= "</form>\n";
    table_row("fa fa-code-o", "$l_au_summary:", "", "none", "$accsummary");
    $accpassword  = "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admusers\">\n";
    $accpassword .= "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
    $accpassword .= "<input name=\"in_accpass\" value=\"1\" type=\"hidden\">\n";
    $accpassword .= "<button type=\"submit\" class=\"btn btn-sm btn-link btn-glink\"><i class=\"fa fa-times-circle-o\"></i> Cambiar contrase&ntilde;a de la cuenta</button>\n";
    $accpassword .= "</form>\n";
    table_row("fa fa-code-o", "$l_password:", "", "none", "$accpassword");
    $dbupassword  = "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admusers\">\n";
    $dbupassword .= "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
    $dbupassword .= "<input name=\"in_dbupass\" value=\"1\" type=\"hidden\">\n";
    $dbupassword .= "<button type=\"submit\" class=\"btn btn-sm btn-link btn-glink\"><i class=\"fa fa-times-circle-o\"></i> Cambiar contrase&ntilde;a de acceso a la base de datos</button>\n";
    $dbupassword .= "</form>\n";
    table_row("fa fa-code-o", "$l_database:", "", "none", "$dbupassword");
    $blockuser  = "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admusers\">\n";
    $blockuser .= "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
    $blockuser .= "<input name=\"in_block\" value=\"1\" type=\"hidden\">\n";
    $blockuser .= "<button type=\"submit\" class=\"btn btn-sm btn-link btn-glink\"><i class=\"fa fa-times-circle-o\"></i> $l_au_blockuser</button>\n";
    $blockuser .= "</form>\n";
    $blockuser .= "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admusers\">\n";
    $blockuser .= "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
    $blockuser .= "<input name=\"in_unblock\" value=\"1\" type=\"hidden\">\n";
    $blockuser .= "<button type=\"submit\" class=\"btn btn-sm btn-link btn-glink\"><i class=\"fa fa-check-circle-o\"></i> $l_au_unblockuser</button>\n";
    $blockuser .= "</form>\n";
    table_row("fa fa-pause-circle-o", "$l_block:", "", "none", "$blockuser");
    $userremoval  = "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admusers\">\n";
    $userremoval .= "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
    $userremoval .= "<input name=\"in_deluser\" value=\"1\" type=\"hidden\">\n";
    $userremoval .= "<button type=\"submit\" class=\"btn btn-sm btn-link btn-glink\"><i class=\"fa fa-times\"></i> $l_au_removeuser</button>\n";
    $userremoval .= "</form>\n";
    table_row("fa fa-user-times", "$l_remove:", "", "none", "$userremoval");
    echo "  </table>\n";
    echo "</div>\n";
  } else {
    oplogs("", "8", "", "");
    echo "<div class=\"title\"><strong>$l_au_userscurrent</strong></div>\n";
    echo "<div class=\"table-responsive-sm\">\n";
    echo "  <table class=\"table table-sm table-hover\">\n";
    echo "  <theader>\n";
    echo "  <tr class=\"bg-success text-light font-weight-bold\">\n";
    echo "   <td>$l_au_uid/$l_au_gid</td>\n";
    echo "   <td>$l_au_username</td>\n";
    echo "   <td>$l_au_name</td>\n";
    echo "   <td>$l_au_operations</td>\n";
    echo "  </tr>\n";
    echo "  </theader>\n";
    echo "  <tbody>\n";
    $command = "/usr/bin/cat /etc/passwd";
    $counter = 0;
    exec($command, $results);
    while ($counter < count($results)) {
      $line = $results[$counter];
      list($au_username,$au_x,$au_uid,$au_gid,$au_info, $au_home, $au_shell)=explode(":",$line);
      if ($au_uid>=$surp_ugmin and $au_uid<$surp_ugmax) { 
        echo "  <tr>\n";
        echo "    <td><small>$au_uid/$au_gid</small></td>\n";
        echo "    <td>$au_username</td>\n";
        echo "    <td>$au_info</td>\n";
        echo "    <td>\n";
        echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admusers\">\n";
        echo "<input name=\"in_user\" value=\"$au_uid\" type=\"hidden\">\n";
        echo "<input name=\"in_view\" value=\"1\" type=\"hidden\">\n";
        echo "<button type=\"submit\" class=\"btn btn-sm btn-link btn-glink\"><i class=\"fa fa-eye\"></i></button>\n";
        echo "</form>\n";
        echo "    </td>\n";
        echo "  </tr>\n";
      }
      $counter++;
    }
    unset($results);
    echo "  </tbody>\n";
    echo "  </table>\n";
    echo "  <form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admusers\">\n";
    echo "  <input name=\"in_new\" value=\"1\" type=\"hidden\">\n";
    echo "  <button type=\"submit\" class=\"btn btn-sm btn-link btn-glink\"><i class=\"fa fa-user-plus\"></i></button>\n";
    echo "  </form>\n";
    echo "  <br /><br />\n";
    echo "</div>\n";
  }
  container_close();

