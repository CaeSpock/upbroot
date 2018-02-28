#!/usr/bin/php
<?php
  if ($argc != 2) {
    echo "Syntax: $argv[0] PASSWORD\n";
  } else {
    $in_pass = $argv[1];
    $passoptions = [ 'cost' => 12, ];
    $hash = password_hash($in_pass, PASSWORD_DEFAULT, $passoptions);
    echo "Your hash is: $hash\n";
  }
?>
