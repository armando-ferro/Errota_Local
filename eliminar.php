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
include 'funciones.php';


if(isset($_POST['id_practica']))
{
    eliminarTarea();
}
?>


<?php
echo "<form action='index.php'>
	    <input type='submit' value='Volver'>
	    </form>";

?>
</BODY>

</HTML>
