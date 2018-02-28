<?php
  ## ChangeLog
  oplogs("$surv_user", "5", "", "");
  container_open("$l_changelog");
  echo "<pre>";
  $ficheroabrir = "$pathppal/changelog.txt";
  $fichero = @fopen( $ficheroabrir, "r");
  if ($fichero) {
    while (($linea = fgets($fichero, 4096)) !== false) {
      echo $linea;
    }
    if (!feof($fichero)) {
      echo "Error: unexpected fgets() fail\n";
    }
    fclose($fichero);
  }
  echo "</pre>";
  container_close();

