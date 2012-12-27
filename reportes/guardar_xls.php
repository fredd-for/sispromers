 <?php
 	$nombre = date("d_m_y").".xls";
	$archivo = fopen($nombre , "w");
	if ($archivo) {
		fputs ($archivo,utf8_decode(stripslashes($_POST["texto"])));
	}
	fclose ($archivo);
	echo($nombre);
	
?> 