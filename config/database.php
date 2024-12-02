
<?php

$server='localhost';
$username='root';
$password='';
$database='devTP';


$mysqli = new mysqli($server, $username, $password, $database);


if ($mysqli->connect_error) {
    die('Error en la conexión: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}else{
    //echo "CONECTADO CORRECTAMENTE A LA BD";
}



?>
