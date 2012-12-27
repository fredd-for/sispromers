<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "municipioinfo.php" ?>
<?php include "usuarioinfo.php" ?>
<?php include "userfn6.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: no-cache, must-revalidate");
//header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Define page object
$municipio_edit = new cmunicipio_edit();
$Page =& $municipio_edit;

// Page init processing
$municipio_edit->Page_Init();

// Page main processing
$municipio_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var municipio_edit = new ew_Page("municipio_edit");

// page properties
municipio_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = municipio_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
municipio_edit.ValidateForm = function(fobj) {
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
//		elm = fobj.elements["x" + infix + "_idDepartamento"];
//		if (elm && !ew_HasValue(elm))
//			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Departamento");
		elm = fobj.elements["x" + infix + "_municipio"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Municipio");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
municipio_edit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
municipio_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
municipio_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Editar TABLA: Municipio<br><br>
<a href="<?php echo $municipio->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $municipio_edit->ShowMessage() ?>
<form name="fmunicipioedit" id="fmunicipioedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return municipio_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="municipio">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($municipio->idMunicipio->Visible) { // idMunicipio ?>
	<tr<?php echo $municipio->idMunicipio->RowAttributes ?>>
		<td class="ewTableHeader">No</td>
		<td<?php echo $municipio->idMunicipio->CellAttributes() ?>><span id="el_idMunicipio">
<div<?php echo $municipio->idMunicipio->ViewAttributes() ?>><?php echo $municipio->idMunicipio->EditValue ?></div><input type="hidden" name="x_idMunicipio" id="x_idMunicipio" value="<?php echo ew_HtmlEncode($municipio->idMunicipio->CurrentValue) ?>">
</span><?php echo $municipio->idMunicipio->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($municipio->idRegional->Visible) { // idRegional ?>
	<tr<?php echo $municipio->idRegional->RowAttributes ?>>
		<td class="ewTableHeader">Regional<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $municipio->idRegional->CellAttributes() ?>><span id="el_idRegional">
<select id="x_idRegional" name="x_idRegional"<?php echo $municipio->idRegional->EditAttributes() ?>>
<?php
if (is_array($municipio->idRegional->EditValue)) {
	$arwrk = $municipio->idRegional->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($municipio->idRegional->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span><?php echo $municipio->idRegional->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($municipio->idDepartamento->Visible) { // idDepartamento ?>
	<tr<?php echo $municipio->idDepartamento->RowAttributes ?>>
		<td class="ewTableHeader">Departamento<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $municipio->idDepartamento->CellAttributes() ?>><span id="el_idDepartamento">
<input type="hidden" name="x_idDepartamento_edit" id="x_idDepartamento_edit" value="<?php echo $municipio->idDepartamento->CurrentValue ?>"/>
<div id="divx_idDepartamento"></div></span><?php echo $municipio->idDepartamento->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($municipio->municipio->Visible) { // municipio ?>
	<tr<?php echo $municipio->municipio->RowAttributes ?>>
		<td class="ewTableHeader">Municipio<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $municipio->municipio->CellAttributes() ?>><span id="el_municipio">
<input type="text" name="x_municipio" id="x_municipio" size="30" maxlength="150" value="<?php echo $municipio->municipio->EditValue ?>"<?php echo $municipio->municipio->EditAttributes() ?>>
</span><?php echo $municipio->municipio->CustomMsg ?></td>
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
class cmunicipio_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'municipio';

	// Page Object Name
	var $PageObjName = 'municipio_edit';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $municipio;
		if ($municipio->UseTokenInUrl) $PageUrl .= "t=" . $municipio->TableVar . "&"; // add page token
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
		global $objForm, $municipio;
		if ($municipio->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($municipio->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($municipio->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cmunicipio_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["municipio"] = new cmunicipio();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'municipio', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $municipio;
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
			$this->Page_Terminate("municipiolist.php");
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
		global $objForm, $gsFormError, $municipio;

		// Load key from QueryString
		if (@$_GET["idMunicipio"] <> "")
			$municipio->idMunicipio->setQueryStringValue($_GET["idMunicipio"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$municipio->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$municipio->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$municipio->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($municipio->idMunicipio->CurrentValue == "")
			$this->Page_Terminate("municipiolist.php"); // Invalid key, return to list
		switch ($municipio->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No se encontraron registros"); // No record found
					$this->Page_Terminate("municipiolist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$municipio->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Actualizacion exitosa"); // Update success
					$sReturnUrl = $municipio->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$municipio->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $municipio;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $municipio;
		$municipio->idMunicipio->setFormValue($objForm->GetValue("x_idMunicipio"));
		$municipio->idRegional->setFormValue($objForm->GetValue("x_idRegional"));
		$municipio->idDepartamento->setFormValue($objForm->GetValue("x_idDepartamento"));
		$municipio->municipio->setFormValue($objForm->GetValue("x_municipio"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $municipio;
		$this->LoadRow();
		$municipio->idMunicipio->CurrentValue = $municipio->idMunicipio->FormValue;
		$municipio->idRegional->CurrentValue = $municipio->idRegional->FormValue;
		$municipio->idDepartamento->CurrentValue = $municipio->idDepartamento->FormValue;
		$municipio->municipio->CurrentValue = $municipio->municipio->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $municipio;
		$sFilter = $municipio->KeyFilter();

		// Call Row Selecting event
		$municipio->Row_Selecting($sFilter);

		// Load sql based on filter
		$municipio->CurrentFilter = $sFilter;
		$sSql = $municipio->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$municipio->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $municipio;
		$municipio->idMunicipio->setDbValue($rs->fields('idMunicipio'));
		$municipio->idRegional->setDbValue($rs->fields('idRegional'));
		$municipio->idDepartamento->setDbValue($rs->fields('idDepartamento'));
		$municipio->municipio->setDbValue($rs->fields('municipio'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $municipio;

		// Call Row_Rendering event
		$municipio->Row_Rendering();

		// Common render codes for all row types
		// idMunicipio

		$municipio->idMunicipio->CellCssStyle = "";
		$municipio->idMunicipio->CellCssClass = "";

		// idRegional
		$municipio->idRegional->CellCssStyle = "";
		$municipio->idRegional->CellCssClass = "";

		// idDepartamento
		$municipio->idDepartamento->CellCssStyle = "";
		$municipio->idDepartamento->CellCssClass = "";

		// municipio
		$municipio->municipio->CellCssStyle = "";
		$municipio->municipio->CellCssClass = "";
		if ($municipio->RowType == EW_ROWTYPE_VIEW) { // View row

			// idMunicipio
			$municipio->idMunicipio->ViewValue = $municipio->idMunicipio->CurrentValue;
			$municipio->idMunicipio->CssStyle = "";
			$municipio->idMunicipio->CssClass = "";
			$municipio->idMunicipio->ViewCustomAttributes = "";

			// idRegional
			if (strval($municipio->idRegional->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `regional` FROM `regional` WHERE `idRegional` = " . ew_AdjustSql($municipio->idRegional->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `regional` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$municipio->idRegional->ViewValue = $rswrk->fields('regional');
					$rswrk->Close();
				} else {
					$municipio->idRegional->ViewValue = $municipio->idRegional->CurrentValue;
				}
			} else {
				$municipio->idRegional->ViewValue = NULL;
			}
			$municipio->idRegional->CssStyle = "";
			$municipio->idRegional->CssClass = "";
			$municipio->idRegional->ViewCustomAttributes = "";

			// idDepartamento
			if (strval($municipio->idDepartamento->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `departamento` FROM `departamento` WHERE `idDepartamento` = " . ew_AdjustSql($municipio->idDepartamento->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `departamento` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$municipio->idDepartamento->ViewValue = $rswrk->fields('departamento');
					$rswrk->Close();
				} else {
					$municipio->idDepartamento->ViewValue = $municipio->idDepartamento->CurrentValue;
				}
			} else {
				$municipio->idDepartamento->ViewValue = NULL;
			}
			$municipio->idDepartamento->CssStyle = "";
			$municipio->idDepartamento->CssClass = "";
			$municipio->idDepartamento->ViewCustomAttributes = "";

			// municipio
			$municipio->municipio->ViewValue = $municipio->municipio->CurrentValue;
			$municipio->municipio->CssStyle = "";
			$municipio->municipio->CssClass = "";
			$municipio->municipio->ViewCustomAttributes = "";

			// idMunicipio
			$municipio->idMunicipio->HrefValue = "";

			// idRegional
			$municipio->idRegional->HrefValue = "";

			// idDepartamento
			$municipio->idDepartamento->HrefValue = "";

			// municipio
			$municipio->municipio->HrefValue = "";
		} elseif ($municipio->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// idMunicipio
			$municipio->idMunicipio->EditCustomAttributes = "";
			$municipio->idMunicipio->EditValue = $municipio->idMunicipio->CurrentValue;
			$municipio->idMunicipio->CssStyle = "";
			$municipio->idMunicipio->CssClass = "";
			$municipio->idMunicipio->ViewCustomAttributes = "";

			// idRegional
			$municipio->idRegional->EditCustomAttributes = "";
			$sSqlWrk = "SELECT `idRegional`, `regional`, '' AS Disp2Fld, '' AS SelectFilterFld FROM `regional`";
			$sWhereWrk = "";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `regional` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Por favor Seleccione"));
			$municipio->idRegional->EditValue = $arwrk;

			// idDepartamento
			$municipio->idDepartamento->EditCustomAttributes = "";
			$sSqlWrk = "SELECT `idDepartamento`, `departamento`, '' AS Disp2Fld, '' AS SelectFilterFld FROM `departamento`";
			$sWhereWrk = "";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `departamento` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Por favor Seleccione"));
			$municipio->idDepartamento->EditValue = $arwrk;

			// municipio
			$municipio->municipio->EditCustomAttributes = "";
			$municipio->municipio->EditValue = ew_HtmlEncode($municipio->municipio->CurrentValue);

			// Edit refer script
			// idMunicipio

			$municipio->idMunicipio->HrefValue = "";

			// idRegional
			$municipio->idRegional->HrefValue = "";

			// idDepartamento
			$municipio->idDepartamento->HrefValue = "";

			// municipio
			$municipio->municipio->HrefValue = "";
		}

		// Call Row Rendered event
		$municipio->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $municipio;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($municipio->idRegional->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Regional";
		}
		if ($municipio->idDepartamento->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Departamento";
		}
		if ($municipio->municipio->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Municipio";
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
		global $conn, $Security, $municipio;
		$sFilter = $municipio->KeyFilter();
		$municipio->CurrentFilter = $sFilter;
		$sSql = $municipio->SQL();
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

			// Field idMunicipio
			// Field idRegional

			$municipio->idRegional->SetDbValueDef($municipio->idRegional->CurrentValue, 0);
			$rsnew['idRegional'] =& $municipio->idRegional->DbValue;

			// Field idDepartamento
			$municipio->idDepartamento->SetDbValueDef($municipio->idDepartamento->CurrentValue, 0);
			$rsnew['idDepartamento'] =& $municipio->idDepartamento->DbValue;

			// Field municipio
			$municipio->municipio->SetDbValueDef($municipio->municipio->CurrentValue, "");
			$rsnew['municipio'] =& $municipio->municipio->DbValue;

			// Call Row Updating event
			$bUpdateRow = $municipio->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($municipio->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($municipio->CancelMessage <> "") {
					$this->setMessage($municipio->CancelMessage);
					$municipio->CancelMessage = "";
				} else {
					$this->setMessage("Actualizacion cancelada");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$municipio->Row_Updated($rsold, $rsnew);
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
