<?php
include 'funciones.php';
// Start the session
session_start();
if ($_SESSION['tipo'] == 'a'){
    header('location: admin.php');
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
                <script src="sorttable.js"></script>
                
	</head>
	<body>
		<!-- bar -->
			<section id="sidebar">
                            <div class="inner">
                                 
					<nav>
						<ul  id="menu">
							<li><a href="#intro">Inicio</a></li>
                                                        <?php
                                                        if (empty($_SESSION['my_user']) == TRUE)
                                                        {
                                                            echo "<li><a href='#three'>Formulario de registro</a></li>";                                                            
                                                        }
                                                        else
                                                        {
                                                            echo "<li><a href='#one'>Trabajos pendientes</a></li>";
                                                            echo "<li><a href='#four'>Notas</a></li>";
                                                            echo "<li><a href='#five'>Clasificación</a></li>";
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
                                                            . "<h3>".$_SESSION['my_user']." ".$_SESSION['apellidos']." - ".$_SESSION['github']."</h3>";
                                                            
                                                        }
                                                    else{
                                                            echo "<center>
                                                                <form method = 'post' action = 'dologin.php' autocomplete='off'>
                                                                <input type = 'text' id = 'userlogin' placeholder = 'dni' name = 'uid'>
                                                                <input type = 'password' id = 'passlogin' name = 'upass' placeholder = '***'>
                                                                <input type = 'submit' id = 'dologin' value = 'Login'></form>
                                                                <ul class='actions'>
								<li><a href='#three' class='button scrolly'>Crear cuenta</a></li>
                                                                </ul></center>";
 
                                                    }
                                                    ?>
                                            </div>
					</section>
                                
                                <!-- Trabajos -->
                                <?php
                                if (empty($_SESSION['my_user']) == FALSE){
                                    $result = CargaPractica();
					echo "<section id='one' class='wrapper style1 fullscreen fade-up'>
                                            <div class='inner'>";
                                                    while ($row = mysql_fetch_array($result)) {
                                                        echo "<h2>".$row{'nombre'}."</h2>"
                                                                . "<h3>".$row{'descripcion'}."</h3>"
                                                                . "<h3>Fecha limite: ".$row['final']." 23:59";
                                                        if(empty($row{'git'})==FALSE){        
                                                        echo "<h3>https://github.com/".$_SESSION['github']."/".$row{'git'}.".git</h3>";
                                                        }
                                                        if(empty($row{'directorio'})==FALSE){
                                                        echo "<a href='/practicas/".$row{'directorio'}."'>
                                                            Descargar ".$row{'nombre'}."
                                                            </a>";
                                                        }
                                                    }            
                                            echo "</div>
					</section>";
                                }
                                ?>
                                <!-- NOTAS -->
                                <?php
                                if (empty($_SESSION['my_user']) == FALSE && $_SESSION['tipo'] == 'b'){
                                    
					echo "<section id='four' class='wrapper style1 fullscreen fade-up'>
                                            <div class='inner'>";
                                            $practica = 1;
                                            do{
                                                $result = CargaNotas($_SESSION['id'], $practica);
                                                $row = mysql_fetch_array($result);
                                                if(empty($row)==FALSE){
                                                echo "<h2>P".$practica."</h2>"
                                                        . "<table border='1' id='notas' name='notas'><thead><tr>"
                                                        . "<th>Ex00</th>"
                                                        . "<th>Ex01</th>"
                                                        . "<th>Ex02</th>"
                                                        . "<th>Ex03</th>"
                                                        . "<th>Ex04</th>"
                                                        . "<th>Ex05</th>"
                                                        . "<th>Ex06</th>"
                                                        . "<th>TOTAL</th>"
                                                        . "</tr></thead><tbody>";
                                                
                                                echo "<tr><td>".$row['ex00']."</td><td>" .$row['ex01']."</td><td>".$row['ex02']."</td><td>" .$row['ex03']."</td><td>".$row['ex04']."</td><td>" .$row['ex05']."</td><td>" .$row['ex06']."</td><td class='notaT'>" .$row['total']."/21</td></tr>"
                                                . "</tbody></table>";
                                                }
                                                $practica=$practica+1;
                                            }while (empty($row)==FALSE);
                                        echo "</div>
					</section>";
                                }
                                ?>
                                
                                <!-- CLASIFICACIÓN -->
                                <?php
                                if (empty($_SESSION['my_user']) == FALSE){
                                    
					echo "<section id='five' class='wrapper style1 fullscreen fade-up'>
                                            <div class='inner'>";
                                        $result= CargaClasificacion();
                                        echo "<h2>Clasificación</h2><table border='1' id='clasificacion' class='sortable'><thead><tr>"
                                            . "<th>Pos</th>"
                                            . "<th>Nombre</th>"
                                            . "<th>Apellidos</th>"
                                            . "<th>Nota</th>"
                                            . "</tr></thead><tbody>";
                                        $n = 1;   
                                        while ($row = mysql_fetch_array($result)){
                                            echo "<tr><td>".$n."</td><td>".$row['nombre']."</td><td>" .$row['apellidos']."</td><td>" .$row['total']."/21</td></tr>";
                                            $n++;
                                        }
                                        echo "</tbody></table></div>
					</section>";
                                }
                                ?>
				<!-- Three -->
                                
					<section id="three" class="wrapper style1 fullscreen fade-up">
						<div class="inner">
							<div class="split style1">
                                                            <?php
                                                            if (empty($_SESSION['my_user']) == TRUE){
                                                            echo "<section>
                                                                    <h2>Formulario de registro</h2>
                                                                    <form method='post' action='doaccount.php' autocomplete='off' onsubmit='return validaFormulario()'>
                                                                        <div class='field half first'>
                                                                                <label for='dni'>DNI</label>
                                                                                <input type='text' name='dni' id='dni' />
                                                                        </div>
                                                                        <div class='field half'>
                                                                                <label for='password'>Password</label>
                                                                                <input type='password' name='password' id='password' />
                                                                        </div>
                                                                        <div class='field half'>
                                                                                <label for='nombre'>Nombre</label>
                                                                                <input type='text' name='nombre' id='nombre' />
                                                                        </div>
                                                                        <div class='field half'>
                                                                                <label for='apellidos'>Apellidos</label>
                                                                                <input type='text' name='apellidos' id='apellidos' />
                                                                        </div>
                                                                        <div class='field half first'>
                                                                                <label for='github'>Github</label>
                                                                                <input type='text' name='github' id='github' />
                                                                        </div>
                                                                        <div class='field half'>
                                                                                <label for='correo'>Correo</label>
                                                                                <input type='email' name='correo' id='correo' />
                                                                        </div>
                                                                        <ul class='actions'>
                                                                                <li><input type='submit' class='button submit' value='Validar'></li>
                                                                        </ul>
                                                                    </form>
								</section>";
                                                            }
                                                            ?>
								
								<section>
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
								</section>
							</div>
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