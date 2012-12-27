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
$responsable_consultoria_add = new cresponsable_consultoria_add();
$Page =& $responsable_consultoria_add;

// Page init processing
$responsable_consultoria_add->Page_Init();

// Page main processing
$responsable_consultoria_add->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var responsable_consultoria_add = new ew_Page("responsable_consultoria_add");

// page properties
responsable_consultoria_add.PageID = "add"; // page ID
var EW_PAGE_ID = responsable_consultoria_add.PageID; // for backward compatibility

// extend page with ValidateForm function
responsable_consultoria_add.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_idUsuario"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Usuario (Revisor)");
		elm = fobj.elements["x" + infix + "_idConsultoria"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Consultoria");
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
responsable_consultoria_add.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
responsable_consultoria_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
responsable_consultoria_add.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Agregar a TABLA: Responsable Consultoria<br><br>
<a href="<?php echo $responsable_consultoria->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $responsable_consultoria_add->ShowMessage() ?>
<form name="fresponsable_consultoriaadd" id="fresponsable_consultoriaadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return responsable_consultoria_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="responsable_consultoria">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($responsable_consultoria->idUsuario->Visible) { // idUsuario ?>
	<tr<?php echo $responsable_consultoria->idUsuario->RowAttributes ?>>
		<td class="ewTableHeader">Usuario (Revisor)<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $responsable_consultoria->idUsuario->CellAttributes() ?>><span id="el_idUsuario">
<select id="x_idUsuario" name="x_idUsuario"<?php echo $responsable_consultoria->idUsuario->EditAttributes() ?>>
<?php
if (is_array($responsable_consultoria->idUsuario->EditValue)) {
	$arwrk = $responsable_consultoria->idUsuario->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($responsable_consultoria->idUsuario->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1]." ".$arwrk[$rowcntwrk][2] ?>
<?php if ($arwrk[$rowcntwrk][3] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk) ?><?php echo $arwrk[$rowcntwrk][3] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
</span><?php echo $responsable_consultoria->idUsuario->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($responsable_consultoria->idConsultoria->Visible) { // idConsultoria ?>
	<tr<?php echo $responsable_consultoria->idConsultoria->RowAttributes ?>>
		<td class="ewTableHeader">Consultoria<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $responsable_consultoria->idConsultoria->CellAttributes() ?>><span id="el_idConsultoria">
<select id="x_idConsultoria" name="x_idConsultoria"<?php echo $responsable_consultoria->idConsultoria->EditAttributes() ?>>
<?php
if (is_array($responsable_consultoria->idConsultoria->EditValue)) {
	$arwrk = $responsable_consultoria->idConsultoria->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($responsable_consultoria->idConsultoria->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "" || $arwrk[$rowcntwrk][3]<>"" || $arwrk[$rowcntwrk][4]<>"") { ?>
<?php echo ew_ValueSeparator($rowcntwrk) ?><?php echo strtoupper($arwrk[$rowcntwrk][2]." ".$arwrk[$rowcntwrk][3]." ".$arwrk[$rowcntwrk][4]) ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
</span><?php echo $responsable_consultoria->idConsultoria->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($responsable_consultoria->fecha->Visible) { // fecha ?>
	<tr<?php echo $responsable_consultoria->fecha->RowAttributes ?>>
		<td class="ewTableHeader">Fecha de Asignacion<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $responsable_consultoria->fecha->CellAttributes() ?>><span id="el_fecha">
<input type="text" name="x_fecha" id="x_fecha" value="<?php echo date("d/m/y") ?>">
&nbsp;<img src="images/calendar.png" id="cal_x_fecha" name="cal_x_fecha" alt="Seleccione una fecha" style="cursor:pointer;cursor:hand;">
<script type="text/javascript">
Calendar.setup({
	inputField : "x_fecha", // ID of the input field
	ifFormat : "%d/%m/%Y", // the date format
	button : "cal_x_fecha" // ID of the button
});
</script>
</span><?php echo $responsable_consultoria->fecha->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="  AGREGAR  ">
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
class cresponsable_consultoria_add {

	// Page ID
	var $PageID = 'add';

	// Table Name
	var $TableName = 'responsable_consultoria';

	// Page Object Name
	var $PageObjName = 'responsable_consultoria_add';

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
	function cresponsable_consultoria_add() {
		global $conn;

		// Initialize table object
		$GLOBALS["responsable_consultoria"] = new cresponsable_consultoria();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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
	var $x_ewPriv = 0;

	// 
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsFormError, $responsable_consultoria;

		// Load key values from QueryString
		$bCopy = TRUE;
		if (@$_GET["idRC"] != "") {
		  $responsable_consultoria->idRC->setQueryStringValue($_GET["idRC"]);
		} else {
		  $bCopy = FALSE;
		}

		// Create form object
		$objForm = new cFormObj();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
		   $responsable_consultoria->CurrentAction = $_POST["a_add"]; // Get form action
		  $this->LoadFormValues(); // Load form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$responsable_consultoria->CurrentAction = "I"; // Form error, reset action
				$this->setMessage($gsFormError);
			}
		} else { // Not post back
		  if ($bCopy) {
		    $responsable_consultoria->CurrentAction = "C"; // Copy Record
		  } else {
		    $responsable_consultoria->CurrentAction = "I"; // Display Blank Record
		    $this->LoadDefaultValues(); // Load default values
		  }
		}

		// Perform action based on action code
		switch ($responsable_consultoria->CurrentAction) {
		  case "I": // Blank record, no action required
				break;
		  case "C": // Copy an existing record
		   if (!$this->LoadRow()) { // Load record based on key
		      $this->setMessage("No se encontraron registros"); // No record found
		      $this->Page_Terminate("responsable_consultorialist.php"); // No matching record, return to list
		    }
				break;
		  case "A": // ' Add new record
				$responsable_consultoria->SendEmail = TRUE; // Send email on add success
		    if ($this->AddRow()) { // Add successful
		      $this->setMessage("Registro agregado satisfactoriamente"); // Set up success message
					$sReturnUrl = $responsable_consultoria->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Clean up and return
		    } else {
		      $this->RestoreFormValues(); // Add failed, restore form values
		    }
		}

		// Render row based on row type
		$responsable_consultoria->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $responsable_consultoria;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $responsable_consultoria;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $responsable_consultoria;
		$responsable_consultoria->idUsuario->setFormValue($objForm->GetValue("x_idUsuario"));
		$responsable_consultoria->idConsultoria->setFormValue($objForm->GetValue("x_idConsultoria"));
		$responsable_consultoria->fecha->setFormValue($objForm->GetValue("x_fecha"));
		$responsable_consultoria->fecha->CurrentValue = ew_UnFormatDateTime($responsable_consultoria->fecha->CurrentValue, 7);
		$responsable_consultoria->idRC->setFormValue($objForm->GetValue("x_idRC"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $responsable_consultoria;
		$responsable_consultoria->idRC->CurrentValue = $responsable_consultoria->idRC->FormValue;
		$responsable_consultoria->idUsuario->CurrentValue = $responsable_consultoria->idUsuario->FormValue;
		$responsable_consultoria->idConsultoria->CurrentValue = $responsable_consultoria->idConsultoria->FormValue;
		$responsable_consultoria->fecha->CurrentValue = $responsable_consultoria->fecha->FormValue;
		$responsable_consultoria->fecha->CurrentValue = ew_UnFormatDateTime($responsable_consultoria->fecha->CurrentValue, 7);
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

			// idUsuario
			$responsable_consultoria->idUsuario->HrefValue = "";

			// idConsultoria
			$responsable_consultoria->idConsultoria->HrefValue = "";

			// fecha
			$responsable_consultoria->fecha->HrefValue = "";
		} elseif ($responsable_consultoria->RowType == EW_ROWTYPE_ADD) { // Add row

			// idUsuario
			$responsable_consultoria->idUsuario->EditCustomAttributes = "";
			$sSqlWrk = "SELECT `idUsuario`, paterno,materno, `nombre`, '' AS SelectFilterFld FROM `usuario`";
			$sWhereWrk = "idRol=2";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `paterno` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Por favor Seleccione", ""));
			$responsable_consultoria->idUsuario->EditValue = $arwrk;

			// idConsultoria
			$responsable_consultoria->idConsultoria->EditCustomAttributes = "";
			$sSqlWrk = "SELECT a.idConsultoria, a.consultoria, b.paterno,b.materno,b.nombre, '' AS SelectFilterFld FROM consultoria a, usuario b";
			$sWhereWrk = "a.idUsuario=b.idUsuario";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `consultoria` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Por favor Seleccione", ""));
			$responsable_consultoria->idConsultoria->EditValue = $arwrk;

			// fecha
			$responsable_consultoria->fecha->EditCustomAttributes = "";
			$responsable_consultoria->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($responsable_consultoria->fecha->CurrentValue, 7));
		}

		// Call Row Rendered event
		$responsable_consultoria->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $responsable_consultoria;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($responsable_consultoria->idUsuario->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Usuario (Revisor)";
		}
		if ($responsable_consultoria->idConsultoria->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Consultoria";
		}
		if ($responsable_consultoria->fecha->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Fecha de Asignacion";
		}
		if (!ew_CheckEuroDate($responsable_consultoria->fecha->FormValue)) {
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

	// Add record
	function AddRow() {
		global $conn, $Security, $responsable_consultoria;
		$rsnew = array();

		// Field idUsuario
		$responsable_consultoria->idUsuario->SetDbValueDef($responsable_consultoria->idUsuario->CurrentValue, 0);
		$rsnew['idUsuario'] =& $responsable_consultoria->idUsuario->DbValue;

		// Field idConsultoria
		$responsable_consultoria->idConsultoria->SetDbValueDef($responsable_consultoria->idConsultoria->CurrentValue, 0);
		$rsnew['idConsultoria'] =& $responsable_consultoria->idConsultoria->DbValue;

		// Field fecha
		$responsable_consultoria->fecha->SetDbValueDef(ew_UnFormatDateTime($responsable_consultoria->fecha->CurrentValue, 7), ew_CurrentDate());
		$rsnew['fecha'] =& $responsable_consultoria->fecha->DbValue;

		// Call Row Inserting event
		$bInsertRow = $responsable_consultoria->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($responsable_consultoria->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($responsable_consultoria->CancelMessage <> "") {
				$this->setMessage($responsable_consultoria->CancelMessage);
				$responsable_consultoria->CancelMessage = "";
			} else {
				$this->setMessage("Insertar cancelado");
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {
			$responsable_consultoria->idRC->setDbValue($conn->Insert_ID());
			$rsnew['idRC'] =& $responsable_consultoria->idRC->DbValue;

			// Call Row Inserted event
			$responsable_consultoria->Row_Inserted($rsnew);
		}
		return $AddRow;
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
