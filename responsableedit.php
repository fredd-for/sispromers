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
$responsable_edit = new cresponsable_edit();
$Page =& $responsable_edit;

// Page init processing
$responsable_edit->Page_Init();

// Page main processing
$responsable_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var responsable_edit = new ew_Page("responsable_edit");

// page properties
responsable_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = responsable_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
responsable_edit.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_idGerente"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Gerente");
		elm = fobj.elements["x" + infix + "_idMer"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Mer");
		elm = fobj.elements["x" + infix + "_fecha"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Fecha de Asignacion");
		elm = fobj.elements["x" + infix + "_fecha"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "Fecha incorrecta, formato = dd/mm/yyyy - Fecha de Asignacion");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
responsable_edit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
responsable_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
responsable_edit.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<link rel="stylesheet" type="text/css" media="all" href="calendar/calendar-win2k-1.css" title="win2k-1">
<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="calendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>
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
<p><span class="phpmaker">Editar TABLA: Responsable<br><br>
<a href="<?php echo $responsable->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $responsable_edit->ShowMessage() ?>
<form name="fresponsableedit" id="fresponsableedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return responsable_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="responsable">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($responsable->idResponsable->Visible) { // idResponsable ?>
	<tr<?php echo $responsable->idResponsable->RowAttributes ?>>
		<td class="ewTableHeader">No</td>
		<td<?php echo $responsable->idResponsable->CellAttributes() ?>><span id="el_idResponsable">
<div<?php echo $responsable->idResponsable->ViewAttributes() ?>><?php echo $responsable->idResponsable->EditValue ?></div><input type="hidden" name="x_idResponsable" id="x_idResponsable" value="<?php echo ew_HtmlEncode($responsable->idResponsable->CurrentValue) ?>">
</span><?php echo $responsable->idResponsable->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($responsable->idGerente->Visible) { // idGerente ?>
	<tr<?php echo $responsable->idGerente->RowAttributes ?>>
		<td class="ewTableHeader">Gerente<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $responsable->idGerente->CellAttributes() ?>><span id="el_idGerente">
<select id="x_idGerente" name="x_idGerente"<?php echo $responsable->idGerente->EditAttributes() ?>>
<?php
if (is_array($responsable->idGerente->EditValue)) {
	$arwrk = $responsable->idGerente->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($responsable->idGerente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
</span><?php echo $responsable->idGerente->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($responsable->idMer->Visible) { // idMer ?>
	<tr<?php echo $responsable->idMer->RowAttributes ?>>
		<td class="ewTableHeader">Mer<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $responsable->idMer->CellAttributes() ?>><span id="el_idMer">
<select id="x_idMer" name="x_idMer"<?php echo $responsable->idMer->EditAttributes() ?>>
<?php
if (is_array($responsable->idMer->EditValue)) {
	$arwrk = $responsable->idMer->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($responsable->idMer->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span><?php echo $responsable->idMer->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($responsable->fecha->Visible) { // fecha ?>
	<tr<?php echo $responsable->fecha->RowAttributes ?>>
		<td class="ewTableHeader">Fecha de Asignacion<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $responsable->fecha->CellAttributes() ?>><span id="el_fecha">
<input type="text" name="x_fecha" id="x_fecha" value="<?php echo $responsable->fecha->EditValue ?>"<?php echo $responsable->fecha->EditAttributes() ?>>
&nbsp;<img src="images/calendar.png" id="cal_x_fecha" name="cal_x_fecha" alt="Seleccione una fecha" style="cursor:pointer;cursor:hand;">
<script type="text/javascript">
Calendar.setup({
	inputField : "x_fecha", // ID of the input field
	ifFormat : "%d/%m/%Y", // the date format
	button : "cal_x_fecha" // ID of the button
});
</script>
</span><?php echo $responsable->fecha->CustomMsg ?></td>
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
class cresponsable_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'responsable';

	// Page Object Name
	var $PageObjName = 'responsable_edit';

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
	function cresponsable_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["responsable"] = new cresponsable();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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

	// 
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsFormError, $responsable;

		// Load key from QueryString
		if (@$_GET["idResponsable"] <> "")
			$responsable->idResponsable->setQueryStringValue($_GET["idResponsable"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$responsable->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$responsable->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$responsable->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($responsable->idResponsable->CurrentValue == "")
			$this->Page_Terminate("responsablelist.php"); // Invalid key, return to list
		switch ($responsable->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No se encontraron registros"); // No record found
					$this->Page_Terminate("responsablelist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$responsable->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Actualizacion exitosa"); // Update success
					$sReturnUrl = $responsable->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$responsable->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $responsable;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $responsable;
		$responsable->idResponsable->setFormValue($objForm->GetValue("x_idResponsable"));
		$responsable->idGerente->setFormValue($objForm->GetValue("x_idGerente"));
		$responsable->idMer->setFormValue($objForm->GetValue("x_idMer"));
		$responsable->fecha->setFormValue($objForm->GetValue("x_fecha"));
		$responsable->fecha->CurrentValue = ew_UnFormatDateTime($responsable->fecha->CurrentValue, 7);
	}

	// Restore form values
	function RestoreFormValues() {
		global $responsable;
		$this->LoadRow();
		$responsable->idResponsable->CurrentValue = $responsable->idResponsable->FormValue;
		$responsable->idGerente->CurrentValue = $responsable->idGerente->FormValue;
		$responsable->idMer->CurrentValue = $responsable->idMer->FormValue;
		$responsable->fecha->CurrentValue = $responsable->fecha->FormValue;
		$responsable->fecha->CurrentValue = ew_UnFormatDateTime($responsable->fecha->CurrentValue, 7);
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
				$sSqlWrk = "SELECT `nombre`, `paterno` FROM `usuario` WHERE `idUsuario` = " . ew_AdjustSql($responsable->idGerente->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `paterno` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$responsable->idGerente->ViewValue = $rswrk->fields('nombre');
					$responsable->idGerente->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('paterno');
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
		} elseif ($responsable->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// idResponsable
			$responsable->idResponsable->EditCustomAttributes = "";
			$responsable->idResponsable->EditValue = $responsable->idResponsable->CurrentValue;
			$responsable->idResponsable->CssStyle = "";
			$responsable->idResponsable->CssClass = "";
			$responsable->idResponsable->ViewCustomAttributes = "";

			// idGerente
			$responsable->idGerente->EditCustomAttributes = "";
			$sSqlWrk = "SELECT `idUsuario`, `paterno`, `nombre`, '' AS SelectFilterFld FROM `usuario`";
			$sWhereWrk = "idRol='2'";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `paterno` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Por favor Seleccione", ""));
			$responsable->idGerente->EditValue = $arwrk;

			// idMer
			$responsable->idMer->EditCustomAttributes = "";
			$sSqlWrk = "SELECT `idMer`, `mer`, '' AS Disp2Fld, '' AS SelectFilterFld FROM `mer`";
			$sWhereWrk = "";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `mer` Asc";
                        $rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Por favor Seleccione"));
			$responsable->idMer->EditValue = $arwrk;

			// fecha
			$responsable->fecha->EditCustomAttributes = "";
			$responsable->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($responsable->fecha->CurrentValue, 7));

			// Edit refer script
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

	// Validate form
	function ValidateForm() {
		global $gsFormError, $responsable;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($responsable->idGerente->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Gerente";
		}
		if ($responsable->idMer->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Mer";
		}
		if ($responsable->fecha->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Fecha de Asignacion";
		}
		if (!ew_CheckEuroDate($responsable->fecha->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Fecha incorrecta, formato = dd/mm/yyyy - Fecha de Asignacion";
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
		global $conn, $Security, $responsable;
		$sFilter = $responsable->KeyFilter();
		$responsable->CurrentFilter = $sFilter;
		$sSql = $responsable->SQL();
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

			// Field idResponsable
			// Field idGerente

			$responsable->idGerente->SetDbValueDef($responsable->idGerente->CurrentValue, 0);
			$rsnew['idGerente'] =& $responsable->idGerente->DbValue;

			// Field idMer
			$responsable->idMer->SetDbValueDef($responsable->idMer->CurrentValue, 0);
			$rsnew['idMer'] =& $responsable->idMer->DbValue;

			// Field fecha
			$responsable->fecha->SetDbValueDef(ew_UnFormatDateTime($responsable->fecha->CurrentValue, 7), ew_CurrentDate());
			$rsnew['fecha'] =& $responsable->fecha->DbValue;

			// Call Row Updating event
			$bUpdateRow = $responsable->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($responsable->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($responsable->CancelMessage <> "") {
					$this->setMessage($responsable->CancelMessage);
					$responsable->CancelMessage = "";
				} else {
					$this->setMessage("Actualizacion cancelada");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$responsable->Row_Updated($rsold, $rsnew);
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
