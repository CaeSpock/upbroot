<?php
  //
  // ^*** Important!!!
  // Rename this to conf.inc.php
  //

  // Web Site info
  // System Name:
     $surp_sitename   = "UPB Root";
     $surp_siteurl    = "http://upbrooturl:port/";
     $surp_siteslogan = "Sistema de Administraci&oacute;n de Servidores de la UPB";

  // Site Admin name and email
  $surp_admname = "Your name";
  $surp_admmail = "Your@email.com";

  // When Emails are sent, use this email address and this from field
  $surp_sitemailaddr = "from@myemail.com";
  $surp_sitemailfrom = "My System";

  // Please dont change this, in order to respect GPL
   $surp_sitecr = "&copy; 2018 - UPB La Paz";
  $surp_sitever = "1.0";
  $surp_autname = "Carlos Anibarro";
  $surp_autmail = "carlosanibarro@lp.upb.edu";

  // Data Base information, please change
  $surp_dbname = "dbname";
  $surp_dbuser = "dbuser";
  $surp_dbpass = "dbpass";

  // Language
  $surp_lang = "spanish";

  // Constants
  // How many lines to display on big items
  $surp_perPage = 15;

  // Values for the ok and no ok graphs
    $surp_labelok   = "<font color=\"#008000\"><i class=\"fa fa-check\"></i></font>";
    $surp_labelnook = "<font color=\"#800000\"><i class=\"fa fa-times\"></i></font>";

  // In order to comnsider users, lets set the minimun and
  // maximun userid and groupid values
  $surp_ugmin = 1000;
  $surp_ugmax = 65000;

  // Logging
  // Log SQL and Operations? 1=yes 0=no
  $surp_logsql = 1;
  $surp_logops = 1;

  // Suffix for the log filenames
  // You can use "-sql.txt" or simply ".txt";
  $surp_extsqllog = ".txt";
  $surp_extopslog = ".txt";

/*
  ## Conventions
  $surc_* <- Cookies
  $surv_* <- Variables
  $surp_* <- Constants defined in the conf file
*/
?>
