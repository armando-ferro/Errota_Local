<?php
include 'funciones.php';
// Start the session
session_start();
if ($_SESSION['tipo'] != 'a'){
    header('location: index.php');
    exit();
}
        
?>

<!DOCTYPE HTML>

<html>
	<head>
		<title>Errota-EHU</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
                <link rel="stylesheet" href="/main.css" />
                <script type="text/javascript" src="/js/funciones.js"></script>
	</head>
	<body>
		<!-- bar -->
            <section id="sidebar">
                <div class="inner">

                    <nav>
                        <ul  id="menu">
                            <li><a href="#intro">Inicio</a></li>
                            <?php
                            if(empty($_SESSION['my_user']) == FALSE && $_SESSION['tipo'] == 'a')
                            {
                                echo "<li><a href='#one'>Notas alumnos</a></li>";
                                echo "<li><a href='#two'>Trabajos pendientes</a></li>";
                                echo "<li><a href='#four'>Añadir tarea</a></li>";
                                echo "<li><a href='#five'>Modificar tarea</a></li>";
                                echo "<li><a href='#seven'>Eliminar tarea</a></li>";
                                echo "<li><a href='#six'>Ejecutar script</a></li>";

                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </section>
                
                
                
    <!-- Wrapper -->
            <div id="wrapper">

        <!-- Intro -->
                <section id="intro" class="wrapper style1 fullscreen fade-up">
                    <div class="inner">

                        <?php

                        if (empty($_SESSION['my_user']) == FALSE)
                            {
                                echo "<a href='logout.php'>Logout</a>";
                                echo "<h1>Ongi Etorri</h1>"
                                . "<h3>".$_SESSION['my_user']."</h3>";

                            }
                        else{
                                echo "<center>
                                    <form method = 'post' action = 'dologin.php' autocomplete='off'>
                                    <input type = 'text' id = 'userlogin' placeholder = 'dni' name = 'uid'>
                                    <input type = 'password' id = 'passlogin' name = 'upass' placeholder = '***'>
                                    <input type = 'submit' id = 'dologin' value = 'Login'></form>";
                        }
                        ?>
                    </div>
                </section>
        
        <!--Alumnos-->
        <?php
            if (empty($_SESSION['my_user']) == FALSE){

                    echo "<section id='one' class='wrapper style1 fullscreen fade-up'>
                        <div class='inner'>";
                    $nombre_alumnos = CargaNombreAlumnos();
                    echo "<form action='#one' id='filtros' method='post'>"
                        . "<select name='alumno_filtro' id='alumno_filtro'>";
                    echo "<option value='Todos'>Todos</option>";
                        while ($row = mysql_fetch_array($nombre_alumnos)) 
                        {
                            echo "<option value=".$row{'id_alumno'}.">".$row{'nombre'}." ".$row{'apellidos'}."</option>";
                        }            
                    echo "</select><input type='submit'></form>";
                    if(isset($_POST['alumno_filtro']))
                    {
                        $filtro = $_POST['alumno_filtro'];
                    }
                    else{
                        $filtro = 'Todos';
                    }
                    $result= CargaClasificacion($filtro);
                    echo "<table border='1' id='notas' name='notas'><thead><tr>"
                        . "<th>DNI</th>"
                        . "<th>Nombre</th>"
                        . "<th>Apellidos</strong></th>"
                        . "<th>Ex00</th>"
                        . "<th>Ex01</th>"
                        . "<th>Ex02</th>"
                        . "<th>Ex03</th>"
                        . "<th>Ex04</th>"
                        . "<th>Ex05</th>"
                        . "<th>Ex06</th>"
                        . "<th>Total</th>"
                        . "</tr></thead><tbody>";
                    while ($row = mysql_fetch_array($result)){
                        
                        echo "<tr bgcolor='white'><td>".$row['dni']."</td><td>".$row['nombre']."</td><td>" .$row['apellidos']."</td>"
                                . "<td>".$row['ex00']."</td><td>" .$row['ex01']."</td><td>".$row['ex02']."</td><td>" .$row['ex03']."</td><td>".$row['ex04']."</td><td>" .$row['ex05']."</td><td>" .$row['ex06']."</td><td class='notaT'>" .$row['total']."/21</td></tr>";
                    }
                    echo "</tbody></table></div>
                    </section>";
            }
        ?>
        

    <!-- Trabajos pendientes-->
    <?php
    if (empty($_SESSION['my_user']) == FALSE){
        $result = CargaPractica();
            echo "<section id='two' class='wrapper style1 fullscreen fade-up'>
                <div class='inner'>";
                        while ($row = mysql_fetch_array($result)) {
                            echo "<h2>".$row{'nombre'}."</h2>"
                                    . "<h3>".$row{'descripcion'}."</h3>"
                                    . "<h3>Fecha limite: ".$row['final']." 23:59";
                            if(empty($row{'git'})==FALSE && empty($_SESSION['github'])==FALSE){        
                            echo "<h3>https://github.com/".$_SESSION['github']."/".$row{'git'}.".git</h3>";
                            }
                            if(empty($row{'directorio'})==FALSE){
                            echo "<p><a href='/practicas/".$row{'directorio'}."'>
                                Descargar ".$row{'nombre'}."
                                </a></p>";
                            }
                        }            
                echo "</div>
            </section>";
    }
    ?>
    <!-- Add tareas -->
    <?php
    if (empty($_SESSION['my_user']) == FALSE){
    echo "<section id='four' class='wrapper style1 fullscreen fade-up'>
           <div class='inner'>
            <h2>Añadir tarea</h2>
            <form method='post' action='addtarea.php' autocomplete='off' id='formtarea' enctype= 'multipart/form-data'>
                <div class='field'>
                        <label for='titulo'>Titulo</label>
                        <input type='text' name='titulo' placeholder = 'Practica X' id='titulo' />
                </div>
                <div class='field half first'>
                        <label for='fechainicio'>Fecha Inicio</label>
                        <input type='date' name='fechainicio' id='fechainicio' />
                </div>
                <div class='field half'>
                        <label for='fechafinal'>Fecha Final</label>
                        <input type='date' name='fechafinal' id='fechafinal' />
                </div>
                <div class='field half first'>
                        <label for='giturl'>Github</label>
                        <input type='text' name='giturl' id='giturl' placeholder='P1'/>
                </div>
                <div class='field half'>
                        <label for='urlfichero'>Fichero</label>
                        <input type='file' name='urlfichero' id='urlfichero'/>
                </div>
                <p></p>
                <div class='field'>
                        <label for='descripcion'>Descripción</label>
                        <textarea name='descripcion' id='descripcion' style='height:100px;' form='formtarea' placeholder='Introduce un comentario sobre la tarea'></textarea>
                </div>
                <ul class='actions'>
                        <li><input type='submit' class='button submit' value='Validar'></li>
                </ul>
            </form>
            </div>
        </section>";
    }
    ?>
    <!-- Modificar tareas -->
    <?php
    if (empty($_SESSION['my_user']) == FALSE){
        $result = CargaPractica();
            echo "<section id='five' class='wrapper style1 fullscreen fade-up'>
                <div class='inner'>
                <h2>Modificar tarea</h2>";
            echo "<form action='modificartarea.php' id='formmodificar' method='post'>"
            . "<select name='id_practica' id='id_practica'>";
                        while ($row = mysql_fetch_array($result)) 
                        {
                            echo "<option value=".$row{'id_practica'}.">".$row{'nombre'}."</option>";
                        }            
                echo "</select><input type='submit'></form></div>
            </section>";
    }
    ?>
    <!--Borrar tareas -->
    <?php
    if (empty($_SESSION['my_user']) == FALSE){
        $result = CargaPractica();
            echo "<section id='seven' class='wrapper style1 fullscreen fade-up'>
                <div class='inner'>
                <h2>Eliminar tarea</h2>";
            echo "<form action='eliminar.php' id='formeliminar' method='post' onsubmit='return confirm('Seguro que desea eliminar la tarea?');'>"
            . "<select name='id_practica' id='id_practica'>";
                        while ($row = mysql_fetch_array($result)) 
                        {
                            echo "<option value=".$row{'id_practica'}.">".$row{'nombre'}."</option>";
                        }            
                echo "</select><input type='submit'></form></div>
            </section>";
    }
    ?>
    
    <?php
    if (empty($_SESSION['my_user']) == FALSE){
    echo "<section id='six' class='wrapper style1 fade-up'>
           <div class='inner'>
            <h2>Ejecutar script P1</h2>
            <form method='post' action='ejecutar.php'>
                
                <ul class='actions'>
                        <li><input type='submit' class='button submit' value='Ejecutar'></li>
                </ul>
            </form>
        
        
            <h2>Ejecutar script JAVA Socket</h2>
            <form method='post' action='ejecutar_Java.php'>
                <ul class='actions'>
                        <li><input type='submit' class='button submit' value='Ejecutar'></li>
                </ul>
            </form>";
    
            

    echo "        </div>
        </section>";
    }
    ?>
                                        
                    <!-- Three -->

                            <section id="three" class="wrapper style1 fullscreen fade-up">
                                    <div class="inner">

                                        <ul class="contact">
                                                <li>
                                                        <h3>Dirección</h3>
                                                        <span>San Mamés<br />
                                                        Bilbao<br />
                                                        Bizkaia</span>
                                                </li>
                                                <li>
                                                        <h3>Email</h3>
                                                        <a href="#">telematica@ehu.eus</a>
                                                </li>
                                                <li>
                                                        <h3>Teléfono</h3>
                                                        <span>(000) 000-0000</span>
                                                </li>
                                                <li>
                                                        <h3>Social</h3>
                                                        <ul class="icons">
                                                                <li><a href="#" class="fa-twitter"><span class="label">Twitter</span></a></li>
                                                                <li><a href="#" class="fa-facebook"><span class="label">Facebook</span></a></li>
                                                                <li><a href="#" class="fa-instagram"><span class="label">Instagram</span></a></li>
                                                        </ul>
                                                </li>
                                        </ul>
                                    </div>
                            </section>

            </div>

		<!-- Footer -->
            <footer id="footer" class="wrapper style1-alt">
                    <div class="inner">
                            <ul class="menu">
                                    <li>&copy; Todos los derechos reservados.</li><li>Diseñado por Aresti-Development</li>
                            </ul>
                    </div>
            </footer>
      </body>
</html>