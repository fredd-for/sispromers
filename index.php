<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
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
$default = new cdefault();
$Page =& $default;

// Page init processing
$default->Page_Init();

// Page main processing
$default->Page_Main();
?>
<?php

//
// Page Class
//
class cdefault {

	// Page ID
	var $PageID = 'default';

	// Page Object Name
	var $PageObjName = 'default';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
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
		return TRUE;
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cdefault() {
		global $conn;

		// Initialize user table object
		$GLOBALS["usuario"] = new cusuario;

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'default', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $usuario;
		global $Security;
		$Security = new cAdvancedSecurity();

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

	// Page main processing
	function Page_Main() {
		global $Security;
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->LoadUserLevel(); // load User Level
		if ($Security->AllowList('mer')) {
		$this->Page_Terminate("merlist.php"); // Exit and go to default page
		}
		if ($Security->AllowList('departamento')) {
			$this->Page_Terminate("departamentolist.php");
		}
		if ($Security->AllowList('formulario')) {
			$this->Page_Terminate("formulariolist.php");
		}
		if ($Security->AllowList('comunidad')) {
			$this->Page_Terminate("comunidadlist.php");
		}
		if ($Security->AllowList('municipio')) {
			$this->Page_Terminate("municipiolist.php");
		}
		if ($Security->AllowList('planilla')) {
                $this->Page_Terminate("planillalist.php");
                }
		if ($Security->AllowList('regional')) {
			$this->Page_Terminate("regionallist.php");
		}
		if ($Security->AllowList('responsable')) {
			$this->Page_Terminate("responsablelist.php");
		}
		if ($Security->AllowList('rubro')) {
			$this->Page_Terminate("rubrolist.php");
		}
		if ($Security->AllowList('usuario')) {
			$this->Page_Terminate("usuariolist.php");
		}
		if ($Security->AllowList('permiso')) {
			$this->Page_Terminate("permisolist.php");
		}
		if ($Security->AllowList('rol')) {
			$this->Page_Terminate("rollist.php");
		}
		if ($Security->AllowList('matriz_marco_logico')) {
			$this->Page_Terminate("marco_logico.htm");
		}
                if ($Security->AllowList('resumen_linea_base')) {
			$this->Page_Terminate("linea_base.htm");
		}
                if ($Security->AllowList('reporte_mml')) {
			$this->Page_Terminate("reporte_mmllist.php");
		}
                if ($Security->AllowList('reporte_indicadores')) {
			$this->Page_Terminate("reporte_indicadoreslist.php");
		}
                if ($Security->AllowList('reporte_rubros')) {
			$this->Page_Terminate("reporte_rubroslist.php");
		}
                if ($Security->AllowList('mers_fortalecidas')) {
			$this->Page_Terminate("mers_fortalecidaslist.php");
		}
                if ($Security->AllowList('reporte_general')) {
			$this->Page_Terminate("reporte_generallist.php");
		}
                if ($Security->AllowList('indicador_impacto')) {
			$this->Page_Terminate("indicador_impactolist.php");
		}
		if ($Security->AllowList('consultoria')) {
			$this->Page_Terminate("consultorialist.php");
		}
                if ($Security->AllowList('cronograma')) {
			$this->Page_Terminate("cronogramalist.php");
		}
                 if ($Security->AllowList('responsable_consultoria')) {
			$this->Page_Terminate("responsable_consultorialist.php");
		}
		if ($Security->IsLoggedIn()) {
			echo "No tiene permisos para consultar esta P&aacute;gina";
			echo "<br><a href=\"logout.php\">Volver a la P&aacute;gina de acceso</a>";
		} else {
			$this->Page_Terminate("login.php"); // Exit and go to login page
		}
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
