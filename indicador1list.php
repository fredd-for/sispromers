<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "indicador1info.php" ?>
<?php include "usuarioinfo.php" ?>
<?php include "userfn6.php" ?>
<?php include "librerias/librerias.php";?>
<?php require_once('Connections/conexion.php'); ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Define page object
$indicador1_list = new cindicador1_list();
$Page =& $indicador1_list;

// Page init processing
$indicador1_list->Page_Init();

// Page main processing
$indicador1_list->Page_Main();
?>
<?php include "header.php" ?>
<script src="ajax/prototype1.7.js" type="text/javascript"></script>
<script type="text/javascript">
function seleccionar_departamento(){
var v_idRegional = document.getElementById("x_idRegional");
var v_idDepartamento = document.getElementById("x_idDepartamento_edit");
new Ajax.Updater('divx_idDepartamento','departamentoSelector.php?idRegional='+v_idRegional.value+'&idDepartamento='+v_idDepartamento.value,{onComplete:function(){
	seleccionar_municipio();
}});
}
function seleccionar_municipio(){
var v_idRegional = document.getElementById("x_idRegional");
var v_idDepartamento = document.getElementById("x_idDepartamento");
var v_idMunicipio = document.getElementById("x_idMunicipio_edit");
new Ajax.Updater('divx_idMunicipio','municipioSelector.php?idRegional='+v_idRegional.value+'&idDepartamento='+v_idDepartamento.value+'&idMunicipio='+v_idMunicipio.value);
}
function ocultar(){
    var i;
    for(i=1;i<$F('contador');i++){
       $('plan_negocio'+i).hide();
       $('plan_estrategico'+i).hide();
       $('plan_produccion'+i).hide();
       $('plan_financiero'+i).hide();
       $('plan_poa'+i).hide();

       $('personeria_juridica'+i).hide();
       $('estatuto_organico'+i).hide();
       $('reglamento_interno'+i).hide();
       $('reg_fundaempresa'+i).hide();
       $('acta_constitucion'+i).hide();
       $('tarjeta_empresarial'+i).hide();

       $('reg_ventas'+i).hide();
       
       $('par_calidad'+i).hide();
   }
}
function verOcultarPlanes(){
    var i;
    for(i=1;i<$F('contador');i++){
       $('plan_negocio'+i).toggle();
       $('plan_estrategico'+i).toggle();
       $('plan_produccion'+i).toggle();
       $('plan_financiero'+i).toggle();
       $('plan_poa'+i).toggle();
   }
}
function verOcultarFormalizacion(){
    var i;
    for(i=1;i<$F('contador');i++){
       $('personeria_juridica'+i).toggle();
       $('estatuto_organico'+i).toggle();
       $('reglamento_interno'+i).toggle();
       $('reg_fundaempresa'+i).toggle();
       $('acta_constitucion'+i).toggle();
       $('tarjeta_empresarial'+i).toggle();
   }
}
function verOcultarRegVentas(){
    var i;
    for(i=1;i<$F('contador');i++){
       $('reg_ventas'+i).toggle();
  }
}
function verOcultarParCalidad(){
    var i;
    for(i=1;i<$F('contador');i++){
       $('par_calidad'+i).toggle();
  }
}
</script>
<span class="phpmaker" style="white-space: nowrap;">
<div id="linkDescargar"></div>
    <?php
/*mysql_select_db($database_conexion, $conexion);
$query_mer = "";
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$totalRows_mer=mysql_num_rows($mostrar_mer);
$contador=1;*/
?>
</span>
<?php 
// seletores para realizar el filtrado
/*mysql_select_db($database_conexion, $conexion);
$query_gestion= "SELECT gestion FROM mer GROUP BY gestion ORDER BY gestion asc";
$mostrar_gestion=mysql_query($query_gestion, $conexion) or die(mysql_error());
$total_gestion=mysql_num_rows($mostrar_gestion);
*/

mysql_select_db($database_conexion, $conexion);
$query_rubro= "SELECT idRubro, rubro FROM rubro ORDER BY rubro asc";
$mostrar_rubro=mysql_query($query_rubro, $conexion) or die(mysql_error());
$total_rubro=mysql_num_rows($mostrar_rubro);

mysql_select_db($database_conexion, $conexion);
$query_regional= "SELECT idRegional, regional FROM regional ORDER BY regional asc";
$mostrar_regional=mysql_query($query_regional, $conexion) or die(mysql_error());
$total_regional=mysql_num_rows($mostrar_regional);

?>
<form method="post" action="indicador1list.php">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
    <tr style="color: blue">
        <td>Gesti&oacute;n</td>
     <td>
         <select name="x_gestion" id="x_gestion">
             <option value="0" style="color: gray">Todos...</option>
			<option value="2009" <?php if($_POST['x_gestion']=='2009'){echo "selected";}?>>2009</option>
			<option value="2010" <?php if($_POST['x_gestion']=='2010'){echo "selected";}?>>2010</option>
			<option value="2011" <?php if($_POST['x_gestion']=='2011'){echo "selected";}?>>2011</option>
			<option value="2012" <?php if($_POST['x_gestion']=='2012'){echo "selected";}?>>2012</option>
         </select>
     </td>
     <td>Rubro</td>
     <td>
         <select name="x_idRubro" id="x_idRubro">
             <option value="0" style="color: gray">Todos...</option>
             <?php
             while($row_rubro=mysql_fetch_assoc($mostrar_rubro)){?>
             <option value="<?php echo $row_rubro['idRubro']?>" <?php if($_POST['x_idRubro']==$row_rubro['idRubro']){echo "selected";}?>><?php echo $row_rubro['rubro']?></option>
             <?php }
             ?>
         </select>
     </td>
     <td>Mers Formalizadas</td>
     <td>
         <select name="x_formalizada" id="x_formalizada">
             <option value="0" <?php if($_POST['x_formalizada']=='0'){echo "selected";$sw='0';}?> style="color: gray">Todos...</option>
             <option value="1" <?php if(isset ($_POST['x_formalizada'])){if($_POST['x_formalizada']=='1'){echo "selected";$sw='1';}}else{echo "selected";$sw='1';}?>>Mers Formalizadas</option>
             <option value="2" <?php if($_POST['x_formalizada']=='2'){echo "selected";$sw='2';}?>>Mers en Proceso</option>
         </select>
     </td>
     </tr>
   <tr style="color: blue">
     <td>Regional</td>
     <td>
         <select name="x_idRegional" id="x_idRegional" onchange="seleccionar_departamento();">
             <option value="0" style="color:gray" >Todos...</option>
             <?php
             while($row_regional=mysql_fetch_assoc($mostrar_regional)){?>
             <option value="<?php echo $row_regional['idRegional']?>" <?php if($_POST['x_idRegional']==$row_regional['idRegional']){echo "selected";}?>><?php echo $row_regional['regional']?></option>
             <?php }
             ?>
         </select>
     </td>
     <td>Departamento</td>
     <td>
<input type="hidden" name="x_idDepartamento_edit" id="x_idDepartamento_edit" value="<?php if($_POST['x_idDepartamento']>0){echo $_POST['x_idDepartamento'];}else{echo "0";}?>"/>
<div id="divx_idDepartamento"></div>
     </td>
     <td>Municipio</td>
     <td>
<input type="hidden" name="x_idMunicipio_edit" id="x_idMunicipio_edit" value="<?php if($_POST['x_idMunicipio']>0){echo $_POST['x_idMunicipio'];}else{echo "0";}?>"/>
<div id="divx_idMunicipio"></div>
     </td>
     </tr>
 <tr>
 <td colspan="6" align="center"><input type="submit" name="filtrar" value="FILTRAR (*)"></td>
 </tr>
 </table>
</div></td></tr></table>
</form>
<div id="div_formulario">
<table>
     <tr style="background: #667120; color:#ffffff; font-size: 15px">
         <th colspan="2">PROPOSITO I.1:</th><td colspan="16">N&uacute;mero de MERS sostenibles y en funcionamiento: A&ntilde;o 2: 50; Fin proyecto: 115</td>
     </tr>
</table>
  <table id="table_example" width="100%" border="1" class="ewTable">
    <thead>
    <tr>
        <th bgcolor="#B8C692"></th>
        <th colspan="5" align="center" bgcolor="#B8C692">INFORME GEOGRAFICO</th>
        <th colspan="4" align="center" bgcolor="#b8c2a5">DATOS DE LA MERS</th>
        <th colspan="4" align="center" bgcolor="#b8f5e0">DOCUMENTO</th>
        <th colspan="1" align="center" bgcolor="#b89ec1">INDICADOR</th>
    </tr>
    <tr class="ewTableHeader">
        <th>Nro</th>
        <th>Regional</th>
        <th>Departamento</th>
        <th>Municipio</th>
        <th>Comunidad</th>
        <th>Zona</th>
        <th>Rubro</th>
        <th>Razon Social de la Mers</th>
        <th>Responsable de la Mers</th>
        <th>Gesti&oacute;n</th>
        <th style="cursor: pointer" title="Ocultar/Ver Comentarios" onclick="verOcultarPlanes();">Planes/POA <img src="images/expand.gif"></th>
        <th style="cursor: pointer" title="Ocultar/Ver Comentarios" onclick="verOcultarFormalizacion();">Formalizacion <img src="images/expand.gif"></th>
        <th style="cursor: pointer" title="Ocultar/Ver Comentarios" onclick="verOcultarRegVentas();">Reg. Ventas <img src="images/expand.gif"></th>
        <th style="cursor: pointer" title="Ocultar/Ver Comentarios" onclick="verOcultarParCalidad();">Parametro Calidad <img src="images/expand.gif"></th>
        <th>Valor</th>
     </tr>
</thead>
<tbody id="contenidoTbody">
<?php
if(isset($_POST['filtrar'])){
$mers_array=indicador1(0, $_POST['x_idRegional'], $_POST['x_idDepartamento'], $_POST['x_idMunicipio'], 0, $_POST['x_idRubro'], $_POST['x_gestion'], $_POST['x_formalizada'], $database_conexion, $conexion);	
}else{
$mers_array=indicador1(0, 0, 0, 0, 0, 0, 0, 1, $database_conexion, $conexion);}
for($i=0;$i<count($mers_array[idMer]);$i++){
mysql_select_db($database_conexion, $conexion);
$query_responsable = "SELECT b.nombre, b.materno, b.paterno FROM responsable a, usuario b WHERE a.idMer='".$mers_array[idMer][$i]."' AND a.idGerente=b.idUsuario ORDER BY b.paterno asc";
$mostrar_responsable=mysql_query($query_responsable, $conexion) or die(mysql_error());
$totalRows_responsable=mysql_num_rows($mostrar_responsable);

?>
<tr <?php if($i%2==0){echo "bgcolor='#F1F1F1'";}?>>
<td><?php echo $i+1;?></td>
<td><?php echo $mers_array[regional][$i];?></td>
<td><?php echo $mers_array[departamento][$i];?></td>
<td><?php echo $mers_array[municipio][$i];?></td>
<td><?php echo $mers_array[comunidad][$i];?></td>
<td><?php echo $mers_array[zona][$i];?></td>
<td><?php echo $mers_array[rubro][$i];?></td>
<td><?php echo $mers_array[mer][$i];?></td>
<td><?php
$color=1;
while ($row_responsable=mysql_fetch_assoc($mostrar_responsable)){ ?>
    <div <?php if($color%2==0){echo "style='background:#d7d3c8'";}?>>
<?php echo $row_responsable['paterno']." ".$row_responsable['materno'].", ".$row_responsable['nombre']."";?>
</div>
<?php $color++;
}
?>
</td>
<td><?php echo $mers_array[gestion][$i];?></td>
<td><table width="120px" id="poas_table">
        <tr <?php if($mers_array[planNegocio][$i]=='SI'){echo "style='color:blue'"; $tiqueado="&radic;";}else{echo "style='color:gray'";$tiqueado="";}?>>
       <td>Plan Negocio <?php echo $tiqueado ?></td>
       <td id="plan_negocio<?php echo $i+1?>"><?php echo $mers_array[planNegocioDesc][$i]?></td>
        </tr>
        <tr <?php if($mers_array[planEstrategico][$i]=='SI'){echo "style='color:blue'"; $tiqueado="&radic;";}else{echo "style='color:gray'";$tiqueado="";}?>>
       <td>Plan Estrategico <?php echo $tiqueado ?></td>
       <td id="plan_estrategico<?php echo $i+1?>"><?php echo $mers_array[planEstrategicoDesc][$i]?></td>
        </tr>
        <tr <?php if($mers_array[planProduccion][$i]=='SI'){echo "style='color:blue'"; $tiqueado="&radic;";}else{echo "style='color:gray'";$tiqueado="";}?>>
       <td>Plan Produccion <?php echo $tiqueado ?></td>
       <td id="plan_produccion<?php echo $i+1?>"><?php echo $mers_array[planProduccionDesc][$i]?></td>
        </tr>
        <tr <?php if($mers_array[planFinanciero][$i]=='SI'){echo "style='color:blue'"; $tiqueado="&radic;";}else{echo "style='color:gray'";$tiqueado="";}?>>
       <td>Plan Financiero <?php echo $tiqueado ?></td>
       <td id="plan_financiero<?php echo $i+1?>"><?php echo $mers_array[planFinacieroDesc][$i]?></td>
        </tr>
        <tr <?php if($mers_array[planPoa][$i]=='SI'){echo "style='color:blue'"; $tiqueado="&radic;";}else{echo "style='color:gray'";$tiqueado="";}?>>
       <td>Plan POA <?php echo $tiqueado ?></td>
       <td id="plan_poa<?php echo $i+1?>"><?php echo $mers_array[planPoaDesc][$i]?></td>
        </tr>
    </table>
</td>
<td><table width="130px" id="formalizada_table">
       <tr <?php if($mers_array[personeriaJuridica][$i]=='SI'){echo "style='color:blue'"; $tiqueado="&radic;";}else{echo "style='color:gray'";$tiqueado="";}?>>
        <td>Personeria Juridica <?php echo $tiqueado ?></td>
        <td id="personeria_juridica<?php echo $i+1?>"><?php echo $mers_array[personeriaJuridicaDesc][$i]?></td>
       </tr>
       <tr <?php if($mers_array[estatutoOrganico][$i]=='SI'){echo "style='color:blue'"; $tiqueado="&radic;";}else{echo "style='color:gray'";$tiqueado="";}?>>
        <td>Estatuto Organico <?php echo $tiqueado ?></td>
        <td id="estatuto_organico<?php echo $i+1?>"><?php echo $mers_array[estatutoOrganicoDesc][$i]?></td>
       </tr>
       <tr <?php if($mers_array[reglamentoInterno][$i]=='SI'){echo "style='color:blue'"; $tiqueado="&radic;";}else{echo "style='color:gray'";$tiqueado="";}?>>
        <td>Reglamento Interno <?php echo $tiqueado ?></td>
        <td id="reglamento_interno<?php echo $i+1?>"><?php echo $mers_array[reglamentoInternoDesc][$i]?></td>
       </tr>
       <tr <?php if($mers_array[regFundaempresa][$i]=='SI'){echo "style='color:blue'"; $tiqueado="&radic;";}else{echo "style='color:gray'";$tiqueado="";}?>>
        <td>Reg. FundaEmpresa <?php echo $tiqueado ?></td>
        <td id="reg_fundaempresa<?php echo $i+1?>"><?php echo $mers_array[regFundaempresaDesc][$i]?></td>
       </tr>
       <tr <?php if($mers_array[actaConstitucion][$i]=='SI'){echo "style='color:blue'"; $tiqueado="&radic;";}else{echo "style='color:gray'";$tiqueado="";}?>>
        <td>Acta Constitucion <?php echo $tiqueado ?></td>
        <td id="acta_constitucion<?php echo $i+1?>"><?php echo $mers_array[actaConstitucionDesc][$i]?></td>
       </tr>
       <tr <?php if($mers_array[tarjetaEmpresarial][$i]=='SI'){echo "style='color:blue'"; $tiqueado="&radic;";}else{echo "style='color:gray'";$tiqueado="";}?>>
        <td>Tarjeta Empresarial <?php echo $tiqueado ?></td>
        <td id="tarjeta_empresarial<?php echo $i+1?>"><?php echo $mers_array[tarjetaEmpresarialDesc][$i]?></td>
       </tr>
    </table>
</td>
<td><table width="130px" id="regVentas_table">
       <tr <?php if($mers_array[regVentas][$i]=='SI'){echo "style='color:blue'"; $tiqueado="&radic;";}else{echo "style='color:gray'";$tiqueado="";}?>>
        <td>Reg. Ventas <?php echo $tiqueado ?></td>
        <td rowspan="2" id="reg_ventas<?php echo $i+1?>"><?php echo $mers_array[regVentasDesc][$i]?></td>
       </tr>
       <tr <?php if($mers_array[regVentas][$i]=='SI'){echo "style='color:blue'"; $tiqueado="&radic;";}else{echo "style='color:gray'";$tiqueado="";}?>>
        <td>Total Ventas Bs.=<?php echo $mers_array[regVentasMonto][$i] ?></td>
       </tr>
    </table>
</td>
<td><table width="110px" id="parCalidad_table">
       <tr <?php if($mers_array[parCalidad][$i]=='SI'){echo "style='color:blue'"; $tiqueado="&radic;";}else{echo "style='color:gray'";$tiqueado="";}?>>
        <td>Par. Calidad <?php echo $tiqueado ?></td>
        <td rowspan="2" id="par_calidad<?php echo $i+1?>"><?php echo $mers_array[parCalidadDesc][$i]?></td>
       </tr>
    </table>
</td>

<td <?php if($mers_array[estado][$i]=='1'){
echo "style='background:#C2D69A'"; $resp="Form.";}else{  echo "style='background:#FFFF99'"; $resp="Proceso"; }?>><?php echo $resp;?></td>
</tr>
<?php
}
?>
</tbody>
</table>
    <input type="hidden" name="contador" id="contador" value="<?php echo count($mers_array[idMer])+1?>">
<table>
     <tr style="background: #667120; color:#ffffff; font-size: 15px">
         <th colspan="6">PROPOSITO I.1:</th><td colspan="12">N&uacute;mero de MERS sostenibles y en funcionamiento: A&ntilde;o 2: 50; Fin proyecto: 115</td>
     </tr>
     <tr style="background:#b8f5e0; font-size: 11px; text-align: center">
         <th colspan="6">N&uacute;mero de MERS sostenibles y en funcionamiento: 
         <?php 
         $mers_cantidad=indicador1_cantidad(0, $_POST['x_idRegional'], $_POST['x_idDepartamento'], $_POST['x_idMunicipio'], 0, $_POST['x_idRubro'], $_POST['x_gestion'], $database_conexion, $conexion);
         
         echo $mers_cantidad[cumple]; ?></th><td colspan="12">Porcentaje de Cumplimiento : <?php printf("%0.2f", ($mers_cantidad[cumple]*100)/115); echo" %"; ?></td>
     </tr>

</table>
</div>
<script type="text/javascript" language="javascript">
<!--
//Free Memory allow case
x320001();
seleccionar_departamento();
ocultar();
-->
</script>
<?php include "footer.php" ?>
<?php

//
// Page Class
//
class cindicador1_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'indicador1';

	// Page Object Name
	var $PageObjName = 'indicador1_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $indicador1;
		if ($indicador1->UseTokenInUrl) $PageUrl .= "t=" . $indicador1->TableVar . "&"; // add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		if (@$_SESSION[EW_SESSION_MESSAGE] <> "") { // Append
			$_SESSION[EW_SESSION_MESSAGE] .= "<br>" . $v;
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = $v;
		}
	}

	// Show Message
	function ShowMessage() {
		if ($this->getMessage() <> "") { // Message in Session, display
			echo "<p><span class=\"ewMessage\">" . $this->getMessage() . "</span></p>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}
	}

	// Validate Page request
	function IsPageRequest() {
		global $objForm, $indicador1;
		if ($indicador1->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($indicador1->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($indicador1->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cindicador1_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["indicador1"] = new cindicador1();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'indicador1', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $indicador1;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->TableName);
		$Security->TablePermission_Loaded();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$indicador1->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $indicador1->Export; // Get export parameter, used in header
	$gsExportFile = $indicador1->TableVar; // Get export file, used in header
	if ($indicador1->Export == "print" || $indicador1->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($indicador1->Export == "excel") {
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
	}

		// Global page loading event (in userfn6.php)
		Page_Loading();

		// Page load event, used in current page
		$this->Page_Load();
	}

	//
	//  Page_Terminate
	//  - called when exit page
	//  - if URL specified, redirect to the URL
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page unload event, used in current page
		$this->Page_Unload();

		// Global page unloaded event (in userfn*.php)
		Page_Unloaded();

		 // Close Connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			ob_end_clean();
			header("Location: $url");
		}
		exit();
	}
	var $lDisplayRecs; // Number of display records
	var $lStartRec;
	var $lStopRec;
	var $lTotalRecs;
	var $lRecRange;
	var $sSrchWhere;
	var $lRecCnt;
	var $lEditRowCnt;
	var $lRowCnt;
	var $lRowIndex;
	var $lOptionCnt;
	var $lRecPerRow;
	var $lColCnt;
	var $sDeleteConfirmMsg; // Delete confirm message
	var $sDbMasterFilter;
	var $sDbDetailFilter;
	var $bMasterRecordExists;	
	var $ListOptions;
	var $sMultiSelectKey;

	//
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsSearchError, $Security, $indicador1;
		$this->lDisplayRecs = 20;
		$this->lRecRange = 10;
		$this->lRecCnt = 0; // Record count

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		$this->sSrchWhere = ""; // Search WHERE clause
		$this->sDeleteConfirmMsg = "�Quiere borrar este registro?"; // Delete confirm message

		// Master/Detail
		$this->sDbMasterFilter = ""; // Master filter
		$this->sDbDetailFilter = ""; // Detail filter
		if ($this->IsPageRequest()) { // Validate request

			// Set up records per page dynamically
			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set Up Sorting Order
			$this->SetUpSortOrder();
		} // End Validate Request

		// Restore display records
		if ($indicador1->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $indicador1->getRecordsPerPage(); // Restore from Session
		} else {
			$this->lDisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if (!$Security->CanList()) {
			$sFilter = "(0=1)"; // Filter all records
		}
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in Session
		$indicador1->setSessionWhere($sFilter);
		$indicador1->CurrentFilter = "";

		// Export data only
		if (in_array($indicador1->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $indicador1;
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->lDisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->lDisplayRecs = -1;
				} else {
					$this->lDisplayRecs = 20; // Non-numeric, load default
				}
			}
			$indicador1->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$indicador1->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $indicador1;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$indicador1->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$indicador1->CurrentOrderType = @$_GET["ordertype"];
			$indicador1->UpdateSort($indicador1->idMer); // Field 
			$indicador1->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $indicador1;
		$sOrderBy = $indicador1->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($indicador1->SqlOrderBy() <> "") {
				$sOrderBy = $indicador1->SqlOrderBy();
				$indicador1->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $indicador1;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$indicador1->setSessionOrderBy($sOrderBy);
				$indicador1->idMer->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$indicador1->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $indicador1;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$indicador1->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$indicador1->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $indicador1->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$indicador1->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$indicador1->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$indicador1->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $indicador1;

		// Call Recordset Selecting event
		$indicador1->Recordset_Selecting($indicador1->CurrentFilter);

		// Load list page SQL
		$sSql = $indicador1->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$indicador1->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $indicador1;
		$sFilter = $indicador1->KeyFilter();

		// Call Row Selecting event
		$indicador1->Row_Selecting($sFilter);

		// Load sql based on filter
		$indicador1->CurrentFilter = $sFilter;
		$sSql = $indicador1->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$indicador1->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $indicador1;
		$indicador1->idMer->setDbValue($rs->fields('idMer'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $indicador1;

		// Call Row_Rendering event
		$indicador1->Row_Rendering();

		// Common render codes for all row types
		// idMer

		$indicador1->idMer->CellCssStyle = "";
		$indicador1->idMer->CellCssClass = "";
		if ($indicador1->RowType == EW_ROWTYPE_VIEW) { // View row

			// idMer
			$indicador1->idMer->ViewValue = $indicador1->idMer->CurrentValue;
			$indicador1->idMer->CssStyle = "";
			$indicador1->idMer->CssClass = "";
			$indicador1->idMer->ViewCustomAttributes = "";

			// idMer
			$indicador1->idMer->HrefValue = "";
		}

		// Call Row Rendered event
		$indicador1->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $indicador1;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($indicador1->ExportAll) {
			$this->lStopRec = $this->lTotalRecs;
		} else { // Export 1 page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->lDisplayRecs < 0) {
				$this->lStopRec = $this->lTotalRecs;
			} else {
				$this->lStopRec = $this->lStartRec + $this->lDisplayRecs - 1;
			}
		}
		if ($indicador1->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($indicador1->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $indicador1->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idMer', $indicador1->Export);
				echo ew_ExportLine($sExportStr, $indicador1->Export);
			}
		}

		// Move to first record
		$this->lRecCnt = $this->lStartRec - 1;
		if (!$rs->EOF) {
			$rs->MoveFirst();
			$rs->Move($this->lStartRec - 1);
		}
		while (!$rs->EOF && $this->lRecCnt < $this->lStopRec) {
			$this->lRecCnt++;
			if (intval($this->lRecCnt) >= intval($this->lStartRec)) {
				$this->LoadRowValues($rs);

				// Render row for display
				$indicador1->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($indicador1->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idMer', $indicador1->idMer->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $indicador1->Export <> "csv") { // Vertical format
						echo ew_ExportField('idMer', $indicador1->idMer->ExportValue($indicador1->Export, $indicador1->ExportOriginalValue), $indicador1->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $indicador1->idMer->ExportValue($indicador1->Export, $indicador1->ExportOriginalValue), $indicador1->Export);
						echo ew_ExportLine($sExportStr, $indicador1->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($indicador1->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($indicador1->Export);
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
