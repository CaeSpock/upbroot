<?php
  ## SysInfo
  oplogs("$surv_user", "5", "", "");
  container_open("$l_phpinfo");
  ob_start();
  phpinfo();
  $Ausgabe = ob_get_contents();
  ob_end_clean();
  preg_match_all("=<body[^>]*>(.*)</body>=siU", $Ausgabe, $a);
  $phpinfo = $a[1][0];
  /*
  $phpinfo = str_replace( 'width="600"', 'width="750"', $phpinfo );
  $phpinfo = str_replace( 'border="0" cellpadding', 'class="x" border="0" cellpadding', $phpinfo );
  $phpinfo = str_replace( '<td>', '<td><div class="tt">', $phpinfo );
  $phpinfo = str_replace( '<td class="e">', '<td class="e"><div class="te">', $phpinfo );
  $phpinfo = str_replace( '<td class="v">', '<td class="v"><div class="tv">', $phpinfo );
  $phpinfo = str_replace( '</td>', '</div></td>', $phpinfo ); 
  echo " <style type=\"text/css\">\n";
  echo " <!--\n";
  echo " body {\n";
  echo "    margin: 10px 10px 10px;\n";
  echo "    background-color: #fff;\n";
  echo "    color: #000000;\n";
  echo " }\n";
  echo " body,p,h1,h2,h3,h4,h5,h6,td,ul,ol,li,div,address,blockquote,nobr {\n";
  echo "    font-size: 11px;\n";
  echo "    font-family: Verdana, Tahoma, Arial Helvetica, Geneva, Sans-Serif;\n";
  echo "    font-weight: normal;\n";
  echo " }\n";
  echo " pre {\n";
  echo "    margin: 0px;\n";
  echo "    font-family: monospace;\n";
  echo " }\n";
  echo " a:link {\n";
  echo "    color: #000099;\n";
  echo "    text-decoration: none;\n";
  echo " }\n";
  echo " a:hover {\n";
  echo "    text-decoration: underline;\n";
  echo " }\n";
  echo " table {\n";
  echo "    border-collapse: collapse;\n";
  echo " }\n";
  echo " .center {\n";
  echo "    text-align: center;\n";
  echo " }\n";
  echo " .center table {\n";
  echo "    margin-left: auto;\n";
  echo "    margin-right: auto;\n";
  echo "    text-align: left;\n";
  echo " }\n";
  echo " .center th {\n";
  echo "    text-align: center !important;\n";
  echo " }\n";
  echo " td, th {\n";
  echo "    border: 1px solid #a2aab8;\n";
  echo "    vertical-align: baseline;\n";
  echo " }\n";
  echo " h1 {\n";
  echo "    font-size: 16px;\n";
  echo "    font-weight: bold;\n";
  echo " }\n";
  echo " h2 {\n";
  echo "    font-size: 14px;\n";
  echo "    font-weight: bold;\n";
  echo " }\n";
  echo " .p {\n";
  echo "    text-align: left;\n";
  echo " }\n";
  echo " .e {\n";
  echo "    background-color: #e3e3ea;\n";
  echo "    font-weight: bold;\n";
  echo "    color: #000000;\n";
  echo " }\n";
  echo " .h {\n";
  echo "    background-color: #a2aab8;\n";
  echo "    font-weight: bold;\n";
  echo "    color: #000000;\n";
  echo "    font-size: 11px;\n";
  echo " }\n";
  echo " .v {\n";
  echo "    background-color: #efeff4;\n";
  echo "    color: #000000;\n";
  echo " }\n";
  echo " i {\n";
  echo "    color: #666666;\n";
  echo "    background-color: #cccccc;\n";
  echo " }\n";
  echo " img {\n";
  echo "    float: right;\n";
  echo "    border: solid 1px #1a1a1a;\n";
  echo "    background-color:#9999cc;\n";
  echo " }\n";
  echo " hr {\n";
  echo "    width: 750px;\n";
  echo "    background-color: #cccccc;\n";
  echo "    border: 0px;\n";
  echo "    height: 1px;\n";
  echo "    color: #1a1a1a;\n";
  echo " }\n";
  echo " .x {\n";
  echo "    width: 750px;\n";
  echo " }\n";
  echo " .tt {\n";
  echo " }\n";
  echo " .te {\n";
  echo "    font-weight:bold;\n";
  echo " }\n";
  echo " .tv {\n";
  echo "    position:relative;\n";
  echo "    overflow:auto;\n";
  echo " }\n";
  echo " //-->\n";
  echo " </style> \n";
  */
  echo "$phpinfo";
  container_close();