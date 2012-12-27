<?php
//funcion indicador 1
function indicador1($idMer,$idRegional,$idDepartamento,$idMunicipio,$idComunidad,$idRubro,$gestion,$estado,$database_conexion,$conexion){

mysql_select_db($database_conexion, $conexion);
$query_mer= "SELECT * FROM mer a, regional b, departamento c, municipio d, comunidad f, rubro e
WHERE a.estado>0 AND a.idRegional=b.idRegional AND a.idDepartamento=c.idDepartamento AND a.idMunicipio=d.idMunicipio AND a.idComunidad=f.idComunidad AND a.idRubro=e.idRubro ";
if($idMer>'0'){
$query_mer.= " AND a.idMer=$idMer";
}
if($idRegional>'0'){
$query_mer.= " AND a.idRegional=$idRegional";
}
if($idDepartamento>'0'){
$query_mer.= " AND a.idDepartamento=$idDepartamento";
}
if($idMunicipio>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
}
if($idComunidad>'0'){
$query_mer.= " AND a.idComunidad=$idComunidad";
}
if($idRubro>'0'){
$query_mer.= " AND a.idRubro=$idRubro";
}
if($gestion>'0'){
$query_mer.= " AND a.gestion=$gestion";
}
$query_mer.= " ORDER BY b.regional asc, c.departamento asc, d.municipio, e.rubro";
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$total_mer=mysql_num_rows($mostrar_mer);
$contador=0;
$numero_cumple=0;
$numero_nocumple=0;
while ($row_mer=mysql_fetch_assoc($mostrar_mer)){

mysql_select_db($database_conexion, $conexion);
$query_formulario2 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=2";
$mostrar_formulario2= mysql_query($query_formulario2, $conexion) or die(mysql_error());
$row_formulario2= mysql_fetch_assoc($mostrar_formulario2);

mysql_select_db($database_conexion, $conexion);
$query_formulario3 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=3";
$mostrar_formulario3= mysql_query($query_formulario3, $conexion) or die(mysql_error());
$row_formulario3= mysql_fetch_assoc($mostrar_formulario3);

mysql_select_db($database_conexion, $conexion);
$query_formulario4 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=4";
$mostrar_formulario4= mysql_query($query_formulario4, $conexion) or die(mysql_error());
$row_formulario4= mysql_fetch_assoc($mostrar_formulario4);

mysql_select_db($database_conexion, $conexion);
$query_formulario5 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=5";
$mostrar_formulario5= mysql_query($query_formulario5, $conexion) or die(mysql_error());
$row_formulario5= mysql_fetch_assoc($mostrar_formulario5);

mysql_select_db($database_conexion, $conexion);
$query_formulario6= "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=6";
$mostrar_formulario6= mysql_query($query_formulario6, $conexion) or die(mysql_error());
$row_formulario6= mysql_fetch_assoc($mostrar_formulario6);

mysql_select_db($database_conexion, $conexion);
$query_formulario7 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=7";
$mostrar_formulario7= mysql_query($query_formulario7, $conexion) or die(mysql_error());
$row_formulario7= mysql_fetch_assoc($mostrar_formulario7);

mysql_select_db($database_conexion, $conexion);
$query_formulario8 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=8";
$mostrar_formulario8= mysql_query($query_formulario8, $conexion) or die(mysql_error());
$row_formulario8= mysql_fetch_assoc($mostrar_formulario8);

mysql_select_db($database_conexion, $conexion);
$query_formulario19 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=19";
$mostrar_formulario19= mysql_query($query_formulario19, $conexion) or die(mysql_error());
$row_formulario19= mysql_fetch_assoc($mostrar_formulario19);

mysql_select_db($database_conexion, $conexion);
$query_formulario10 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=10";
$mostrar_formulario10= mysql_query($query_formulario10, $conexion) or die(mysql_error());
$row_formulario10= mysql_fetch_assoc($mostrar_formulario10);

mysql_select_db($database_conexion, $conexion);
$query_formulario11 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=11";
$mostrar_formulario11= mysql_query($query_formulario11, $conexion) or die(mysql_error());
$row_formulario11= mysql_fetch_assoc($mostrar_formulario11);

mysql_select_db($database_conexion, $conexion);
$query_formulario17 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=17";
$mostrar_formulario17= mysql_query($query_formulario17, $conexion) or die(mysql_error());
$row_formulario17= mysql_fetch_assoc($mostrar_formulario17);

mysql_select_db($database_conexion, $conexion);
$query_formulario18 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=18";
$mostrar_formulario18= mysql_query($query_formulario18, $conexion) or die(mysql_error());
$row_formulario18= mysql_fetch_assoc($mostrar_formulario18);

mysql_select_db($database_conexion, $conexion);
$query_formulario21 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=21";
$mostrar_formulario21= mysql_query($query_formulario21, $conexion) or die(mysql_error());
$row_formulario21= mysql_fetch_assoc($mostrar_formulario21);

//planes /poas
$b3=$row_formulario3['cuenta']; $b2=$row_formulario2['cuenta']; $b4=$row_formulario4['cuenta']; $b5=$row_formulario5['cuenta']; $b6=$row_formulario6['cuenta'];
// formalizacion
$b7=$row_formulario7['cuenta']; $b19=$row_formulario19['cuenta']; $b8=$row_formulario8['cuenta']; $b10=$row_formulario10['cuenta']; $b11=$row_formulario11['cuenta'];$b9=$row_formulario9['cuenta'];
//reg ventas
$b17=$row_formulario17['cuenta'];
//parametros de calidad
$b21=$row_formulario21['cuenta'];
//condicionante
if(($b2=='SI' || $b3=='SI' || $b4=='SI'|| $b5=='SI' || $b6=='SI') && ($b7=='SI' || $b19=='SI' || $b8=='SI' || $b10=='SI' || $b11=='SI' || $b9=='SI') && ($b17=='SI') && ($b21=='SI')){$indicador2='1';$numero_cumple=$numero_cumple+1;}else{$indicador2='2';$numero_nocumple=$numero_nocumple+1;}
if($estado==$indicador2 || $estado=='0'){
$indicador_array['idMer'][$contador]=$row_mer['idMer'];
$indicador_array['regional'][$contador]=$row_mer['regional'];
$indicador_array['departamento'][$contador]=$row_mer['departamento'];
$indicador_array['municipio'][$contador]=$row_mer['municipio'];
$indicador_array['comunidad'][$contador]=$row_mer['comunidad'];
$indicador_array['zona'][$contador]=$row_mer['zona'];
$indicador_array['rubro'][$contador]=$row_mer['rubro'];
$indicador_array['mer'][$contador]=$row_mer['mer'];
$indicador_array['gestion'][$contador]=$row_mer['gestion'];

$indicador_array['planNegocio'][$contador]=$b2;
$indicador_array['planEstrategico'][$contador]=$b3;
$indicador_array['planProduccion'][$contador]=$b5;
$indicador_array['planFinanciero'][$contador]=$b4;
$indicador_array['planPoa'][$contador]=$b6;

$indicador_array['planNegocioDesc'][$contador]=$row_formulario2['observacion'];
$indicador_array['planEstrategicoDesc'][$contador]=$row_formulario3['observacion'];
$indicador_array['planProduccionDesc'][$contador]=$row_formulario5['observacion'];
$indicador_array['planFinancieroDesc'][$contador]=$row_formulario4['observacion'];
$indicador_array['planPoaDesc'][$contador]=$row_formulario6['observacion'];


$indicador_array['personeriaJuridica'][$contador]=$row_formulario19['cuenta'];
$indicador_array['estatutoOrganico'][$contador]=$row_formulario8['cuenta'];
$indicador_array['reglamentoInterno'][$contador]=$row_formulario9['cuenta'];
$indicador_array['regFundaempresa'][$contador]=$row_formulario11['cuenta'];
$indicador_array['actaConstitucion'][$contador]=$row_formulario7['cuenta'];
$indicador_array['tarjetaEmpresarial'][$contador]=$row_formulario10['cuenta'];

$indicador_array['personeriaJuridicaDesc'][$contador]=$row_formulario19['observacion'];
$indicador_array['estatutoOrganicoDesc'][$contador]=$row_formulario8['observacion'];
$indicador_array['reglamentoInternoDesc'][$contador]=$row_formulario9['observacion'];
$indicador_array['regFundaempresaDesc'][$contador]=$row_formulario11['observacion'];
$indicador_array['actaConstitucionDesc'][$contador]=$row_formulario7['observacion'];
$indicador_array['tarjetaEmpresarialDesc'][$contador]=$row_formulario10['observacion'];

$indicador_array['regVentas'][$contador]=$row_formulario17['cuenta'];
$indicador_array['regVentasDesc'][$contador]=$row_formulario17['observacion'];
$indicador_array['regVentasMonto'][$contador]=$row_formulario17['porcentaje'];

$indicador_array['parCalidad'][$contador]=$b21;
$indicador_array['parCalidadDesc'][$contador]=$row_formulario21['observacion'];

$indicador_array['estado'][$contador]=$indicador2;

$contador++;
}
}
return $indicador_array;
}

function indicador1_cantidad($idMer,$idRegional,$idDepartamento,$idMunicipio,$idComunidad,$idRubro,$gestion,$database_conexion,$conexion){
$query_merTotal="SELECT a.idMer FROM mer a WHERE a.estado>0";
$query_mer= "SELECT a.idMer FROM mer a WHERE a.estado>0
AND
((SELECT cuenta FROM formulario WHERE idPlanilla=2 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=3 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=4 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=5 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=6 AND idMer=a.idMer)='SI'
)
AND
((SELECT cuenta FROM formulario WHERE idPlanilla=19 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=8 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=9 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=11 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=7 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=10 AND idMer=a.idMer)='SI'
)
AND
((SELECT cuenta FROM formulario WHERE idPlanilla=17 AND idMer=a.idMer)='SI'
)
AND
((SELECT cuenta FROM formulario WHERE idPlanilla=21 AND idMer=a.idMer)='SI'
)
";
if($idMer>'0'){
$query_mer.= " AND a.idMer=$idMer";
$query_merTotal.= " AND a.idMer=$idMer";
}
if($idRegional>'0'){
$query_mer.= " AND a.idRegional=$idRegional";
$query_merTotal.= " AND a.idRegional=$idRegional";
}
if($idDepartamento>'0'){
$query_mer.= " AND a.idDepartamento=$idDepartamento";
$query_merTotal.= " AND a.idDepartamento=$idDepartamento";
}
if($idMunicipio>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
$query_merTotal.= " AND a.idMunicipio=$idMunicipio";
}
if($idComunidad>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
$query_merTotal.= " AND a.idMunicipio=$idMunicipio";
}
if($idRubro>'0'){
$query_mer.= " AND a.idRubro=$idRubro";
$query_merTotal.= " AND a.idRubro=$idRubro";
}
if($gestion>'0'){
$query_mer.= " AND a.gestion=$gestion";
$query_merTotal.= " AND a.gestion=$gestion";
}

mysql_select_db($database_conexion, $conexion);
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$total_mer=mysql_num_rows($mostrar_mer);

mysql_select_db($database_conexion, $conexion);
$mostrar_merTotal=mysql_query($query_merTotal, $conexion) or die(mysql_error());
$total_merTotal=mysql_num_rows($mostrar_merTotal);

$cantidadArray['cumple']=$total_mer;
$cantidadArray['nocumple']=$total_merTotal-$total_mer;
$cantidadArray['total']=$total_merTotal;
return $cantidadArray;
}

// funcion indicador 2

function indicador2($idMer,$idRegional,$idDepartamento,$idMunicipio,$idComunidad,$idRubro,$gestion,$estado,$database_conexion,$conexion){

mysql_select_db($database_conexion, $conexion);
$query_mer= "SELECT * FROM mer a, regional b, departamento c, municipio d, comunidad f, rubro e
WHERE a.estado>0 AND a.idRegional=b.idRegional AND a.idDepartamento=c.idDepartamento AND a.idMunicipio=d.idMunicipio AND a.idComunidad=f.idComunidad AND a.idRubro=e.idRubro ";
if($idMer>'0'){
$query_mer.= " AND a.idMer=$idMer";
}
if($idRegional>'0'){
$query_mer.= " AND a.idRegional=$idRegional";
}
if($idDepartamento>'0'){
$query_mer.= " AND a.idDepartamento=$idDepartamento";
}
if($idMunicipio>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
}
if($idComunidad>'0'){
$query_mer.= " AND a.idComunidad=$idComunidad";
}
if($idRubro>'0'){
$query_mer.= " AND a.idRubro=$idRubro";
}
if($gestion>'0'){
$query_mer.= " AND a.gestion=$gestion";
}
$query_mer.= " ORDER BY b.regional asc, c.departamento asc, d.municipio, e.rubro";
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$total_mer=mysql_num_rows($mostrar_mer);
$contador=0;
$numero_cumple=0;
$numero_nocumple=0;
while ($row_mer=mysql_fetch_assoc($mostrar_mer)){

mysql_select_db($database_conexion, $conexion);
$query_empleos = "SELECT sum(certConformidad) as empleos FROM contrato_llenar WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=20 AND completo='SI'";
$mostrar_empleos= mysql_query($query_empleos, $conexion) or die(mysql_error());
$row_empleos= mysql_fetch_assoc($mostrar_empleos);

//mysql_select_db($database_conexion, $conexion);
//$query_nrocontratos = "SELECT sum(a.nroContrato) as nroContrato, a.idTipoContrato, b.tipoContrato FROM contrato_llenar a, tipo_contrato b WHERE a.idMer='".$row_mer['idMer']."' AND a.idPlanilla=20 AND a.completo='SI' AND a.idTipoContrato=b.idTipoContrato GROUP BY a.idTipoContrato";
//$mostrar_nrocontratos = mysql_query($query_nrocontratos, $conexion) or die(mysql_error());
//
//mysql_select_db($database_conexion, $conexion);
//$query_nroregistros = "SELECT sum(a.nroContrato) as nroContrato, a.idRegistroContrato, b.registroContrato FROM contrato_llenar a, registro_contrato b WHERE a.idMer='".$row_mer['idMer']."' AND a.idPlanilla=20 AND a.completo='SI' AND a.idRegistroContrato=b.idRegistroContrato GROUP BY a.idRegistroContrato";
//$mostrar_nroregistros= mysql_query($query_nroregistros, $conexion) or die(mysql_error());

//condicionante
if($row_empleos['empleos']>0){$indicador2='1';$numero_cumple=$numero_cumple+1;}else{$indicador2='0';$numero_nocumple=$numero_nocumple+1;}
if($estado==$indicador2 || $estado=='0'){

$indicador_array['idMer'][$contador]=$row_mer['idMer'];
$indicador_array['regional'][$contador]=$row_mer['regional'];
$indicador_array['departamento'][$contador]=$row_mer['departamento'];
$indicador_array['municipio'][$contador]=$row_mer['municipio'];
$indicador_array['comunidad'][$contador]=$row_mer['comunidad'];
$indicador_array['zona'][$contador]=$row_mer['zona'];
$indicador_array['rubro'][$contador]=$row_mer['rubro'];
$indicador_array['mer'][$contador]=$row_mer['mer'];
$indicador_array['gestion'][$contador]=$row_mer['gestion'];
$indicador_array['nroEmpleos'][$contador]=$row_empleos['empleos'];
$indicador_array['estado'][$contador]=$indicador2;

$contador++;
}
}
return $indicador_array;
}

function indicador2_cantidad($idMer,$idRegional,$idDepartamento,$idMunicipio,$idComunidad,$idRubro,$gestion,$database_conexion,$conexion){
$query_mer= "SELECT sum((SELECT sum(certConformidad) FROM contrato_llenar
    WHERE idMer=a.idMer AND idPlanilla=20 AND completo='SI')) as empleos
    FROM mer a WHERE a.estado>0 ";
if($idMer>'0'){
$query_mer.= " AND a.idMer=$idMer";
}
if($idRegional>'0'){
$query_mer.= " AND a.idRegional=$idRegional";
}
if($idDepartamento>'0'){
$query_mer.= " AND a.idDepartamento=$idDepartamento";
}
if($idMunicipio>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
}
if($idComunidad>'0'){
$query_mer.= " AND a.idComunidad=$idComunidad";
}
if($idRubro>'0'){
$query_mer.= " AND a.idRubro=$idRubro";
}
if($gestion>'0'){
$query_mer.= " AND a.gestion=$gestion";
}
mysql_select_db($database_conexion, $conexion);
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$row_mer=mysql_fetch_assoc($mostrar_mer);

$indicador_array['cumple']=$row_mer['empleos'];
return $indicador_array;
}
function indicador3_cantidad($idMer,$idRegional,$idDepartamento,$idMunicipio,$idComunidad,$idRubro,$gestion,$database_conexion,$conexion){
$query_mer= "SELECT idMunicipio FROM mer WHERE estado>0 AND idMer IN(SELECT idMer FROM formulario WHERE idPlanilla=12 AND cuenta='SI') ";
if($idMer>'0'){
$query_mer.= " AND idMer=$idMer";
}
if($idRegional>'0'){
$query_mer.= " AND idRegional=$idRegional";
}
if($idDepartamento>'0'){
$query_mer.= " AND idDepartamento=$idDepartamento";
}
if($idMunicipio>'0'){
$query_mer.= " AND idMunicipio=$idMunicipio";
}
if($idComunidad>'0'){
$query_mer.= " AND idComunidad=$idComunidad";
}
if($idRubro>'0'){
$query_mer.= " AND idRubro=$idRubro";
}
if($gestion>'0'){
$query_mer.= " AND gestion=$gestion";
}
$query_mer.=" GROUP BY idMunicipio";
mysql_select_db($database_conexion, $conexion);
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$row_mer=mysql_fetch_assoc($mostrar_mer);
$total_mer=mysql_num_rows($mostrar_mer);

$indicador_array['cumple']=$total_mer;
return $indicador_array;
}
// funcion indicador 4

function indicador4($idMer,$idRegional,$idDepartamento,$idMunicipio,$idComunidad,$idRubro,$gestion,$estado,$database_conexion,$conexion){

mysql_select_db($database_conexion, $conexion);
$query_mer= "SELECT * FROM mer a, regional b, departamento c, municipio d, comunidad f, rubro e
WHERE a.estado>0 AND a.idRegional=b.idRegional AND a.idDepartamento=c.idDepartamento AND a.idMunicipio=d.idMunicipio AND a.idComunidad=f.idComunidad AND a.idRubro=e.idRubro ";
if($idMer>'0'){
$query_mer.= " AND a.idMer=$idMer";
}
if($idRegional>'0'){
$query_mer.= " AND a.idRegional=$idRegional";
}
if($idDepartamento>'0'){
$query_mer.= " AND a.idDepartamento=$idDepartamento";
}
if($idMunicipio>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
}
if($idComunidad>'0'){
$query_mer.= " AND a.idComunidad=$idComunidad";
}
if($idRubro>'0'){
$query_mer.= " AND a.idRubro=$idRubro";
}
if($gestion>'0'){
$query_mer.= " AND a.gestion=$gestion";
}
$query_mer.= " ORDER BY b.regional asc, c.departamento asc, d.municipio, e.rubro";
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$total_mer=mysql_num_rows($mostrar_mer);
$contador=0;
$numero_cumple=0;
$numero_nocumple=0;
while ($row_mer=mysql_fetch_assoc($mostrar_mer)){

mysql_select_db($database_conexion, $conexion);
$query_formulario14 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=14";
$mostrar_formulario14= mysql_query($query_formulario14, $conexion) or die(mysql_error());
$row_formulario14= mysql_fetch_assoc($mostrar_formulario14);

//condicionante
if($row_formulario14['cumple']=='SI'){$indicador2='1';$numero_cumple=$numero_cumple+1;}else{$indicador2='0';$numero_nocumple=$numero_nocumple+1;}
if($estado==$indicador2 || $estado=='0'){

$indicador_array['idMer'][$contador]=$row_mer['idMer'];
$indicador_array['regional'][$contador]=$row_mer['regional'];
$indicador_array['departamento'][$contador]=$row_mer['departamento'];
$indicador_array['municipio'][$contador]=$row_mer['municipio'];
$indicador_array['comunidad'][$contador]=$row_mer['comunidad'];
$indicador_array['zona'][$contador]=$row_mer['zona'];
$indicador_array['rubro'][$contador]=$row_mer['rubro'];
$indicador_array['mer'][$contador]=$row_mer['mer'];
$indicador_array['gestion'][$contador]=$row_mer['gestion'];
$indicador_array['nroEmpleos'][$contador]=$row_empleos['empleos'];

$indicador_array['alianza'][$contador]=$row_formulario14['cuenta'];
$indicador_array['alianzaDesc'][$contador]=$row_formulario14['observacion'];

$indicador_array['estado'][$contador]=$indicador2;

$contador++;
}
}
return $indicador_array;
}

function indicador4_cantidad($idMer,$idRegional,$idDepartamento,$idMunicipio,$idComunidad,$idRubro,$gestion,$database_conexion,$conexion){
$query_mer= "SELECT a.idMunicipio 
    FROM mer a, formulario b 
    WHERE a.estado>0 AND a.idMer=b.idMer AND b.idPlanilla=14 AND b.cuenta='SI' ";
if($idMer>'0'){
$query_mer.= " AND a.idMer=$idMer";
}
if($idRegional>'0'){
$query_mer.= " AND a.idRegional=$idRegional";
}
if($idDepartamento>'0'){
$query_mer.= " AND a.idDepartamento=$idDepartamento";
}
if($idMunicipio>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
}
if($idComunidad>'0'){
$query_mer.= " AND a.idComunidad=$idComunidad";
}
if($idRubro>'0'){
$query_mer.= " AND a.idRubro=$idRubro";
}
if($gestion>'0'){
$query_mer.= " AND a.gestion=$gestion";
}
$query_mer.= " GROUP BY a.idMunicipio";
mysql_select_db($database_conexion, $conexion);
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$total_mer=mysql_num_rows($mostrar_mer);
$indicador_array['cumple']=$total_mer;
return $indicador_array;
}
//funcion indicador 5
function indicador5($idMer,$idRegional,$idDepartamento,$idMunicipio,$idComunidad,$idRubro,$gestion,$estado,$database_conexion,$conexion){

mysql_select_db($database_conexion, $conexion);
$query_mer= "SELECT * FROM mer a, regional b, departamento c, municipio d, comunidad f, rubro e
WHERE a.estado>0 AND a.idRegional=b.idRegional AND a.idDepartamento=c.idDepartamento AND a.idMunicipio=d.idMunicipio AND a.idComunidad=f.idComunidad AND a.idRubro=e.idRubro ";
if($idMer>'0'){
$query_mer.= " AND a.idMer=$idMer";
}
if($idRegional>'0'){
$query_mer.= " AND a.idRegional=$idRegional";
}
if($idDepartamento>'0'){
$query_mer.= " AND a.idDepartamento=$idDepartamento";
}
if($idMunicipio>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
}
if($idComunidad>'0'){
$query_mer.= " AND a.idComunidad=$idComunidad";
}
if($idRubro>'0'){
$query_mer.= " AND a.idRubro=$idRubro";
}
if($gestion>'0'){
$query_mer.= " AND a.gestion=$gestion";
}
$query_mer.= " ORDER BY b.regional asc, c.departamento asc, d.municipio, e.rubro";
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$total_mer=mysql_num_rows($mostrar_mer);
$contador=0;
$numero_cumple=0;
$numero_nocumple=0;
while ($row_mer=mysql_fetch_assoc($mostrar_mer)){

mysql_select_db($database_conexion, $conexion);
$query_formulario6= "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=6";
$mostrar_formulario6= mysql_query($query_formulario6, $conexion) or die(mysql_error());
$row_formulario6= mysql_fetch_assoc($mostrar_formulario6);

mysql_select_db($database_conexion, $conexion);
$query_formulario7 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=7";
$mostrar_formulario7= mysql_query($query_formulario7, $conexion) or die(mysql_error());
$row_formulario7= mysql_fetch_assoc($mostrar_formulario7);

mysql_select_db($database_conexion, $conexion);
$query_formulario8 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=8";
$mostrar_formulario8= mysql_query($query_formulario8, $conexion) or die(mysql_error());
$row_formulario8= mysql_fetch_assoc($mostrar_formulario8);

mysql_select_db($database_conexion, $conexion);
$query_formulario19 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=19";
$mostrar_formulario19= mysql_query($query_formulario19, $conexion) or die(mysql_error());
$row_formulario19= mysql_fetch_assoc($mostrar_formulario19);

mysql_select_db($database_conexion, $conexion);
$query_formulario10 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=10";
$mostrar_formulario10= mysql_query($query_formulario10, $conexion) or die(mysql_error());
$row_formulario10= mysql_fetch_assoc($mostrar_formulario10);

mysql_select_db($database_conexion, $conexion);
$query_formulario11 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=11";
$mostrar_formulario11= mysql_query($query_formulario11, $conexion) or die(mysql_error());
$row_formulario11= mysql_fetch_assoc($mostrar_formulario11);

// formalizacion
$b7=$row_formulario7['cuenta']; $b19=$row_formulario19['cuenta']; $b8=$row_formulario8['cuenta']; $b10=$row_formulario10['cuenta']; $b11=$row_formulario11['cuenta'];$b9=$row_formulario9['cuenta'];
//condicionante
if($b7=='SI' || $b19=='SI' || $b8=='SI' || $b10=='SI' || $b11=='SI' || $b9=='SI'){$indicador2='1';$numero_cumple=$numero_cumple+1;}else{$indicador2='2';$numero_nocumple=$numero_nocumple+1;}
if($estado==$indicador2 || $estado=='0'){
$indicador_array['idMer'][$contador]=$row_mer['idMer'];
$indicador_array['regional'][$contador]=$row_mer['regional'];
$indicador_array['departamento'][$contador]=$row_mer['departamento'];
$indicador_array['municipio'][$contador]=$row_mer['municipio'];
$indicador_array['comunidad'][$contador]=$row_mer['comunidad'];
$indicador_array['zona'][$contador]=$row_mer['zona'];
$indicador_array['rubro'][$contador]=$row_mer['rubro'];
$indicador_array['mer'][$contador]=$row_mer['mer'];
$indicador_array['gestion'][$contador]=$row_mer['gestion'];

$indicador_array['personeriaJuridica'][$contador]=$row_formulario19['cuenta'];
$indicador_array['estatutoOrganico'][$contador]=$row_formulario8['cuenta'];
$indicador_array['reglamentoInterno'][$contador]=$row_formulario9['cuenta'];
$indicador_array['regFundaempresa'][$contador]=$row_formulario11['cuenta'];
$indicador_array['actaConstitucion'][$contador]=$row_formulario7['cuenta'];
$indicador_array['tarjetaEmpresarial'][$contador]=$row_formulario10['cuenta'];

$indicador_array['personeriaJuridicaDesc'][$contador]=$row_formulario19['observacion'];
$indicador_array['estatutoOrganicoDesc'][$contador]=$row_formulario8['observacion'];
$indicador_array['reglamentoInternoDesc'][$contador]=$row_formulario9['observacion'];
$indicador_array['regFundaempresaDesc'][$contador]=$row_formulario11['observacion'];
$indicador_array['actaConstitucionDesc'][$contador]=$row_formulario7['observacion'];
$indicador_array['tarjetaEmpresarialDesc'][$contador]=$row_formulario10['observacion'];

$indicador_array['estado'][$contador]=$indicador2;

$contador++;
}
}
return $indicador_array;
}

function indicador5_cantidad($idMer,$idRegional,$idDepartamento,$idMunicipio,$idComunidad,$idRubro,$gestion,$database_conexion,$conexion){
$query_merTotal="SELECT a.idMer FROM mer a WHERE a.estado>0";
$query_mer= "SELECT a.idMer FROM mer a WHERE a.estado>0
AND
((SELECT cuenta FROM formulario WHERE idPlanilla=19 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=8 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=9 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=11 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=7 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=10 AND idMer=a.idMer)='SI'
)
";
if($idMer>'0'){
$query_mer.= " AND a.idMer=$idMer";
$query_merTotal.= " AND a.idMer=$idMer";
}
if($idRegional>'0'){
$query_mer.= " AND a.idRegional=$idRegional";
$query_merTotal.= " AND a.idRegional=$idRegional";
}
if($idDepartamento>'0'){
$query_mer.= " AND a.idDepartamento=$idDepartamento";
$query_merTotal.= " AND a.idDepartamento=$idDepartamento";
}
if($idMunicipio>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
$query_merTotal.= " AND a.idMunicipio=$idMunicipio";
}
if($idComunidad>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
$query_merTotal.= " AND a.idMunicipio=$idMunicipio";
}
if($idRubro>'0'){
$query_mer.= " AND a.idRubro=$idRubro";
$query_merTotal.= " AND a.idRubro=$idRubro";
}
if($gestion>'0'){
$query_mer.= " AND a.gestion=$gestion";
$query_merTotal.= " AND a.gestion=$gestion";
}

mysql_select_db($database_conexion, $conexion);
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$total_mer=mysql_num_rows($mostrar_mer);

mysql_select_db($database_conexion, $conexion);
$mostrar_merTotal=mysql_query($query_merTotal, $conexion) or die(mysql_error());
$total_merTotal=mysql_num_rows($mostrar_merTotal);

$cantidadArray['cumple']=$total_mer;
$cantidadArray['nocumple']=$total_merTotal-$total_mer;
$cantidadArray['total']=$total_merTotal;
return $cantidadArray;
}

//funcion indicador 6
function indicador6($idMer,$idRegional,$idDepartamento,$idMunicipio,$idComunidad,$idRubro,$gestion,$estado,$database_conexion,$conexion){

mysql_select_db($database_conexion, $conexion);
$query_mer= "SELECT * FROM mer a, regional b, departamento c, municipio d, comunidad f, rubro e
WHERE a.estado>0 AND a.idRegional=b.idRegional AND a.idDepartamento=c.idDepartamento AND a.idMunicipio=d.idMunicipio AND a.idComunidad=f.idComunidad AND a.idRubro=e.idRubro ";
if($idMer>'0'){
$query_mer.= " AND a.idMer=$idMer";
}
if($idRegional>'0'){
$query_mer.= " AND a.idRegional=$idRegional";
}
if($idDepartamento>'0'){
$query_mer.= " AND a.idDepartamento=$idDepartamento";
}
if($idMunicipio>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
}
if($idComunidad>'0'){
$query_mer.= " AND a.idComunidad=$idComunidad";
}
if($idRubro>'0'){
$query_mer.= " AND a.idRubro=$idRubro";
}
if($gestion>'0'){
$query_mer.= " AND a.gestion=$gestion";
}
$query_mer.= " ORDER BY b.regional asc, c.departamento asc, d.municipio, e.rubro";
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$total_mer=mysql_num_rows($mostrar_mer);
$contador=0;
$numero_cumple=0;
$numero_nocumple=0;
while ($row_mer=mysql_fetch_assoc($mostrar_mer)){

mysql_select_db($database_conexion, $conexion);
$query_formulario2 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=2";
$mostrar_formulario2= mysql_query($query_formulario2, $conexion) or die(mysql_error());
$row_formulario2= mysql_fetch_assoc($mostrar_formulario2);

mysql_select_db($database_conexion, $conexion);
$query_formulario3 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=3";
$mostrar_formulario3= mysql_query($query_formulario3, $conexion) or die(mysql_error());
$row_formulario3= mysql_fetch_assoc($mostrar_formulario3);

mysql_select_db($database_conexion, $conexion);
$query_formulario4 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=4";
$mostrar_formulario4= mysql_query($query_formulario4, $conexion) or die(mysql_error());
$row_formulario4= mysql_fetch_assoc($mostrar_formulario4);

mysql_select_db($database_conexion, $conexion);
$query_formulario5 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=5";
$mostrar_formulario5= mysql_query($query_formulario5, $conexion) or die(mysql_error());
$row_formulario5= mysql_fetch_assoc($mostrar_formulario5);

mysql_select_db($database_conexion, $conexion);
$query_formulario6= "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=6";
$mostrar_formulario6= mysql_query($query_formulario6, $conexion) or die(mysql_error());
$row_formulario6= mysql_fetch_assoc($mostrar_formulario6);

mysql_select_db($database_conexion, $conexion);
$query_formulario17 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=17";
$mostrar_formulario17= mysql_query($query_formulario17, $conexion) or die(mysql_error());
$row_formulario17= mysql_fetch_assoc($mostrar_formulario17);

//planes /poas
$b3=$row_formulario3['cuenta']; $b2=$row_formulario2['cuenta']; $b4=$row_formulario4['cuenta']; $b5=$row_formulario5['cuenta']; $b6=$row_formulario6['cuenta'];
//reg ventas
$b17=$row_formulario17['cuenta'];
//condicionante
if(($b2=='SI' || $b3=='SI' || $b4=='SI'|| $b5=='SI' || $b6=='SI') && ($b17=='SI')){$indicador2='1';$numero_cumple=$numero_cumple+1;}else{$indicador2='2';$numero_nocumple=$numero_nocumple+1;}
if($estado==$indicador2 || $estado=='0'){
$indicador_array['idMer'][$contador]=$row_mer['idMer'];
$indicador_array['regional'][$contador]=$row_mer['regional'];
$indicador_array['departamento'][$contador]=$row_mer['departamento'];
$indicador_array['municipio'][$contador]=$row_mer['municipio'];
$indicador_array['comunidad'][$contador]=$row_mer['comunidad'];
$indicador_array['zona'][$contador]=$row_mer['zona'];
$indicador_array['rubro'][$contador]=$row_mer['rubro'];
$indicador_array['mer'][$contador]=$row_mer['mer'];
$indicador_array['gestion'][$contador]=$row_mer['gestion'];

$indicador_array['planNegocio'][$contador]=$b2;
$indicador_array['planEstrategico'][$contador]=$b3;
$indicador_array['planProduccion'][$contador]=$b5;
$indicador_array['planFinanciero'][$contador]=$b4;
$indicador_array['planPoa'][$contador]=$b6;

$indicador_array['planNegocioDesc'][$contador]=$row_formulario2['observacion'];
$indicador_array['planEstrategicoDesc'][$contador]=$row_formulario3['observacion'];
$indicador_array['planProduccionDesc'][$contador]=$row_formulario5['observacion'];
$indicador_array['planFinancieroDesc'][$contador]=$row_formulario4['observacion'];
$indicador_array['planPoaDesc'][$contador]=$row_formulario6['observacion'];

$indicador_array['regVentas'][$contador]=$row_formulario17['cuenta'];
$indicador_array['regVentasDesc'][$contador]=$row_formulario17['observacion'];
$indicador_array['regVentasMonto'][$contador]=$row_formulario17['porcentaje'];

$indicador_array['estado'][$contador]=$indicador2;

$contador++;
}
}
return $indicador_array;
}

function indicador6_cantidad($idMer,$idRegional,$idDepartamento,$idMunicipio,$idComunidad,$idRubro,$gestion,$database_conexion,$conexion){
$query_merTotal="SELECT a.idMer FROM mer a WHERE a.estado>0";
$query_mer= "SELECT a.idMer FROM mer a WHERE a.estado>0
AND
((SELECT cuenta FROM formulario WHERE idPlanilla=2 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=3 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=4 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=5 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=6 AND idMer=a.idMer)='SI'
)
AND
((SELECT cuenta FROM formulario WHERE idPlanilla=17 AND idMer=a.idMer)='SI'
)
";
if($idMer>'0'){
$query_mer.= " AND a.idMer=$idMer";
$query_merTotal.= " AND a.idMer=$idMer";
}
if($idRegional>'0'){
$query_mer.= " AND a.idRegional=$idRegional";
$query_merTotal.= " AND a.idRegional=$idRegional";
}
if($idDepartamento>'0'){
$query_mer.= " AND a.idDepartamento=$idDepartamento";
$query_merTotal.= " AND a.idDepartamento=$idDepartamento";
}
if($idMunicipio>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
$query_merTotal.= " AND a.idMunicipio=$idMunicipio";
}
if($idComunidad>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
$query_merTotal.= " AND a.idMunicipio=$idMunicipio";
}
if($idRubro>'0'){
$query_mer.= " AND a.idRubro=$idRubro";
$query_merTotal.= " AND a.idRubro=$idRubro";
}
if($gestion>'0'){
$query_mer.= " AND a.gestion=$gestion";
$query_merTotal.= " AND a.gestion=$gestion";
}

mysql_select_db($database_conexion, $conexion);
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$total_mer=mysql_num_rows($mostrar_mer);

mysql_select_db($database_conexion, $conexion);
$mostrar_merTotal=mysql_query($query_merTotal, $conexion) or die(mysql_error());
$total_merTotal=mysql_num_rows($mostrar_merTotal);

$cantidadArray['cumple']=$total_mer;
$cantidadArray['nocumple']=$total_merTotal-$total_mer;
$cantidadArray['total']=$total_merTotal;
return $cantidadArray;
}

//funcion indicador 7
function indicador7($idMer,$idRegional,$idDepartamento,$idMunicipio,$idComunidad,$idRubro,$gestion,$estado,$database_conexion,$conexion){

mysql_select_db($database_conexion, $conexion);
$query_mer= "SELECT * FROM mer a, regional b, departamento c, municipio d, comunidad f, rubro e
WHERE a.estado>0 AND a.idRegional=b.idRegional AND a.idDepartamento=c.idDepartamento AND a.idMunicipio=d.idMunicipio AND a.idComunidad=f.idComunidad AND a.idRubro=e.idRubro ";
if($idMer>'0'){
$query_mer.= " AND a.idMer=$idMer";
}
if($idRegional>'0'){
$query_mer.= " AND a.idRegional=$idRegional";
}
if($idDepartamento>'0'){
$query_mer.= " AND a.idDepartamento=$idDepartamento";
}
if($idMunicipio>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
}
if($idComunidad>'0'){
$query_mer.= " AND a.idComunidad=$idComunidad";
}
if($idRubro>'0'){
$query_mer.= " AND a.idRubro=$idRubro";
}
if($gestion>'0'){
$query_mer.= " AND a.gestion=$gestion";
}
$query_mer.= " ORDER BY b.regional asc, c.departamento asc, d.municipio, e.rubro";
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$total_mer=mysql_num_rows($mostrar_mer);
$contador=0;
$numero_cumple=0;
$numero_nocumple=0;
while ($row_mer=mysql_fetch_assoc($mostrar_mer)){

mysql_select_db($database_conexion, $conexion);
$query_formulario16 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=16";
$mostrar_formulario16= mysql_query($query_formulario16, $conexion) or die(mysql_error());
$row_formulario16= mysql_fetch_assoc($mostrar_formulario16);
$totalRows_formulario16=mysql_num_rows($mostrar_formulario16);

mysql_select_db($database_conexion, $conexion);
$query_obtencionCredito = "SELECT sum(montoSolicitado) as prestamo FROM obtencion_credito16 WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=16 GROUP BY idMer";
$mostrar_obtencionCredito= mysql_query($query_obtencionCredito, $conexion) or die(mysql_error());
$row_obtencionCredito= mysql_fetch_assoc($mostrar_obtencionCredito);
$totalRows_obtencionCredito=mysql_num_rows($mostrar_obtencionCredito);

//condicionante
if($row_formulario16['cuenta']=='SI'){$indicador2='1';$numero_cumple=$numero_cumple+1;}else{$indicador2='2';$numero_nocumple=$numero_nocumple+1;}

if($estado==$indicador2 || $estado=='0'){
$indicador_array['idMer'][$contador]=$row_mer['idMer'];
$indicador_array['regional'][$contador]=$row_mer['regional'];
$indicador_array['departamento'][$contador]=$row_mer['departamento'];
$indicador_array['municipio'][$contador]=$row_mer['municipio'];
$indicador_array['comunidad'][$contador]=$row_mer['comunidad'];
$indicador_array['zona'][$contador]=$row_mer['zona'];
$indicador_array['rubro'][$contador]=$row_mer['rubro'];
$indicador_array['mer'][$contador]=$row_mer['mer'];
$indicador_array['gestion'][$contador]=$row_mer['gestion'];

$indicador_array['obtencionCredito'][$contador]=$row_formulario16['cuenta'];
$indicador_array['obtencionCreditoDesc'][$contador]=$row_formulario16['observacion'];
$indicador_array['prestamo'][$contador]=$row_obtencionCredito['prestamo'];

$indicador_array['estado'][$contador]=$indicador2;

$contador++;
}
}
return $indicador_array;
}

function indicador7_cantidad($idMer,$idRegional,$idDepartamento,$idMunicipio,$idComunidad,$idRubro,$gestion,$database_conexion,$conexion){
$query_mer= "SELECT a.idMer FROM mer a WHERE a.estado>0
AND
(SELECT cuenta FROM formulario WHERE idPlanilla=16 AND idMer=a.idMer)='SI'
";
if($idMer>'0'){
$query_mer.= " AND a.idMer=$idMer";
}
if($idRegional>'0'){
$query_mer.= " AND a.idRegional=$idRegional";
}
if($idDepartamento>'0'){
$query_mer.= " AND a.idDepartamento=$idDepartamento";
}
if($idMunicipio>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
}
if($idComunidad>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
}
if($idRubro>'0'){
$query_mer.= " AND a.idRubro=$idRubro";
}
if($gestion>'0'){
$query_mer.= " AND a.gestion=$gestion";
}

mysql_select_db($database_conexion, $conexion);
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$total_mer=mysql_num_rows($mostrar_mer);

$cantidadArray['cumple']=$total_mer;

return $cantidadArray;
}

//funcion indicador 8
function indicador8($idMer,$idRegional,$idDepartamento,$idMunicipio,$idComunidad,$idRubro,$gestion,$estado,$database_conexion,$conexion){

mysql_select_db($database_conexion, $conexion);
$query_mer= "SELECT * FROM mer a, regional b, departamento c, municipio d, comunidad f, rubro e
WHERE a.estado>0 AND a.idRegional=b.idRegional AND a.idDepartamento=c.idDepartamento AND a.idMunicipio=d.idMunicipio AND a.idComunidad=f.idComunidad AND a.idRubro=e.idRubro ";
if($idMer>'0'){
$query_mer.= " AND a.idMer=$idMer";
}
if($idRegional>'0'){
$query_mer.= " AND a.idRegional=$idRegional";
}
if($idDepartamento>'0'){
$query_mer.= " AND a.idDepartamento=$idDepartamento";
}
if($idMunicipio>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
}
if($idComunidad>'0'){
$query_mer.= " AND a.idComunidad=$idComunidad";
}
if($idRubro>'0'){
$query_mer.= " AND a.idRubro=$idRubro";
}
if($gestion>'0'){
$query_mer.= " AND a.gestion=$gestion";
}
$query_mer.= " ORDER BY b.regional asc, c.departamento asc, d.municipio, e.rubro";
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$total_mer=mysql_num_rows($mostrar_mer);
$contador=0;
$numero_cumple=0;
$numero_nocumple=0;
while ($row_mer=mysql_fetch_assoc($mostrar_mer)){

mysql_select_db($database_conexion, $conexion);
$query_formulario16 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=16";
$mostrar_formulario16= mysql_query($query_formulario16, $conexion) or die(mysql_error());
$row_formulario16= mysql_fetch_assoc($mostrar_formulario16);
$totalRows_formulario16=mysql_num_rows($mostrar_formulario16);

mysql_select_db($database_conexion, $conexion);
$query_obtencionCredito = "SELECT sum(montoSolicitado) as prestamo FROM obtencion_credito16 WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=16 GROUP BY idMer";
$mostrar_obtencionCredito= mysql_query($query_obtencionCredito, $conexion) or die(mysql_error());
$row_obtencionCredito= mysql_fetch_assoc($mostrar_obtencionCredito);
$totalRows_obtencionCredito=mysql_num_rows($mostrar_obtencionCredito);

//condicionante
if($row_formulario16['porcentaje']=='SI'){$indicador2='1';$numero_cumple=$numero_cumple+1;}else{$indicador2='2';$numero_nocumple=$numero_nocumple+1;}

if($estado==$indicador2 || $estado=='0'){
$indicador_array['idMer'][$contador]=$row_mer['idMer'];
$indicador_array['regional'][$contador]=$row_mer['regional'];
$indicador_array['departamento'][$contador]=$row_mer['departamento'];
$indicador_array['municipio'][$contador]=$row_mer['municipio'];
$indicador_array['comunidad'][$contador]=$row_mer['comunidad'];
$indicador_array['zona'][$contador]=$row_mer['zona'];
$indicador_array['rubro'][$contador]=$row_mer['rubro'];
$indicador_array['mer'][$contador]=$row_mer['mer'];
$indicador_array['gestion'][$contador]=$row_mer['gestion'];

$indicador_array['obtencionCredito'][$contador]=$row_formulario16['cuenta'];
$indicador_array['obtencionCreditoDesc'][$contador]=$row_formulario16['observacion'];
$indicador_array['mora'][$contador]=$row_formulario16['porcentaje'];
$indicador_array['prestamo'][$contador]=$row_obtencionCredito['prestamo'];

$indicador_array['estado'][$contador]=$indicador2;

$contador++;
}
}
return $indicador_array;
}

function indicador8_cantidad($idMer,$idRegional,$idDepartamento,$idMunicipio,$idComunidad,$idRubro,$gestion,$database_conexion,$conexion){
$query_mer= "SELECT a.idMer FROM mer a WHERE a.estado>0
AND
(SELECT porcentaje FROM formulario WHERE idPlanilla=16 AND idMer=a.idMer)=1
";
if($idMer>'0'){
$query_mer.= " AND a.idMer=$idMer";
}
if($idRegional>'0'){
$query_mer.= " AND a.idRegional=$idRegional";
}
if($idDepartamento>'0'){
$query_mer.= " AND a.idDepartamento=$idDepartamento";
}
if($idMunicipio>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
}
if($idComunidad>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
}
if($idRubro>'0'){
$query_mer.= " AND a.idRubro=$idRubro";
}
if($gestion>'0'){
$query_mer.= " AND a.gestion=$gestion";
}

mysql_select_db($database_conexion, $conexion);
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$total_mer=mysql_num_rows($mostrar_mer);

$cantidadArray['cumple']=$total_mer;

return $cantidadArray;
}

function indicador9_cantidad($idMer,$idRegional,$idDepartamento,$idMunicipio,$idComunidad,$idRubro,$gestion,$database_conexion,$conexion){
$query_mer= "SELECT a.idMer FROM mer a, formulario g  WHERE a.estado > 0  AND a.idMer=g.idMer AND g.idPlanilla='12' AND g.porcentaje>'0' ";
if($idMer>'0'){
$query_mer.= " AND a.idMer=$idMer";
}
if($idRegional>'0'){
$query_mer.= " AND a.idRegional=$idRegional";
}
if($idDepartamento>'0'){
$query_mer.= " AND a.idDepartamento=$idDepartamento";
}
if($idMunicipio>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
}
if($idComunidad>'0'){
$query_mer.= " AND a.idComunidad=$idComunidad";
}
if($idRubro>'0'){
$query_mer.= " AND a.idRubro=$idRubro";
}
if($gestion>'0'){
$query_mer.= " AND a.gestion=$gestion";
}

mysql_select_db($database_conexion, $conexion);
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$row_mer=mysql_fetch_assoc($mostrar_mer);
$total_mer=mysql_num_rows($mostrar_mer);

$indicador_array['cumple']=$total_mer;
return $indicador_array;
}
//funcion indicador 10
function indicador10($idMer,$idRegional,$idDepartamento,$idMunicipio,$idComunidad,$idRubro,$gestion,$estado,$database_conexion,$conexion){

mysql_select_db($database_conexion, $conexion);
$query_mer= "SELECT * FROM mer a, regional b, departamento c, municipio d, comunidad f, rubro e
WHERE a.estado>0 AND a.idRegional=b.idRegional AND a.idDepartamento=c.idDepartamento AND a.idMunicipio=d.idMunicipio AND a.idComunidad=f.idComunidad AND a.idRubro=e.idRubro ";
if($idMer>'0'){
$query_mer.= " AND a.idMer=$idMer";
}
if($idRegional>'0'){
$query_mer.= " AND a.idRegional=$idRegional";
}
if($idDepartamento>'0'){
$query_mer.= " AND a.idDepartamento=$idDepartamento";
}
if($idMunicipio>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
}
if($idComunidad>'0'){
$query_mer.= " AND a.idComunidad=$idComunidad";
}
if($idRubro>'0'){
$query_mer.= " AND a.idRubro=$idRubro";
}
if($gestion>'0'){
$query_mer.= " AND a.gestion=$gestion";
}
$query_mer.= " ORDER BY b.regional asc, c.departamento asc, d.municipio, e.rubro";
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$total_mer=mysql_num_rows($mostrar_mer);
$contador=0;
$numero_cumple=0;
$numero_nocumple=0;
while ($row_mer=mysql_fetch_assoc($mostrar_mer)){

mysql_select_db($database_conexion, $conexion);
$query_formulario1 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=1";
$mostrar_formulario1= mysql_query($query_formulario1, $conexion) or die(mysql_error());
$row_formulario1= mysql_fetch_assoc($mostrar_formulario1);

mysql_select_db($database_conexion, $conexion);
$query_formulario2 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=2";
$mostrar_formulario2= mysql_query($query_formulario2, $conexion) or die(mysql_error());
$row_formulario2= mysql_fetch_assoc($mostrar_formulario2);

mysql_select_db($database_conexion, $conexion);
$query_formulario3 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=3";
$mostrar_formulario3= mysql_query($query_formulario3, $conexion) or die(mysql_error());
$row_formulario3= mysql_fetch_assoc($mostrar_formulario3);

mysql_select_db($database_conexion, $conexion);
$query_formulario4 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=4";
$mostrar_formulario4= mysql_query($query_formulario4, $conexion) or die(mysql_error());
$row_formulario4= mysql_fetch_assoc($mostrar_formulario4);

mysql_select_db($database_conexion, $conexion);
$query_formulario5 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=5";
$mostrar_formulario5= mysql_query($query_formulario5, $conexion) or die(mysql_error());
$row_formulario5= mysql_fetch_assoc($mostrar_formulario5);

mysql_select_db($database_conexion, $conexion);
$query_formulario6= "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=6";
$mostrar_formulario6= mysql_query($query_formulario6, $conexion) or die(mysql_error());
$row_formulario6= mysql_fetch_assoc($mostrar_formulario6);

mysql_select_db($database_conexion, $conexion);
$query_meta15= "SELECT sum(respuesta) as meta FROM pregunta_respuesta WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=15 GROUP BY idMer";
$mostrar_meta15= mysql_query($query_meta15, $conexion) or die(mysql_error());
$row_meta15= mysql_fetch_assoc($mostrar_meta15);

mysql_select_db($database_conexion, $conexion);
$query_logro17= "SELECT sum(valor) as logro FROM registroventas17 WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=17  GROUP BY idMer";
$mostrar_logro17= mysql_query($query_logro17, $conexion) or die(mysql_error());
$row_logro17= mysql_fetch_assoc($mostrar_logro17);

if($row_meta15['meta']>'0'){$resul=($row_logro17['logro']*100)/$row_meta15['meta'];}else{$resul=0;}
//condicionante
if(($row_formulario2['cuenta']=='SI' || $row_formulario3['cuenta']=='SI' || $row_formulario4['cuenta']=='SI' || $row_formulario5['cuenta']=='SI' || $row_formulario6['cuenta']=='SI') && ($resul>'99')){$indicador2='1';}else{$indicador2='0';}
if($estado==$indicador2 || $estado=='0'){
$indicador_array['idMer'][$contador]=$row_mer['idMer'];
$indicador_array['regional'][$contador]=$row_mer['regional'];
$indicador_array['departamento'][$contador]=$row_mer['departamento'];
$indicador_array['municipio'][$contador]=$row_mer['municipio'];
$indicador_array['comunidad'][$contador]=$row_mer['comunidad'];
$indicador_array['zona'][$contador]=$row_mer['zona'];
$indicador_array['rubro'][$contador]=$row_mer['rubro'];
$indicador_array['mer'][$contador]=$row_mer['mer'];
$indicador_array['gestion'][$contador]=$row_mer['gestion'];

$indicador_array['planNegocio'][$contador]=$row_formulario2['cuenta'];
$indicador_array['planEstrategico'][$contador]=$row_formulario3['cuenta'];
$indicador_array['planProduccion'][$contador]=$row_formulario5['cuenta'];
$indicador_array['planFinanciero'][$contador]=$row_formulario4['cuenta'];
$indicador_array['planPoa'][$contador]=$row_formulario6['cuenta'];

$indicador_array['planNegocioDesc'][$contador]=$row_formulario2['observacion'];
$indicador_array['planEstrategicoDesc'][$contador]=$row_formulario3['observacion'];
$indicador_array['planProduccionDesc'][$contador]=$row_formulario5['observacion'];
$indicador_array['planFinancieroDesc'][$contador]=$row_formulario4['observacion'];
$indicador_array['planPoaDesc'][$contador]=$row_formulario6['observacion'];

$indicador_array['meta'][$contador]=$row_meta15['meta'];
$indicador_array['logro'][$contador]=$row_meta17['logro'];

$indicador_array['estado'][$contador]=$indicador2;

$contador++;
}
}
return $indicador_array;
}
function indicador10_cantidad($idMer,$idRegional,$idDepartamento,$idMunicipio,$idComunidad,$idRubro,$gestion,$database_conexion,$conexion){
$query_mer= "SELECT a.idMer FROM mer a WHERE a.estado>0
AND
((SELECT cuenta FROM formulario WHERE idPlanilla=2 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=3 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=4 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=5 AND idMer=a.idMer)='SI'
OR (SELECT cuenta FROM formulario WHERE idPlanilla=6 AND idMer=a.idMer)='SI'
)
AND
(SELECT sum(valor) as logro FROM registroventas17 WHERE idMer=a.idMer AND idPlanilla=17)/(SELECT sum(respuesta) as meta FROM pregunta_respuesta
WHERE idMer=a.idMer AND idPlanilla=15 GROUP BY idMer)>0.99

";
if($idMer>'0'){
$query_mer.= " AND a.idMer=$idMer";
}
if($idRegional>'0'){
$query_mer.= " AND a.idRegional=$idRegional";
}
if($idDepartamento>'0'){
$query_mer.= " AND a.idDepartamento=$idDepartamento";
}
if($idMunicipio>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
}
if($idComunidad>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
}
if($idRubro>'0'){
$query_mer.= " AND a.idRubro=$idRubro";
}
if($gestion>'0'){
$query_mer.= " AND a.gestion=$gestion";
}
$query_mer.=" GROUP BY a.idMer";
mysql_select_db($database_conexion, $conexion);
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$total_mer=mysql_num_rows($mostrar_mer);

$cantidadArray['cumple']=$total_mer;
return $cantidadArray;
}

function indicador11_cantidad($idMer,$idRegional,$idDepartamento,$idMunicipio,$idComunidad,$idRubro,$gestion,$database_conexion,$conexion){
$query_mer= "SELECT a.idMer FROM mer a WHERE a.estado > 0 AND a.idMer IN (SELECT idMer FROM formulario WHERE idPlanilla=15 AND porcentaje>=100 ) ";
if($idMer>'0'){
$query_mer.= " AND a.idMer=$idMer";
}
if($idRegional>'0'){
$query_mer.= " AND a.idRegional=$idRegional";
}
if($idDepartamento>'0'){
$query_mer.= " AND a.idDepartamento=$idDepartamento";
}
if($idMunicipio>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
}
if($idComunidad>'0'){
$query_mer.= " AND a.idComunidad=$idComunidad";
}
if($idRubro>'0'){
$query_mer.= " AND a.idRubro=$idRubro";
}
if($gestion>'0'){
$query_mer.= " AND a.gestion=$gestion";
}

mysql_select_db($database_conexion, $conexion);
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$row_mer=mysql_fetch_assoc($mostrar_mer);
$total_mer=mysql_num_rows($mostrar_mer);

$indicador_array['cumple']=$total_mer;
return $indicador_array;
}
function indicador13_cantidad($idMer,$idRegional,$idDepartamento,$idMunicipio,$idComunidad,$idRubro,$gestion,$database_conexion,$conexion){
$query_mer= "SELECT a.idMunicipio FROM mer a WHERE a.idMer IN (SELECT idMer FROM formulario WHERE idPlanilla=13 AND cuenta='SI') AND a.estado>0 ";
if($idMer>'0'){
$query_mer.= " AND a.idMer=$idMer";
}
if($idRegional>'0'){
$query_mer.= " AND a.idRegional=$idRegional";
}
if($idDepartamento>'0'){
$query_mer.= " AND a.idDepartamento=$idDepartamento";
}
if($idMunicipio>'0'){
$query_mer.= " AND a.idMunicipio=$idMunicipio";
}
if($idComunidad>'0'){
$query_mer.= " AND a.idComunidad=$idComunidad";
}
if($idRubro>'0'){
$query_mer.= " AND a.idRubro=$idRubro";
}
if($gestion>'0'){
$query_mer.= " AND a.gestion=$gestion";
}
$query_mer.= " GROUP BY a.idMunicipio ";
mysql_select_db($database_conexion, $conexion);
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$row_mer=mysql_fetch_assoc($mostrar_mer);
$total_mer=mysql_num_rows($mostrar_mer);

$indicador_array['cumple']=$total_mer;
return $indicador_array;
}
?>
