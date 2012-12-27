<?php

// PHPMaker 6 configuration for Table mer
$mer = NULL; // Initialize table object

// Define table class
class cmer {

	// Define table level constants
	var $TableVar;
	var $TableName;
	var $SelectLimit = FALSE;
	var $idMer;
	var $idRegional;
	var $idDepartamento;
	var $idMunicipio;
	var $idComunidad;
	var $idRubro;
	var $mer;
	var $unidadProductivaDedica;
	var $codigo;
	var $numeroSocios;
	var $direccion;
	var $zona;
	var $referencia;
	var $refTelefonica;
	var $refCelular;
	var $fechaInicio;
	var $fechaFinal;
	var $longitudUTM;
	var $latitudUTM;
	var $gestion;
	var $estado;
	var $fechaCreacion;
	var $fechaModificacion;
	var $fields = array();
	var $UseTokenInUrl = EW_USE_TOKEN_IN_URL;
	var $Export; // Export
	var $ExportOriginalValue = EW_EXPORT_ORIGINAL_VALUE;
	var	$ExportAll = EW_EXPORT_ALL;
	var $SendEmail; // Send Email
	var $TableCustomInnerHtml; // Custom Inner Html

	function cmer() {
		$this->TableVar = "mer";
		$this->TableName = "mer";
		$this->SelectLimit = TRUE;
		$this->idMer = new cField('mer', 'x_idMer', 'idMer', "`idMer`", 3, -1, FALSE);
		$this->fields['idMer'] =& $this->idMer;
		$this->idRegional = new cField('mer', 'x_idRegional', 'idRegional', "`idRegional`", 3, -1, FALSE);
		$this->fields['idRegional'] =& $this->idRegional;
		$this->idDepartamento = new cField('mer', 'x_idDepartamento', 'idDepartamento', "`idDepartamento`", 3, -1, FALSE);
		$this->fields['idDepartamento'] =& $this->idDepartamento;
		$this->idMunicipio = new cField('mer', 'x_idMunicipio', 'idMunicipio', "`idMunicipio`", 3, -1, FALSE);
		$this->fields['idMunicipio'] =& $this->idMunicipio;
		$this->idComunidad = new cField('mer', 'x_idComunidad', 'idComunidad', "`idComunidad`", 3, -1, FALSE);
		$this->fields['idComunidad'] =& $this->idComunidad;
		$this->idRubro = new cField('mer', 'x_idRubro', 'idRubro', "`idRubro`", 3, -1, FALSE);
		$this->fields['idRubro'] =& $this->idRubro;
		$this->mer = new cField('mer', 'x_mer', 'mer', "`mer`", 200, -1, FALSE);
		$this->fields['mer'] =& $this->mer;
		$this->unidadProductivaDedica = new cField('mer', 'x_unidadProductivaDedica', 'unidadProductivaDedica', "`unidadProductivaDedica`", 200, -1, FALSE);
		$this->fields['unidadProductivaDedica'] =& $this->unidadProductivaDedica;
		$this->codigo = new cField('mer', 'x_codigo', 'codigo', "`codigo`", 200, -1, FALSE);
		$this->fields['codigo'] =& $this->codigo;
		$this->numeroSocios = new cField('mer', 'x_numeroSocios', 'numeroSocios', "`numeroSocios`", 3, -1, FALSE);
		$this->fields['numeroSocios'] =& $this->numeroSocios;
		$this->direccion = new cField('mer', 'x_direccion', 'direccion', "`direccion`", 200, -1, FALSE);
		$this->fields['direccion'] =& $this->direccion;
		$this->zona = new cField('mer', 'x_zona', 'zona', "`zona`", 200, -1, FALSE);
		$this->fields['zona'] =& $this->zona;
		$this->referencia = new cField('mer', 'x_referencia', 'referencia', "`referencia`", 200, -1, FALSE);
		$this->fields['referencia'] =& $this->referencia;
		$this->refTelefonica = new cField('mer', 'x_refTelefonica', 'refTelefonica', "`refTelefonica`", 3, -1, FALSE);
		$this->fields['refTelefonica'] =& $this->refTelefonica;
		$this->refCelular = new cField('mer', 'x_refCelular', 'refCelular', "`refCelular`", 3, -1, FALSE);
		$this->fields['refCelular'] =& $this->refCelular;
		$this->fechaInicio = new cField('mer', 'x_fechaInicio', 'fechaInicio', "`fechaInicio`", 133, 7, FALSE);
		$this->fields['fechaInicio'] =& $this->fechaInicio;
		$this->fechaFinal = new cField('mer', 'x_fechaFinal', 'fechaFinal', "`fechaFinal`", 133, 7, FALSE);
		$this->fields['fechaFinal'] =& $this->fechaFinal;
		$this->longitudUTM = new cField('mer', 'x_longitudUTM', 'longitudUTM', "`longitudUTM`", 5, -1, FALSE);
		$this->fields['longitudUTM'] =& $this->longitudUTM;
		$this->latitudUTM = new cField('mer', 'x_latitudUTM', 'latitudUTM', "`latitudUTM`", 5, -1, FALSE);
		$this->fields['latitudUTM'] =& $this->latitudUTM;
		$this->gestion = new cField('mer', 'x_gestion', 'gestion', "`gestion`", 3, -1, FALSE);
		$this->fields['gestion'] =& $this->gestion;
		$this->estado = new cField('mer', 'x_estado', 'estado', "`estado`", 3, -1, FALSE);
		$this->fields['estado'] =& $this->estado;
		$this->fechaCreacion = new cField('mer', 'x_fechaCreacion', 'fechaCreacion', "`fechaCreacion`", 133, 7, FALSE);
		$this->fields['fechaCreacion'] =& $this->fechaCreacion;
		$this->fechaModificacion = new cField('mer', 'x_fechaModificacion', 'fechaModificacion', "`fechaModificacion`", 133, 7, FALSE);
		$this->fields['fechaModificacion'] =& $this->fechaModificacion;
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
		return "mer_Highlight";
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
	if($_SESSION['idRol']>1)
            return "SELECT a.* FROM mer a, responsable b";
            else return "SELECT * FROM mer";
	}

	function SqlWhere() { // Where
	if($_SESSION['idRol']>1)
            return "b.idGerente='".(int)$_SESSION['idUsuario']."' AND b.idMer=a.idMer AND a.estado!=0";
            else return "estado!=0";
	}

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
        if($_SESSION['idRol']>1)
            return "a.idMer asc";
            else return "idMer asc";
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
		return "INSERT INTO `mer` ($names) VALUES ($values)";
	}

	// UPDATE statement
	function UpdateSQL(&$rs) {
		$SQL = "UPDATE `mer` SET ";
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
		$SQL = "DELETE FROM `mer` WHERE ";
		$SQL .= EW_DB_QUOTE_START . 'idMer' . EW_DB_QUOTE_END . '=' .	ew_QuotedValue($rs['idMer'], $this->idMer->FldDataType) . ' AND ';
		if (substr($SQL, -5) == " AND ") $SQL = substr($SQL, 0, strlen($SQL)-5);
		if ($this->CurrentFilter <> "")	$SQL .= " AND " . $this->CurrentFilter;
		return $SQL;
	}

	// Key filter for table
	function SqlKeyFilter() {
		return "`idMer` = @idMer@";
	}

	// Return Key filter for table
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->idMer->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@idMer@", ew_AdjustSql($this->idMer->CurrentValue), $sKeyFilter); // Replace key value
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
			return "merlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// View url
	function ViewUrl() {
		return $this->KeyUrl("formulariolist.php", $this->UrlParm());
	}

	// Add url
	function AddUrl() {
		$AddUrl = "meradd.php";
		$sUrlParm = $this->UrlParm();
		if ($sUrlParm <> "")
			$AddUrl .= "?" . $sUrlParm;
		return $AddUrl;
	}

	// Edit url
	function EditUrl() {
		return $this->KeyUrl("meredit.php", $this->UrlParm());
	}

	// Inline edit url
	function InlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy url
	function CopyUrl() {
		return $this->KeyUrl("meradd.php", $this->UrlParm());
	}

	// Inline copy url
	function InlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete url
	function DeleteUrl() {
		return $this->KeyUrl("merdelete.php", $this->UrlParm());
	}

	// Key url
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->idMer->CurrentValue)) {
			$sUrl .= "idMer=" . urlencode($this->idMer->CurrentValue);
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
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		}
	}

	// URL parm
	function UrlParm($parm = "") {
		$UrlParm = ($this->UseTokenInUrl) ? "t=mer" : "";
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
		$this->idMer->setDbValue($rs->fields('idMer'));
		$this->idRegional->setDbValue($rs->fields('idRegional'));
		$this->idDepartamento->setDbValue($rs->fields('idDepartamento'));
		$this->idMunicipio->setDbValue($rs->fields('idMunicipio'));
		$this->idComunidad->setDbValue($rs->fields('idComunidad'));
		$this->idRubro->setDbValue($rs->fields('idRubro'));
		$this->mer->setDbValue($rs->fields('mer'));
		$this->unidadProductivaDedica->setDbValue($rs->fields('unidadProductivaDedica'));
		$this->codigo->setDbValue($rs->fields('codigo'));
		$this->numeroSocios->setDbValue($rs->fields('numeroSocios'));
		$this->direccion->setDbValue($rs->fields('direccion'));
		$this->zona->setDbValue($rs->fields('zona'));
		$this->referencia->setDbValue($rs->fields('referencia'));
		$this->refTelefonica->setDbValue($rs->fields('refTelefonica'));
		$this->refCelular->setDbValue($rs->fields('refCelular'));
		$this->fechaInicio->setDbValue($rs->fields('fechaInicio'));
		$this->fechaFinal->setDbValue($rs->fields('fechaFinal'));
		$this->longitudUTM->setDbValue($rs->fields('longitudUTM'));
		$this->latitudUTM->setDbValue($rs->fields('latitudUTM'));
		$this->gestion->setDbValue($rs->fields('gestion'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fechaCreacion->setDbValue($rs->fields('fechaCreacion'));
		$this->fechaModificacion->setDbValue($rs->fields('fechaModificacion'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

		// idMer
		$this->idMer->ViewValue = $this->idMer->CurrentValue;
		$this->idMer->CssStyle = "";
		$this->idMer->CssClass = "";
		$this->idMer->ViewCustomAttributes = "";

		// idRegional
		if (strval($this->idRegional->CurrentValue) <> "") {
			$sSqlWrk = "SELECT `regional` FROM `regional` WHERE `idRegional` = " . ew_AdjustSql($this->idRegional->CurrentValue) . "";
			$sSqlWrk .= " ORDER BY `regional` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
				$this->idRegional->ViewValue = $rswrk->fields('regional');
				$rswrk->Close();
			} else {
				$this->idRegional->ViewValue = $this->idRegional->CurrentValue;
			}
		} else {
			$this->idRegional->ViewValue = NULL;
		}
		$this->idRegional->CssStyle = "";
		$this->idRegional->CssClass = "";
		$this->idRegional->ViewCustomAttributes = "";

		// idDepartamento
		if (strval($this->idDepartamento->CurrentValue) <> "") {
			$sSqlWrk = "SELECT `departamento` FROM `departamento` WHERE `idDepartamento` = " . ew_AdjustSql($this->idDepartamento->CurrentValue) . "";
			$sSqlWrk .= " ORDER BY `departamento` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
				$this->idDepartamento->ViewValue = $rswrk->fields('departamento');
				$rswrk->Close();
			} else {
				$this->idDepartamento->ViewValue = $this->idDepartamento->CurrentValue;
			}
		} else {
			$this->idDepartamento->ViewValue = NULL;
		}
		$this->idDepartamento->CssStyle = "";
		$this->idDepartamento->CssClass = "";
		$this->idDepartamento->ViewCustomAttributes = "";

		// idMunicipio
		if (strval($this->idMunicipio->CurrentValue) <> "") {
			$sSqlWrk = "SELECT `municipio` FROM `municipio` WHERE `idMunicipio` = " . ew_AdjustSql($this->idMunicipio->CurrentValue) . "";
			$sSqlWrk .= " ORDER BY `municipio` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
				$this->idMunicipio->ViewValue = $rswrk->fields('municipio');
				$rswrk->Close();
			} else {
				$this->idMunicipio->ViewValue = $this->idMunicipio->CurrentValue;
			}
		} else {
			$this->idMunicipio->ViewValue = NULL;
		}
		$this->idMunicipio->CssStyle = "";
		$this->idMunicipio->CssClass = "";
		$this->idMunicipio->ViewCustomAttributes = "";

		// idComunidad
		if (strval($this->idComunidad->CurrentValue) <> "") {
			$sSqlWrk = "SELECT `comunidad` FROM `comunidad` WHERE `idComunidad` = " . ew_AdjustSql($this->idComunidad->CurrentValue) . "";
			$sSqlWrk .= " ORDER BY `comunidad` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
				$this->idComunidad->ViewValue = $rswrk->fields('comunidad');
				$rswrk->Close();
			} else {
				$this->idComunidad->ViewValue = $this->idComunidad->CurrentValue;
			}
		} else {
			$this->idComunidad->ViewValue = NULL;
		}
		$this->idComunidad->CssStyle = "";
		$this->idComunidad->CssClass = "";
		$this->idComunidad->ViewCustomAttributes = "";

		// idRubro
		if (strval($this->idRubro->CurrentValue) <> "") {
			$sSqlWrk = "SELECT `rubro` FROM `rubro` WHERE `idRubro` = " . ew_AdjustSql($this->idRubro->CurrentValue) . "";
			$sSqlWrk .= " ORDER BY `rubro` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
				$this->idRubro->ViewValue = $rswrk->fields('rubro');
				$rswrk->Close();
			} else {
				$this->idRubro->ViewValue = $this->idRubro->CurrentValue;
			}
		} else {
			$this->idRubro->ViewValue = NULL;
		}
		$this->idRubro->CssStyle = "";
		$this->idRubro->CssClass = "";
		$this->idRubro->ViewCustomAttributes = "";

		// mer
		$this->mer->ViewValue = $this->mer->CurrentValue;
		$this->mer->CssStyle = "";
		$this->mer->CssClass = "";
		$this->mer->ViewCustomAttributes = "";

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

		// estado
		if (strval($this->estado->CurrentValue) <> "") {
			switch ($this->estado->CurrentValue) {
				case "0":
					$this->estado->ViewValue = "Borrado";
					break;
				case "1":
					$this->estado->ViewValue = "Habilitado";
					break;
				case "2":
					$this->estado->ViewValue = "Desabilitado";
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

		// idMer
		$this->idMer->HrefValue = "";

		// idRegional
		$this->idRegional->HrefValue = "";

		// idDepartamento
		$this->idDepartamento->HrefValue = "";

		// idMunicipio
		$this->idMunicipio->HrefValue = "";

		// idComunidad
		$this->idComunidad->HrefValue = "";

		// idRubro
		$this->idRubro->HrefValue = "";

		// mer
		$this->mer->HrefValue = "";

		// fechaInicio
		$this->fechaInicio->HrefValue = "";

		// fechaFinal
		$this->fechaFinal->HrefValue = "";

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
