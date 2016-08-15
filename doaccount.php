
<?php


include 'funciones.php';

if(isset($_POST['dni']) && isset($_POST['nombre']) && isset($_POST['password']) && 
        isset($_POST['apellidos']) && isset($_POST['correo']) && isset($_POST['github']))
{
    $registro = RegisterUser();
} 


?>

<HTML>
   <HEAD>
         <meta content="text/html" http-equiv=Content-Type>
         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <link rel="stylesheet" type="text/css" href="/main.css" />
   

      <TITLE>
         Registro
      </TITLE>
         
   </HEAD>
</BODY>

<?php
    if ($registro == TRUE)
    {
        echo "<p>Te has registrado con exito. Vuelve a la página de inicio y haz un login.</p>";
    }
    else{
        echo "<p>No se ha podido realizar el registro con éxito. Prueba otra vez o contacta con el administrador.</p>";
    }
?>


<?php
echo "<form action='index.php'>
	    <input type='submit' value='Volver'>
	    </form>";

?>
</BODY>

</HTML>

