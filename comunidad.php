<?php require_once('Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_mostrar_comunidad = "SELECT idComunidad,comunidad FROM comunidad WHERE idRegional = ".(int)$_GET['idRegional']." AND idDepartamento=".(int)$_GET['idDepartamento']." AND idMunicipio=".(int)$_GET['idMunicipio']." ORDER BY comunidad ASC";
$mostrar_comunidad = mysql_query($query_mostrar_comunidad, $conexion) or die(mysql_error());
$row_mostrar_comunidad = mysql_fetch_assoc($mostrar_comunidad);
$totalRows_mostrar_comunidad = mysql_num_rows($mostrar_comunidad);
?>
<select id="x_idComunidad" name="x_idComunidad">
  <?php
do {  
?>
  <option value="<?php echo $row_mostrar_comunidad['idComunidad']?>" <?php if($row_mostrar_comunidad['idComunidad']==(int)$_GET['idComunidad']){
	  echo("selected");
	  } ?>><?php echo utf8_encode($row_mostrar_comunidad['comunidad'])?></option>
  <?php
} while ($row_mostrar_comunidad = mysql_fetch_assoc($mostrar_comunidad));
  $rows = mysql_num_rows($mostrar_comunidad);
  if($rows > 0) {
      mysql_data_seek($mostrar_comunidad, 0);
	  $row_mostrar_comunidad = mysql_fetch_assoc($mostrar_comunidad);
  }
?>
</select>
<?php
mysql_free_result($mostrar_comunidad);
?>
