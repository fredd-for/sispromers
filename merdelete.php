<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "merinfo.php" ?>
<?php include "usuarioinfo.php" ?>
<?php include "userfn6.php" ?>
<?php require_once('Connections/conexion.php'); ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Define page object
$mer_delete = new cmer_delete();
$Page =& $mer_delete;

// Page init processing
$mer_delete->Page_Init();

// Page main processing
$mer_delete->Page_Main();
?>
<?php
if($_GET['sw']=='ocultarMer'){
mysql_select_db($database_conexion, $conexion);
$query_merdelete = "UPDATE mer SET estado='0' WHERE idMer='".(int)$_GET['idMer']."'";
mysql_query($query_merdelete, $conexion) or die(mysql_error());
header("Location: merlist.php");
 }else{

?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var mer_delete = new ew_Page("mer_delete");

// page properties
mer_delete.PageID = "delete"; // page ID
var EW_PAGE_ID = mer_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
mer_delete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
mer_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
mer_delete.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<?php

// Load records for display
$rs = $mer_delete->LoadRecordset();
$mer_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($mer_deletelTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	$mer_delete->Page_Terminate("merlist.php"); // Return to list
}
?>
<p><span class="phpmaker">Borrar de TABLA: Mer<br><br>
<a href="<?php echo $mer->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $mer_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="mer">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($mer_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $mer->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top">No</td>
		<td valign="top">Regional</td>
		<td valign="top">Departamento</td>
		<td valign="top">Municipio</td>
		<td valign="top">Comunidad</td>
		<td valign="top">Rubro</td>
		<td valign="top">Nombre de la Mer</td>
		<td valign="top">Fecha Inicio</td>
		<td valign="top">Fecha Final</td>
		<td valign="top">Estado</td>
	</tr>
	</thead>
	<tbody>
<?php
$mer_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$mer_delete->lRecCnt++;

	// Set row properties
	$mer->CssClass = "";
	$mer->CssStyle = "";
	$mer->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$mer_delete->LoadRowValues($rs);

	// Render row
	$mer_delete->RenderRow();
?>
	<tr<?php echo $mer->RowAttributes() ?>>
		<td<?php echo $mer->idMer->CellAttributes() ?>>
<div<?php echo $mer->idMer->ViewAttributes() ?>><?php echo $mer->idMer->ListViewValue() ?></div></td>
		<td<?php echo $mer->idRegional->CellAttributes() ?>>
<div<?php echo $mer->idRegional->ViewAttributes() ?>><?php echo $mer->idRegional->ListViewValue() ?></div></td>
		<td<?php echo $mer->idDepartamento->CellAttributes() ?>>
<div<?php echo $mer->idDepartamento->ViewAttributes() ?>><?php echo $mer->idDepartamento->ListViewValue() ?></div></td>
		<td<?php echo $mer->idMunicipio->CellAttributes() ?>>
<div<?php echo $mer->idMunicipio->ViewAttributes() ?>><?php echo $mer->idMunicipio->ListViewValue() ?></div></td>
		<td<?php echo $mer->idComunidad->CellAttributes() ?>>
<div<?php echo $mer->idComunidad->ViewAttributes() ?>><?php echo $mer->idComunidad->ListViewValue() ?></div></td>
		<td<?php echo $mer->idRubro->CellAttributes() ?>>
<div<?php echo $mer->idRubro->ViewAttributes() ?>><?php echo $mer->idRubro->ListViewValue() ?></div></td>
		<td<?php echo $mer->mer->CellAttributes() ?>>
<div<?php echo $mer->mer->ViewAttributes() ?>><?php echo $mer->mer->ListViewValue() ?></div></td>
		<td<?php echo $mer->fechaInicio->CellAttributes() ?>>
<div<?php echo $mer->fechaInicio->ViewAttributes() ?>><?php echo $mer->fechaInicio->ListViewValue() ?></div></td>
		<td<?php echo $mer->fechaFinal->CellAttributes() ?>>
<div<?php echo $mer->fechaFinal->ViewAttributes() ?>><?php echo $mer->fechaFinal->ListViewValue() ?></div></td>
		<td<?php echo $mer->estado->CellAttributes() ?>>
<div<?php echo $mer->estado->ViewAttributes() ?>><?php echo $mer->estado->ListViewValue() ?></div></td>
	</tr>
<?php
	$rs->MoveNext();
}
$rs->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="CONFIRMAR BORRADO">
</form>
<?php include "footer.php" ?>
<?php
}
//
// Page Class
//
class cmer_delete {

	// Page ID
	var $PageID = 'delete';

	// Table Name
	var $TableName = 'mer';

	// Page Object Name
	var $PageObjName = 'mer_delete';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $mer;
		if ($mer->UseTokenInUrl) $PageUrl .= "t=" . $mer->TableVar . "&"; // add page token
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
		global $objForm, $mer;
		if ($mer->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($mer->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($mer->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cmer_delete() {
		global $conn;

		// Initialize table object
		$GLOBALS["mer"] = new cmer();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'mer', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $mer;
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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("merlist.php");
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
	var $lTotalRecs;
	var $lRecCnt;
	var $arRecKeys = array();

	// Page main processing
	function Page_Main() {
		global $mer;

		// Load Key Parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["idMer"] <> "") {
			$mer->idMer->setQueryStringValue($_GET["idMer"]);
			if (!is_numeric($mer->idMer->QueryStringValue))
				$this->Page_Terminate("merlist.php"); // Prevent SQL injection, exit
			$sKey .= $mer->idMer->QueryStringValue;
		} else {
			$bSingleDelete = FALSE;
		}
		if ($bSingleDelete) {
			$nKeySelected = 1; // Set up key selected count
			$this->arRecKeys[0] = $sKey;
		} else {
			if (isset($_POST["key_m"])) { // Key in form
				$nKeySelected = count($_POST["key_m"]); // Set up key selected count
				$this->arRecKeys = ew_StripSlashes($_POST["key_m"]);
			}
		}
		if ($nKeySelected <= 0)
			$this->Page_Terminate("merlist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("merlist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`idMer`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WhHERE clause) and get return SQL
		// SQL constructor in SQL constructor in mer class, merinfo.php

		$mer->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$mer->CurrentAction = $_POST["a_delete"];
		} else {
			$mer->CurrentAction = "I"; // Delete record directly
		}
		switch ($mer->CurrentAction) {
			case "D": // Delete
				$mer->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage("Borrado Exitoso"); // Set up success message
					$this->Page_Terminate($mer->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	//  Function DeleteRows
	//  - Delete Records based on current filter
	//
	function DeleteRows() {
		global $conn, $Security, $mer;
		$DeleteRows = TRUE;
		$sWrkFilter = $mer->CurrentFilter;

		// Set up filter (Sql Where Clause) and get Return SQL
		// SQL constructor in mer class, merinfo.php

		$mer->CurrentFilter = $sWrkFilter;
		$sSql = $mer->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setMessage("No se encontraron registros"); // No record found
			$rs->Close();
			return FALSE;
		}
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs) $rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $mer->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['idMer'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($mer->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($mer->CancelMessage <> "") {
				$this->setMessage($mer->CancelMessage);
				$mer->CancelMessage = "";
			} else {
				$this->setMessage("borrado cancelado");
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call recordset deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$mer->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $mer;

		// Call Recordset Selecting event
		$mer->Recordset_Selecting($mer->CurrentFilter);

		// Load list page SQL
		$sSql = $mer->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$mer->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $mer;
		$sFilter = $mer->KeyFilter();

		// Call Row Selecting event
		$mer->Row_Selecting($sFilter);

		// Load sql based on filter
		$mer->CurrentFilter = $sFilter;
		$sSql = $mer->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$mer->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $mer;
		$mer->idMer->setDbValue($rs->fields('idMer'));
		$mer->idRegional->setDbValue($rs->fields('idRegional'));
		$mer->idDepartamento->setDbValue($rs->fields('idDepartamento'));
		$mer->idMunicipio->setDbValue($rs->fields('idMunicipio'));
		$mer->idComunidad->setDbValue($rs->fields('idComunidad'));
		$mer->idRubro->setDbValue($rs->fields('idRubro'));
		$mer->mer->setDbValue($rs->fields('mer'));
		$mer->unidadProductivaDedica->setDbValue($rs->fields('unidadProductivaDedica'));
		$mer->codigo->setDbValue($rs->fields('codigo'));
		$mer->numeroSocios->setDbValue($rs->fields('numeroSocios'));
		$mer->direccion->setDbValue($rs->fields('direccion'));
		$mer->zona->setDbValue($rs->fields('zona'));
		$mer->referencia->setDbValue($rs->fields('referencia'));
		$mer->refTelefonica->setDbValue($rs->fields('refTelefonica'));
		$mer->refCelular->setDbValue($rs->fields('refCelular'));
		$mer->fechaInicio->setDbValue($rs->fields('fechaInicio'));
		$mer->fechaFinal->setDbValue($rs->fields('fechaFinal'));
		$mer->longitudUTM->setDbValue($rs->fields('longitudUTM'));
		$mer->latitudUTM->setDbValue($rs->fields('latitudUTM'));
		$mer->gestion->setDbValue($rs->fields('gestion'));
		$mer->estado->setDbValue($rs->fields('estado'));
		$mer->fechaCreacion->setDbValue($rs->fields('fechaCreacion'));
		$mer->fechaModificacion->setDbValue($rs->fields('fechaModificacion'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $mer;

		// Call Row_Rendering event
		$mer->Row_Rendering();

		// Common render codes for all row types
		// idMer

		$mer->idMer->CellCssStyle = "";
		$mer->idMer->CellCssClass = "";

		// idRegional
		$mer->idRegional->CellCssStyle = "";
		$mer->idRegional->CellCssClass = "";

		// idDepartamento
		$mer->idDepartamento->CellCssStyle = "";
		$mer->idDepartamento->CellCssClass = "";

		// idMunicipio
		$mer->idMunicipio->CellCssStyle = "";
		$mer->idMunicipio->CellCssClass = "";

		// idComunidad
		$mer->idComunidad->CellCssStyle = "";
		$mer->idComunidad->CellCssClass = "";

		// idRubro
		$mer->idRubro->CellCssStyle = "";
		$mer->idRubro->CellCssClass = "";

		// mer
		$mer->mer->CellCssStyle = "";
		$mer->mer->CellCssClass = "";

		// fechaInicio
		$mer->fechaInicio->CellCssStyle = "";
		$mer->fechaInicio->CellCssClass = "";

		// fechaFinal
		$mer->fechaFinal->CellCssStyle = "";
		$mer->fechaFinal->CellCssClass = "";

		// estado
		$mer->estado->CellCssStyle = "white-space: nowrap;";
		$mer->estado->CellCssClass = "";
		if ($mer->RowType == EW_ROWTYPE_VIEW) { // View row

			// idMer
			$mer->idMer->ViewValue = $mer->idMer->CurrentValue;
			$mer->idMer->CssStyle = "";
			$mer->idMer->CssClass = "";
			$mer->idMer->ViewCustomAttributes = "";

			// idRegional
			if (strval($mer->idRegional->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `regional` FROM `regional` WHERE `idRegional` = " . ew_AdjustSql($mer->idRegional->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `regional` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$mer->idRegional->ViewValue = $rswrk->fields('regional');
					$rswrk->Close();
				} else {
					$mer->idRegional->ViewValue = $mer->idRegional->CurrentValue;
				}
			} else {
				$mer->idRegional->ViewValue = NULL;
			}
			$mer->idRegional->CssStyle = "";
			$mer->idRegional->CssClass = "";
			$mer->idRegional->ViewCustomAttributes = "";

			// idDepartamento
			if (strval($mer->idDepartamento->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `departamento` FROM `departamento` WHERE `idDepartamento` = " . ew_AdjustSql($mer->idDepartamento->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `departamento` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$mer->idDepartamento->ViewValue = $rswrk->fields('departamento');
					$rswrk->Close();
				} else {
					$mer->idDepartamento->ViewValue = $mer->idDepartamento->CurrentValue;
				}
			} else {
				$mer->idDepartamento->ViewValue = NULL;
			}
			$mer->idDepartamento->CssStyle = "";
			$mer->idDepartamento->CssClass = "";
			$mer->idDepartamento->ViewCustomAttributes = "";

			// idMunicipio
			if (strval($mer->idMunicipio->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `municipio` FROM `municipio` WHERE `idMunicipio` = " . ew_AdjustSql($mer->idMunicipio->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `municipio` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$mer->idMunicipio->ViewValue = $rswrk->fields('municipio');
					$rswrk->Close();
				} else {
					$mer->idMunicipio->ViewValue = $mer->idMunicipio->CurrentValue;
				}
			} else {
				$mer->idMunicipio->ViewValue = NULL;
			}
			$mer->idMunicipio->CssStyle = "";
			$mer->idMunicipio->CssClass = "";
			$mer->idMunicipio->ViewCustomAttributes = "";

			// idComunidad
			if (strval($mer->idComunidad->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `comunidad` FROM `comunidad` WHERE `idComunidad` = " . ew_AdjustSql($mer->idComunidad->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `comunidad` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$mer->idComunidad->ViewValue = $rswrk->fields('comunidad');
					$rswrk->Close();
				} else {
					$mer->idComunidad->ViewValue = $mer->idComunidad->CurrentValue;
				}
			} else {
				$mer->idComunidad->ViewValue = NULL;
			}
			$mer->idComunidad->CssStyle = "";
			$mer->idComunidad->CssClass = "";
			$mer->idComunidad->ViewCustomAttributes = "";

			// idRubro
			if (strval($mer->idRubro->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `rubro` FROM `rubro` WHERE `idRubro` = " . ew_AdjustSql($mer->idRubro->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `rubro` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$mer->idRubro->ViewValue = $rswrk->fields('rubro');
					$rswrk->Close();
				} else {
					$mer->idRubro->ViewValue = $mer->idRubro->CurrentValue;
				}
			} else {
				$mer->idRubro->ViewValue = NULL;
			}
			$mer->idRubro->CssStyle = "";
			$mer->idRubro->CssClass = "";
			$mer->idRubro->ViewCustomAttributes = "";

			// mer
			$mer->mer->ViewValue = $mer->mer->CurrentValue;
			$mer->mer->CssStyle = "";
			$mer->mer->CssClass = "";
			$mer->mer->ViewCustomAttributes = "";

			// fechaInicio
			$mer->fechaInicio->ViewValue = $mer->fechaInicio->CurrentValue;
			$mer->fechaInicio->ViewValue = ew_FormatDateTime($mer->fechaInicio->ViewValue, 7);
			$mer->fechaInicio->CssStyle = "";
			$mer->fechaInicio->CssClass = "";
			$mer->fechaInicio->ViewCustomAttributes = "";

			// fechaFinal
			$mer->fechaFinal->ViewValue = $mer->fechaFinal->CurrentValue;
			$mer->fechaFinal->ViewValue = ew_FormatDateTime($mer->fechaFinal->ViewValue, 7);
			$mer->fechaFinal->CssStyle = "";
			$mer->fechaFinal->CssClass = "";
			$mer->fechaFinal->ViewCustomAttributes = "";

			// estado
			if (strval($mer->estado->CurrentValue) <> "") {
				switch ($mer->estado->CurrentValue) {
					case "0":
						$mer->estado->ViewValue = "Borrado";
						break;
					case "1":
						$mer->estado->ViewValue = "Habilitado";
						break;
					case "2":
						$mer->estado->ViewValue = "Desabilitado";
						break;
					default:
						$mer->estado->ViewValue = $mer->estado->CurrentValue;
				}
			} else {
				$mer->estado->ViewValue = NULL;
			}
			$mer->estado->CssStyle = "";
			$mer->estado->CssClass = "";
			$mer->estado->ViewCustomAttributes = "";

			// idMer
			$mer->idMer->HrefValue = "";

			// idRegional
			$mer->idRegional->HrefValue = "";

			// idDepartamento
			$mer->idDepartamento->HrefValue = "";

			// idMunicipio
			$mer->idMunicipio->HrefValue = "";

			// idComunidad
			$mer->idComunidad->HrefValue = "";

			// idRubro
			$mer->idRubro->HrefValue = "";

			// mer
			$mer->mer->HrefValue = "";

			// fechaInicio
			$mer->fechaInicio->HrefValue = "";

			// fechaFinal
			$mer->fechaFinal->HrefValue = "";

			// estado
			$mer->estado->HrefValue = "";
		}

		// Call Row Rendered event
		$mer->Row_Rendered();
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
