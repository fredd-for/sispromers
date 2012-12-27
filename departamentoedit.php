<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "departamentoinfo.php" ?>
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
$departamento_edit = new cdepartamento_edit();
$Page =& $departamento_edit;

// Page init processing
$departamento_edit->Page_Init();

// Page main processing
$departamento_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var departamento_edit = new ew_Page("departamento_edit");

// page properties
departamento_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = departamento_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
departamento_edit.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_idRegional"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Regional");
		elm = fobj.elements["x" + infix + "_departamento"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Departamento");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
departamento_edit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
departamento_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
departamento_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Editar TABLA: Departamento<br><br>
<a href="<?php echo $departamento->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $departamento_edit->ShowMessage() ?>
<form name="fdepartamentoedit" id="fdepartamentoedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return departamento_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="departamento">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($departamento->idDepartamento->Visible) { // idDepartamento ?>
	<tr<?php echo $departamento->idDepartamento->RowAttributes ?>>
		<td class="ewTableHeader">No</td>
		<td<?php echo $departamento->idDepartamento->CellAttributes() ?>><span id="el_idDepartamento">
<div<?php echo $departamento->idDepartamento->ViewAttributes() ?>><?php echo $departamento->idDepartamento->EditValue ?></div><input type="hidden" name="x_idDepartamento" id="x_idDepartamento" value="<?php echo ew_HtmlEncode($departamento->idDepartamento->CurrentValue) ?>">
</span><?php echo $departamento->idDepartamento->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($departamento->idRegional->Visible) { // idRegional ?>
	<tr<?php echo $departamento->idRegional->RowAttributes ?>>
		<td class="ewTableHeader">Regional<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $departamento->idRegional->CellAttributes() ?>><span id="el_idRegional">
<select id="x_idRegional" name="x_idRegional"<?php echo $departamento->idRegional->EditAttributes() ?>>
<?php
if (is_array($departamento->idRegional->EditValue)) {
	$arwrk = $departamento->idRegional->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($departamento->idRegional->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span><?php echo $departamento->idRegional->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($departamento->departamento->Visible) { // departamento ?>
	<tr<?php echo $departamento->departamento->RowAttributes ?>>
		<td class="ewTableHeader">Departamento<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $departamento->departamento->CellAttributes() ?>><span id="el_departamento">
<input type="text" name="x_departamento" id="x_departamento" size="30" maxlength="150" value="<?php echo $departamento->departamento->EditValue ?>"<?php echo $departamento->departamento->EditAttributes() ?>>
</span><?php echo $departamento->departamento->CustomMsg ?></td>
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
class cdepartamento_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'departamento';

	// Page Object Name
	var $PageObjName = 'departamento_edit';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $departamento;
		if ($departamento->UseTokenInUrl) $PageUrl .= "t=" . $departamento->TableVar . "&"; // add page token
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
		global $objForm, $departamento;
		if ($departamento->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($departamento->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($departamento->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cdepartamento_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["departamento"] = new cdepartamento();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'departamento', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $departamento;
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
			$this->Page_Terminate("departamentolist.php");
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
		global $objForm, $gsFormError, $departamento;

		// Load key from QueryString
		if (@$_GET["idDepartamento"] <> "")
			$departamento->idDepartamento->setQueryStringValue($_GET["idDepartamento"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$departamento->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$departamento->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$departamento->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($departamento->idDepartamento->CurrentValue == "")
			$this->Page_Terminate("departamentolist.php"); // Invalid key, return to list
		switch ($departamento->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No se encontraron registros"); // No record found
					$this->Page_Terminate("departamentolist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$departamento->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Actualizacion exitosa"); // Update success
					$sReturnUrl = $departamento->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$departamento->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $departamento;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $departamento;
		$departamento->idDepartamento->setFormValue($objForm->GetValue("x_idDepartamento"));
		$departamento->idRegional->setFormValue($objForm->GetValue("x_idRegional"));
		$departamento->departamento->setFormValue($objForm->GetValue("x_departamento"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $departamento;
		$this->LoadRow();
		$departamento->idDepartamento->CurrentValue = $departamento->idDepartamento->FormValue;
		$departamento->idRegional->CurrentValue = $departamento->idRegional->FormValue;
		$departamento->departamento->CurrentValue = $departamento->departamento->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $departamento;
		$sFilter = $departamento->KeyFilter();

		// Call Row Selecting event
		$departamento->Row_Selecting($sFilter);

		// Load sql based on filter
		$departamento->CurrentFilter = $sFilter;
		$sSql = $departamento->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$departamento->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $departamento;
		$departamento->idDepartamento->setDbValue($rs->fields('idDepartamento'));
		$departamento->idRegional->setDbValue($rs->fields('idRegional'));
		$departamento->departamento->setDbValue($rs->fields('departamento'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $departamento;

		// Call Row_Rendering event
		$departamento->Row_Rendering();

		// Common render codes for all row types
		// idDepartamento

		$departamento->idDepartamento->CellCssStyle = "";
		$departamento->idDepartamento->CellCssClass = "";

		// idRegional
		$departamento->idRegional->CellCssStyle = "";
		$departamento->idRegional->CellCssClass = "";

		// departamento
		$departamento->departamento->CellCssStyle = "";
		$departamento->departamento->CellCssClass = "";
		if ($departamento->RowType == EW_ROWTYPE_VIEW) { // View row

			// idDepartamento
			$departamento->idDepartamento->ViewValue = $departamento->idDepartamento->CurrentValue;
			$departamento->idDepartamento->CssStyle = "";
			$departamento->idDepartamento->CssClass = "";
			$departamento->idDepartamento->ViewCustomAttributes = "";

			// idRegional
			if (strval($departamento->idRegional->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `regional` FROM `regional` WHERE `idRegional` = " . ew_AdjustSql($departamento->idRegional->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `regional` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$departamento->idRegional->ViewValue = $rswrk->fields('regional');
					$rswrk->Close();
				} else {
					$departamento->idRegional->ViewValue = $departamento->idRegional->CurrentValue;
				}
			} else {
				$departamento->idRegional->ViewValue = NULL;
			}
			$departamento->idRegional->CssStyle = "";
			$departamento->idRegional->CssClass = "";
			$departamento->idRegional->ViewCustomAttributes = "";

			// departamento
			$departamento->departamento->ViewValue = $departamento->departamento->CurrentValue;
			$departamento->departamento->CssStyle = "";
			$departamento->departamento->CssClass = "";
			$departamento->departamento->ViewCustomAttributes = "";

			// idDepartamento
			$departamento->idDepartamento->HrefValue = "";

			// idRegional
			$departamento->idRegional->HrefValue = "";

			// departamento
			$departamento->departamento->HrefValue = "";
		} elseif ($departamento->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// idDepartamento
			$departamento->idDepartamento->EditCustomAttributes = "";
			$departamento->idDepartamento->EditValue = $departamento->idDepartamento->CurrentValue;
			$departamento->idDepartamento->CssStyle = "";
			$departamento->idDepartamento->CssClass = "";
			$departamento->idDepartamento->ViewCustomAttributes = "";

			// idRegional
			$departamento->idRegional->EditCustomAttributes = "";
			$sSqlWrk = "SELECT `idRegional`, `regional`, '' AS Disp2Fld, '' AS SelectFilterFld FROM `regional`";
			$sWhereWrk = "";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `regional` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Por favor Seleccione"));
			$departamento->idRegional->EditValue = $arwrk;

			// departamento
			$departamento->departamento->EditCustomAttributes = "";
			$departamento->departamento->EditValue = ew_HtmlEncode($departamento->departamento->CurrentValue);

			// Edit refer script
			// idDepartamento

			$departamento->idDepartamento->HrefValue = "";

			// idRegional
			$departamento->idRegional->HrefValue = "";

			// departamento
			$departamento->departamento->HrefValue = "";
		}

		// Call Row Rendered event
		$departamento->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $departamento;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($departamento->idRegional->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Regional";
		}
		if ($departamento->departamento->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Departamento";
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
		global $conn, $Security, $departamento;
		$sFilter = $departamento->KeyFilter();
		$departamento->CurrentFilter = $sFilter;
		$sSql = $departamento->SQL();
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

			// Field idDepartamento
			// Field idRegional

			$departamento->idRegional->SetDbValueDef($departamento->idRegional->CurrentValue, 0);
			$rsnew['idRegional'] =& $departamento->idRegional->DbValue;

			// Field departamento
			$departamento->departamento->SetDbValueDef($departamento->departamento->CurrentValue, "");
			$rsnew['departamento'] =& $departamento->departamento->DbValue;

			// Call Row Updating event
			$bUpdateRow = $departamento->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($departamento->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($departamento->CancelMessage <> "") {
					$this->setMessage($departamento->CancelMessage);
					$departamento->CancelMessage = "";
				} else {
					$this->setMessage("Actualizacion cancelada");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$departamento->Row_Updated($rsold, $rsnew);
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
