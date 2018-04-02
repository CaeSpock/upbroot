#!/usr/bin/php
<?php
  date_default_timezone_set('America/La_Paz');
            $fecha = date("Y-m-d");
             $hora = date("H:i:s");
         $horadiff = 4*60*60;
         $fechabol = gmdate("Y-m-d", time()-$horadiff);
          $horabol = gmdate("H:i:s", time()-$horadiff);

  $samepath = dirname(__FILE__);
  include_once("$samepath/paths.inc.php");

  include_once("$pathinc/langs/$surp_lang.inc.php");
  include_once("$pathinc/func.inc.php");
  include_once("$pathinc/dbopen.inc.php");
  echo "[".date("Y-m-i H:i:s")."] $surp_sitename v. $surp_sitever\n";
  echo "[".date("Y-m-i H:i:s")."] Email Alias Generator ...\n";
  echo "[".date("Y-m-i H:i:s")."] ----------------------------------------------------\n";
  $lock_file = fopen($lockaliaspid, 'c');
  $got_lock = flock($lock_file, LOCK_EX | LOCK_NB, $wouldblock);
  if ($lock_file === false || (!$got_lock && !$wouldblock)) {
    throw new Exception(
        "[".date("Y-m-i H:i:s")."] Unexpected error opening or locking lock file. Perhaps you " .
        "don't  have permission to write to the lock file or its " .
        "containing directory?"
    );
  } else if (!$got_lock && $wouldblock) {
    exit("[".date("Y-m-i H:i:s")."] Another instance is already running; terminating.\n");
  }
  // Lock acquired; let's write our PID to the lock file for the convenience
  // of humans who may wish to terminate the script.
  ftruncate($lock_file, 0);
  fwrite($lock_file, getmypid() . "\n");
  echo "[".date("Y-m-i H:i:s")."] Dumping main aliases base file \n";
  $command = "cat $samepath/aliases > /etc/aliases";
  system($command);
  echo "[".date("Y-m-i H:i:s")."] Now adding all the user email aliases \n";
  file_put_contents("/etc/aliases", "\n", FILE_APPEND);
  file_put_contents("/etc/aliases", "# User Aliases\n", FILE_APPEND);
  $command = "/usr/bin/cat /etc/passwd";
  exec($command, $results);
  $counter = 0;
  while ($counter < count($results)) {
    unset($u_email);
    unset($split);
    $line = $results[$counter];
    list($u_username,$u_x,$u_uid,$u_gid,$u_info,$u_home,$u_shell)=explode(":",$line);
    if ($u_uid>=$surp_ugmin and $u_uid<$surp_ugmax) { 
      $split =explode(",", $u_info);
      if (isset($split[2])) { 
        $u_email = $split[2];
        if (filter_var($u_email, FILTER_VALIDATE_EMAIL)) {
          file_put_contents("/etc/aliases", "$u_username: $u_email\n", FILE_APPEND);
        }
      }
    }
    $counter++;
  }
  unset($results);
  file_put_contents("/etc/aliases", "\n", FILE_APPEND);
  echo "[".date("Y-m-i H:i:s")."] Running 'newaliases'\n";
  $command = "/usr/bin/newaliases";
  exec($command, $results);
  echo "[".date("Y-m-i H:i:s")."] ----------------------------------------------------\n";
  echo "[".date("Y-m-i H:i:s")."] Process terminating ...\n";
  // All done; we blank the PID file and explicitly release the lock 
  // (although this should be unnecessary) before terminating.
  ftruncate($lock_file, 0);
  flock($lock_file, LOCK_UN);
  include_once("$pathinc/dbclose.inc.php");
?>
