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

if(isset($_POST['titulo']) || isset($_POST['giturl']) || isset($_POST['descripcion']))
{
    ModificarTarea();
}


if(isset($_POST['id_practica']))
{
    $result=  CargaPractica();
    $row = mysql_fetch_array($result);
    $id_practica = $_POST['id_practica'];
    echo "<form method='post' action='' autocomplete='off' id='formtarea' enctype= 'multipart/form-data'>
                <input type='hidden' name='id_practica'  id='id_practica' value='".$id_practica."'/>
                <div class='field'>
                        <label for='titulo'>Titulo</label>
                        <input type='text' name='titulo'  id='titulo' value='".$row{'nombre'}."'/>
                </div>
                <div class='field half first'>
                        <label for='fechainicio'>Fecha Inicio</label>
                        <input type='date' name='fechainicio' id='fechainicio' value='".$row{'inicio'}."'/>
                </div>
                <div class='field half'>
                        <label for='fechafinal'>Fecha Final</label>
                        <input type='date' name='fechafinal' id='fechafinal' value='".$row{'final'}."'/>
                </div>
                <div class='field half first'>
                        <label for='giturl'>Github</label>
                        <input type='text' name='giturl' id='giturl' value='".$row{'git'}."'/>
                </div>
                <div class='field half'>
                        <label for='urlfichero'>Fichero</label>
                        <input type='file' name='urlfichero' id='urlfichero'/>
                </div>
                <p></p>
                <div class='field'>
                        <label for='descripcion'>Descripción</label>
                        <textarea name='descripcion' id='descripcion' style='height:100px;' form='formtarea'>".$row{'descripcion'}."</textarea>
                </div>
                <ul class='actions'>
                        <li><input type='submit' class='button submit' value='Validar'></li>
                </ul>
            </form>";
}
?>


<?php
echo "<form action='index.php'>
	    <input type='submit' value='Volver'>
	    </form>";

?>
</BODY>

</HTML>
