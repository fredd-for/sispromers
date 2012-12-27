<?php

// PHPMaker 6 configuration for Table cronograma
$cronograma = NULL; // Initialize table object

// Define table class
class ccronograma {

	// Define table level constants
	var $TableVar;
	var $TableName;
	var $SelectLimit = FALSE;
	var $idCronograma;
	var $idConsultoria;
	var $fechaInicio;
	var $fechaFinal;
	var $detalle;
	var $mesAnio;
	var $estado;
	var $fields = array();
	var $UseTokenInUrl = EW_USE_TOKEN_IN_URL;
	var $Export; // Export
	var $ExportOriginalValue = EW_EXPORT_ORIGINAL_VALUE;
	var	$ExportAll = EW_EXPORT_ALL;
	var $SendEmail; // Send Email
	var $TableCustomInnerHtml; // Custom Inner Html

	function ccronograma() {
		$this->TableVar = "cronograma";
		$this->TableName = "cronograma";
		$this->SelectLimit = TRUE;
		$this->idCronograma = new cField('cronograma', 'x_idCronograma', 'idCronograma', "`idCronograma`", 3, -1, FALSE);
		$this->fields['idCronograma'] =& $this->idCronograma;
		$this->idConsultoria = new cField('cronograma', 'x_idConsultoria', 'idConsultoria', "`idConsultoria`", 3, -1, FALSE);
		$this->fields['idConsultoria'] =& $this->idConsultoria;
		$this->fechaInicio = new cField('cronograma', 'x_fechaInicio', 'fechaInicio', "`fechaInicio`", 133, 7, FALSE);
		$this->fields['fechaInicio'] =& $this->fechaInicio;
		$this->fechaFinal = new cField('cronograma', 'x_fechaFinal', 'fechaFinal', "`fechaFinal`", 133, 7, FALSE);
		$this->fields['fechaFinal'] =& $this->fechaFinal;
		$this->detalle = new cField('cronograma', 'x_detalle', 'detalle', "`detalle`", 200, -1, FALSE);
		$this->fields['detalle'] =& $this->detalle;
		$this->mesAnio = new cField('cronograma', 'x_mesAnio', 'mesAnio', "`mesAnio`", 133, 7, FALSE);
		$this->fields['mesAnio'] =& $this->mesAnio;
		$this->estado = new cField('cronograma', 'x_estado', 'estado', "`estado`", 3, -1, FALSE);
		$this->fields['estado'] =& $this->estado;
	}

	// Records per page
	function getRecordsPerPage() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_REC_PER_PAGE];
	}

	function setRecordsPerPage($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_REC_PER_PAGE] = $v;
	}

	// Start record number
	function getStartRecordNumber() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_START_REC];
	}

	function setStartRecordNumber($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_START_REC] = $v;
	}

	// Search Highlight Name
	function HighlightName() {
		return "cronograma_Highlight";
	}

	// Advanced search
	function getAdvancedSearch($fld) {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ADVANCED_SEARCH . "_" . $fld];
	}

	function setAdvancedSearch($fld, $v) {
		if (@$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ADVANCED_SEARCH . "_" . $fld] <> $v) {
			$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ADVANCED_SEARCH . "_" . $fld] = $v;
		}
	}

	// Basic search Keyword
	function getBasicSearchKeyword() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH];
	}

	function setBasicSearchKeyword($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH] = $v;
	}

	// Basic Search Type
	function getBasicSearchType() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH_TYPE];
	}

	function setBasicSearchType($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH_TYPE] = $v;
	}

	// Search where clause
	function getSearchWhere() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_SEARCH_WHERE];
	}

	function setSearchWhere($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_SEARCH_WHERE] = $v;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Session WHERE Clause
	function getSessionWhere() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_WHERE];
	}

	function setSessionWhere($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_WHERE] = $v;
	}

	// Session ORDER BY
	function getSessionOrderBy() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY];
	}

	function setSessionOrderBy($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY] = $v;
	}

	// Session Key
	function getKey($fld) {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_KEY . "_" . $fld];
	}

	function setKey($fld, $v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_KEY . "_" . $fld] = $v;
	}

	// Table level SQL
	function SqlSelect() { // Select
	//           return "SELECT * FROM `cronograma`";
        switch ($_SESSION['idRol']) {
            case 2:
            return "SELECT a.* FROM cronograma a, responsable_consultoria c";
            break;
            case 3:
            return "SELECT a.* FROM cronograma a, consultoria b";
            break;
            default:
                return "SELECT * FROM `cronograma`";
                break;
        }
	}

	function SqlWhere() { // Where
//	if($_GET['idConsultoria'])
//            return "idConsultoria=".$_GET['idConsultoria'];
//        else return "";
        switch ($_SESSION['idRol']) {
            case 2:
            return " a.idConsultoria=c.idConsultoria AND c.idUsuario='".(int)$_SESSION['idUsuario']."' AND a.idConsultoria=".$_GET['idConsultoria'];
            break;
            case 3:
            return " a.idConsultoria='".$_GET['idConsultoria']."' AND a.idConsultoria=b.idConsultoria AND b.idUsuario='".(int)$_SESSION['idUsuario']."'";
            break;
            default:
               return " idConsultoria='".$_GET['idConsultoria']."'";
                break;
        }

        }

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "";
	}

	// SQL variables
	var $CurrentFilter; // Current filter
	var $CurrentOrder; // Current order
	var $CurrentOrderType; // Current order type

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Return table sql with list page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		if ($this->CurrentFilter <> "") {
			if ($sFilter <> "") $sFilter = "($sFilter) AND ";
			$sFilter .= "(" . $this->CurrentFilter . ")";
		}
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Return record count
	function SelectRecordCount() {
		global $conn;
		$cnt = -1;
		$sFilter = $this->CurrentFilter;
		$this->Recordset_Selecting($this->CurrentFilter);
		if ($this->SelectLimit) {
			$sSelect = $this->SelectSQL();
			if (strtoupper(substr($sSelect, 0, 13)) == "SELECT * FROM") {
				$sSelect = "SELECT COUNT(*) FROM" . substr($sSelect, 13);
				if ($rs = $conn->Execute($sSelect)) {
					if (!$rs->EOF)
						$cnt = $rs->fields[0];
					$rs->Close();
				}
			}
		}
		if ($cnt == -1) {
			if ($rs = $conn->Execute($this->SelectSQL())) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $sFilter;
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= (is_null($value) ? "NULL" : ew_QuotedValue($value, $this->fields[$name]->FldDataType)) . ",";
		}
		if (substr($names, -1) == ",") $names = substr($names, 0, strlen($names)-1);
		if (substr($values, -1) == ",") $values = substr($values, 0, strlen($values)-1);
		return "INSERT INTO `cronograma` ($names) VALUES ($values)";
	}

	// UPDATE statement
	function UpdateSQL(&$rs) {
		$SQL = "UPDATE `cronograma` SET ";
		foreach ($rs as $name => $value) {
			$SQL .= $this->fields[$name]->FldExpression . "=" .
					(is_null($value) ? "NULL" : ew_QuotedValue($value, $this->fields[$name]->FldDataType)) . ",";
		}
		if (substr($SQL, -1) == ",") $SQL = substr($SQL, 0, strlen($SQL)-1);
		if ($this->CurrentFilter <> "")	$SQL .= " WHERE " . $this->CurrentFilter;
		return $SQL;
	}

	// DELETE statement
	function DeleteSQL(&$rs) {
		$SQL = "DELETE FROM `cronograma` WHERE ";
		$SQL .= EW_DB_QUOTE_START . 'idCronograma' . EW_DB_QUOTE_END . '=' .	ew_QuotedValue($rs['idCronograma'], $this->idCronograma->FldDataType) . ' AND ';
		if (substr($SQL, -5) == " AND ") $SQL = substr($SQL, 0, strlen($SQL)-5);
		if ($this->CurrentFilter <> "")	$SQL .= " AND " . $this->CurrentFilter;
		return $SQL;
	}

	// Key filter for table
	function SqlKeyFilter() {
		return "`idCronograma` = @idCronograma@";
	}

	// Return Key filter for table
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->idCronograma->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@idCronograma@", ew_AdjustSql($this->idCronograma->CurrentValue), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return url
	function getReturnUrl() {

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] <> "") {
			return $_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL];
		} else {
			return "cronogramalist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// View url
	function ViewUrl() {
		return $this->KeyUrl("avance_productolist.php", $this->UrlParm("idConsultoria=".$_GET['idConsultoria']));
	}

	// Add url
	function AddUrl() {
		$AddUrl = "cronogramaadd.php";
		$sUrlParm = $this->UrlParm();
		if ($sUrlParm <> "")
			$AddUrl .= "?" . $sUrlParm;
		return $AddUrl;
	}

	// Edit url
	function EditUrl() {
		return $this->KeyUrl("cronogramaedit.php", $this->UrlParm("idConsultoria=".$_GET['idConsultoria']));
	}

	// Inline edit url
	function InlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy url
	function CopyUrl() {
		return $this->KeyUrl("cronogramaadd.php", $this->UrlParm("idConsultoria=".$_GET['idConsultoria']));
	}

	// Inline copy url
	function InlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete url
	function DeleteUrl() {
		return $this->KeyUrl("cronogramadelete.php", $this->UrlParm("idConsultoria=".$_GET['idConsultoria']));
	}

	// Key url
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->idCronograma->CurrentValue)) {
			$sUrl .= "idCronograma=" . urlencode($this->idCronograma->CurrentValue);
		} else {
			return "javascript:alert('Llave incorrecta es nula');";
		}
		return $sUrl;
	}

	// Sort Url
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			($fld->FldType == 205)) { // Unsortable data type
			return "";
		} else {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&idConsultoria=".$_GET['idConsultoria']."&ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		}
	}

	// URL parm
	function UrlParm($parm = "") {
		$UrlParm = ($this->UseTokenInUrl) ? "t=cronograma" : "";
		if ($parm <> "") {
			if ($UrlParm <> "")
				$UrlParm .= "&";
			$UrlParm .= $parm;
		}
		return $UrlParm;
	}

	// Function LoadRs
	// - Load rows based on filter
	function LoadRs($sFilter) {
		global $conn;

		// Set up filter (Sql Where Clause) and get Return Sql
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		return $conn->Execute($sSql);
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->idCronograma->setDbValue($rs->fields('idCronograma'));
		$this->idConsultoria->setDbValue($rs->fields('idConsultoria'));
		$this->fechaInicio->setDbValue($rs->fields('fechaInicio'));
		$this->fechaFinal->setDbValue($rs->fields('fechaFinal'));
		$this->detalle->setDbValue($rs->fields('detalle'));
		$this->mesAnio->setDbValue($rs->fields('mesAnio'));
		$this->estado->setDbValue($rs->fields('estado'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

		// idCronograma
		$this->idCronograma->ViewValue = $this->idCronograma->CurrentValue;
		$this->idCronograma->CssStyle = "";
		$this->idCronograma->CssClass = "";
		$this->idCronograma->ViewCustomAttributes = "";

		// idConsultoria
		$this->idConsultoria->ViewValue = $this->idConsultoria->CurrentValue;
		$this->idConsultoria->CssStyle = "";
		$this->idConsultoria->CssClass = "";
		$this->idConsultoria->ViewCustomAttributes = "";

		// fechaInicio
		$this->fechaInicio->ViewValue = $this->fechaInicio->CurrentValue;
		$this->fechaInicio->ViewValue = ew_FormatDateTime($this->fechaInicio->ViewValue, 7);
		$this->fechaInicio->CssStyle = "";
		$this->fechaInicio->CssClass = "";
		$this->fechaInicio->ViewCustomAttributes = "";

		// fechaFinal
		$this->fechaFinal->ViewValue = $this->fechaFinal->CurrentValue;
		$this->fechaFinal->ViewValue = ew_FormatDateTime($this->fechaFinal->ViewValue, 7);
		$this->fechaFinal->CssStyle = "";
		$this->fechaFinal->CssClass = "";
		$this->fechaFinal->ViewCustomAttributes = "";

		// detalle
		$this->detalle->ViewValue = $this->detalle->CurrentValue;
		$this->detalle->CssStyle = "";
		$this->detalle->CssClass = "";
		$this->detalle->ViewCustomAttributes = "";

		// mesAnio
		$this->mesAnio->ViewValue = $this->mesAnio->CurrentValue;
		$this->mesAnio->ViewValue = ew_FormatDateTime($this->mesAnio->ViewValue, 7);
		$this->mesAnio->CssStyle = "";
		$this->mesAnio->CssClass = "";
		$this->mesAnio->ViewCustomAttributes = "";

		// estado
		if (strval($this->estado->CurrentValue) <> "") {
			switch ($this->estado->CurrentValue) {
				case "1":
					$this->estado->ViewValue = "Habilitado";
					break;
				case "2":
					$this->estado->ViewValue = "Desabilitado";
					break;
				case "3":
					$this->estado->ViewValue = "Aprobado";
					break;
				default:
					$this->estado->ViewValue = $this->estado->CurrentValue;
			}
		} else {
			$this->estado->ViewValue = NULL;
		}
		$this->estado->CssStyle = "";
		$this->estado->CssClass = "";
		$this->estado->ViewCustomAttributes = "";

		// idCronograma
		$this->idCronograma->HrefValue = "";

		// idConsultoria
		$this->idConsultoria->HrefValue = "";

		// fechaInicio
		$this->fechaInicio->HrefValue = "";

		// fechaFinal
		$this->fechaFinal->HrefValue = "";

		// detalle
		$this->detalle->HrefValue = "";

		// mesAnio
		$this->mesAnio->HrefValue = "";

		// estado
		$this->estado->HrefValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $CurrentAction; // Current action
	var $EventName; // Event name
	var $EventCancelled; // Event cancelled
	var $CancelMessage; // Cancel message
	var $RowType; // Row Type
	var $CssClass; // Css class
	var $CssStyle; // Css style
	var $RowClientEvents; // Row client events

	// Row Attribute
	function RowAttributes() {
		$sAtt = "";
		if (trim($this->CssStyle) <> "") {
			$sAtt .= " style=\"" . trim($this->CssStyle) . "\"";
		}
		if (trim($this->CssClass) <> "") {
			$sAtt .= " class=\"" . trim($this->CssClass) . "\"";
		}
		if ($this->Export == "") {
			if (trim($this->RowClientEvents) <> "") {
				$sAtt .= " " . trim($this->RowClientEvents);
			}
		}
		return $sAtt;
	}

	// Field objects
	function fields($fldname) {
		return $this->fields[$fldname];
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// Row Inserting event
	function Row_Inserting(&$rs) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted(&$rs) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating(&$rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated(&$rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}
}
?>
