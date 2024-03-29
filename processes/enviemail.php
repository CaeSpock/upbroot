#!/usr/bin/php
<?php
  date_default_timezone_set('America/La_Paz');
            $fecha = date("Y-m-d");
             $hora = date("H:i:s");
         $horadiff = 4*60*60;
         $fechabol = gmdate("Y-m-d", time()-$horadiff);
          $horabol = gmdate("H:i:s", time()-$horadiff);

  $samepath = dirname(__FILE__);
  include_once("/var/www/upbroot/processes/paths.inc.php");

  include_once("$pathinc/langs/$surp_lang.inc.php");
  include_once("$pathinc/func.inc.php");
  include_once("$pathinc/dbopen.inc.php");
  if ($argc < 2) {
    echo "Debe enviar como parametro la cuenta a procesar.\n";
    echo $argv[0]." CUENTA\n";
    exit;
  }
  $account = $argv[1];
  echo "[".date("Y-m-i H:i:s")."] Envio de E-Mails para cuentas nuevas \n";
  echo "[".date("Y-m-i H:i:s")."] -------------------------------------\n";
  $selcuentas  = "select ot_d_username, ot_d_flags from OPERATIONS where ot_id='9' ";
  $selcuentas .= "and ot_d_username='$account';";
  $getcuentas = db_query($selcuentas);
  while ($pc = $getcuentas->fetch_object()) {
    unset($username);
    unset($clave);
    unset($info);
    unset($home);
    unset($shell);
    unset($quota);
    unset($nombre);
    unset($codigo);
    unset($email);
    unset($telefono);
    list($username,$clave,$info,$home,$shell,$quota)=explode("|", $pc->ot_d_flags);
    list($nombre, $codigo, $email, $telefono)=explode(",", $info);
    echo "Cuenta: $pc->ot_d_username[$clave] - E-Mail: $email [";
    $msg  = "";
    $msg .= "Hola $nombre,".PHP_EOL;
    $msg .= PHP_EOL;
    $msg .= "Este es un mensaje automático para avisarte que ya creamos tu cuenta en el servidor ";
    $msg .= "skynet.lp.upb.edu :)".PHP_EOL;
    $msg .= PHP_EOL;
    $msg .= "Los datos para tu ingreso son:".PHP_EOL;
    $msg .= "-----------------------------".PHP_EOL;
    $msg .= "Usuario: $username".PHP_EOL;
    $msg .= "Clave: $clave".PHP_EOL;
    $msg .= "-----------------------------".PHP_EOL;
    $msg .= PHP_EOL;
    $msg .= "El servidor tiene muchas ventajas que serán explicadas en este correo. Una de las más ";
    $msg .= "interesantes es que tienes una cuenta de correo .EDU ($username@isc.lp.upb.edu) que te ";
    $msg .= "permite gozar de todas las ventajas y descuentos para cuentas educativas que hay en ";
    $msg .= "GitHub, Microsoft Office 365, Apple Music, y otros sitios. Ya llegaremos a ese punto.".PHP_EOL;
    $msg .= PHP_EOL;
    $msg .= "Skynet es un servidor Linux, por ende para conectarte necesitarás usar un cliente ";
    $msg .= "SSH cualquiera. Muchos sistemas operativos ya incorporan un programa SSH de forma ";
    $msg .= "nativa. En Windows te aconsejo uses Putty, y la última versión la puedes descargar ";
    $msg .= "de esta dirección: (es software libre)".PHP_EOL;
    $msg .= "https://www.chiark.greenend.org.uk/~sgtatham/putty/latest.html".PHP_EOL;
    $msg .= "Para conectarte debes hacer uso de la dirección (host o ip) y de un puerto especial, ";
    $msg .= "distinto al puerto por defecto. Los datos son:".PHP_EOL;
    $msg .= "-----------------------------".PHP_EOL;
    $msg .= "Host: skynet.lp.upb.edu".PHP_EOL;
    $msg .= "IP Interno: 192.168.50.100 (Solo accesible desde dentro de la Universidad)".PHP_EOL;
    $msg .= "IP Externo: 186.121.251.3 (Solo accesible desde fuera de la Universidad)".PHP_EOL;
    $msg .= "Puerto: 44".PHP_EOL;
    $msg .= "-----------------------------".PHP_EOL;
    $msg .= "Una vez que realices tu primera conexión, el servidor te informará que tu clave está ";
    $msg .= "expirada y que debes configurar una clave que solo tu conozcas. Este es un paso ";
    $msg .= "muy importante y debes elegir una clave que solo tu conozcas, que tenga una letra ";
    $msg .= "mayúscula, tenga minúsculas, números y también algun caracter especial (*, !, _, etc).".PHP_EOL;
    $msg .= PHP_EOL;
    $msg .= "La primera vez que ingreses tendrás estos mensajes:".PHP_EOL;
    $msg .= "-----------------------------".PHP_EOL;
    $msg .= "You are required to change your password immediately (root enforced)".PHP_EOL;
    $msg .= "WARNING: Your password has expired.".PHP_EOL;
    $msg .= "You must change your password now and login again!".PHP_EOL;
    $msg .= "Changing password for user TuNombreDeUsuario.".PHP_EOL;
    $msg .= "Changing password for TuNombreDeUsuario.".PHP_EOL;
    $msg .= "(current) UNIX password: <-- Aca debes ingresar nuevamente tu clave".PHP_EOL;
    $msg .= "New password: <-- Aca debes ingresar tu nueva clave".PHP_EOL;
    $msg .= "BAD PASSWORD: The password is too similar to the old one <-- Si hay algun error con tu clave propuesta el sistema te avisara sobre esto".PHP_EOL;
    $msg .= "New password: <-- Aca debes ingresar tu nueva clave".PHP_EOL;
    $msg .= "Retype new password: <-- aca confirma tu nueva calve".PHP_EOL;
    $msg .= "passwd: all authentication tokens updated successfully. <-- si el cambio fue exitoso el sistema te avisara".PHP_EOL;
    $msg .= "Connection to localhost closed. <-- cerrara la conexion para que vuelvas a conectarte".PHP_EOL;
    $msg .= "-----------------------------".PHP_EOL;
    $msg .= "Una vez que ingreses al sistema tendrás a tu disposicion Java, Python, Perl, C++, ";
    $msg .= "PHP, GIT, etc, etc".PHP_EOL;
    $msg .= PHP_EOL;
    $msg .= "Los datos de tu cuenta en el sistema son:".PHP_EOL;
    $msg .= "-----------------------------".PHP_EOL;
    $msg .= "Username: $username".PHP_EOL;
    $msg .= "Nombre: $nombre".PHP_EOL;
    $msg .= "Código: $codigo".PHP_EOL;
    $msg .= "E-Mail: $email".PHP_EOL;
    $msg .= "Telefono: $telefono".PHP_EOL;
    $msg .= "-----------------------------".PHP_EOL;
    $msg .= "Home: $home".PHP_EOL;
    $msg .= "Shell: $shell".PHP_EOL;
    $msg .= "Quota: $quota bytes (1 giga de espacio)".PHP_EOL;
    $msg .= "Pagina Web: http://skynet.lp.upb.edu/~$username".PHP_EOL;
    $msg .= "E-Mail UPB: $username@isc.lp.upb.edu".PHP_EOL;
    $msg .= "-----------------------------".PHP_EOL;
    $msg .= "¿Mencione que tienes almacenamiento para una página web? Si, lo tienes. Todo lo que ";
    $msg .= "tengas en el directorio 'public_html' que esta en tu cuenta aparecerá automáticamente ";
    $msg .= "en el sitio web http://skynet.lp.upb.edu/~$username .".PHP_EOL;
    $msg .= "Podrás tener páginas web con JavaScript, Java o PHP e incluso con una base de datos.".PHP_EOL;
    $msg .= "La información de tu base de datos personal es:".PHP_EOL;
    $msg .= "-----------------------------".PHP_EOL;
    $msg .= "Servidor: localhost o 127.0.0.1".PHP_EOL;
    $msg .= "Base de datos: $username".PHP_EOL;
    $msg .= "Usuario: $username".PHP_EOL;
    $msg .= "Clave: $clave".PHP_EOL;
    $msg .= "-----------------------------".PHP_EOL;
    $msg .= "Para conectarte a la base de datos puedes usar el comando:".PHP_EOL;
    $msg .= "mysql -u $username -p $username".PHP_EOL;
    $msg .= "El sistema solicitará tu clave para ingresar. Una vez dentro de la base de datos, puedes ";
    $msg .= "usar el siguiente comando para cambiar tu clave: ".PHP_EOL;
    $msg .= "set PASSWORD = PASSWORD('AcaTuNuevaContrasena');".PHP_EOL;
    $msg .= PHP_EOL;
    $msg .= "Tambien puedes acceder a la base de datos mendiante la interfaz web:".PHP_EOL;
    $msg .= "https://skynet.lp.upb.edu/phpMyAdmin/".PHP_EOL;
    $msg .= "Si necesitas una base mongoDB, por favor solicitala al administrador.".PHP_EOL;
    $msg .= PHP_EOL;
    $msg .= "¿Está largo el E-Mail, no? Bueno, falta poco.".PHP_EOL;
    $msg .= PHP_EOL;
    $msg .= "También queremos comentarte que tienes una dirección de E-Mail UPB.EDU y haciendo uso de ";
    $msg .= "ella podrás acceder a descuentos que se dan a partir de direcciones educativas. Tu ";
    $msg .= "direccion de email es '$username@isc.lp.upb.edu'. Cualquier correo que se envíe a ";
    $msg .= "esa dirección se re enviará automáticamente a tu email '$email'. Puedes probar enviando ";
    $msg .= "un mensaje desde otra cuenta que no sea '$email' y ver que el mensaje te llegará a '$email'.".PHP_EOL;
    $msg .= PHP_EOL;
    $msg .= "Finalmente, utiliza el servidor de manera responsable. Recuerda que por un tema de seguridad ";
    $msg .= "todas las acciones estan siendo guardadas en bitacoras(logs) que se revisan de forma ";
    $msg .= "periódica. Cualquier duda que tengas estamos a la orden para ayudarte.".PHP_EOL;
    $msg .= PHP_EOL;
    $msg .= "Atentamente, ".PHP_EOL;
    $msg .= PHP_EOL;
    $msg .= "Administracion SkyNET".PHP_EOL;
    $msg .= "E-Mail: admin@isc.lp.upb.edu".PHP_EOL;
    $msg .= PHP_EOL;
    $email_from = "Admin SkyNET <admin@isc.lp.upb.edu>";
    $email_addparam = "-fadmin@isc.lp.upb.edu";
    $email_subject = "Información de tu cuenta en el servidor SkyNET";
    $email_to = $email;
    $email_headers = "";
    $email_headers .= "From: Admin SkyNET <admin@isc.lp.upb.edu>".PHP_EOL;
    $email_headers .= "Reply-To: admin@isc.lp.upb.edu".PHP_EOL;
    $email_headers .= "X-Mailer: PHP/CAE/$surp_sitename-$surp_sitever".PHP_EOL;
    $status = mail($email_to, $email_subject, $msg, $email_headers, $email_addparam);
    if($status === True) {
      echo "OK";
    } else {
      echo "NOOK";
    }
    echo "]\n";
  }
  echo "[".date("Y-m-i H:i:s")."] ----------------------------------------------------\n";
  include_once("$pathinc/dbclose.inc.php");
?>
