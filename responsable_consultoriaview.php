<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "responsable_consultoriainfo.php" ?>
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
$responsable_consultoria_view = new cresponsable_consultoria_view();
$Page =& $responsable_consultoria_view;

// Page init processing
$responsable_consultoria_view->Page_Init();

// Page main processing
$responsable_consultoria_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($responsable_consultoria->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var responsable_consultoria_view = new ew_Page("responsable_consultoria_view");

// page properties
responsable_consultoria_view.PageID = "view"; // page ID
var EW_PAGE_ID = responsable_consultoria_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
responsable_consultoria_view.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
responsable_consultoria_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
responsable_consultoria_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Ver TABLA: Responsable Consultoria
<br><br>
<?php if ($responsable_consultoria->Export == "") { ?>
<a href="responsable_consultorialist.php">Volver al listado</a>&nbsp;
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $responsable_consultoria->AddUrl() ?>">Adicionar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<a href="<?php echo $responsable_consultoria->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $responsable_consultoria->CopyUrl() ?>">Copear</a>&nbsp;
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<a onclick="return ew_Confirm('¿Quiere borrar este registro?');" href="<?php echo $responsable_consultoria->DeleteUrl() ?>">Borrar</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $responsable_consultoria_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($responsable_consultoria->idRC->Visible) { // idRC ?>
	<tr<?php echo $responsable_consultoria->idRC->RowAttributes ?>>
		<td class="ewTableHeader">No</td>
		<td<?php echo $responsable_consultoria->idRC->CellAttributes() ?>>
<div<?php echo $responsable_consultoria->idRC->ViewAttributes() ?>><?php echo $responsable_consultoria->idRC->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($responsable_consultoria->idUsuario->Visible) { // idUsuario ?>
	<tr<?php echo $responsable_consultoria->idUsuario->RowAttributes ?>>
		<td class="ewTableHeader">Usuario (Revisor)</td>
		<td<?php echo $responsable_consultoria->idUsuario->CellAttributes() ?>>
<div<?php echo $responsable_consultoria->idUsuario->ViewAttributes() ?>><?php echo $responsable_consultoria->idUsuario->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($responsable_consultoria->idConsultoria->Visible) { // idConsultoria ?>
	<tr<?php echo $responsable_consultoria->idConsultoria->RowAttributes ?>>
		<td class="ewTableHeader">Consultoria</td>
		<td<?php echo $responsable_consultoria->idConsultoria->CellAttributes() ?>>
<div<?php echo $responsable_consultoria->idConsultoria->ViewAttributes() ?>><?php echo $responsable_consultoria->idConsultoria->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($responsable_consultoria->fecha->Visible) { // fecha ?>
	<tr<?php echo $responsable_consultoria->fecha->RowAttributes ?>>
		<td class="ewTableHeader">Fecha de Asignacion</td>
		<td<?php echo $responsable_consultoria->fecha->CellAttributes() ?>>
<div<?php echo $responsable_consultoria->fecha->ViewAttributes() ?>><?php echo $responsable_consultoria->fecha->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($responsable_consultoria->Export == "") { ?>
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
class cresponsable_consultoria_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'responsable_consultoria';

	// Page Object Name
	var $PageObjName = 'responsable_consultoria_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $responsable_consultoria;
		if ($responsable_consultoria->UseTokenInUrl) $PageUrl .= "t=" . $responsable_consultoria->TableVar . "&"; // add page token
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
		global $objForm, $responsable_consultoria;
		if ($responsable_consultoria->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($responsable_consultoria->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($responsable_consultoria->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cresponsable_consultoria_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["responsable_consultoria"] = new cresponsable_consultoria();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'responsable_consultoria', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $responsable_consultoria;
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
			$this->Page_Terminate("responsable_consultorialist.php");
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
		global $responsable_consultoria;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idRC"] <> "") {
				$responsable_consultoria->idRC->setQueryStringValue($_GET["idRC"]);
			} else {
				$sReturnUrl = "responsable_consultorialist.php"; // Return to list
			}

			// Get action
			$responsable_consultoria->CurrentAction = "I"; // Display form
			switch ($responsable_consultoria->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No se encontraron registros"); // Set no record message
						$sReturnUrl = "responsable_consultorialist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "responsable_consultorialist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$responsable_consultoria->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $responsable_consultoria;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$responsable_consultoria->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$responsable_consultoria->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $responsable_consultoria->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$responsable_consultoria->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$responsable_consultoria->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$responsable_consultoria->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $responsable_consultoria;
		$sFilter = $responsable_consultoria->KeyFilter();

		// Call Row Selecting event
		$responsable_consultoria->Row_Selecting($sFilter);

		// Load sql based on filter
		$responsable_consultoria->CurrentFilter = $sFilter;
		$sSql = $responsable_consultoria->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$responsable_consultoria->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $responsable_consultoria;
		$responsable_consultoria->idRC->setDbValue($rs->fields('idRC'));
		$responsable_consultoria->idUsuario->setDbValue($rs->fields('idUsuario'));
		$responsable_consultoria->idConsultoria->setDbValue($rs->fields('idConsultoria'));
		$responsable_consultoria->fecha->setDbValue($rs->fields('fecha'));
		$responsable_consultoria->habilitado->setDbValue($rs->fields('habilitado'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $responsable_consultoria;

		// Call Row_Rendering event
		$responsable_consultoria->Row_Rendering();

		// Common render codes for all row types
		// idRC

		$responsable_consultoria->idRC->CellCssStyle = "";
		$responsable_consultoria->idRC->CellCssClass = "";

		// idUsuario
		$responsable_consultoria->idUsuario->CellCssStyle = "";
		$responsable_consultoria->idUsuario->CellCssClass = "";

		// idConsultoria
		$responsable_consultoria->idConsultoria->CellCssStyle = "";
		$responsable_consultoria->idConsultoria->CellCssClass = "";

		// fecha
		$responsable_consultoria->fecha->CellCssStyle = "";
		$responsable_consultoria->fecha->CellCssClass = "";
		if ($responsable_consultoria->RowType == EW_ROWTYPE_VIEW) { // View row

			// idRC
			$responsable_consultoria->idRC->ViewValue = $responsable_consultoria->idRC->CurrentValue;
			$responsable_consultoria->idRC->CssStyle = "";
			$responsable_consultoria->idRC->CssClass = "";
			$responsable_consultoria->idRC->ViewCustomAttributes = "";

			// idUsuario
			if (strval($responsable_consultoria->idUsuario->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `nombre`, `paterno` FROM `usuario` WHERE `idUsuario` = " . ew_AdjustSql($responsable_consultoria->idUsuario->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `paterno` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$responsable_consultoria->idUsuario->ViewValue = $rswrk->fields('nombre');
					$responsable_consultoria->idUsuario->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('paterno');
					$rswrk->Close();
				} else {
					$responsable_consultoria->idUsuario->ViewValue = $responsable_consultoria->idUsuario->CurrentValue;
				}
			} else {
				$responsable_consultoria->idUsuario->ViewValue = NULL;
			}
			$responsable_consultoria->idUsuario->CssStyle = "";
			$responsable_consultoria->idUsuario->CssClass = "";
			$responsable_consultoria->idUsuario->ViewCustomAttributes = "";

			// idConsultoria
			if (strval($responsable_consultoria->idConsultoria->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `consultoria`, `idUsuario` FROM `consultoria` WHERE `idConsultoria` = " . ew_AdjustSql($responsable_consultoria->idConsultoria->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `consultoria` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$responsable_consultoria->idConsultoria->ViewValue = $rswrk->fields('consultoria');
					$responsable_consultoria->idConsultoria->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('idUsuario');
					$rswrk->Close();
				} else {
					$responsable_consultoria->idConsultoria->ViewValue = $responsable_consultoria->idConsultoria->CurrentValue;
				}
			} else {
				$responsable_consultoria->idConsultoria->ViewValue = NULL;
			}
			$responsable_consultoria->idConsultoria->CssStyle = "";
			$responsable_consultoria->idConsultoria->CssClass = "";
			$responsable_consultoria->idConsultoria->ViewCustomAttributes = "";

			// fecha
			$responsable_consultoria->fecha->ViewValue = $responsable_consultoria->fecha->CurrentValue;
			$responsable_consultoria->fecha->ViewValue = ew_FormatDateTime($responsable_consultoria->fecha->ViewValue, 7);
			$responsable_consultoria->fecha->CssStyle = "";
			$responsable_consultoria->fecha->CssClass = "";
			$responsable_consultoria->fecha->ViewCustomAttributes = "";

			// idRC
			$responsable_consultoria->idRC->HrefValue = "";

			// idUsuario
			$responsable_consultoria->idUsuario->HrefValue = "";

			// idConsultoria
			$responsable_consultoria->idConsultoria->HrefValue = "";

			// fecha
			$responsable_consultoria->fecha->HrefValue = "";
		}

		// Call Row Rendered event
		$responsable_consultoria->Row_Rendered();
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
