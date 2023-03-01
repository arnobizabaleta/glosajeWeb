<?php
//Variables parametros conexion servidor y bases de datos 
$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="";
$dbname="glosajeweb";
$conexion = new mysqli($host, $user, $password, $dbname, $port, $socket);

?>