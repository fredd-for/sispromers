<?php require_once('Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_mostrar_municipio = "SELECT idMunicipio,municipio FROM municipio WHERE idRegional = ".(int)$_GET['idRegional']." AND idDepartamento=".(int)$_GET['idDepartamento']." ORDER BY municipio ASC";
$mostrar_municipio = mysql_query($query_mostrar_municipio, $conexion) or die(mysql_error());
$row_mostrar_municipio = mysql_fetch_assoc($mostrar_municipio);
$totalRows_mostrar_municipio = mysql_num_rows($mostrar_municipio);
?>
<select id="x_idMunicipio" name="x_idMunicipio">
  <?php
do {  
?>
  <option value="<?php echo $row_mostrar_municipio['idMunicipio']?>" <?php if($row_mostrar_municipio['idMunicipio']==(int)$_GET['idMunicipio']){
	  echo("selected");
	  } ?>><?php echo utf8_encode($row_mostrar_municipio['municipio'])?></option>
  <?php
} while ($row_mostrar_municipio = mysql_fetch_assoc($mostrar_municipio));
  $rows = mysql_num_rows($mostrar_municipio);
  if($rows > 0) {
      mysql_data_seek($mostrar_municipio, 0);
	  $row_mostrar_municipio = mysql_fetch_assoc($mostrar_municipio);
  }
?>
</select>
<?php
mysql_free_result($mostrar_municipio);
?>
