<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "responsableinfo.php" ?>
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
$responsable_view = new cresponsable_view();
$Page =& $responsable_view;

// Page init processing
$responsable_view->Page_Init();

// Page main processing
$responsable_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($responsable->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var responsable_view = new ew_Page("responsable_view");

// page properties
responsable_view.PageID = "view"; // page ID
var EW_PAGE_ID = responsable_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
responsable_view.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
responsable_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
responsable_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Ver TABLA: Responsable
<br><br>
<?php if ($responsable->Export == "") { ?>
<a href="responsablelist.php">Volver al listado</a>&nbsp;
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $responsable->AddUrl() ?>">Adicionar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<a href="<?php echo $responsable->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<a onclick="return ew_Confirm('�Quiere borrar este registro?');" href="<?php echo $responsable->DeleteUrl() ?>">Borrar</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $responsable_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($responsable->idResponsable->Visible) { // idResponsable ?>
	<tr<?php echo $responsable->idResponsable->RowAttributes ?>>
		<td class="ewTableHeader">No</td>
		<td<?php echo $responsable->idResponsable->CellAttributes() ?>>
<div<?php echo $responsable->idResponsable->ViewAttributes() ?>><?php echo $responsable->idResponsable->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($responsable->idGerente->Visible) { // idGerente ?>
	<tr<?php echo $responsable->idGerente->RowAttributes ?>>
		<td class="ewTableHeader">Gerente</td>
		<td<?php echo $responsable->idGerente->CellAttributes() ?>>
<div<?php echo $responsable->idGerente->ViewAttributes() ?>><?php echo $responsable->idGerente->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($responsable->idMer->Visible) { // idMer ?>
	<tr<?php echo $responsable->idMer->RowAttributes ?>>
		<td class="ewTableHeader">Mer</td>
		<td<?php echo $responsable->idMer->CellAttributes() ?>>
<div<?php echo $responsable->idMer->ViewAttributes() ?>><?php echo $responsable->idMer->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($responsable->fecha->Visible) { // fecha ?>
	<tr<?php echo $responsable->fecha->RowAttributes ?>>
		<td class="ewTableHeader">Fecha de Asignacion</td>
		<td<?php echo $responsable->fecha->CellAttributes() ?>>
<div<?php echo $responsable->fecha->ViewAttributes() ?>><?php echo $responsable->fecha->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($responsable->Export == "") { ?>
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
class cresponsable_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'responsable';

	// Page Object Name
	var $PageObjName = 'responsable_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $responsable;
		if ($responsable->UseTokenInUrl) $PageUrl .= "t=" . $responsable->TableVar . "&"; // add page token
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
		global $objForm, $responsable;
		if ($responsable->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($responsable->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($responsable->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cresponsable_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["responsable"] = new cresponsable();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'responsable', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $responsable;
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
			$this->Page_Terminate("responsablelist.php");
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
		global $responsable;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idResponsable"] <> "") {
				$responsable->idResponsable->setQueryStringValue($_GET["idResponsable"]);
			} else {
				$sReturnUrl = "responsablelist.php"; // Return to list
			}

			// Get action
			$responsable->CurrentAction = "I"; // Display form
			switch ($responsable->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No se encontraron registros"); // Set no record message
						$sReturnUrl = "responsablelist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "responsablelist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$responsable->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $responsable;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$responsable->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$responsable->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $responsable->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$responsable->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$responsable->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$responsable->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $responsable;
		$sFilter = $responsable->KeyFilter();

		// Call Row Selecting event
		$responsable->Row_Selecting($sFilter);

		// Load sql based on filter
		$responsable->CurrentFilter = $sFilter;
		$sSql = $responsable->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$responsable->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $responsable;
		$responsable->idResponsable->setDbValue($rs->fields('idResponsable'));
		$responsable->idGerente->setDbValue($rs->fields('idGerente'));
		$responsable->idMer->setDbValue($rs->fields('idMer'));
		$responsable->fecha->setDbValue($rs->fields('fecha'));
		$responsable->habilitado->setDbValue($rs->fields('habilitado'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $responsable;

		// Call Row_Rendering event
		$responsable->Row_Rendering();

		// Common render codes for all row types
		// idResponsable

		$responsable->idResponsable->CellCssStyle = "";
		$responsable->idResponsable->CellCssClass = "";

		// idGerente
		$responsable->idGerente->CellCssStyle = "";
		$responsable->idGerente->CellCssClass = "";

		// idMer
		$responsable->idMer->CellCssStyle = "";
		$responsable->idMer->CellCssClass = "";

		// fecha
		$responsable->fecha->CellCssStyle = "";
		$responsable->fecha->CellCssClass = "";
		if ($responsable->RowType == EW_ROWTYPE_VIEW) { // View row

			// idResponsable
			$responsable->idResponsable->ViewValue = $responsable->idResponsable->CurrentValue;
			$responsable->idResponsable->CssStyle = "";
			$responsable->idResponsable->CssClass = "";
			$responsable->idResponsable->ViewCustomAttributes = "";

			// idGerente
			if (strval($responsable->idGerente->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `nombre`, `paterno`, `materno` FROM `usuario` WHERE `idUsuario` = " . ew_AdjustSql($responsable->idGerente->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `paterno` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
		$responsable->idGerente->ViewValue = $rswrk->fields('paterno');
                                        $responsable->idGerente->ViewValue .= " ".$rswrk->fields('materno');
					$responsable->idGerente->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('nombre');
					$rswrk->Close();
				} else {
					$responsable->idGerente->ViewValue = $responsable->idGerente->CurrentValue;
				}
			} else {
				$responsable->idGerente->ViewValue = NULL;
			}
			$responsable->idGerente->CssStyle = "";
			$responsable->idGerente->CssClass = "";
			$responsable->idGerente->ViewCustomAttributes = "";

			// idMer
			if (strval($responsable->idMer->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `mer` FROM `mer` WHERE `idMer` = " . ew_AdjustSql($responsable->idMer->CurrentValue) . "";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$responsable->idMer->ViewValue = $rswrk->fields('mer');
					$rswrk->Close();
				} else {
					$responsable->idMer->ViewValue = $responsable->idMer->CurrentValue;
				}
			} else {
				$responsable->idMer->ViewValue = NULL;
			}
			$responsable->idMer->CssStyle = "";
			$responsable->idMer->CssClass = "";
			$responsable->idMer->ViewCustomAttributes = "";

			// fecha
			$responsable->fecha->ViewValue = $responsable->fecha->CurrentValue;
			$responsable->fecha->ViewValue = ew_FormatDateTime($responsable->fecha->ViewValue, 7);
			$responsable->fecha->CssStyle = "";
			$responsable->fecha->CssClass = "";
			$responsable->fecha->ViewCustomAttributes = "";

			// idResponsable
			$responsable->idResponsable->HrefValue = "";

			// idGerente
			$responsable->idGerente->HrefValue = "";

			// idMer
			$responsable->idMer->HrefValue = "";

			// fecha
			$responsable->fecha->HrefValue = "";
		}

		// Call Row Rendered event
		$responsable->Row_Rendered();
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
