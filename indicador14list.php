<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "indicador14info.php" ?>
<?php include "usuarioinfo.php" ?>
<?php include "userfn6.php" ?>
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
$indicador14_list = new cindicador14_list();
$Page =& $indicador14_list;

// Page init processing
$indicador14_list->Page_Init();

// Page main processing
$indicador14_list->Page_Main();
?>
<?php include "header.php" ?>
<script src="ajax/prototype.js" type="text/javascript"></script>
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
for(var i=1;i<$F('contador');i++){
    $('detalle_'+i).hide();
}
}
function verOcultarFormalizacion(){
for(var i=1;i<$F('contador');i++){
    $('detalle_'+i).toggle();
}
}
</script>
<span class="phpmaker" style="white-space: nowrap;">
<?php if ($Reporte_Mers->Export == "") { ?>
<div id="linkDescargar"></div>
    <?php } ?>
<script type="text/javascript">
    $(function () {
        $('input#id_search').quicksearch('table table#table_example #contenidoTbody tr');
    });
</script>
    <?php
mysql_select_db($database_conexion, $conexion);
$query_mer = "SELECT a.idMer, b.regional, c.departamento, d.municipio, e.comunidad, a.zona, f.rubro, a.mer, a.gestion
FROM mer a, regional b, departamento c, municipio d, comunidad e, rubro f ";

if(isset($_POST['x_formalizada'])){if($_POST['x_formalizada']=='1')
    {$query_mer.=" , formulario g ";}}
else{$query_mer.=" , formulario g ";}

$query_mer.=" WHERE a.idRegional = b.idRegional And a.idDepartamento = c.idDepartamento And a.idMunicipio = d.idMunicipio And a.idComunidad = e.idComunidad And a.idRubro = f.idRubro And a.estado > 0 ";

if(isset($_POST['x_formalizada'])){if($_POST['x_formalizada']=='1')
    {$query_mer.=" AND a.idMer=g.idMer AND g.idPlanilla='12' AND g.cuenta='SI' ";}}
else{$query_mer.=" AND a.idMer=g.idMer AND g.idPlanilla='12' AND g.cuenta='SI' ";}

if($_POST['x_formalizada']=='2'){$query_mer.=" AND a.idMer NOT IN (SELECT idMer FROM formulario WHERE cuenta =  'SI' AND idPlanilla =  '12') ";}
if($_POST['x_idRegional']>'0'){
$query_mer.= " AND a.idRegional=".$_POST['x_idRegional'];
}
if($_POST['x_idDepartamento']>'0'){
$query_mer.= " AND a.idDepartamento=".$_POST['x_idDepartamento'];
}
if($_POST['x_idMunicipio']>'0'){
$query_mer.= " AND a.idMunicipio=".$_POST['x_idMunicipio'];
}
if($_POST['x_idRubro']>'0'){
$query_mer.= " AND a.idRubro=".$_POST['x_idRubro'];
}
if($_POST['x_gestion']>'0'){
$query_mer.= " AND a.gestion=".$_POST['x_gestion'];
}
$query_mer.=" ORDER BY b.regional ASC, c.departamento ASC, d.municipio asc, e.comunidad asc, f.rubro asc";
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$totalRows_mer=mysql_num_rows($mostrar_mer);

?>
</span>
<?php
// seletores para realizar el filtrado
mysql_select_db($database_conexion, $conexion);
$query_rubro= "SELECT idRubro, rubro FROM rubro ORDER BY rubro asc";
$mostrar_rubro=mysql_query($query_rubro, $conexion) or die(mysql_error());
$total_rubro=mysql_num_rows($mostrar_rubro);

mysql_select_db($database_conexion, $conexion);
$query_regional= "SELECT idRegional, regional FROM regional ORDER BY regional asc";
$mostrar_regional=mysql_query($query_regional, $conexion) or die(mysql_error());
$total_regional=mysql_num_rows($mostrar_regional);
?>
<form method="post" action="indicador3list.php">
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
     <td>Mers Contrato</td>
     <td>
         <select name="x_formalizada" id="x_formalizada">
             <option value="0" <?php if($_POST['x_formalizada']=='0'){echo "selected";$sw='0';}?> style="color: gray">Todos...</option>
             <option value="1" <?php if(isset ($_POST['x_formalizada'])){if($_POST['x_formalizada']=='1'){echo "selected";$sw='1';}}else{echo "selected";$sw='1';}?>>Municipios-Mers</option>
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
         <th colspan="2">INDICADOR C.3-I.3:</th><td colspan="16">Municipios que contratan anualmente los servicios de al menos una MERS. A&ntilde;o 2: 4; Fin de proyecto: 8</td>
     </tr>
</table>
 <table id="table_example" width="100%" border="1" class="ewTable">
    <thead>
    <tr>
        <th bgcolor="#B8C692"></th>
        <th colspan="5" align="center" bgcolor="#B8C692">INFORME GEOGRAFICO</th>
        <th colspan="4" align="center" bgcolor="#b8c2a5">DATOS DE LA MERS</th>
        <th colspan="1" align="center" bgcolor="#b8f5e0">DOCUMENTO</th>
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
        <th style="cursor: pointer" title="Ocultar/Ver Comentarios" onclick="verOcultarFormalizacion();">Contrato Municipio-Mers <img src="images/expand.gif"></th>
        <th>Valor</th>
    </tr>
</thead>
<tbody id="contenidoTbody">
<?php if ($Reporte_Mers->Export == "") { ?>
<?php
$contador=1;
$contadorInd=1;
while ($row_mer=mysql_fetch_assoc($mostrar_mer)){

mysql_select_db($database_conexion, $conexion);
$query_responsable = "SELECT b.nombre, b.materno, b.paterno FROM responsable a, usuario b WHERE a.idMer='".$row_mer['idMer']."' AND a.idGerente=b.idUsuario ORDER BY b.paterno asc";
$mostrar_responsable=mysql_query($query_responsable, $conexion) or die(mysql_error());
$totalRows_responsable=mysql_num_rows($mostrar_responsable);

mysql_select_db($database_conexion, $conexion);
$query_formulario12 = "SELECT tipoContrato, concat(descripcion,' ',cantidad,' ',unidad,' = ',costoTotal, ' Bs.') as detalle, costoTotal,cumple FROM formulario12 WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=12 AND tipoContrato='1'";
$mostrar_formulario12= mysql_query($query_formulario12, $conexion) or die(mysql_error());
$total_formulario12=mysql_num_rows($mostrar_formulario12);

?>
<tr <?php if($contador%2==0){echo "bgcolor='#F1F1F1'";}?>>
<td><?php echo $contador;?></td>
        <td><?php echo $row_mer['regional'];?></td>
        <td><?php echo $row_mer['departamento'];?></td>
        <td><?php echo $row_mer['municipio'];?></td>
        <td><?php echo $row_mer['comunidad'];?></td>
        <td><?php echo $row_mer['zona'];?></td>
        <td><?php echo $row_mer['rubro'];?></td>
        <td><?php echo $row_mer['mer'];?></td>
        <td><?php
        $color=1;
        $aux=0;
        while ($row_responsable=mysql_fetch_assoc($mostrar_responsable)){ ?>
            <div <?php if($color%2==0){echo "style='background:#d7d3c8'";}?>><?php echo $row_responsable['paterno']." ".$row_responsable['materno'].", ".$row_responsable['nombre']."</div>";
        $color++;
        }?>
        </td>
        <td><?php echo $row_mer['gestion'];?></td>
        <td><?php if($total_formulario12>0){?>
            <table>
             <?php
             $suma=0;
             while($row_formulario12= mysql_fetch_assoc($mostrar_formulario12)){ ?>
                <tr <?php if($row_formulario12['cumple']=='SI'){echo "style='color:blue'"; $tiqueado="&radic;";}else{echo "style='color:gray'";$tiqueado="";}?>>
                    <td><?php
                    switch ($row_formulario12['tipoContrato']) {
                       case 1:
                        echo "Municipio-Mers ".$tiqueado; $aux=1; break;
                       case 2:
                        echo "Privado-Privado ".$tiqueado; break;
                    case 3:
                        echo "Publico-Privado ".$tiqueado; break;
                        default:
                            break;
                    }
                    ?></td>
                    <td id="detalle_<?php echo $contadorInd; ?>"><?php echo $row_formulario12['detalle']?></td>
                </tr>
             <?php
             $suma+=$row_formulario12['costoTotal'];
             $contadorInd++;
             }
                 ?>
                <tr><td colspan="2">TOTAL Bs.= <?php echo $suma;?></td></tr>
            </table>
            <?php } ?>
        </td>
<td <?php if($aux=='1'){
echo "style='background:#C2D69A'"; $resp="Cumple.";}else{  echo "style='background:#FFFF99'"; $resp="Proceso"; }?>><?php echo $resp;?></td>
    </tr>
<?php
$contador++;
}
?>
<?php } ?>
 </tbody>
 </table>
    <input type="hidden" name="contador" id="contador" value="<?php echo $contadorInd?>">
<?php
mysql_select_db($database_conexion, $conexion);
$query_numMunicipios= "SELECT idMunicipio FROM mer WHERE idMer IN(SELECT idMer FROM formulario WHERE idPlanilla=12 AND cuenta='SI') GROUP BY idMunicipio";
$mostrar_numMunicipios=mysql_query($query_numMunicipios, $conexion) or die(mysql_error());
$total_numMunicipios=mysql_num_rows($mostrar_numMunicipios);
?>
    <table>
     <tr style="background: #667120; color:#ffffff; font-size: 15px">
         <th colspan="2">INDICADOR C.3-I.3:</th><td colspan="16">Municipios que contratan anualmente los servicios de al menos una MERS. A&ntilde;o 2: 4; Fin de proyecto: 8</td>
     </tr>
     <tr style="background:#b8f5e0; font-size: 11px; text-align: center">
         <th colspan="6">N&uacute;mero Municipios que contratan servicios de al menos una MERS: <?php echo $total_numMunicipios; ?></th><td colspan="12">Porcentaje de Cumplimiento : <?php printf("%0.2f", ($total_numMunicipios*100)/8); echo" %"; ?></td>
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
class cindicador14_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'indicador14';

	// Page Object Name
	var $PageObjName = 'indicador14_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $indicador14;
		if ($indicador14->UseTokenInUrl) $PageUrl .= "t=" . $indicador14->TableVar . "&"; // add page token
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
		global $objForm, $indicador14;
		if ($indicador14->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($indicador14->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($indicador14->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cindicador14_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["indicador14"] = new cindicador14();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'indicador14', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $indicador14;
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
	$indicador14->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $indicador14->Export; // Get export parameter, used in header
	$gsExportFile = $indicador14->TableVar; // Get export file, used in header
	if ($indicador14->Export == "print" || $indicador14->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($indicador14->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $indicador14;
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
		if ($indicador14->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $indicador14->getRecordsPerPage(); // Restore from Session
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
		$indicador14->setSessionWhere($sFilter);
		$indicador14->CurrentFilter = "";

		// Export data only
		if (in_array($indicador14->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $indicador14;
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
			$indicador14->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$indicador14->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $indicador14;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$indicador14->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$indicador14->CurrentOrderType = @$_GET["ordertype"];
			$indicador14->UpdateSort($indicador14->idMer); // Field 
			$indicador14->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $indicador14;
		$sOrderBy = $indicador14->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($indicador14->SqlOrderBy() <> "") {
				$sOrderBy = $indicador14->SqlOrderBy();
				$indicador14->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $indicador14;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$indicador14->setSessionOrderBy($sOrderBy);
				$indicador14->idMer->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$indicador14->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $indicador14;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$indicador14->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$indicador14->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $indicador14->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$indicador14->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$indicador14->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$indicador14->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $indicador14;

		// Call Recordset Selecting event
		$indicador14->Recordset_Selecting($indicador14->CurrentFilter);

		// Load list page SQL
		$sSql = $indicador14->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$indicador14->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $indicador14;
		$sFilter = $indicador14->KeyFilter();

		// Call Row Selecting event
		$indicador14->Row_Selecting($sFilter);

		// Load sql based on filter
		$indicador14->CurrentFilter = $sFilter;
		$sSql = $indicador14->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$indicador14->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $indicador14;
		$indicador14->idMer->setDbValue($rs->fields('idMer'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $indicador14;

		// Call Row_Rendering event
		$indicador14->Row_Rendering();

		// Common render codes for all row types
		// idMer

		$indicador14->idMer->CellCssStyle = "";
		$indicador14->idMer->CellCssClass = "";
		if ($indicador14->RowType == EW_ROWTYPE_VIEW) { // View row

			// idMer
			$indicador14->idMer->ViewValue = $indicador14->idMer->CurrentValue;
			$indicador14->idMer->CssStyle = "";
			$indicador14->idMer->CssClass = "";
			$indicador14->idMer->ViewCustomAttributes = "";

			// idMer
			$indicador14->idMer->HrefValue = "";
		}

		// Call Row Rendered event
		$indicador14->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $indicador14;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($indicador14->ExportAll) {
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
		if ($indicador14->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($indicador14->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $indicador14->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idMer', $indicador14->Export);
				echo ew_ExportLine($sExportStr, $indicador14->Export);
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
				$indicador14->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($indicador14->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idMer', $indicador14->idMer->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $indicador14->Export <> "csv") { // Vertical format
						echo ew_ExportField('idMer', $indicador14->idMer->ExportValue($indicador14->Export, $indicador14->ExportOriginalValue), $indicador14->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $indicador14->idMer->ExportValue($indicador14->Export, $indicador14->ExportOriginalValue), $indicador14->Export);
						echo ew_ExportLine($sExportStr, $indicador14->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($indicador14->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($indicador14->Export);
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
