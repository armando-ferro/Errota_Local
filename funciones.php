<?php

include 'constantes.php';


function guardaActividad($myusername, $accion)
{   
    $ip = $_SERVER['REMOTE_ADDR'];
    $date = date("Y-m-d H:i:s");
    $sql = "INSERT INTO `actividad`(`usuario`, `fecha`, `ip`,`accion`) "
                . "VALUES ('$myusername','$date','$ip', '$accion')";
    global $dbname, $hostname, $password, $username;
    // Crea conexion
    $conn = new mysqli($hostname, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
    }
    if ($conn->query($sql) === TRUE){
    } else {
        echo "Error: <br>" . $conn->error;
    }
}

function RegisterUser()
{
        error_reporting(E_ALL ^ E_DEPRECATED);
        
	global $dbname, $hostname, $password, $username;
        
        $nombre = $_POST['nombre'];
	$dni= $_POST['dni'];
	$pass = $_POST['password'];
        $apellidos = $_POST['apellidos'];
        $correo = $_POST['correo'];
        $github = $_POST['github'];
        

	// Crea conexion
        $conn = new mysqli($hostname, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "INSERT INTO `alumnos`(`nombre`, `apellidos`, `correo`,`github`,`dni`,`password`) "
                . "VALUES ('$nombre','$apellidos','$correo','$github','$dni','$pass')";
        
        if (mysqli_query($conn,$sql) == TRUE) {
	    return TRUE;
	} else {
            return FALSE;
	}
}

function CargaNotas($id, $practica)
{
        error_reporting(E_ALL ^ E_DEPRECATED);
	
        
        global $dbname, $hostname, $password, $username;
	//conexion a la base de datos
	$dbhandle = mysql_connect($hostname, $username, $password, $dbname)
	 or die("No se ha podido conectar a MySQL");
	//seleccion de base de datos
	$selected = mysql_select_db($dbname,$dbhandle)
	  or die("No se ha podido seleccionar la base de datos");
	$practica="practica".$practica;
	$sql_T =  "SELECT * "
                . "FROM `$practica` "
                . "WHERE `$practica`.`id_alumno`=$id";
        mysql_query("SET NAMES 'UTF8'");
	$result_T = mysql_query($sql_T);
        return $result_T;
}

function CargaClasificacion($filtro)
{
    error_reporting(E_ALL ^ E_DEPRECATED);
        
    global $dbname, $hostname, $password, $username;
	
    //conexion a la base de datos
    $dbhandle = mysql_connect($hostname, $username, $password, $dbname)
     or die("No se ha podido conectar a MySQL");
    //seleccion de base de datos
    $selected = mysql_select_db($dbname,$dbhandle)
      or die("No se ha podido seleccionar la base de datos");
    if(is_null($filtro) == true || $filtro == "Todos"){
            $sql_R =  "SELECT * FROM alumnos INNER JOIN practica1 on alumnos.id_alumno = practica1.id_alumno ORDER BY practica1.total DESC";
    }
    else{
            $sql_R =  "SELECT * FROM alumnos INNER JOIN practica1 on alumnos.id_alumno = practica1.id_alumno WHERE alumnos.id_alumno ='$filtro' ORDER BY practica1.total DESC";
    }
    mysql_query("SET NAMES 'UTF8'");
    $result_R = mysql_query($sql_R);

    return $result_R;
}

function CargaNombreAlumnos(){
    error_reporting(E_ALL ^ E_DEPRECATED);
        
    global $dbname, $hostname, $password, $username;
	
    //conexion a la base de datos
    $dbhandle = mysql_connect($hostname, $username, $password, $dbname)
     or die("No se ha podido conectar a MySQL");
    //seleccion de base de datos
    $selected = mysql_select_db($dbname,$dbhandle)
      or die("No se ha podido seleccionar la base de datos");
    
    $sql_R =  "SELECT nombre,apellidos,id_alumno FROM alumnos ORDER BY alumnos.apellidos ASC";
    
    mysql_query("SET NAMES 'UTF8'");
    $result_R = mysql_query($sql_R);

    return $result_R;
}

function CargaPractica(){
    
    error_reporting(E_ALL ^ E_DEPRECATED);
        
    global $dbname, $hostname, $password, $username;
    $fecha = date("Y-m-d");
    //conexion a la base de datos
    $dbhandle = mysql_connect($hostname, $username, $password, $dbname)
     or die("No se ha podido conectar a MySQL");
    //seleccion de base de datos
    $selected = mysql_select_db($dbname,$dbhandle)
      or die("No se ha podido seleccionar la base de datos");
    
    $sql = "SELECT * FROM `practicas`";
    
    mysql_query("SET NAMES 'UTF8'");
    $result = mysql_query($sql);
    return $result;
}

function SubeFichero()
{
    $ftp_server = 'ftp.errota-ehu.hol.es';
    
    $conn_id = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
    ftp_login($conn_id, "u754152113", "inactive90");
    
    $file = $_FILES["urlfichero"]["tmp_name"];
    $remotefile = $_FILES['urlfichero']['name'];

    // change the directory
    ftp_chdir($conn_id, "practicas");
    // upload a file
    if (ftp_put($conn_id, $remotefile , $file, FTP_ASCII)) {
        echo "<p>Successfully uploaded $file.</p>";
    } else {
        echo "<p>Error uploading.".$file.".</p>";
    }

    // close the connection
    ftp_close($conn_id);
        
}

function RegistraTarea()
{
        error_reporting(E_ALL ^ E_DEPRECATED);
        
	global $dbname, $hostname, $password, $username;
        //Se sube el pdf
        SubeFichero();
        //Se guardan todos los datos en la base de datos
        $titulo = $_POST['titulo'];
	$fechainicio= $_POST['fechainicio'];
	$fechafinal = $_POST['fechafinal'];
        $giturl = $_POST['giturl'];
        $descripcion = $_POST['descripcion'];
        $directorio = $_FILES['urlfichero']['name'];
        
	// Crea conexion
        $conn = new mysqli($hostname, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "INSERT INTO `practicas`(`nombre`, `directorio`, `inicio`,`final`,`descripcion`,`git`) "
                . "VALUES ('$titulo','$directorio','$fechainicio','$fechafinal','$descripcion','$giturl')";
        if ($conn->query($sql) === TRUE) {
	    echo "<p>Tarea insertada correctamente</p>";
	} else {
            echo "<p>Error al subir la tarea</p>";
	}
}

function ModificarTarea()
{
    error_reporting(E_ALL ^ E_DEPRECATED);
        
    global $dbname, $hostname, $password, $username;
    
    //Se guardan todos los datos en la base de datos
    $titulo = $_POST['titulo'];
    $fechainicio= $_POST['fechainicio'];
    $fechafinal = $_POST['fechafinal'];
    $giturl = $_POST['giturl'];
    $descripcion = $_POST['descripcion'];
    $directorio = $_FILES['urlfichero']['name'];
    $id_practica = $_POST['id_practica'];
    // Crea conexion
    $conn = new mysqli($hostname, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "UPDATE `mydb`.`practicas` "
            . "SET `nombre`='$titulo', `directorio`='$directorio', `inicio`='$fechainicio', `final`='$fechafinal', `descripcion`='$descripcion', `git`='$giturl' "
            . "WHERE `id_practica`='$id_practica'";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Tarea modificada correctamente</p>";
    } else {
        echo "<p>Error al modificar la tarea</p>";
    }
}

function eliminarTarea()
{
    error_reporting(E_ALL ^ E_DEPRECATED);
        
    global $dbname, $hostname, $password, $username;
    
    //Los datos necesarios para el borrado de la practica
    $id_practica = $_POST['id_practica'];
    // Crea conexion
    $conn = new mysqli($hostname, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "DELETE FROM `mydb`.`practicas` "
            . "WHERE `id_practica`='$id_practica'";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Tarea eliminada correctamente</p>";
    } else {
        echo "<p>Error al eliminar la tarea</p>";
    }
}