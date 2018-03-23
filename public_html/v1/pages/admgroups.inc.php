<?php
  ## Admin Groups
  oplogs("$surv_user", "5", "", "");
  container_open("$l_admgroups");
  // Receive variables
  $in_new       = receive_variable("POST", "in_new", "INT", 1);
  $in_view      = receive_variable("POST", "in_view", "INT", 1);
  $in_group     = receive_variable("POST", "in_group", "INT", 5);
  $in_delgroup  = receive_variable("POST", "in_delgroup", "INT", 1);
  $in_confirm   = receive_variable("POST", "in_confirm", "INT", 1);
  $in_doit      = receive_variable("POST", "in_doit", "INT", 5);
  $in_groupname = receive_variable("POST", "in_groupname", "STRING", 15);

  if ($in_new == 1) {
    echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
    if ($in_doit == 1) {
      $error = 0;
      $errortext = "";
      $errorgraph = "";
      eval_null("$in_groupname", "$l_ag_groupname");
      // Lets check if the system already has this group
      $groupname_exists = 0;
      $command = "/usr/bin/cat /etc/group";
      $counter = 0;
      exec($command, $results);
      while ($counter < count($results)) {
        $line = $results[$counter];
        list($ag_groupname,$ag_x,$ag_gid,$ag_groupmembers)=explode(":",$line);
        if ($ag_groupname == $in_groupname) {
          $groupname_exists = 1;
        }
        $counter++;
      }
      unset($results);
      // Comprobaremos si ya existe el login en el sistema
      if ($groupname_exists == 1) {
          $error = 1;
          $errortext .= $l_errorgrouonamexists;
          $errorgraph .= $surp_labelnook;
      } else {
          $errorgraph .= $surp_labelok;
      }
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
          table_row("fa fa-file-text-o", "$l_ag_groupname:", "", "none", "$in_groupname");
        }
        echo "  </table>\n";
        echo "<br /><br />\n";
        echo "</div>\n";
        $ag_createstring = "$in_groupname";
        // Lets create the operation and insert it
        $optxt  = "insert into OPERATIONS (ot_r_date, ot_r_time, ";
        $optxt .= "ot_r_user, ot_r_username, ot_id, ot_d_username, ot_d_flags, ot_d_comment, os_id) values(";
        $optxt .= "'$date', '$time', '$surc_user', '$surv_user', 18, ";
        $optxt .= "'$in_groupname', '$ag_createstring', '', '1');";
        $doop = db_query($optxt);
        $op_id=$dblink->insert_id;
        oplogs("$in_groupname", "18", "$ag_createstring", "", "$op_id");
        echo "<div class=\"card\">\n";
        echo "  <h5 class=\"card-header\"><i class=\"fa fa-exclamation-circle\"></i> $l_au_important</h5>\n";
        echo "  <div class=\"card-body\">\n";
        echo "    <h5 class=\"card-title\">$l_au_taskscheduled</h5>\n";
        echo "    <p class=\"card-text\">$l_au_taskid: $op_id</p>\n";
        echo "  </div>\n";
        echo "</div>\n";
      } else {
        echo "<div class=\"title\"><strong>$l_ag_groupaddconf</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n"; 
        table_row("fa fa-th-list", "$l_verifyingvars:", "", "none", "$errorgraph");
        if ($error == 1) {
          table_row("fa fa-exclamation-triangle", "$l_errorsfound:", "", "none", "$errortext");
          echo "<tr><td colspan=\"2\"><center>\n";
          go_back();
          echo "</center></td></tr>\n";
        } else {
          table_row("fa fa-file-text-o", "$l_ag_groupname:", "", "none", "$in_groupname");
          echo "<input type=\"hidden\" name=\"in_groupname\" value=\"$in_groupname\">\n";
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
      echo "<div class=\"title\"><strong>$l_ag_groupadd</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      echo "  <table class=\"table table-sm table-hover\">\n"; 
      table_row("fa fa-file-text-o", "$l_ag_groupname:", "in_groupname", "text", "", "$l_ag_groupname");
      table_row("", "", "", "none", "<small>(Debe ser &uacute;nico)</small>");
      echo "<input name=\"in_new\" value=\"1\" type=\"hidden\">\n";
      echo "<input name=\"in_doit\" value=\"1\" type=\"hidden\">\n";
      $reset = "<button type=\"reset\" class=\"btn btn-danger\">$l_reset</button>";
      $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_add</button>";
      table_row("", "$reset", "", "none", "$submit");
      echo "  </table>\n";
      echo "</div>\n";
    }
    echo "</form>\n";
  } elseif ($in_delgroup == 1) {
    if ($in_confirm == 1) {
      echo "<div class=\"title\"><strong>$l_au_userremoval</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      // Lets find the group
      $command = "/usr/bin/cat /etc/group";
      $counter = 0;
      exec($command, $results);
      while ($counter < count($results)) {
        $line = $results[$counter];
        list($ag_groupname,$ag_x,$ag_gid, $ag_groupmembers)=explode(":",$line);
        if ($ag_gid>=$surp_ugmin and $ag_gid<$surp_ugmax) {
          if ($ag_gid == $in_group) {
            $agp_groupname = $ag_groupname;
            oplogs("$ag_groupname", "17", "", "$in_group");
            $agp_gid = $ag_gid;
            $agp_groupmembers = $ag_groupmembers;
          }
        }
        $counter++;
      }
      unset($results);
      echo "  <table class=\"table table-sm table-hover\">\n"; 
      table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$agp_gid");
      table_row("fa fa-file-text-o", "$l_ag_groupname:", "", "none", "$agp_groupname");
      table_row("fa fa-users", "$l_ag_groupmembers:", "", "none", "$agp_groupmembers");
      echo "  </table>\n";
      echo "</div>\n";
      // Lets create the operation and insert it
      $optxt  = "insert into OPERATIONS (ot_r_date, ot_r_time, ";
      $optxt .= "ot_r_user, ot_r_username, ot_id, ot_d_username, ot_d_flags, ot_d_comment, os_id) values(";
      $optxt .= "'$date', '$time', '$surc_user', '$surv_user', 19, ";
      $optxt .= "'$agp_groupname', '', '', '1');";
      $doop = db_query($optxt);
      $op_id=$dblink->insert_id;
      oplogs("$agp_groupname", "19", "", "", "$op_id");
      echo "<div class=\"card\">\n";
      echo "  <h5 class=\"card-header\"><i class=\"fa fa-exclamation-circle\"></i> $l_au_important</h5>\n";
      echo "  <div class=\"card-body\">\n";
      echo "    <h5 class=\"card-title\">$l_au_taskscheduled</h5>\n";
      echo "    <p class=\"card-text\">$l_au_taskid: $op_id</p>\n";
      echo "  </div>\n";
      echo "</div>\n";
    } else {
      echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
      echo "<div class=\"title\"><strong>$l_ag_groupremovalconf</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      // Lets find the group
      $command = "/usr/bin/cat /etc/group";
      $counter = 0;
      exec($command, $results);
      while ($counter < count($results)) {
        $line = $results[$counter];
        list($ag_groupname,$ag_x,$ag_gid, $ag_groupmembers)=explode(":",$line);
        if ($ag_gid>=$surp_ugmin and $ag_gid<$surp_ugmax) {
          if ($ag_gid == $in_group) {
            $agp_groupname = $ag_groupname;
            oplogs("$ag_groupname", "17", "", "$in_group");
            $agp_gid = $ag_gid;
            $agp_groupmembers = $ag_groupmembers;
          }
        }
        $counter++;
      }
      unset($results);
      echo "  <table class=\"table table-sm table-hover\">\n"; 
      table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$agp_gid");
      table_row("fa fa-file-text-o", "$l_ag_groupname:", "", "none", "$agp_groupname");
      table_row("fa fa-users", "$l_ag_groupmembers:", "", "none", "$agp_groupmembers");
      echo "<input name=\"in_group\" value=\"$in_group\" type=\"hidden\">\n";
      echo "<input name=\"in_delgroup\" value=\"1\" type=\"hidden\">\n";
      echo "<input name=\"in_confirm\" value=\"1\" type=\"hidden\">\n";
      $reset = "<a href=\"$PHPSELF\"><button type=\"button\" class=\"btn btn-danger\">$l_no</button></a>";
      $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_yesconfirm</button>";
      table_row("", "$reset", "", "none", "$submit");
      echo "  </table>\n";
      echo "</div>\n";
      echo "</form>\n";
    }
  } elseif ($in_view == 1) {
    echo "<div class=\"title\"><strong>$l_ag_viewgroup</strong></div>\n";
    echo "<div class=\"table-responsive-sm\">\n";
    // Lets find the group
    $command = "/usr/bin/cat /etc/group";
    $counter = 0;
    exec($command, $results);
    while ($counter < count($results)) {
      $line = $results[$counter];
      list($ag_groupname,$ag_x,$ag_gid, $ag_groupmembers)=explode(":",$line);
      if ($ag_gid>=$surp_ugmin and $ag_gid<$surp_ugmax) {
        if ($ag_gid == $in_group) {
          $agp_groupname = $ag_groupname;
          oplogs("$ag_groupname", "17", "", "$in_group");
          $agp_gid = $ag_gid;
          $agp_groupmembers = $ag_groupmembers;
        }
      }
      $counter++;
    }
    unset($results);
    echo "  <table class=\"table table-sm table-hover\">\n"; 
    table_row("fa fa-user-circle-o", "$l_au_gid:", "", "none", "$agp_gid");
    table_row("fa fa-file-text-o", "$l_ag_groupname:", "", "none", "$agp_groupname");
    table_row("fa fa-users", "$l_ag_groupmembers:", "", "none", "$agp_groupmembers");
    $groupremoval  = "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admgroups\">\n";
    $groupremoval .= "<input name=\"in_group\" value=\"$in_group\" type=\"hidden\">\n";
    $groupremoval .= "<input name=\"in_delgroup\" value=\"1\" type=\"hidden\">\n";
    $groupremoval .= "<button type=\"submit\" class=\"btn btn-sm btn-link btn-glink\"><i class=\"fa fa-times\"></i> $l_ag_removegroup</button>\n";
    $groupremoval .= "</form>\n";
    table_row("fa fa-times-circle-o", "$l_remove:", "", "none", "$groupremoval");
    echo "  </table>\n";
    echo "</div>\n";
  } else {
    oplogs("", "16", "", "");
    echo "<div class=\"title\"><strong>$l_ag_currentgroups</strong></div>\n";
    echo "<div class=\"table-responsive-sm\">\n";
    echo "  <table class=\"table table-sm table-hover\">\n";
    echo "  <theader>\n";
    echo "  <tr class=\"bg-success text-light font-weight-bold\">\n";
    echo "   <td>$l_au_gid</td>\n";
    echo "   <td>$l_ag_groupname</td>\n";
    echo "   <td>$l_ag_operations</td>\n";
    echo "  </tr>\n";
    echo "  </theader>\n";
    echo "  <tbody>\n";
    $command = "/usr/bin/cat /etc/group";
    $counter = 0;
    exec($command, $results);
    while ($counter < count($results)) {
      $line = $results[$counter];
      list($ag_groupname,$ag_x,$ag_gid, $ag_groupmembers)=explode(":",$line);
      if ($ag_gid>=$surp_ugmin and $ag_gid<$surp_ugmax) { 
        echo "  <tr>\n";
        echo "    <td><small>$ag_gid</small></td>\n";
        echo "    <td>$ag_groupname</td>\n";
        echo "    <td>\n";
        echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admgroups\">\n";
        echo "<input name=\"in_group\" value=\"$ag_gid\" type=\"hidden\">\n";
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
    echo "  <form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admgroups\">\n";
    echo "  <input name=\"in_new\" value=\"1\" type=\"hidden\">\n";
    echo "  <button type=\"submit\" class=\"btn btn-sm btn-link btn-glink\"><i class=\"fa fa-user-plus\"></i></button>\n";
    echo "  </form>\n";
    echo "  <br /><br />\n";
    echo "</div>\n";
  }
  container_close();

