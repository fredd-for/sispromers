<?php
$hostname_conexion = "localhost";
$database_conexion = "db_sispromers";
$username_conexion = "root";
$password_conexion = "8209125";
$conexion = mysql_pconnect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysql_error(),E_USER_ERROR); 
?>