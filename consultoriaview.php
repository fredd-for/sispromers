<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "consultoriainfo.php" ?>
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
$consultoria_view = new cconsultoria_view();
$Page =& $consultoria_view;

// Page init processing
$consultoria_view->Page_Init();

// Page main processing
$consultoria_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($consultoria->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var consultoria_view = new ew_Page("consultoria_view");

// page properties
consultoria_view.PageID = "view"; // page ID
var EW_PAGE_ID = consultoria_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
consultoria_view.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
consultoria_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
consultoria_view.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<p><span class="phpmaker">Ver TABLA: Consultoria
<br><br>
<?php if ($consultoria->Export == "") { ?>
<a href="consultorialist.php">Volver al listado</a>&nbsp;
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $consultoria->AddUrl() ?>">Adicionar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<a href="<?php echo $consultoria->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<a onclick="return ew_Confirm('¿Quiere borrar este registro?');" href="<?php echo $consultoria->DeleteUrl() ?>">Borrar</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $consultoria_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($consultoria->idConsultoria->Visible) { // idConsultoria ?>
	<tr<?php echo $consultoria->idConsultoria->RowAttributes ?>>
		<td class="ewTableHeader">Nro</td>
		<td<?php echo $consultoria->idConsultoria->CellAttributes() ?>>
<div<?php echo $consultoria->idConsultoria->ViewAttributes() ?>><?php echo $consultoria->idConsultoria->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($consultoria->idUsuario->Visible) { // idUsuario ?>
	<tr<?php echo $consultoria->idUsuario->RowAttributes ?>>
		<td class="ewTableHeader">Consultor</td>
		<td<?php echo $consultoria->idUsuario->CellAttributes() ?>>
<div<?php echo $consultoria->idUsuario->ViewAttributes() ?>><?php echo $consultoria->idUsuario->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($consultoria->consultoria->Visible) { // consultoria ?>
	<tr<?php echo $consultoria->consultoria->RowAttributes ?>>
		<td class="ewTableHeader">Titulo de la Consultoria</td>
		<td<?php echo $consultoria->consultoria->CellAttributes() ?>>
<div<?php echo $consultoria->consultoria->ViewAttributes() ?>><?php echo $consultoria->consultoria->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($consultoria->fechaInicio->Visible) { // fechaInicio ?>
	<tr<?php echo $consultoria->fechaInicio->RowAttributes ?>>
		<td class="ewTableHeader">Fecha Inicio</td>
		<td<?php echo $consultoria->fechaInicio->CellAttributes() ?>>
<div<?php echo $consultoria->fechaInicio->ViewAttributes() ?>><?php echo $consultoria->fechaInicio->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($consultoria->fechaFinal->Visible) { // fechaFinal ?>
	<tr<?php echo $consultoria->fechaFinal->RowAttributes ?>>
		<td class="ewTableHeader">Fecha Finalizacion</td>
		<td<?php echo $consultoria->fechaFinal->CellAttributes() ?>>
<div<?php echo $consultoria->fechaFinal->ViewAttributes() ?>><?php echo $consultoria->fechaFinal->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($consultoria->estado->Visible) { // estado ?>
	<tr<?php echo $consultoria->estado->RowAttributes ?>>
		<td class="ewTableHeader">Estado</td>
		<td<?php echo $consultoria->estado->CellAttributes() ?>>
<div<?php echo $consultoria->estado->ViewAttributes() ?>><?php echo $consultoria->estado->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($consultoria->Export == "") { ?>
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
class cconsultoria_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'consultoria';

	// Page Object Name
	var $PageObjName = 'consultoria_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $consultoria;
		if ($consultoria->UseTokenInUrl) $PageUrl .= "t=" . $consultoria->TableVar . "&"; // add page token
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
		global $objForm, $consultoria;
		if ($consultoria->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($consultoria->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($consultoria->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cconsultoria_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["consultoria"] = new cconsultoria();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'consultoria', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $consultoria;
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
			$this->Page_Terminate("consultorialist.php");
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
		global $consultoria;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idConsultoria"] <> "") {
				$consultoria->idConsultoria->setQueryStringValue($_GET["idConsultoria"]);
			} else {
				$sReturnUrl = "consultorialist.php"; // Return to list
			}

			// Get action
			$consultoria->CurrentAction = "I"; // Display form
			switch ($consultoria->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No se encontraron registros"); // Set no record message
						$sReturnUrl = "consultorialist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "consultorialist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$consultoria->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $consultoria;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$consultoria->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$consultoria->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $consultoria->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$consultoria->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$consultoria->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$consultoria->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $consultoria;
		$sFilter = $consultoria->KeyFilter();

		// Call Row Selecting event
		$consultoria->Row_Selecting($sFilter);

		// Load sql based on filter
		$consultoria->CurrentFilter = $sFilter;
		$sSql = $consultoria->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$consultoria->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $consultoria;
		$consultoria->idConsultoria->setDbValue($rs->fields('idConsultoria'));
		$consultoria->idUsuario->setDbValue($rs->fields('idUsuario'));
		$consultoria->consultoria->setDbValue($rs->fields('consultoria'));
		$consultoria->fechaInicio->setDbValue($rs->fields('fechaInicio'));
		$consultoria->fechaFinal->setDbValue($rs->fields('fechaFinal'));
		$consultoria->estado->setDbValue($rs->fields('estado'));
		$consultoria->fechaCreacion->setDbValue($rs->fields('fechaCreacion'));
		$consultoria->fechaModificacion->setDbValue($rs->fields('fechaModificacion'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $consultoria;

		// Call Row_Rendering event
		$consultoria->Row_Rendering();

		// Common render codes for all row types
		// idConsultoria

		$consultoria->idConsultoria->CellCssStyle = "";
		$consultoria->idConsultoria->CellCssClass = "";

		// idUsuario
		$consultoria->idUsuario->CellCssStyle = "";
		$consultoria->idUsuario->CellCssClass = "";

		// consultoria
		$consultoria->consultoria->CellCssStyle = "";
		$consultoria->consultoria->CellCssClass = "";

		// fechaInicio
		$consultoria->fechaInicio->CellCssStyle = "";
		$consultoria->fechaInicio->CellCssClass = "";

		// fechaFinal
		$consultoria->fechaFinal->CellCssStyle = "";
		$consultoria->fechaFinal->CellCssClass = "";

		// estado
		$consultoria->estado->CellCssStyle = "";
		$consultoria->estado->CellCssClass = "";
		if ($consultoria->RowType == EW_ROWTYPE_VIEW) { // View row

			// idConsultoria
			$consultoria->idConsultoria->ViewValue = $consultoria->idConsultoria->CurrentValue;
			$consultoria->idConsultoria->CssStyle = "";
			$consultoria->idConsultoria->CssClass = "";
			$consultoria->idConsultoria->ViewCustomAttributes = "";

			// idUsuario
			if (strval($consultoria->idUsuario->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `paterno`, `nombre` FROM `usuario` WHERE `idUsuario` = " . ew_AdjustSql($consultoria->idUsuario->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `paterno` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$consultoria->idUsuario->ViewValue = $rswrk->fields('paterno');
					$consultoria->idUsuario->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('nombre');
					$rswrk->Close();
				} else {
					$consultoria->idUsuario->ViewValue = $consultoria->idUsuario->CurrentValue;
				}
			} else {
				$consultoria->idUsuario->ViewValue = NULL;
			}
			$consultoria->idUsuario->CssStyle = "";
			$consultoria->idUsuario->CssClass = "";
			$consultoria->idUsuario->ViewCustomAttributes = "";

			// consultoria
			$consultoria->consultoria->ViewValue = $consultoria->consultoria->CurrentValue;
			$consultoria->consultoria->CssStyle = "";
			$consultoria->consultoria->CssClass = "";
			$consultoria->consultoria->ViewCustomAttributes = "";

			// fechaInicio
			$consultoria->fechaInicio->ViewValue = $consultoria->fechaInicio->CurrentValue;
			$consultoria->fechaInicio->ViewValue = ew_FormatDateTime($consultoria->fechaInicio->ViewValue, 7);
			$consultoria->fechaInicio->CssStyle = "";
			$consultoria->fechaInicio->CssClass = "";
			$consultoria->fechaInicio->ViewCustomAttributes = "";

			// fechaFinal
			$consultoria->fechaFinal->ViewValue = $consultoria->fechaFinal->CurrentValue;
			$consultoria->fechaFinal->ViewValue = ew_FormatDateTime($consultoria->fechaFinal->ViewValue, 7);
			$consultoria->fechaFinal->CssStyle = "";
			$consultoria->fechaFinal->CssClass = "";
			$consultoria->fechaFinal->ViewCustomAttributes = "";

			// estado
			if (strval($consultoria->estado->CurrentValue) <> "") {
				switch ($consultoria->estado->CurrentValue) {
					case "0":
						$consultoria->estado->ViewValue = "borrado";
						break;
					case "1":
						$consultoria->estado->ViewValue = "Habilitado";
						break;
					case "2":
						$consultoria->estado->ViewValue = "Desabilitado";
						break;
					case "3":
						$consultoria->estado->ViewValue = "Aprobado";
						break;
					default:
						$consultoria->estado->ViewValue = $consultoria->estado->CurrentValue;
				}
			} else {
				$consultoria->estado->ViewValue = NULL;
			}
			$consultoria->estado->CssStyle = "";
			$consultoria->estado->CssClass = "";
			$consultoria->estado->ViewCustomAttributes = "";

			// idConsultoria
			$consultoria->idConsultoria->HrefValue = "";

			// idUsuario
			$consultoria->idUsuario->HrefValue = "";

			// consultoria
			$consultoria->consultoria->HrefValue = "";

			// fechaInicio
			$consultoria->fechaInicio->HrefValue = "";

			// fechaFinal
			$consultoria->fechaFinal->HrefValue = "";

			// estado
			$consultoria->estado->HrefValue = "";
		}

		// Call Row Rendered event
		$consultoria->Row_Rendered();
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
