<?php
  ## ChangeLog
  oplogs("$surv_user", "5", "", "");
  container_open("$l_viewlogs");
  // Receive Variables
  $in_view       = receive_variable("POST", "in_view", "INT", 1);
  $in_opinfo     = receive_variable("POST", "in_opinfo", "INT", 1);
  $in_opdetail   = receive_variable("POST", "in_opdetail", "INT", 1);
  $in_startdate  = receive_variable("POST", "in_startdate", "STRING", 10);
  $in_enddate    = receive_variable("POST", "in_enddate", "STRING", 10);
  $in_fromuser   = receive_variable("POST", "in_fromuser", "STRING", 32);
  $in_opover     = receive_variable("POST", "in_opover", "STRING", 32);
  $in_optype     = receive_variable("POST", "in_optype", "STRING", 32);
  $in_pageNumber = receive_variable("POST", "in_pageNumber", "INT", 3);

  if ($in_view == 1) {
    if ($in_opinfo == 1) {
      if ($in_opdetail == 1){
        // Op Detail
        echo "<div class=\"title\"><strong>$l_vl_opdetail $in_opover</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n";
        echo "  <theader>\n";
        echo "  <tr class=\"bg-success text-light font-weight-bold\">\n";
        echo "    <td>$l_vl_datetime</td>\n";
        echo "    <td>$l_vl_command</td>\n";
        echo "    <td>$l_vl_output</td>\n";
        echo "    <td>$l_vl_returnvar</td>\n";
        echo "  </tr>\n";
        echo "  </theader>\n";
        echo "  <tbody>\n";
        $sl  = "select * from TRANSACTIONLOG where op_id='$in_opover' order by tl_id asc;";
        $ql = db_query($sl);
        oplogs("$surv_user", "22", "$in_opover", "");
        while ($pl = $ql->fetch_object()) {
          echo "  <tr class=\"text-small\">\n";
          echo "   <td>".proc_date5($pl->tl_date)." $pl->tl_time</td>\n";
          echo "   <td>$pl->tl_command</td>";
          echo "   <td>$pl->tl_output</td>";
          echo "   <td>$pl->tl_returnvar</td>";
          echo "  </tr>\n";
        }
        echo "  </tbody>\n";
        echo "  </table>";
        echo "  <br /><br />\n";
        echo "</div>\n";
      } else {
        // Op Info
        echo "<div class=\"title\"><strong>$l_vl_opinfo</strong></div>\n";
        echo "<div class=\"table-responsive-sm\">\n";
        echo "  <table class=\"table table-sm table-hover\">\n";
        table_row("fa fa-cogs", "$l_vl_operation:", "", "none", "$in_opover");
        $so  = "select * from OPERATIONS op, OPERATIONTYPES ot, OPERATIONSTATUS os where ";
        $so .= "op.os_id=os.os_id and op.ot_id=ot.ot_id and op.op_id='$in_opover' limit 1;";
        $qo = db_query($so);
        $po = $qo->fetch_object();
        oplogs("$surv_user", "21", "$in_opover", "");
        table_row("fa fa-calendar", "$l_vl_datetime:", "", "none", proc_date3($po->ot_r_date)." $po->ot_r_time");
        table_row("fa fa-user", "$l_vl_r_user:", "", "none", "$po->ot_r_username [$po->ot_r_user]");
        table_row("fa fa-file-o", "$l_vl_optype:", "", "none", "$po->ot_short");
        table_row("fa fa-user-o", "$l_vl_d_user:", "", "none", "$po->ot_d_username");
        table_row("fa fa-flag", "$l_vl_flags:", "", "none", "$po->ot_d_flags");
        table_row("fa fa-chevron-right", "$l_vl_status:", "", "none", "$po->os_value");
        table_row("fa fa-list", "$l_vl_result:", "", "none", "$po->ot_d_result");
        $vl_viewoplogdetail  = "<form method=\"post\" action=\"".$_SERVER['REQUEST_URI']."\">\n";
        $vl_viewoplogdetail .= "<input name=\"in_opover\" value=\"$in_opover\" type=\"hidden\">\n";
        $vl_viewoplogdetail .= "<input name=\"in_opinfo\" value=\"1\" type=\"hidden\">\n";
        $vl_viewoplogdetail .= "<input name=\"in_opdetail\" value=\"1\" type=\"hidden\">\n";
        $vl_viewoplogdetail .= "<input name=\"in_view\" value=\"1\" type=\"hidden\">\n";
        $vl_viewoplogdetail .= "<button type=\"submit\" class=\"btn btn-sm btn-link\">$l_vl_viewdetail</button>\n";
        $vl_viewoplogdetail .= "</form>";
        table_row("fa fa-info", "", "", "none" , "$vl_viewoplogdetail");
        echo "  </table>";
        echo "  <br /><br />\n";
        echo "</div>\n";
      }
    } else {
      // View logs
      echo "<div class=\"title\"><strong>$l_vl_searchresult</strong></div>\n";
      echo "<div class=\"table-responsive-sm\">\n";
      echo "  <table class=\"table table-sm table-hover\">\n";
      $sl  = "select * from OPLOGS ol, OPERATIONTYPES ot where ol.ot_id=ot.ot_id and ";
      table_row("fa fa-calendar", "$l_vl_daterange:", "", "none", "$in_startdate - $in_enddate");
      $sl .= "(ol.ol_date between '$in_startdate' and '$in_enddate') ";
      $vl_fromuser = $in_fromuser;
      if ($in_fromuser == "ANYUSER") {
        $vl_fromuser = "Cualquier usuario";
      } else {
        $sl .= "and ol.ol_orig_user_id='$in_fromuser' ";
      }
      table_row("fa fa-user-o", "Operaciones hechas por:", "", "none", "$vl_fromuser");
      $vl_opover = $in_opover;
      if ($in_opover == "ANYUSER") {
        $vl_opover = $l_vl_anyuser;
      } elseif ($in_opover == "ANYGROUP") {
        $vl_opover == $l_vl_anygroup;
      } else {
        $sl .= "and ol.ol_dest_username='$in_opover' ";
      }
      table_row("fa fa-user-circle-o", "$l_vl_opover:", "", "none", "$vl_opover");
      $vl_optype = $in_optype;
      if ($in_optype == "ANYTYPE") {
        $vl_optype = "Cualquier tipo";
      } else {
        $sl .= "and ol.ot_id='$in_optype' ";
      }
      $sl .= "and ot.ot_showinlogs='1' ";
      table_row("fa fa-cogs", "$l_vl_optypef:", "", "none", "$vl_optype");
      echo "  </table>\n";
      $ql = db_query($sl);
      $total = $ql->num_rows;
      if ($in_pageNumber == "") { $in_pageNumber = 1; }
      $y = 1;
      $num = 0;
      echo "<table class=\"table-responsive table-sm table-condensed\">\n";
      echo " <tr>\n";
      echo "  <td>$l_vl_shresults:</td>\n";
      while ($total >= $y ) {
        $num = ($y-1) + $surp_perPage;
        if ($num > $total ) {
          $num = $total;
        }
        if ( $y == $in_pageNumber ) {
          if ($y == $num) {
            echo "<td>[$y]</td>\n";
          } else {
            echo "<td>[$y-$num]</td>\n";
          }
        } else {
          echo "<td>";
          echo "<form method=\"post\" action=\"".$_SERVER['REQUEST_URI']."\">\n";
          echo "<input name=\"in_pageNumber\" value=\"$y\" type=\"hidden\">\n";
          echo "<input name=\"in_startdate\" value=\"$in_startdate\" type=\"hidden\">\n";
          echo "<input name=\"in_enddate\" value=\"$in_enddate\" type=\"hidden\">\n";
          echo "<input name=\"in_fromuser\" value=\"$in_fromuser\" type=\"hidden\">\n";
          echo "<input name=\"in_opover\" value=\"$in_opover\" type=\"hidden\">\n";
          echo "<input name=\"in_optype\" value=\"$in_optype\" type=\"hidden\">\n";
          echo "<input name=\"in_view\" value=\"1\" type=\"hidden\">\n";
          echo "<button type=\"submit\" class=\"btn btn-sm btn-link\">$y-$num</button>\n";
          echo "</form>";
          echo "</td>";
        }
        $y = $y + $surp_perPage;
      }
      echo " </tr>\n";
      echo "</table>\n";
      $startpage = $in_pageNumber-1;
      $sl .= "limit $startpage, $surp_perPage;";
      $ql = db_query($sl);
      oplogs("$surv_user", "20", "$in_startdate|$in_enddate|$in_fromuser|$in_opover|$in_optype|$in_pageNumber|$total", "");
      echo "  <table class=\"table table-sm table-hover\">\n";
      echo "  <theader>\n";
      echo "  <tr class=\"bg-success text-light font-weight-bold\">\n";
      echo "    <td>$l_vl_id</td>\n";
      echo "    <td>$l_vl_datetime</td>\n";
      echo "    <td>$l_vl_optype</td>\n";
      echo "    <td>$l_vl_opby</td>\n";
      echo "    <td>$l_vl_opovers</td>\n";
      echo "    <td>$l_vl_opid</td>\n";
      echo "  </tr>\n";
      echo "  </theader>\n";
      echo "  <tbody>\n";
      while ($pl = $ql->fetch_object()) {
        echo "  <tr class=\"text-small\">\n";
        echo "    <td class=\"text-sm\">$pl->ol_id</td>\n";
        echo "    <td class=\"text-small\">".proc_date5($pl->ol_date)." $pl->ol_time</td>\n";
        echo "    <td>$pl->ot_short</td>\n";
        echo "    <td>$pl->ol_orig_user</td>\n";
        $vl_ol_dest_username = $pl->ol_dest_username;
        if ($pl->ot_id == 1 || $pl->ot_id == 2 || $pl->ot_id == 3 || $pl->ot_id == 4 || $pl->ot_id == 5) {
          $vl_ol_dest_username = "";
        }
        echo "    <td>$vl_ol_dest_username</td>\n";
        $vl_op_id=$pl->op_id;
        if ($pl->op_id==0) {
          echo "    <td>-</td>";
        } else {
          echo "    <td>";
          echo "<form method=\"post\" action=\"".$_SERVER['REQUEST_URI']."\">\n";
          echo "<input name=\"in_view\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"in_opinfo\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"in_opover\" value=\"$vl_op_id\" type=\"hidden\">\n";
          echo "<button type=\"submit\" class=\"btn btn-sm btn-link\">$vl_op_id</button>\n";
          echo "</form>";
          echo "</td>\n";
        }
        echo "  </tr>\n";
      }
      echo "  </tbody>\n";
      echo "  </table>";
      echo "  <br /><br />\n";
      echo "</div>\n";
    }
  } else {
    include_once("$pathinc/javadate.inc.php");
    echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['REQUEST_URI']."\" autocomplete=\"off\">\n";
    echo "<div class=\"title\"><strong>$l_vl_detailsearch</strong></div>\n";
    echo "<div class=\"table-responsive-sm\">\n";
    echo "  <table class=\"table table-sm table-hover\">\n";
    $fecha1 = date("Y-m-01", strtotime("Today"));
    $fecha2 = date("Y-m-d", strtotime("Today"));
    $vl_daterange  = "";
    $vl_daterange .= "<input type=\"text\" name=\"in_startdate\" size=\"10\" value=\"$fecha1\"> <input name=\"b1\" type=\"button\" value=\"...\" onClick=\"javascript:pedirFecha(in_startdate,'Fecha de Inicio');\">";
    $vl_daterange .= " - ";
    $vl_daterange .= "<input type=\"text\" name=\"in_enddate\" size=\"10\" value=\"$fecha2\"> <input name=\"b1\" type=\"button\" value=\"...\" onClick=\"javascript:pedirFecha(in_enddate,'Fecha de Final');\">";
    table_row("fa fa-calendar", "$l_vl_daterange:", "", "none", "$vl_daterange");
    $vl_fromuser  = "<select name=\"in_fromuser\">\n";
    $vl_fromuser .= "  <option value=\"\">---</option>\n";
    $vl_fromuser .= "  <option value=\"ANYUSER\">$l_vl_anyuser</option>\n";
    $sl  = "select user_id, user_username, level_name, us_name from USERS u, USERSTATUS s, USERLEVELS l ";
    $sl .= "where binary u.user_status=s.us_id and binary u.level_id=l.level_id ";
    $sl .= "order by l.level_id asc, user_status desc;";
    $ql = db_query($sl);
    while ($pl=$ql->fetch_object()) {
      $vl_fromuser .= "  <option value=\"$pl->user_id\">$pl->user_username ($pl->us_name)</option>\n";
    }
    $vl_fromuser .= "</select>";
    table_row("fa fa-user-o", "$l_vl_opfrom:", "", "none", "$vl_fromuser");
    $vl_opover  = "<select name=\"in_opover\">";
    $vl_opover .= "  <option value=\"\">---</option>\n";
    // First lets generate the user list
    $vl_opover .= "  <option value=\"\">- Usuarios -</option>\n";
    $vl_opover .= "  <option value=\"ANYUSER\">$l_vl_anyuser</option>\n";
    $command = "/usr/bin/cat /etc/passwd";
    $counter = 0;
    exec($command, $results);
    while ($counter < count($results)) {
      $line = $results[$counter];
      list($vl_username,$vl_x,$vl_uid,$vl_gid,$vl_info, $vl_home, $vl_shell)=explode(":",$line);
      if ($vl_uid>=$surp_ugmin and $vl_uid<$surp_ugmax) {
        $vl_opover .= "  <option value=\"$vl_uid\">$vl_username</option>\n";
      }
      $counter++;
    }
    unset($results);
    // Now lets generate the group list
    $vl_opover .= "  <option value=\"\">- Grupos -</option>\n";
    $vl_opover .= "  <option value=\"ANYGROUP\">$l_vl_anygroup</option>\n";
    $command = "/usr/bin/cat /etc/group | /usr/bin/cut -d\":\" -f1,3";
    $counter = 0;
    exec($command, $results);
    while ($counter < count($results)) {
      $line = $results[$counter];
      list($vl_groupname,$vl_gid)=explode(":",$line);
      if ($vl_gid>=$surp_ugmin and $vl_gid<$surp_ugmax) { 
        $vl_opover .= "  <option value=\"grp-$vl_gid\">$vl_groupname</option>\n";
      }
      $counter++;
    }
    unset($results);
    $vl_opover .= "</select>\n";
    table_row("fa fa-user-circle-o", "$l_vl_opover:", "", "none", "$vl_opover");
    $vl_optype  = "<select name=\"in_optype\">";
    $vl_optype .= "  <option value=\"\">---</option>\n";
    $vl_optype .= "  <option value=\"ANYTYPE\">$l_vl_anyop</option>";
    $sot  = "select * from OPERATIONTYPES where ot_showinlogs='1' order by ot_id asc;";
    $qot = db_query($sot);
    while ($pot=$qot->fetch_object()) {
      $vl_optype .= "  <option value=\"$pot->ot_id\">$pot->ot_short</option>\n";
    }
    $vl_optype .= "</select>\n";
    table_row("fa fa-cogs", "$l_vl_optypef:", "", "none", "$vl_optype");
    echo "<input name=\"in_view\" value=\"1\" type=\"hidden\">\n";
    $reset = "<button type=\"reset\" class=\"btn btn-danger\">$l_reset</button>";
    $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_search</button>";
    table_row("", "$reset", "", "none", "$submit");
    echo "  </table>\n";
    echo "  <br /><br />\n";
    echo "</div>\n";
    echo "</form>";
  }
  container_close();

