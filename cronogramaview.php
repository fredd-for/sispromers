<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "cronogramainfo.php" ?>
<?php include "usuarioinfo.php" ?>
<?php include "userfn6.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Define page object
$cronograma_view = new ccronograma_view();
$Page =& $cronograma_view;

// Page init processing
$cronograma_view->Page_Init();

// Page main processing
$cronograma_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($cronograma->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var cronograma_view = new ew_Page("cronograma_view");

// page properties
cronograma_view.PageID = "view"; // page ID
var EW_PAGE_ID = cronograma_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
cronograma_view.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
cronograma_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cronograma_view.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>

<?php } ?>
<?php
//echo $_GET['idConsultoria'];
mysql_select_db($database_conexion, $conexion);
$query_consultoria= "SELECT a.idConsultoria, a.consultoria, a.fechaInicio, a.fechaFinal, b.paterno, b.materno,b.nombre FROM consultoria a, usuario b WHERE a.idConsultoria='".(int)$_GET['idConsultoria']."' AND a.idUsuario=b.idUsuario";
$mostrar_consultoria=mysql_query($query_consultoria, $conexion) or die(mysql_error());
$row_consultoria=mysql_fetch_assoc($mostrar_consultoria);
?>
<p><span class="phpmaker">
<?php if ($cronograma->Export == "") { ?>
<a href="cronogramalist.php?idConsultoria=<?php echo $_GET['idConsultoria']?>">Volver al listado</a>&nbsp;
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $cronograma->AddUrl() ?>">Adicionar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<a href="<?php echo $cronograma->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<a onclick="return ew_Confirm('Quiere borrar este registro?');" href="<?php echo $cronograma->DeleteUrl() ?>">Borrar</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $cronograma_view->ShowMessage() ?>
<fieldset>
    <legend>Proyecto: Promoviendo el Desarrollo Local y la Formacion de MERS</legend>
    <table>
        <tr>
            <td><div>Consultoria:</div></td><td colspan="7"><?php echo $row_consultoria['consultoria']?></td>
        </tr>
        <tr>
            <td><div>Responsable:</div></td><td><?php echo $row_consultoria['paterno']." ".$row_consultoria['materno'].", ".$row_consultoria['nombre']?></td>
            <td><div>Desde:</div></td><td><?php echo date("d-m-Y",strtotime($row_consultoria['fechaInicio']))?></td>
            <td><div>Hasta:</div></td><td><?php echo date("d-m-Y",strtotime($row_consultoria['fechaFinal']))?></td>
        </tr>

    </table>
</fieldset>
<?php
mysql_select_db($database_conexion, $conexion);
$query_regional= "SELECT a.idUC, a.idRegional, b.regional, count(a.idRegional) as numRegional FROM ubicacion_consultoria a, regional b, municipio c, mer d WHERE a.idConsultoria='".$_GET['idConsultoria']."' AND a.idRegional=b.idRegional AND a.idMunicipio=c.idMunicipio AND a.idMer=d.idMer GROUP BY a.idRegional ORDER BY b.regional asc, c.municipio asc, d.mer asc ";
$mostrar_regional=mysql_query($query_regional, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query_municipio= "SELECT a.idUC, a.idMunicipio, c.municipio, count(a.idMunicipio) as numMunicipio FROM ubicacion_consultoria a, regional b, municipio c, mer d WHERE a.idConsultoria='".$_GET['idConsultoria']."' AND a.idRegional=b.idRegional AND a.idMunicipio=c.idMunicipio AND a.idMer=d.idMer GROUP BY a.idMunicipio ORDER BY b.regional asc, c.municipio asc, d.mer asc ";
$mostrar_municipio=mysql_query($query_municipio, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query_totalmers= "SELECT count(idMer) as totalmers FROM ubicacion_consultoria WHERE idConsultoria='".$_GET['idConsultoria']."'";
$mostrar_totalmers=mysql_query($query_totalmers, $conexion) or die(mysql_error());
$row_totalmers=mysql_fetch_assoc($mostrar_totalmers);
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($cronograma->detalle->Visible) { // detalle ?>
	<tr<?php echo $cronograma->detalle->RowAttributes ?>>
		<td class="ewTableHeader">Hito</td>
                <td<?php echo $cronograma->detalle->CellAttributes() ?> colspan="3">
<div<?php echo $cronograma->detalle->ViewAttributes() ?>><?php echo $cronograma->detalle->ViewValue ?></div></td>
                <td>Regional</td>
<?php while($row_regional=mysql_fetch_assoc($mostrar_regional)) {?>
<td colspan="<?php echo $row_regional['numRegional']?>" align="center" style="font-size: 10pt;background: #75923C;color: white"><?php echo strtoupper($row_regional['regional'])?></td>
<?php } ?>
<td rowspan="3">Avance %</td>
        </tr>
<?php } ?>
<?php if ($cronograma->fechaInicio->Visible) { // fechaInicio ?>
	<tr<?php echo $cronograma->fechaInicio->RowAttributes ?>>
		<td class="ewTableHeader">Fecha Inicio</td>
		<td<?php echo $cronograma->fechaInicio->CellAttributes() ?>>
<div<?php echo $cronograma->fechaInicio->ViewAttributes() ?>><?php echo $cronograma->fechaInicio->ViewValue ?></div></td>
<td class="ewTableHeader">Fecha Final</td>
		<td<?php echo $cronograma->fechaFinal->CellAttributes() ?>>
<div<?php echo $cronograma->fechaFinal->ViewAttributes() ?>><?php echo $cronograma->fechaFinal->ViewValue ?></div></td>
                <td>Municipio(s)</td>
<?php while($row_municipio=mysql_fetch_assoc($mostrar_municipio)){?>
<td colspan="<?php echo $row_municipio['numMunicipio']?>" style="font-size: 8pt;background: #C2D69A;text-align: center;border-color: #ffffff"><?php echo $row_municipio['municipio']?></td>
<?php }?>
        </tr>
<?php } ?>
<tr class="ewTableHeader">
    <td style="background: #9df9c1;text-align: center" colspan="2">DESCRIPCION DE RESULTADOS DEL HITO</td>
    <td style="background: #9dfb98;text-align: center" colspan="2">META</td>
    <td style="background: #9dfb98;text-align: center">Meta Alcanzar</td>
 <?php
 $mostrar_municipio=mysql_query($query_municipio, $conexion) or die(mysql_error());
 while($row_municipio=mysql_fetch_assoc($mostrar_municipio)){
mysql_select_db($database_conexion, $conexion);
$query_mers= "SELECT a.idMer, b.mer FROM ubicacion_consultoria a, mer b WHERE a.idConsultoria='".$_GET['idConsultoria']."' AND a.idMunicipio='".$row_municipio['idMunicipio']."' AND a.idMer=b.idMer ORDER BY mer asc";
$mostrar_mers=mysql_query($query_mers, $conexion) or die(mysql_error());
$total_mers=mysql_num_rows($mostrar_mers);
while($row_mers=mysql_fetch_assoc($mostrar_mers)){
?>
    <td style="font-size: 8.5px;background: #EAF1DD"><?php echo $row_mers['mer']?></td>
<?php } }?>
</tr>
<?php
$sw=1;
mysql_select_db($database_conexion, $conexion);
$query_indicador= "SELECT * FROM indicador WHERE idCronograma='".$_GET['idCronograma']."'";
$mostrar_indicador=mysql_query($query_indicador, $conexion) or die(mysql_error());
$total_indicador=mysql_num_rows($mostrar_indicador);

mysql_select_db($database_conexion, $conexion);
$query_resultado= "SELECT * FROM meta WHERE idCronograma='".$_GET['idCronograma']."' ORDER BY idMeta asc";
$mostrar_resultado=mysql_query($query_resultado, $conexion) or die(mysql_error());
$total_resultado=mysql_num_rows($mostrar_resultado);
while($row_resultado=mysql_fetch_assoc($mostrar_resultado)){ ?>
<tr <?php if($row_resultado['cabecera']=='1'){echo "style='background: #DBE5F1;'";}?>>
    <?php if($sw=='1'){?><td colspan="2" rowspan="<?php echo $total_resultado?>">
    <?php while($row_indicador=mysql_fetch_assoc($mostrar_indicador)){?>
        <p><div><?php echo $row_indicador['indicador']?></div></p>
    <?php }
    ?>
    </td><?php $sw=0;} ?>
    <td colspan="2"><table  style="width: 300px;"><tr><td><?php echo $row_resultado['meta']?></td></tr></table></td>
    <td><?php if($row_resultado['cabecera']=='0') {echo $row_resultado['metaAlcanzar']." %";}?></td>
    <?php
    for($i=1;$i<=$row_totalmers['totalmers'];$i++){
      echo "<td></td>";
    }
    ?>
    <td></td>
</tr>
<?php }
?>


</table>
</div>
</td></tr></table>
<p>
<?php if ($cronograma->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php

//
// Page Class
//
class ccronograma_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'cronograma';

	// Page Object Name
	var $PageObjName = 'cronograma_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $cronograma;
		if ($cronograma->UseTokenInUrl) $PageUrl .= "t=" . $cronograma->TableVar . "&"; // add page token
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
		global $objForm, $cronograma;
		if ($cronograma->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($cronograma->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($cronograma->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function ccronograma_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["cronograma"] = new ccronograma();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cronograma', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $cronograma;
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
		if (!$Security->CanView()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("cronogramalist.php");
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
	var $lRecCnt;

	//
	// Page main processing
	//
	function Page_Main() {
		global $cronograma;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idCronograma"] <> "") {
				$cronograma->idCronograma->setQueryStringValue($_GET["idCronograma"]);
			} else {
				$sReturnUrl = "cronogramalist.php"; // Return to list
			}

			// Get action
			$cronograma->CurrentAction = "I"; // Display form
			switch ($cronograma->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No se encontraron registros"); // Set no record message
						$sReturnUrl = "cronogramalist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "cronogramalist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$cronograma->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $cronograma;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$cronograma->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$cronograma->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $cronograma->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$cronograma->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$cronograma->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$cronograma->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $cronograma;
		$sFilter = $cronograma->KeyFilter();

		// Call Row Selecting event
		$cronograma->Row_Selecting($sFilter);

		// Load sql based on filter
		$cronograma->CurrentFilter = $sFilter;
		$sSql = $cronograma->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$cronograma->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $cronograma;
		$cronograma->idCronograma->setDbValue($rs->fields('idCronograma'));
		$cronograma->idConsultoria->setDbValue($rs->fields('idConsultoria'));
		$cronograma->fechaInicio->setDbValue($rs->fields('fechaInicio'));
		$cronograma->fechaFinal->setDbValue($rs->fields('fechaFinal'));
		$cronograma->detalle->setDbValue($rs->fields('detalle'));
		$cronograma->mesAnio->setDbValue($rs->fields('mesAnio'));
		$cronograma->estado->setDbValue($rs->fields('estado'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $cronograma;

		// Call Row_Rendering event
		$cronograma->Row_Rendering();

		// Common render codes for all row types
		// idCronograma

		$cronograma->idCronograma->CellCssStyle = "";
		$cronograma->idCronograma->CellCssClass = "";

		// fechaInicio
		$cronograma->fechaInicio->CellCssStyle = "";
		$cronograma->fechaInicio->CellCssClass = "";

		// fechaFinal
		$cronograma->fechaFinal->CellCssStyle = "";
		$cronograma->fechaFinal->CellCssClass = "";

		// detalle
		$cronograma->detalle->CellCssStyle = "";
		$cronograma->detalle->CellCssClass = "";

		// mesAnio
		$cronograma->mesAnio->CellCssStyle = "";
		$cronograma->mesAnio->CellCssClass = "";

		// estado
		$cronograma->estado->CellCssStyle = "";
		$cronograma->estado->CellCssClass = "";
		if ($cronograma->RowType == EW_ROWTYPE_VIEW) { // View row

			// idCronograma
			$cronograma->idCronograma->ViewValue = $cronograma->idCronograma->CurrentValue;
			$cronograma->idCronograma->CssStyle = "";
			$cronograma->idCronograma->CssClass = "";
			$cronograma->idCronograma->ViewCustomAttributes = "";

			// idConsultoria
			$cronograma->idConsultoria->ViewValue = $cronograma->idConsultoria->CurrentValue;
			$cronograma->idConsultoria->CssStyle = "";
			$cronograma->idConsultoria->CssClass = "";
			$cronograma->idConsultoria->ViewCustomAttributes = "";

			// fechaInicio
			$cronograma->fechaInicio->ViewValue = $cronograma->fechaInicio->CurrentValue;
			$cronograma->fechaInicio->ViewValue = ew_FormatDateTime($cronograma->fechaInicio->ViewValue, 7);
			$cronograma->fechaInicio->CssStyle = "";
			$cronograma->fechaInicio->CssClass = "";
			$cronograma->fechaInicio->ViewCustomAttributes = "";

			// fechaFinal
			$cronograma->fechaFinal->ViewValue = $cronograma->fechaFinal->CurrentValue;
			$cronograma->fechaFinal->ViewValue = ew_FormatDateTime($cronograma->fechaFinal->ViewValue, 7);
			$cronograma->fechaFinal->CssStyle = "";
			$cronograma->fechaFinal->CssClass = "";
			$cronograma->fechaFinal->ViewCustomAttributes = "";

			// detalle
			$cronograma->detalle->ViewValue = $cronograma->detalle->CurrentValue;
			$cronograma->detalle->CssStyle = "";
			$cronograma->detalle->CssClass = "";
			$cronograma->detalle->ViewCustomAttributes = "";

			// mesAnio
			$cronograma->mesAnio->ViewValue = $cronograma->mesAnio->CurrentValue;
			$cronograma->mesAnio->ViewValue = ew_FormatDateTime($cronograma->mesAnio->ViewValue, 7);
			$cronograma->mesAnio->CssStyle = "";
			$cronograma->mesAnio->CssClass = "";
			$cronograma->mesAnio->ViewCustomAttributes = "";

			// estado
			if (strval($cronograma->estado->CurrentValue) <> "") {
				switch ($cronograma->estado->CurrentValue) {
					case "1":
						$cronograma->estado->ViewValue = "Habilitado";
						break;
					case "2":
						$cronograma->estado->ViewValue = "Desabilitado";
						break;
					case "3":
						$cronograma->estado->ViewValue = "Aprobado";
						break;
					default:
						$cronograma->estado->ViewValue = $cronograma->estado->CurrentValue;
				}
			} else {
				$cronograma->estado->ViewValue = NULL;
			}
			$cronograma->estado->CssStyle = "";
			$cronograma->estado->CssClass = "";
			$cronograma->estado->ViewCustomAttributes = "";

			// idCronograma
			$cronograma->idCronograma->HrefValue = "";

			// fechaInicio
			$cronograma->fechaInicio->HrefValue = "";

			// fechaFinal
			$cronograma->fechaFinal->HrefValue = "";

			// detalle
			$cronograma->detalle->HrefValue = "";

			// mesAnio
			$cronograma->mesAnio->HrefValue = "";

			// estado
			$cronograma->estado->HrefValue = "";
		}

		// Call Row Rendered event
		$cronograma->Row_Rendered();
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}
}
?>
