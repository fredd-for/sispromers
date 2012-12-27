<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "planillainfo.php" ?>
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
$planilla_edit = new cplanilla_edit();
$Page =& $planilla_edit;

// Page init processing
$planilla_edit->Page_Init();

// Page main processing
$planilla_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var planilla_edit = new ew_Page("planilla_edit");

// page properties
planilla_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = planilla_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
planilla_edit.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_Nombre"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Nombre del Formulario");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
planilla_edit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
planilla_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
planilla_edit.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script type="text/javascript">
<!--
var ew_DHTMLEditors = [];

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<p><span class="phpmaker">Editar TABLA: Formularios<br><br>
<a href="<?php echo $planilla->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $planilla_edit->ShowMessage() ?>
<form name="fplanillaedit" id="fplanillaedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return planilla_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="planilla">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($planilla->idPlanilla->Visible) { // idPlanilla ?>
	<tr<?php echo $planilla->idPlanilla->RowAttributes ?>>
		<td class="ewTableHeader">No</td>
		<td<?php echo $planilla->idPlanilla->CellAttributes() ?>><span id="el_idPlanilla">
<div<?php echo $planilla->idPlanilla->ViewAttributes() ?>><?php echo $planilla->idPlanilla->EditValue ?></div><input type="hidden" name="x_idPlanilla" id="x_idPlanilla" value="<?php echo ew_HtmlEncode($planilla->idPlanilla->CurrentValue) ?>">
</span><?php echo $planilla->idPlanilla->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($planilla->Nombre->Visible) { // Nombre ?>
	<tr<?php echo $planilla->Nombre->RowAttributes ?>>
		<td class="ewTableHeader">Nombre del Formulario<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $planilla->Nombre->CellAttributes() ?>><span id="el_Nombre">
<input type="text" name="x_Nombre" id="x_Nombre" size="30" maxlength="150" value="<?php echo $planilla->Nombre->EditValue ?>"<?php echo $planilla->Nombre->EditAttributes() ?>>
</span><?php echo $planilla->Nombre->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="  EDITAR  ">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php

//
// Page Class
//
class cplanilla_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'planilla';

	// Page Object Name
	var $PageObjName = 'planilla_edit';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $planilla;
		if ($planilla->UseTokenInUrl) $PageUrl .= "t=" . $planilla->TableVar . "&"; // add page token
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
		global $objForm, $planilla;
		if ($planilla->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($planilla->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($planilla->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cplanilla_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["planilla"] = new cplanilla();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'planilla', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $planilla;
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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("planillalist.php");
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

	// 
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsFormError, $planilla;

		// Load key from QueryString
		if (@$_GET["idPlanilla"] <> "")
			$planilla->idPlanilla->setQueryStringValue($_GET["idPlanilla"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$planilla->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$planilla->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$planilla->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($planilla->idPlanilla->CurrentValue == "")
			$this->Page_Terminate("planillalist.php"); // Invalid key, return to list
		switch ($planilla->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No se encontraron registros"); // No record found
					$this->Page_Terminate("planillalist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$planilla->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Actualizacion exitosa"); // Update success
					$sReturnUrl = $planilla->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$planilla->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $planilla;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $planilla;
		$planilla->idPlanilla->setFormValue($objForm->GetValue("x_idPlanilla"));
		$planilla->Nombre->setFormValue($objForm->GetValue("x_Nombre"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $planilla;
		$this->LoadRow();
		$planilla->idPlanilla->CurrentValue = $planilla->idPlanilla->FormValue;
		$planilla->Nombre->CurrentValue = $planilla->Nombre->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $planilla;
		$sFilter = $planilla->KeyFilter();

		// Call Row Selecting event
		$planilla->Row_Selecting($sFilter);

		// Load sql based on filter
		$planilla->CurrentFilter = $sFilter;
		$sSql = $planilla->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$planilla->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $planilla;
		$planilla->idPlanilla->setDbValue($rs->fields('idPlanilla'));
		$planilla->Nombre->setDbValue($rs->fields('Nombre'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $planilla;

		// Call Row_Rendering event
		$planilla->Row_Rendering();

		// Common render codes for all row types
		// idPlanilla

		$planilla->idPlanilla->CellCssStyle = "";
		$planilla->idPlanilla->CellCssClass = "";

		// Nombre
		$planilla->Nombre->CellCssStyle = "";
		$planilla->Nombre->CellCssClass = "";
		if ($planilla->RowType == EW_ROWTYPE_VIEW) { // View row

			// idPlanilla
			$planilla->idPlanilla->ViewValue = $planilla->idPlanilla->CurrentValue;
			$planilla->idPlanilla->CssStyle = "";
			$planilla->idPlanilla->CssClass = "";
			$planilla->idPlanilla->ViewCustomAttributes = "";

			// Nombre
			$planilla->Nombre->ViewValue = $planilla->Nombre->CurrentValue;
			$planilla->Nombre->CssStyle = "";
			$planilla->Nombre->CssClass = "";
			$planilla->Nombre->ViewCustomAttributes = "";

			// idPlanilla
			$planilla->idPlanilla->HrefValue = "";

			// Nombre
			$planilla->Nombre->HrefValue = "";
		} elseif ($planilla->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// idPlanilla
			$planilla->idPlanilla->EditCustomAttributes = "";
			$planilla->idPlanilla->EditValue = $planilla->idPlanilla->CurrentValue;
			$planilla->idPlanilla->CssStyle = "";
			$planilla->idPlanilla->CssClass = "";
			$planilla->idPlanilla->ViewCustomAttributes = "";

			// Nombre
			$planilla->Nombre->EditCustomAttributes = "";
			$planilla->Nombre->EditValue = ew_HtmlEncode($planilla->Nombre->CurrentValue);

			// Edit refer script
			// idPlanilla

			$planilla->idPlanilla->HrefValue = "";

			// Nombre
			$planilla->Nombre->HrefValue = "";
		}

		// Call Row Rendered event
		$planilla->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $planilla;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($planilla->Nombre->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Nombre del Formulario";
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $planilla;
		$sFilter = $planilla->KeyFilter();
		$planilla->CurrentFilter = $sFilter;
		$sSql = $planilla->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold =& $rs->fields;
			$rsnew = array();

			// Field idPlanilla
			// Field Nombre

			$planilla->Nombre->SetDbValueDef($planilla->Nombre->CurrentValue, "");
			$rsnew['Nombre'] =& $planilla->Nombre->DbValue;

			// Call Row Updating event
			$bUpdateRow = $planilla->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($planilla->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($planilla->CancelMessage <> "") {
					$this->setMessage($planilla->CancelMessage);
					$planilla->CancelMessage = "";
				} else {
					$this->setMessage("Actualizacion cancelada");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$planilla->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
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
