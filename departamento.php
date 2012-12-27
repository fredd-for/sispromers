<?php require_once('Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_mostrar_departamento = "SELECT idDepartamento,departamento FROM departamento WHERE idRegional = ".(int)$_GET['idRegional']." ORDER BY departamento ASC";
$mostrar_departamento = mysql_query($query_mostrar_departamento, $conexion) or die(mysql_error());
$row_mostrar_departamento = mysql_fetch_assoc($mostrar_departamento);
$totalRows_mostrar_departamento = mysql_num_rows($mostrar_departamento);
?>
<select id="x_idDepartamento" name="x_idDepartamento">
  <?php
do {  
?>
  <option value="<?php echo $row_mostrar_departamento['idDepartamento']?>" <?php if($row_mostrar_departamento['idDepartamento']==(int)$_GET['idDepartamento']){
	  echo("selected");
	  } ?>><?php echo utf8_encode($row_mostrar_departamento['departamento'])?></option>
  <?php
} while ($row_mostrar_departamento = mysql_fetch_assoc($mostrar_departamento));
  $rows = mysql_num_rows($mostrar_departamento);
  if($rows > 0) {
      mysql_data_seek($mostrar_departamento, 0);
	  $row_mostrar_departamento = mysql_fetch_assoc($mostrar_departamento);
  }
?>
</select>
<?php
mysql_free_result($mostrar_departamento);
?>
