<?php
  // Access permits
  // Menu options available only to valid users
  if ($surv_level_id > 1) {
    $pathsys = "pages";
    if ($action == "dashboard") { include_once("$pathsys/dashboard.inc.php"); }
    if ($action == "changelog") { include_once("$pathsys/changelog.inc.php"); }
    if ($action == "whatis") { include_once("$pathsys/whatis.inc.php"); }
    if ($action == "updatedata") { include_once("$pathsys/updatedata.inc.php"); }
    if ($action == "updatepass") { include_once("$pathsys/updatepass.inc.php"); }
    if ($surv_level_id > 60) {
      if ($action == "sysinfo") { include_once("$pathsys/sysinfo.inc.php"); }
      if ($action == "mrtg") { include_once("$pathsys/mrtg.inc.php"); }
      if ($action == "admusers") { include_once("$pathsys/admusers.inc.php"); }
      if ($action == "admgroups") { include_once("$pathsys/admgroups.inc.php"); }
      if ($surv_level_id > 75) {
        if ($action == "viewlogs") { include_once("$pathsys/viewlogs.inc.php"); }
        if ($action == "admsysusers") { include_once("$pathsys/admsysusers.inc.php"); }
      }
    }
  }

