<?php
  // Menu
  $activepagemenu = "class=\"active\"";
  $activeexpanded = "false";
  $activecollapse = "collapse";

  // Defaults
  $dashboard_active = "";
  $whatis_active = "";
  $updatedata_active = "";
  $updatepass_active = "";
  $admusers_active = "";
  $admgroups_active = "";
  $viewlogs_active = "";
  $admsysusers_active = "";

  // Menu has been selected
  // Dashboard
  if ($action == "dashboard") { $dashboard_active = $activepagemenu; }
  if ($action == "changelog") { $dashboard_active = $activepagemenu; }
  if ($action == "whatis") { $whatis_active = $activepagemenu; $activeexpanded = "true"; $activecollapse = ""; }
  if ($action == "updatedata") { $updatedata_active = $activepagemenu; $activeexpanded = "true"; $activecollapse = ""; }
  if ($action == "updatepass") { $updatepass_active = $activepagemenu; $activeexpanded = "true"; $activecollapse = ""; }
  if ($action == "admusers") { $admusers_active = $activepagemenu; }
  if ($action == "admgroups") { $admgroups_active = $activepagemenu; }
  if ($action == "viewlogs") { $viewlogs_active = $activepagemenu; }
  if ($action == "admsysusers") { $admsysusers_active = $activepagemenu; }

  // echo "      <!-- Sidebar Navigation-->\n";
  echo "      <nav id=\"sidebar\">\n";
  // echo "        <!-- Sidebar Header-->\n";
  echo "        <div class=\"sidebar-header d-flex align-items-center\"></div>\n";
  // echo "        <!-- Sidebar Navidation Menus-->";
  echo "        <span class=\"heading\">$l_menu</span>\n";
  echo "        <ul class=\"list-unstyled\">\n";
  // Menu only for valid users
  if ($surv_level_id > 1) {
    echo "                <li $dashboard_active><a href=\"$PHPSELF?action=dashboard\"> <i class=\"icon-home fa-fw\"></i> $l_dashboard </a></li>\n";
    echo "                <li><a href=\"#SystemDropDown\" aria-expanded=\"$activeexpanded\" data-toggle=\"collapse\"> <i class=\"icon-windows fa-fw\"></i> $surp_sitename </a>\n";
    echo "                  <ul id=\"SystemDropDown\" class=\"$activecollapse list-unstyled \">\n";
    echo "                    <li $whatis_active><a href=\"$PHPSELF?action=whatis\">$l_whatis</a></li>\n";
    echo "                    <li $updatedata_active><a href=\"$PHPSELF?action=updatedata\">$l_updatedata</a></li>\n";
    echo "                    <li $updatepass_active><a href=\"$PHPSELF?action=updatepass\">$l_updatepass</a></li>\n";
    echo "                  </ul>\n";
    echo "                </li>\n";
    echo "                <li $admusers_active><a href=\"$PHPSELF?action=admusers\"> <i class=\"fa fa-user-o fa-fw\"></i> $l_admusers </a></li>\n";
    echo "                <li $admgroups_active><a href=\"$PHPSELF?action=admgroups\"> <i class=\"fa fa-users fa-fw\"></i> $l_admgroups </a></li>\n";
    if ($surv_level_id > 75) {
      echo "                <li $viewlogs_active><a href=\"$PHPSELF?action=viewlogs\"> <i class=\"fa fa-file-text-o fa-fw\"></i> $l_viewlogs </a></li>\n";
      echo "                <li $admsysusers_active><a href=\"$PHPSELF?action=admsysusers\"> <i class=\"fa fa-user-secret fa-fw\"></i> $l_admsysusers </a></li>\n";
    }
    /*
    echo "                <li><a href=\"tables.html\"> <i class=\"icon-grid\"></i>Tablas </a></li>\n";
    echo "                <li><a href=\"charts.html\"> <i class=\"fa fa-bar-chart\"></i>Gráficos </a></li>\n";
    echo "                <li><a href=\"forms.html\"> <i class=\"icon-padnote\"></i>Forms </a></li>\n";
    echo "                <li><a href=\"#exampledropdownDropdown\" aria-expanded=\"false\" data-toggle=\"collapse\"> <i class=\"icon-windows\"></i>Example dropdown </a>\n";
    echo "                  <ul id=\"exampledropdownDropdown\" class=\"collapse list-unstyled \">\n";
    echo "                    <li><a href=\"#\">Page</a></li>\n"
    echo "                    <li><a href=\"#\">Page</a></li>\n";
    echo "                    <li><a href=\"#\">Page</a></li>\n";
    echo "                  </ul>\n";
    echo "                </li>\n";
    echo "                <li><a href=\"$PHPSELF?action=logout\"> <i class=\"icon-logout\ fa-fw"></i>$l_logout</a></li>\n";
    echo "        </ul><span class=\"heading\">Extras</span>\n";
    echo "        <ul class=\"list-unstyled\">\n";
    echo "          <li> <a href=\"#\"> <i class=\"icon-settings\"></i>Demo </a></li>\n";
    echo "          <li> <a href=\"#\"> <i class=\"icon-writing-whiteboard\"></i>Demo </a></li>\n";
    echo "          <li> <a href=\"#\"> <i class=\"icon-chart\"></i>Demo </a></li>\n";
    echo "        </ul>\n";
    echo "        <ul class=\"list-unstyled\">\n";
    echo "                <li><a href=\"tables.html\"> <i class=\"icon-grid\"></i>Tablas </a></li>\n";
    echo "                <li><a href=\"charts.html\"> <i class=\"fa fa-bar-chart\"></i>Gráficos </a></li>\n";
    echo "                <li><a href=\"forms.html\"> <i class=\"icon-padnote\"></i>Forms </a></li>\n";
    echo "                <li><a href=\"#exampledropdownDropdown\" aria-expanded=\"false\" data-toggle=\"collapse\"> <i class=\"icon-windows\"></i>Example dropdown </a>\n";
    echo "                  <ul id=\"exampledropdownDropdown\" class=\"collapse list-unstyled \">\n";
    echo "                    <li><a href=\"#\">Page</a></li>\n";
    echo "                    <li><a href=\"#\">Page</a></li>\n";
    echo "                    <li><a href=\"#\">Page</a></li>\n";
    echo "                  </ul>\n";
    echo "                </li>\n";
    echo "        </ul>\n";
    */
  }
  echo "                <li><a href=\"$PHPSELF?action=logout\"> <i class=\"icon-logout fa-fw\"></i> $l_logout</a></li>\n";
  echo "        </ul>\n";
  echo "      </nav>\n";
  // echo "      <!-- Sidebar Navigation end-->\n";

