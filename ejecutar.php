<HTML>
   <HEAD>
         <meta content="text/html" http-equiv=Content-Type>
         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <link rel="stylesheet" type="text/css" href="/main.css" />
   

      <TITLE>
         Errota
      </TITLE>
         
   </HEAD>
</BODY>
<h3>Errota</h3>
<h2>Corregir práctica 1</H2>
<?php
    
    $command = 'python errotaP1.py';
    exec($command, $output, $return_value);

    foreach ($output as $line) 
    {
        echo "$line<br></br>";
    }
?>


<?php
echo "<form action='admin.php'>
	    <input type='submit' value='Volver'>
	    </form>";

?>
</BODY>

</HTML>