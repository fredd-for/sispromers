<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "comunidadinfo.php" ?>
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
$comunidad_edit = new ccomunidad_edit();
$Page =& $comunidad_edit;

// Page init processing
$comunidad_edit->Page_Init();

// Page main processing
$comunidad_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var comunidad_edit = new ew_Page("comunidad_edit");

// page properties
comunidad_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = comunidad_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
comunidad_edit.ValidateForm = function(fobj) {
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
//		elm = fobj.elements["x" + infix + "_idMunicipio"];
//		if (elm && !ew_HasValue(elm))
//			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Municipio");
		elm = fobj.elements["x" + infix + "_comunidad"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Comunidad");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
comunidad_edit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
comunidad_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
comunidad_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Editar TABLA: Comunidad<br><br>
<a href="<?php echo $comunidad->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $comunidad_edit->ShowMessage() ?>
<form name="fcomunidadedit" id="fcomunidadedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return comunidad_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="comunidad">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($comunidad->idComunidad->Visible) { // idComunidad ?>
	<tr<?php echo $comunidad->idComunidad->RowAttributes ?>>
		<td class="ewTableHeader">No</td>
		<td<?php echo $comunidad->idComunidad->CellAttributes() ?>><span id="el_idComunidad">
<div<?php echo $comunidad->idComunidad->ViewAttributes() ?>><?php echo $comunidad->idComunidad->EditValue ?></div><input type="hidden" name="x_idComunidad" id="x_idComunidad" value="<?php echo ew_HtmlEncode($comunidad->idComunidad->CurrentValue) ?>">
</span><?php echo $comunidad->idComunidad->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comunidad->idRegional->Visible) { // idRegional ?>
	<tr<?php echo $comunidad->idRegional->RowAttributes ?>>
		<td class="ewTableHeader">Regional<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $comunidad->idRegional->CellAttributes() ?>><span id="el_idRegional">
                        <select id="x_idRegional" name="x_idRegional"<?php echo $comunidad->idRegional->EditAttributes() ?> >
<?php
if (is_array($comunidad->idRegional->EditValue)) {
	$arwrk = $comunidad->idRegional->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($comunidad->idRegional->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span><?php echo $comunidad->idRegional->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comunidad->idDepartamento->Visible) { // idDepartamento ?>
	<tr<?php echo $comunidad->idDepartamento->RowAttributes ?>>
		<td class="ewTableHeader">Departamento<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $comunidad->idDepartamento->CellAttributes() ?>><span id="el_idDepartamento">
<input type="hidden" name="x_idDepartamento_edit" id="x_idDepartamento_edit" value="<?php echo $comunidad->idDepartamento->CurrentValue ?>"/>
<div id="divx_idDepartamento"></div>
</span><?php echo $comunidad->idDepartamento->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comunidad->idMunicipio->Visible) { // idMunicipio ?>
	<tr<?php echo $comunidad->idMunicipio->RowAttributes ?>>
		<td class="ewTableHeader">Municipio<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $comunidad->idMunicipio->CellAttributes() ?>><span id="el_idMunicipio">
<input type="hidden" name="x_idMunicipio_edit" id="x_idMunicipio_edit" value="<?php echo $comunidad->idMunicipio->CurrentValue ?>"/>
<div id="divx_idMunicipio"></div>

</span><?php echo $comunidad->idMunicipio->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comunidad->comunidad->Visible) { // comunidad ?>
	<tr<?php echo $comunidad->comunidad->RowAttributes ?>>
		<td class="ewTableHeader">Comunidad<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $comunidad->comunidad->CellAttributes() ?>><span id="el_comunidad">
<input type="text" name="x_comunidad" id="x_comunidad" size="30" maxlength="150" value="<?php echo $comunidad->comunidad->EditValue ?>"<?php echo $comunidad->comunidad->EditAttributes() ?>>
</span><?php echo $comunidad->comunidad->CustomMsg ?></td>
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
class ccomunidad_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'comunidad';

	// Page Object Name
	var $PageObjName = 'comunidad_edit';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $comunidad;
		if ($comunidad->UseTokenInUrl) $PageUrl .= "t=" . $comunidad->TableVar . "&"; // add page token
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
		global $objForm, $comunidad;
		if ($comunidad->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($comunidad->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($comunidad->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function ccomunidad_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["comunidad"] = new ccomunidad();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'comunidad', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $comunidad;
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
			$this->Page_Terminate("comunidadlist.php");
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
		global $objForm, $gsFormError, $comunidad;

		// Load key from QueryString
		if (@$_GET["idComunidad"] <> "")
			$comunidad->idComunidad->setQueryStringValue($_GET["idComunidad"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$comunidad->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$comunidad->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$comunidad->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($comunidad->idComunidad->CurrentValue == "")
			$this->Page_Terminate("comunidadlist.php"); // Invalid key, return to list
		switch ($comunidad->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No se encontraron registros"); // No record found
					$this->Page_Terminate("comunidadlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$comunidad->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Actualizacion exitosa"); // Update success
					$sReturnUrl = $comunidad->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$comunidad->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $comunidad;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $comunidad;
		$comunidad->idComunidad->setFormValue($objForm->GetValue("x_idComunidad"));
		$comunidad->idRegional->setFormValue($objForm->GetValue("x_idRegional"));
		$comunidad->idDepartamento->setFormValue($objForm->GetValue("x_idDepartamento"));
		$comunidad->idMunicipio->setFormValue($objForm->GetValue("x_idMunicipio"));
		$comunidad->comunidad->setFormValue($objForm->GetValue("x_comunidad"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $comunidad;
		$this->LoadRow();
		$comunidad->idComunidad->CurrentValue = $comunidad->idComunidad->FormValue;
		$comunidad->idRegional->CurrentValue = $comunidad->idRegional->FormValue;
		$comunidad->idDepartamento->CurrentValue = $comunidad->idDepartamento->FormValue;
		$comunidad->idMunicipio->CurrentValue = $comunidad->idMunicipio->FormValue;
		$comunidad->comunidad->CurrentValue = $comunidad->comunidad->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $comunidad;
		$sFilter = $comunidad->KeyFilter();

		// Call Row Selecting event
		$comunidad->Row_Selecting($sFilter);

		// Load sql based on filter
		$comunidad->CurrentFilter = $sFilter;
		$sSql = $comunidad->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$comunidad->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $comunidad;
		$comunidad->idComunidad->setDbValue($rs->fields('idComunidad'));
		$comunidad->idRegional->setDbValue($rs->fields('idRegional'));
		$comunidad->idDepartamento->setDbValue($rs->fields('idDepartamento'));
		$comunidad->idMunicipio->setDbValue($rs->fields('idMunicipio'));
		$comunidad->comunidad->setDbValue($rs->fields('comunidad'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $comunidad;

		// Call Row_Rendering event
		$comunidad->Row_Rendering();

		// Common render codes for all row types
		// idComunidad

		$comunidad->idComunidad->CellCssStyle = "";
		$comunidad->idComunidad->CellCssClass = "";

		// idRegional
		$comunidad->idRegional->CellCssStyle = "";
		$comunidad->idRegional->CellCssClass = "";

		// idDepartamento
		$comunidad->idDepartamento->CellCssStyle = "";
		$comunidad->idDepartamento->CellCssClass = "";

		// idMunicipio
		$comunidad->idMunicipio->CellCssStyle = "";
		$comunidad->idMunicipio->CellCssClass = "";

		// comunidad
		$comunidad->comunidad->CellCssStyle = "";
		$comunidad->comunidad->CellCssClass = "";
		if ($comunidad->RowType == EW_ROWTYPE_VIEW) { // View row

			// idComunidad
			$comunidad->idComunidad->ViewValue = $comunidad->idComunidad->CurrentValue;
			$comunidad->idComunidad->CssStyle = "";
			$comunidad->idComunidad->CssClass = "";
			$comunidad->idComunidad->ViewCustomAttributes = "";

			// idRegional
			if (strval($comunidad->idRegional->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `regional` FROM `regional` WHERE `idRegional` = " . ew_AdjustSql($comunidad->idRegional->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `regional` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$comunidad->idRegional->ViewValue = $rswrk->fields('regional');
					$rswrk->Close();
				} else {
					$comunidad->idRegional->ViewValue = $comunidad->idRegional->CurrentValue;
				}
			} else {
				$comunidad->idRegional->ViewValue = NULL;
			}
			$comunidad->idRegional->CssStyle = "";
			$comunidad->idRegional->CssClass = "";
			$comunidad->idRegional->ViewCustomAttributes = "";

			// idDepartamento
			if (strval($comunidad->idDepartamento->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `departamento` FROM `departamento` WHERE `idDepartamento` = " . ew_AdjustSql($comunidad->idDepartamento->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `departamento` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$comunidad->idDepartamento->ViewValue = $rswrk->fields('departamento');
					$rswrk->Close();
				} else {
					$comunidad->idDepartamento->ViewValue = $comunidad->idDepartamento->CurrentValue;
				}
			} else {
				$comunidad->idDepartamento->ViewValue = NULL;
			}
			$comunidad->idDepartamento->CssStyle = "";
			$comunidad->idDepartamento->CssClass = "";
			$comunidad->idDepartamento->ViewCustomAttributes = "";

			// idMunicipio
			if (strval($comunidad->idMunicipio->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `municipio` FROM `municipio` WHERE `idMunicipio` = " . ew_AdjustSql($comunidad->idMunicipio->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `municipio` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$comunidad->idMunicipio->ViewValue = $rswrk->fields('municipio');
					$rswrk->Close();
				} else {
					$comunidad->idMunicipio->ViewValue = $comunidad->idMunicipio->CurrentValue;
				}
			} else {
				$comunidad->idMunicipio->ViewValue = NULL;
			}
			$comunidad->idMunicipio->CssStyle = "";
			$comunidad->idMunicipio->CssClass = "";
			$comunidad->idMunicipio->ViewCustomAttributes = "";

			// comunidad
			$comunidad->comunidad->ViewValue = $comunidad->comunidad->CurrentValue;
			$comunidad->comunidad->CssStyle = "";
			$comunidad->comunidad->CssClass = "";
			$comunidad->comunidad->ViewCustomAttributes = "";

			// idComunidad
			$comunidad->idComunidad->HrefValue = "";

			// idRegional
			$comunidad->idRegional->HrefValue = "";

			// idDepartamento
			$comunidad->idDepartamento->HrefValue = "";

			// idMunicipio
			$comunidad->idMunicipio->HrefValue = "";

			// comunidad
			$comunidad->comunidad->HrefValue = "";
		} elseif ($comunidad->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// idComunidad
			$comunidad->idComunidad->EditCustomAttributes = "";
			$comunidad->idComunidad->EditValue = $comunidad->idComunidad->CurrentValue;
			$comunidad->idComunidad->CssStyle = "";
			$comunidad->idComunidad->CssClass = "";
			$comunidad->idComunidad->ViewCustomAttributes = "";

			// idRegional
			$comunidad->idRegional->EditCustomAttributes = "";
			$sSqlWrk = "SELECT `idRegional`, `regional`, '' AS Disp2Fld, '' AS SelectFilterFld FROM `regional`";
			$sWhereWrk = "";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `regional` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Por favor Seleccione"));
			$comunidad->idRegional->EditValue = $arwrk;

			// idDepartamento
			$comunidad->idDepartamento->EditCustomAttributes = "";
			$sSqlWrk = "SELECT `idDepartamento`, `departamento`, '' AS Disp2Fld, '' AS SelectFilterFld FROM `departamento`";
			$sWhereWrk = "";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `departamento` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Por favor Seleccione"));
			$comunidad->idDepartamento->EditValue = $arwrk;

			// idMunicipio
			$comunidad->idMunicipio->EditCustomAttributes = "";
			$sSqlWrk = "SELECT `idMunicipio`, `municipio`, '' AS Disp2Fld, '' AS SelectFilterFld FROM `municipio`";
			$sWhereWrk = "";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `municipio` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Por favor Seleccione"));
			$comunidad->idMunicipio->EditValue = $arwrk;

			// comunidad
			$comunidad->comunidad->EditCustomAttributes = "";
			$comunidad->comunidad->EditValue = ew_HtmlEncode($comunidad->comunidad->CurrentValue);

			// Edit refer script
			// idComunidad

			$comunidad->idComunidad->HrefValue = "";

			// idRegional
			$comunidad->idRegional->HrefValue = "";

			// idDepartamento
			$comunidad->idDepartamento->HrefValue = "";

			// idMunicipio
			$comunidad->idMunicipio->HrefValue = "";

			// comunidad
			$comunidad->comunidad->HrefValue = "";
		}

		// Call Row Rendered event
		$comunidad->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $comunidad;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($comunidad->idRegional->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Regional";
		}
		if ($comunidad->idDepartamento->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Departamento";
		}
		if ($comunidad->idMunicipio->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Municipio";
		}
		if ($comunidad->comunidad->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Comunidad";
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
		global $conn, $Security, $comunidad;
		$sFilter = $comunidad->KeyFilter();
		$comunidad->CurrentFilter = $sFilter;
		$sSql = $comunidad->SQL();
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

			// Field idComunidad
			// Field idRegional

			$comunidad->idRegional->SetDbValueDef($comunidad->idRegional->CurrentValue, 0);
			$rsnew['idRegional'] =& $comunidad->idRegional->DbValue;

			// Field idDepartamento
			$comunidad->idDepartamento->SetDbValueDef($comunidad->idDepartamento->CurrentValue, 0);
			$rsnew['idDepartamento'] =& $comunidad->idDepartamento->DbValue;

			// Field idMunicipio
			$comunidad->idMunicipio->SetDbValueDef($comunidad->idMunicipio->CurrentValue, 0);
			$rsnew['idMunicipio'] =& $comunidad->idMunicipio->DbValue;

			// Field comunidad
			$comunidad->comunidad->SetDbValueDef($comunidad->comunidad->CurrentValue, "");
			$rsnew['comunidad'] =& $comunidad->comunidad->DbValue;

			// Call Row Updating event
			$bUpdateRow = $comunidad->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($comunidad->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($comunidad->CancelMessage <> "") {
					$this->setMessage($comunidad->CancelMessage);
					$comunidad->CancelMessage = "";
				} else {
					$this->setMessage("Actualizacion cancelada");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$comunidad->Row_Updated($rsold, $rsnew);
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
