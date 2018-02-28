<?php
  ## Dashboard
  oplogs("$surv_user", "5", "", "");
  container_open("$l_dashboard");
  echo "            <div class=\"row\">\n";
  echo "              <div class=\"col-md-3 col-sm-6\">\n";
  echo "                <div class=\"statistic-block block\">\n";
  echo "                  <div class=\"progress-details d-flex align-items-end justify-content-between\">\n";
  echo "                    <div class=\"title\">\n";
  echo "                      <div class=\"icon\"><i class=\"fa fa-user\"></i></div><strong>$l_users</strong>\n";
  echo "                    </div>\n";
  $command = "/usr/bin/cat /etc/passwd | /usr/bin/cut -d\":\" -f1,3,4";
  $users = 0;
  $counter = 0;
  exec($command, $results);
  while ($counter < count($results)) {
    $line = $results[$counter];
    list($username,$uid,$gid)=explode(":",$line);
    if ($uid>=$surp_ugmin and $uid<$surp_ugmax) { $users++; }
    $counter++;
  }
  unset($results);
  echo "                    <div class=\"number dashtext-1\">$users</div>\n";
  echo "                  </div>\n";
  echo "                  <div class=\"progress progress-template\">\n";
  echo "                    <div role=\"progressbar\" style=\"width: 50%\" aria-valuenow=\"30\" aria-valuemin=\"0\" aria-valuemax=\"100\" class=\"progress-bar progress-bar-template dashbg-1\"></div>\n";
  echo "                  </div>\n";
  echo "                </div>\n";
  echo "              </div>\n";
  echo "              <div class=\"col-md-3 col-sm-6\">\n";
  echo "                <div class=\"statistic-block block\">\n";
  echo "                  <div class=\"progress-details d-flex align-items-end justify-content-between\">\n";
  echo "                    <div class=\"title\">\n";
  echo "                      <div class=\"icon\"><i class=\"fa fa-users\"></i></div><strong>$l_groups</strong>\n";
  echo "                    </div>\n";
  $command = "/usr/bin/cat /etc/group | /usr/bin/cut -d\":\" -f1,3";
  $groups = 0;
  $counter = 0;
  exec($command, $results);
  while ($counter < count($results)) {
    $line = $results[$counter];
    list($group,$gid)=explode(":",$line);
    if ($gid>=$surp_ugmin and $gid<$surp_ugmax) { $groups++; }
    $counter++;
  }
  unset($results);
  echo "                    <div class=\"number dashtext-2\">$groups</div>\n";
  echo "                  </div>\n";
  echo "                  <div class=\"progress progress-template\">\n";
  echo "                    <div role=\"progressbar\" style=\"width: 50%\" aria-valuenow=\"70\" aria-valuemin=\"0\" aria-valuemax=\"100\" class=\"progress-bar progress-bar-template dashbg-2\"></div>\n";
  echo "                  </div>\n";
  echo "                </div>\n";
  echo "              </div>\n";
  echo "              <div class=\"col-md-3 col-sm-6\">\n";
  echo "                <div class=\"statistic-block block\">\n";
  echo "                  <div class=\"progress-details d-flex align-items-end justify-content-between\">\n";
  echo "                    <div class=\"title\">\n";
  echo "                      <div class=\"icon\"><i class=\"fa fa-sign-in\"></i></div><strong>$l_loggedin</strong>\n";
  echo "                    </div>\n";
  $command = "/usr/bin/uptime | /usr/bin/awk {'print $4'}";
  exec($command, $results);
  $loggedin = $results[0];
  unset($results);
  if ($loggedin == "min,") {
    $command = "/usr/bin/uptime | /usr/bin/awk {'print $5'}";
    exec($command, $results);
    $loggedin = $results[0];
    unset($results);
  }
  echo "                    <div class=\"number dashtext-3\">$loggedin</div>\n";
  echo "                  </div>\n";
  echo "                  <div class=\"progress progress-template\">\n";
  echo "                    <div role=\"progressbar\" style=\"width: 50%\" aria-valuenow=\"55\" aria-valuemin=\"0\" aria-valuemax=\"100\" class=\"progress-bar progress-bar-template dashbg-3\"></div>\n";
  echo "                  </div>\n";
  echo "                </div>\n";
  echo "              </div>\n";
  echo "              <div class=\"col-md-3 col-sm-6\">\n";
  echo "                <div class=\"statistic-block block\">\n";
  echo "                  <div class=\"progress-details d-flex align-items-end justify-content-between\">\n";
  echo "                    <div class=\"title\">\n";
  echo "                      <div class=\"icon\"><i class=\"fa fa-microchip\"></i></div><strong>$l_userprocesses</strong>\n";
  echo "                    </div>\n";
  $command = "/usr/bin/ps au | /usr/bin/wc -l";
  exec($command, $results);
  $userprocesses = $results[0];
  unset($results);
  echo "                    <div class=\"number dashtext-4\">$userprocesses</div>\n";
  echo "                  </div>\n";
  echo "                  <div class=\"progress progress-template\">\n";
  echo "                    <div role=\"progressbar\" style=\"width: 50%\" aria-valuenow=\"35\" aria-valuemin=\"0\" aria-valuemax=\"100\" class=\"progress-bar progress-bar-template dashbg-4\"></div>\n";
  echo "                  </div>\n";
  echo "                </div>\n";
  echo "              </div>\n";
  echo "            </div>\n";
  echo "          </div>\n";
  echo "        </section>\n";
  echo "        <section>\n";
  echo "          <div class=\"container-fluid\">\n";
  echo "            <div class=\"row\">\n";
  echo "              <div class=\"col-lg-4\">\n";
  echo "                <div class=\"stats-with-chart-2 block\">\n";
  echo "                  <div class=\"title\"><strong class=\"d-block\"><i class=\"fa fa-server\"></i> $l_server</i> </strong><span class=\"d-block\">".$_SERVER['SERVER_NAME']."</span></div>\n";
  echo "        ".$_SERVER['SERVER_SOFTWARE']."<br />PHP version ". phpversion()."<br />DB version ".$dblink->server_info."\n";
  echo "                </div>\n";
  echo "              </div>\n";
  echo "              <div class=\"col-lg-4\">\n";
  echo "                <div class=\"stats-with-chart-2 block\">\n";
  echo "                  <div class=\"title\"><strong class=\"d-block\"><i class=\"fa fa-calendar\"></i> $l_datetime</strong><span class=\"d-block\">".proc_date($date)." $time</span></div>\n";
  echo "                  <div class=\"title\"><strong class=\"d-block\"><i class=\"fa fa-connectdevelop\"></i> $l_connectedfrom</strong><span class=\"d-block\">$user_host $user_ip<br />$user_client</span></div>\n";
  echo "                </div>\n";
  echo "              </div>\n";
  echo "              <div class=\"col-lg-4\">\n";
  echo "                <div class=\"stats-with-chart-2 block\">\n";
  echo "                  <div class=\"title\"><strong class=\"d-block\"><i class=\"fa fa-user\"></i> $l_user</strong><span class=\"d-block\">$surv_user_name</span></div>\n";
  $s_level = "select * from USERLEVELS where level_id='$surv_level_id' limit 1;";
  $q_level = db_query($s_level);
  if ($q_level->num_rows > 0) {
    $level = $q_level->fetch_object();
    echo "        $level->level_name\n";
  }
  echo "        <br />";
  echo "<a href=\"$PHPSELF?action=changelog\">$l_changelog</a>";
  echo "<br /><br /><br /><br /><br />\n";
  echo "                </div>\n";
  echo "              </div>\n";
  echo "            </div>\n";
  container_close();

