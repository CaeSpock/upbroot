<?php
    $dblink = new mysqli('localhost', $surp_dbuser, $surp_dbpass, $surp_dbname);
    if ($dblink->connect_error) {
      die('Error al conectar a la Base de Datos (' . $dblink->connect_errno . ') '
            . $dblink->connect_error);
    }
?>
