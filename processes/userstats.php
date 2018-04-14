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
  echo "[".date("Y-m-i H:i:s")."] User Stats Generator ...\n";
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
      $filetowrite = $pathtouserdata."/".$u_username.".txt";
      echo "[".date("Y-m-i H:i:s")."] User > $u_username [$u_uid] $filetowrite\n";
      file_put_contents($filetowrite, "<pre>\n");
      file_put_contents($filetowrite, "<a id=\"status\">#### $l_au_summary_s ####</a>\n\n", FILE_APPEND);
      file_put_contents($filetowrite, "$l_datetime: $fecha $hora\n", FILE_APPEND);
      file_put_contents($filetowrite, "$l_au_username: $u_username\n", FILE_APPEND);
      file_put_contents($filetowrite, "$l_au_uid/$l_au_gid: $u_uid/$u_gid\n", FILE_APPEND);
      file_put_contents($filetowrite, "$l_au_info: $u_info\n", FILE_APPEND);
      file_put_contents($filetowrite, "$l_au_home: $u_home\n", FILE_APPEND);
      file_put_contents($filetowrite, "$l_au_shell: $u_shell\n", FILE_APPEND);
      file_put_contents($filetowrite, "\n\n", FILE_APPEND);
      file_put_contents($filetowrite, "<a href=\"#top\">$l_au_backtotop</a>\n\n", FILE_APPEND);
      file_put_contents($filetowrite, "<a id=\"home\">#### $l_au_summary_h ####</a>\n\n", FILE_APPEND);
      $command = "/usr/bin/du -skh $u_home";
      exec($command, $out_ic, $rv_ic);
      $counter_ic = 0;
      while ($counter_ic < count($out_ic)) {
        file_put_contents($filetowrite, $out_ic[$counter_ic]."\n", FILE_APPEND);
        $counter_ic++;
      }
      unset($out_ic);
      unset($rv_ic);
      file_put_contents($filetowrite, "\n", FILE_APPEND);
      file_put_contents($filetowrite, "$l_au_contents:\n", FILE_APPEND);
      file_put_contents($filetowrite, "-------------\n", FILE_APPEND);
      $command = "/usr/bin/ls -alF -R $u_home";
      exec($command, $out_ic, $rv_ic);
      $counter_ic = 0;
      while ($counter_ic < count($out_ic)) {
        file_put_contents($filetowrite, $out_ic[$counter_ic]."\n", FILE_APPEND);
        $counter_ic++;
      }
      unset($out_ic);
      unset($rv_ic);
      file_put_contents($filetowrite, "\n\n", FILE_APPEND);
      file_put_contents($filetowrite, "<a href=\"#top\">$l_au_backtotop</a>\n\n", FILE_APPEND);
      file_put_contents($filetowrite, "<a id=\"crontab\">#### $l_au_summary_c ####</a>\n\n", FILE_APPEND);
      $cronfile = "/var/spool/cron/".$u_username;
      if (file_exists($cronfile)) {
        $command = "/usr/bin/cat $cronfile";
        exec($command, $out_ic, $rv_ic);
        $counter_ic = 0;
        while ($counter_ic < count($out_ic)) {
         file_put_contents($filetowrite, $out_ic[$counter_ic]."\n", FILE_APPEND);
          $counter_ic++;
        }
        unset($out_ic);
        unset($rv_ic);
      } else {
        file_put_contents($filetowrite, "$l_au_nocrontab\n", FILE_APPEND);
      }
      file_put_contents($filetowrite, "\n\n", FILE_APPEND);
      file_put_contents($filetowrite, "<a href=\"#top\">$l_au_backtotop</a>\n\n", FILE_APPEND);
      file_put_contents($filetowrite, "<a id=\"database\">#### $l_au_summary_d ####</a>\n\n", FILE_APPEND);
      $sql = "SELECT sum(data_length + index_length)  as size FROM information_schema.TABLES WHERE table_schema='$u_username';";
      $getsize = db_query($sql);
      $size = 0;
      $ps = $getsize->fetch_object();
      $size = $size + $ps->size;
      $cadena = "$l_au_summary_d: $u_username [".DownloadSize($size)."]";
      file_put_contents($filetowrite, "$cadena\n", FILE_APPEND);
      file_put_contents($filetowrite, "\n", FILE_APPEND);
      file_put_contents($filetowrite, "$l_au_contents:\n", FILE_APPEND);
      file_put_contents($filetowrite, "-----------\n", FILE_APPEND);
      $mysqludir = "/var/lib/mysql/$u_username";
      if (file_exists($mysqludir)) {
        $command = "/usr/bin/ls -alF -R $mysqludir";
        exec($command, $out_ic, $rv_ic);
        $counter_ic = 0;
        while ($counter_ic < count($out_ic)) {
          file_put_contents($filetowrite, $out_ic[$counter_ic]."\n", FILE_APPEND);
          $counter_ic++;
       }
        unset($out_ic);
        unset($rv_ic);
      } else {
        file_put_contents($filetowrite, "$l_au_nodbdir\n", FILE_APPEND);
      }
      file_put_contents($filetowrite, "\n\n", FILE_APPEND);
      file_put_contents($filetowrite, "<a href=\"#top\">$l_au_backtotop</a>\n\n", FILE_APPEND);
      file_put_contents($filetowrite, "<a id=\"processes\">#### $l_au_summary_p ####</a>\n\n", FILE_APPEND);
      $command = "/usr/bin/ps -flu $u_username";
      exec($command, $out_ic, $rv_ic);
      $counter_ic = 0;
      while ($counter_ic < count($out_ic)) {
       file_put_contents($filetowrite, $out_ic[$counter_ic]."\n", FILE_APPEND);
        $counter_ic++;
      }
      unset($out_ic);
      unset($rv_ic);
      file_put_contents($filetowrite, "</pre>\n", FILE_APPEND);
      file_put_contents($filetowrite, "<a href=\"#top\">$l_au_backtotop</a>\n\n", FILE_APPEND);
    }
    $counter++;
  }
  unset($results);
  echo "[".date("Y-m-i H:i:s")."] ----------------------------------------------------\n";
  echo "[".date("Y-m-i H:i:s")."] Process terminating ...\n";
  // All done; we blank the PID file and explicitly release the lock 
  // (although this should be unnecessary) before terminating.
  ftruncate($lock_file, 0);
  flock($lock_file, LOCK_UN);
  include_once("$pathinc/dbclose.inc.php");
?>
