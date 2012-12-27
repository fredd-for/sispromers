<?php
$hostname_conexion = "localhost";
$database_conexion = "db_sispromers";
$username_conexion = "user_sispromers";
$password_conexion = "pass_sispromers";
$conexion = mysql_pconnect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysql_error(),E_USER_ERROR); 
?>