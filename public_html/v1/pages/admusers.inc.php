<?php
  ## ChangeLog
  oplogs("$surv_user", "5", "", "");
  container_open("$l_admusers");
  $in_view = receive_variable("POST", "in_view", "INT", 1);
  $in_user = receive_variable("POST", "in_user", "INT", 5);
  $in_modinfo = receive_variable("POST", "in_modinfo", "INT", 5);
  $in_modgroups = receive_variable("POST", "in_modgroups", "INT", 5);
  $in_doit = receive_variable("POST", "in_doit", "INT", 1);
  $in_info = receive_variable("POST", "in_info", "STRING", 250);

  if ($in_modinfo == 1) {
    echo "<div class=\"title\"><strong>Modificaci&oacute;n de usuario</strong></div>\n";
    echo "<div class=\"table-responsive-sm\">\n";
    // Lets fine the user
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
      echo "  <table class=\"table table-sm table-hover\">\n";
      table_row("fa fa-user-o", "UID:", "", "none", "$aup_uid");
      table_row("fa fa-user-circle-o", "GID:", "", "none", "$aup_gid");
      table_row("fa fa-user", "Username:", "", "none", "$aup_username");
      table_row("fa fa-info", "Info:", "", "none", "$in_info");
      echo "  </table>\n";
      oplogs("$aup_username", "10", "$in_info", "");
      echo "<div class=\"card\">\n";
      echo "  <h5 class=\"card-header\"><i class=\"fa fa-exclamation-circle\"></i> Importante</h5>\n";
      echo "  <div class=\"card-body\">\n";
      echo "    <h5 class=\"card-title\">La tarea ha sido programada</h5>\n";
      echo "    <p class=\"card-text\">Tarea ID: 3232</p>\n";
      echo "  </div>\n";
      echo "</div>\n";
    } else {
      echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
      echo "  <table class=\"table table-sm table-hover\">\n";
      table_row("fa fa-user-o", "UID:", "", "none", "$aup_uid");
      table_row("fa fa-user-circle-o", "GID:", "", "none", "$aup_gid");
      table_row("fa fa-user", "Username:", "", "none", "$aup_username");
      table_row("fa fa-info", "Info:", "in_info", "text", "$aup_info", "Info");
      echo "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
      echo "<input name=\"in_modinfo\" value=\"1\" type=\"hidden\">\n";
      echo "<input name=\"in_doit\" value=\"1\" type=\"hidden\">\n";
      $reset = "<button type=\"reset\" class=\"btn btn-danger\">$l_reset</button>";
      $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_update</button>";
      table_row("", "$reset", "", "none", "$submit");
      echo "  </table>\n";
      echo "<br /><br />\n";
      echo "</form>\n";
    }
    echo "</div>\n";
  } elseif ($in_view == 1) {
    echo "<div class=\"title\"><strong>Informaci&oacute;n de usuario</strong></div>\n";
    echo "<div class=\"table-responsive-sm\">\n";
    // Lets fine the user
    $command = "/usr/bin/cat /etc/passwd";
    $counter = 0;
    exec($command, $results);
    while ($counter < count($results)) {
      $line = $results[$counter];
      list($au_username,$au_x,$au_uid,$au_gid,$au_info, $au_home, $au_shell)=explode(":",$line);
      if ($au_uid>=$surp_ugmin and $au_uid<$surp_ugmax) {
        if ($au_uid == $in_user) {
          $aup_username = $au_username;
          oplogs("$au_username", "9", "", "$in_user");
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
    table_row("fa fa-user-o", "UID:", "", "none", "$aup_uid");
    table_row("fa fa-user-circle-o", "GID:", "", "none", "$aup_gid");
    table_row("fa fa-user", "Username:", "", "none", "$aup_username");
    $moduserinfo  = "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admusers\">\n";
    $moduserinfo .= "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
    $moduserinfo .= "<input name=\"in_modinfo\" value=\"1\" type=\"hidden\">\n";
    $moduserinfo .= "$aup_info <button type=\"submit\" class=\"btn btn-sm btn-link\"><i class=\"fa fa-pencil-square-o\"></i></button>\n";
    $moduserinfo .= "</form>";
    table_row("fa fa-info-circle", "Info:", "", "none", "$moduserinfo");
    table_row("fa fa-home", "Home:", "", "none", "$aup_home");
    $modusershell  = "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admusers\">\n";
    $modusershell .= "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
    $modusershell .= "<input name=\"in_modgroups\" value=\"1\" type=\"hidden\">\n";
    $modusershell .= "$aup_shell ";
    $modusershell .= "<button type=\"submit\" class=\"btn btn-sm btn-link\"><i class=\"fa fa-pencil-square-o\"></i></button>\n";
    $modusershell .= "</form>\n";
    table_row("fa fa-terminal", "Shell:", "", "none", "$modusershell");
    $command = "/usr/bin/id -Gn $aup_username";
    $aup_groups = "";
    exec($command, $results);
    $aup_groups = $results[0];
    unset($results);
    $modusergroups  = "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?action=admusers\">\n";
    $modusergroups .= "<input name=\"in_user\" value=\"$in_user\" type=\"hidden\">\n";
    $modusergroups .= "<input name=\"in_modgroups\" value=\"1\" type=\"hidden\">\n";
    $modusergroups .= "$aup_groups ";
    $modusergroups .= "<button type=\"submit\" class=\"btn btn-sm btn-link\"><i class=\"fa fa-pencil-square-o\"></i></button>\n";
    $modusergroups .= "</form>\n";
    table_row("fa fa-users", "Grupos:", "", "none", "$modusergroups");
    $command = "/usr/bin/sudo /usr/bin/quota -v -u $aup_username";
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
    $moduserquota .= "<button type=\"submit\" class=\"btn btn-sm btn-link\"><i class=\"fa fa-pencil-square-o\"></i></button>\n";
    $moduserquota .= "</form>\n";
    table_row("fa fa-hdd-o", "Quota:", "", "none", "<pre>$aup_quota</pre>$moduserquota");
    echo "  </table>\n";
    echo "</div>\n";
  } else {
    oplogs("", "8", "", "");
    echo "<div class=\"title\"><strong>Usuarios Actuales del Sistema</strong></div>\n";
    echo "<div class=\"table-responsive-sm\">\n";
    echo "  <table class=\"table table-sm table-hover\">\n";
    echo "  <theader>\n";
    echo "  <tr>\n";
    echo "   <td>UID/GID</td>\n";
    echo "   <td>Username</td>\n";
    echo "   <td>Nombre</td>\n";
    echo "   <td>Operaciones</td>\n";
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
        echo "<button type=\"submit\" class=\"btn btn-sm btn-link\"><i class=\"fa fa-eye\"></i></button>\n";
        echo "</form>\n";
        echo "    </td>\n";
        echo "  </tr>\n";
      }
      $counter++;
    }
    unset($results);
    echo "  </tbody>\n";
    echo "  </table>\n";
    echo "<br /><br />\n";
    echo "</div>\n";
  }
  container_close();

