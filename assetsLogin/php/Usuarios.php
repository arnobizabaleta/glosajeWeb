<?php

include 'conexion.php';

$Nombre_Completo = $_POST['Nombre_Completo'];
$Correo = $_POST['Correo'];
$Usuario = $_POST['Usuario'];
$Contrasena = $_POST['Contrasena'];

$query = "INSERT INTO Usuarios(Nombre_Completo,Correo,Usuario,Contrasena) 
          VALUES ('$Nombre_Completo','$Correo','$Usuario','$Contrasena')";

$ejecutar = mysqli_query($conexion,$query);
?>