<?php
$Nombre_Host = 'mysql';  // Nombre del  de MySQL en docker-compose.yml
$Nombre_Usuario = 'root';
$contra = getenv('MYSQL_ROOT_PASSWORD');    
$Base_de_datos = getenv('MYSQL_DATABASE'); 

$conex = mysqli_connect($Nombre_Host, $Nombre_Usuario, $contra, $Base_de_datos);

