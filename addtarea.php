
<?php


include 'funciones.php';

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
<h3>Tarea</h3>
<?php
    if(isset($_FILES['urlfichero']['name']))
    {
        RegistraTarea();
    }
    
?>


<?php
echo "<form action='index.php'>
	    <input type='submit' value='Volver'>
	    </form>";

?>
</BODY>

</HTML>