<?php
include 'config.php';
$cone = mysqli_connect($host,$user,$password,$bd);

if (!$cone){
  exit("Fallo la conexión a la base de Datos");
}

?>