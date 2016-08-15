<?php

include 'funciones.php';
include 'constantes.php';

session_start();

$usuario = $_POST['uid'];
$pass = $_POST['upass'];

error_reporting(E_ALL ^ E_DEPRECATED);


//conexion a la base de datos
$dbhandle = mysql_connect($hostname, $username, $password, $dbname)
        or die("Fatal error: No se ha podido conectar a MySQL");

//seleccion de base de datos
$selected = mysql_select_db($dbname,$dbhandle)
        or die("No se ha podido seleccionar la base de datos");


//ADMINISTRADOR
//
//definicion de la query
$sql= "SELECT * FROM `profesores` WHERE `nombre` LIKE '$usuario'";
//resultado de la query
$result = mysql_query($sql);

if($result === FALSE) { 
    die(mysql_error());
}

$row = mysql_fetch_row($result);

$myusername = $row[1];

if($row[3] == $pass)
{
    $_SESSION["my_user"] = $myusername;
    $_SESSION["tipo"] = 'a';
    header('location: admin.php');
    exit();
}

//ALUMNO

$sql= "SELECT * FROM `alumnos` WHERE `dni` LIKE '$usuario'";
$result = mysql_query($sql);

if($result === FALSE) { 
    die(mysql_error());
}

$row = mysql_fetch_row($result);


if($row[6] == $pass)
{
    $_SESSION["id"] = $row[0];
    $_SESSION["my_user"] = $row[1];
    $_SESSION["apellidos"] = $row[2];
    $_SESSION["tipo"] = 'b';
    $_SESSION["github"] = $row[4];
    $_SESSION["correo"] = $row[3];
    $_SESSION["dni"] = $row[5];
    
    header('location: index.php'); 
    exit();
}

//USUARIO NO ENCONTRADO

if(empty($_SESSION["my_user"])){
    header('location: index.php');
}