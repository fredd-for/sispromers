<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "formularioinfo.php" ?>
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
$formulario_view = new cformulario_view();
$Page =& $formulario_view;

// Page init processing
$formulario_view->Page_Init();

// Page main processing
$formulario_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($formulario->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var formulario_view = new ew_Page("formulario_view");

// page properties
formulario_view.PageID = "view"; // page ID
var EW_PAGE_ID = formulario_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
formulario_view.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
formulario_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
formulario_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Ver TABLA: Formulario
<br><br>
<?php if ($formulario->Export == "") { ?>
<a href="formulariolist.php">Volver al listado</a>&nbsp;
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $formulario->AddUrl() ?>">Adicionar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<a href="<?php echo $formulario->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<a onclick="return ew_Confirm('¿Quiere borrar este registro?');" href="<?php echo $formulario->DeleteUrl() ?>">Borrar</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $formulario_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($formulario->idFormulario->Visible) { // idFormulario ?>
	<tr<?php echo $formulario->idFormulario->RowAttributes ?>>
		<td class="ewTableHeader">Id Formulario</td>
		<td<?php echo $formulario->idFormulario->CellAttributes() ?>>
<div<?php echo $formulario->idFormulario->ViewAttributes() ?>><?php echo $formulario->idFormulario->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($formulario->idMer->Visible) { // idMer ?>
	<tr<?php echo $formulario->idMer->RowAttributes ?>>
		<td class="ewTableHeader">Id Mer</td>
		<td<?php echo $formulario->idMer->CellAttributes() ?>>
<div<?php echo $formulario->idMer->ViewAttributes() ?>><?php echo $formulario->idMer->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($formulario->idPlanilla->Visible) { // idPlanilla ?>
	<tr<?php echo $formulario->idPlanilla->RowAttributes ?>>
		<td class="ewTableHeader">Id Planilla</td>
		<td<?php echo $formulario->idPlanilla->CellAttributes() ?>>
<div<?php echo $formulario->idPlanilla->ViewAttributes() ?>><?php echo $formulario->idPlanilla->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($formulario->archivo->Visible) { // archivo ?>
	<tr<?php echo $formulario->archivo->RowAttributes ?>>
		<td class="ewTableHeader">Archivo</td>
		<td<?php echo $formulario->archivo->CellAttributes() ?>>
<div<?php echo $formulario->archivo->ViewAttributes() ?>><?php echo $formulario->archivo->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($formulario->cuenta->Visible) { // cuenta ?>
	<tr<?php echo $formulario->cuenta->RowAttributes ?>>
		<td class="ewTableHeader">Cuenta</td>
		<td<?php echo $formulario->cuenta->CellAttributes() ?>>
<div<?php echo $formulario->cuenta->ViewAttributes() ?>><?php echo $formulario->cuenta->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($formulario->porcentaje->Visible) { // porcentaje ?>
	<tr<?php echo $formulario->porcentaje->RowAttributes ?>>
		<td class="ewTableHeader">Porcentaje</td>
		<td<?php echo $formulario->porcentaje->CellAttributes() ?>>
<div<?php echo $formulario->porcentaje->ViewAttributes() ?>><?php echo $formulario->porcentaje->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($formulario->observacion->Visible) { // observacion ?>
	<tr<?php echo $formulario->observacion->RowAttributes ?>>
		<td class="ewTableHeader">Observacion</td>
		<td<?php echo $formulario->observacion->CellAttributes() ?>>
<div<?php echo $formulario->observacion->ViewAttributes() ?>><?php echo $formulario->observacion->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($formulario->Export == "") { ?>
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
class cformulario_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'formulario';

	// Page Object Name
	var $PageObjName = 'formulario_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $formulario;
		if ($formulario->UseTokenInUrl) $PageUrl .= "t=" . $formulario->TableVar . "&"; // add page token
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
		global $objForm, $formulario;
		if ($formulario->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($formulario->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($formulario->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cformulario_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["formulario"] = new cformulario();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'formulario', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $formulario;
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
			$this->Page_Terminate("formulariolist.php");
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
		global $formulario;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idFormulario"] <> "") {
				$formulario->idFormulario->setQueryStringValue($_GET["idFormulario"]);
			} else {
				$sReturnUrl = "formulariolist.php"; // Return to list
			}

			// Get action
			$formulario->CurrentAction = "I"; // Display form
			switch ($formulario->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No se encontraron registros"); // Set no record message
						$sReturnUrl = "formulariolist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "formulariolist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$formulario->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $formulario;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$formulario->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$formulario->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $formulario->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$formulario->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$formulario->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$formulario->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $formulario;
		$sFilter = $formulario->KeyFilter();

		// Call Row Selecting event
		$formulario->Row_Selecting($sFilter);

		// Load sql based on filter
		$formulario->CurrentFilter = $sFilter;
		$sSql = $formulario->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$formulario->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $formulario;
		$formulario->idFormulario->setDbValue($rs->fields('idFormulario'));
		$formulario->idMer->setDbValue($rs->fields('idMer'));
		$formulario->idPlanilla->setDbValue($rs->fields('idPlanilla'));
		$formulario->archivo->setDbValue($rs->fields('archivo'));
		$formulario->cuenta->setDbValue($rs->fields('cuenta'));
		$formulario->porcentaje->setDbValue($rs->fields('porcentaje'));
		$formulario->observacion->setDbValue($rs->fields('observacion'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $formulario;

		// Call Row_Rendering event
		$formulario->Row_Rendering();

		// Common render codes for all row types
		// idFormulario

		$formulario->idFormulario->CellCssStyle = "";
		$formulario->idFormulario->CellCssClass = "";

		// idMer
		$formulario->idMer->CellCssStyle = "";
		$formulario->idMer->CellCssClass = "";

		// idPlanilla
		$formulario->idPlanilla->CellCssStyle = "";
		$formulario->idPlanilla->CellCssClass = "";

		// archivo
		$formulario->archivo->CellCssStyle = "";
		$formulario->archivo->CellCssClass = "";

		// cuenta
		$formulario->cuenta->CellCssStyle = "";
		$formulario->cuenta->CellCssClass = "";

		// porcentaje
		$formulario->porcentaje->CellCssStyle = "";
		$formulario->porcentaje->CellCssClass = "";

		// observacion
		$formulario->observacion->CellCssStyle = "";
		$formulario->observacion->CellCssClass = "";
		if ($formulario->RowType == EW_ROWTYPE_VIEW) { // View row

			// idFormulario
			$formulario->idFormulario->ViewValue = $formulario->idFormulario->CurrentValue;
			$formulario->idFormulario->CssStyle = "";
			$formulario->idFormulario->CssClass = "";
			$formulario->idFormulario->ViewCustomAttributes = "";

			// idMer
			$formulario->idMer->ViewValue = $formulario->idMer->CurrentValue;
			$formulario->idMer->CssStyle = "";
			$formulario->idMer->CssClass = "";
			$formulario->idMer->ViewCustomAttributes = "";

			// idPlanilla
			$formulario->idPlanilla->ViewValue = $formulario->idPlanilla->CurrentValue;
			$formulario->idPlanilla->CssStyle = "";
			$formulario->idPlanilla->CssClass = "";
			$formulario->idPlanilla->ViewCustomAttributes = "";

			// archivo
			$formulario->archivo->ViewValue = $formulario->archivo->CurrentValue;
			$formulario->archivo->CssStyle = "";
			$formulario->archivo->CssClass = "";
			$formulario->archivo->ViewCustomAttributes = "";

			// cuenta
			$formulario->cuenta->ViewValue = $formulario->cuenta->CurrentValue;
			$formulario->cuenta->CssStyle = "";
			$formulario->cuenta->CssClass = "";
			$formulario->cuenta->ViewCustomAttributes = "";

			// porcentaje
			$formulario->porcentaje->ViewValue = $formulario->porcentaje->CurrentValue;
			$formulario->porcentaje->CssStyle = "";
			$formulario->porcentaje->CssClass = "";
			$formulario->porcentaje->ViewCustomAttributes = "";

			// observacion
			$formulario->observacion->ViewValue = $formulario->observacion->CurrentValue;
			$formulario->observacion->CssStyle = "";
			$formulario->observacion->CssClass = "";
			$formulario->observacion->ViewCustomAttributes = "";

			// idFormulario
			$formulario->idFormulario->HrefValue = "";

			// idMer
			$formulario->idMer->HrefValue = "";

			// idPlanilla
			$formulario->idPlanilla->HrefValue = "";

			// archivo
			$formulario->archivo->HrefValue = "";

			// cuenta
			$formulario->cuenta->HrefValue = "";

			// porcentaje
			$formulario->porcentaje->HrefValue = "";

			// observacion
			$formulario->observacion->HrefValue = "";
		}

		// Call Row Rendered event
		$formulario->Row_Rendered();
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
