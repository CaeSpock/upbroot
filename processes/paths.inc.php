<?php
  // Please configure all the paths needed for "runtasks.php"
    $pathinc    = "/home/upbroot/public_html/v1/inc";
    $pathlogops = "/home/upbroot/logs/operations";
    $pathlogsql = "/home/upbroot/logs/sql";
   $lockfilepid = "/home/upbroot/processes/lock.pid";
  $lockaliaspid = "/home/upbroot/processes/alias.pid";
 
  // This include uses the full path to the file, as its loated outside of the web directory
  include_once("/home/upbroot/conf/conf.inc.php");
