<?php
  ## MRTG
  oplogs("$surv_user", "5", "", "");
  container_open("$l_mrtg");
  echo "$l_mrtg_text";
  container_close();