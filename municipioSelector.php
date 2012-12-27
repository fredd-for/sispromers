<?php require_once('Connections/conexion.php'); ?>
<?php
// nos permite realizar una combinacion de regionales y departamentos para encontrar municipio
function combinaciones_municipio($regional,$departamento){
//combinaciones
    $combinacion_municipio=0;
    if($regional=='0' && $departamento=='0'){ $combinacion_municipio=1; return '1';}
    if($regional=='0' && $departamento>'0'){ $combinacion_municipio=2; return '2';}
    if($regional>'0' && $departamento>'0'){ $combinacion_municipio=3; return '3';}
    if($regional>'0' && $departamento=='0'){ $combinacion_municipio=4; return '4';}
    if($combinacion_municipio=='0'){
return '1';
}
}
$combinacion=combinaciones_municipio($_GET['idRegional'], $_GET['idDepartamento']);
mysql_select_db($database_conexion, $conexion);
$query_mostrar_municipio = "SELECT * FROM municipio WHERE case ".$combinacion." when 1 then idRegional>0 AND idDepartamento>0 when 2 then idRegional>0 and idDepartamento='".$_GET['idDepartamento']."' when 3 then idRegional='".$_GET['idRegional']."' and idDepartamento='".$_GET['idDepartamento']."' when 4 then idRegional='".$_GET['idRegional']."' and idDepartamento>0 end ORDER BY municipio asc";
$mostrar_municipio = mysql_query($query_mostrar_municipio, $conexion) or die(mysql_error());
$row_mostrar_municipio = mysql_fetch_assoc($mostrar_municipio);
$totalRows_mostrar_municipio = mysql_num_rows($mostrar_municipio);
?>
<select id="x_idMunicipio" name="x_idMunicipio">
    <option value="0" <?php if($_GET['idRegional']=='0' && $_GET['idDepartamento']=='0'){echo "selected";}?> style="color: gray">Todos...</option>
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
