<?php require_once('Connections/conexion.php'); ?>
<script type="text/javascript" language="JavaScript1.2" src="ewmenu/stmenu.js"></script>
<?php

// Menu
define("EW_MENUBAR_VERTICAL_CLASSNAME", "ewMenuBarVertical", TRUE);
define("EW_MENUBAR_SUBMENU_CLASSNAME", "", TRUE);
define("EW_MENUBAR_RIGHTHOVER_IMAGE", "", TRUE);
?>
<?php
define("EW_SESSION_MENU_AR_USER_LEVEL_PRIV", "sispromers2_arUserLevelPriv", TRUE); // User Level Privilege Array
define("EW_SESSION_MENU_USER_LEVEL", "sispromers2_status_UserLevelValue", TRUE); // User level value
define("EW_MENU_ALLOW_ADMIN", 16, TRUE);

// Restore user level privilege
if (is_array(@$_SESSION[EW_SESSION_MENU_AR_USER_LEVEL_PRIV]))
	$arMenuUserLevelPriv = $_SESSION[EW_SESSION_MENU_AR_USER_LEVEL_PRIV];

// Check if menu item is allowed for current user level
function AllowListMenu($TableName) {
	global $arMenuUserLevelPriv;
	$userlevellist = "";
	if (function_exists("CurrentUserLevelList"))
		$userlevellist = CurrentUserLevelList(); // Get user level id list
	if (strval($userlevellist) == "") // Not defined, just get user level
		$userlevellist = CurrentUserLevel();
	if (IsLoggedIn()) {
		if (IsListItem($userlevellist, "-1")) {
			return TRUE;
		} else {
			$priv = 0;
			if (is_array($arMenuUserLevelPriv)) {
				foreach ($arMenuUserLevelPriv as $row) {
					if (strval($row[0]) == strval($TableName) &&
						IsListItem($userlevellist, $row[1])) {
						$thispriv = $row[2];
						if (is_null($thispriv)) $thispriv = 0;
						$thispriv = intval($thispriv);
						$priv = $priv | $thispriv;
					}
				}
			}
			return ($priv & 8);
		}
	} else {
		return FALSE;
	}
}

// Is list item
function IsListItem($list, $item) {
	if ($list == "") {
		return FALSE;
	} else {
		$ar = explode(",", $list);
		foreach ($ar as $level) {
			if (trim(strval($item)) == trim(strval($level)))
				return TRUE;
		}
		return FALSE;
	}
}

/**
 * Menu class
 */

class cMenu {
	var $Id;
	var $IsRoot = FALSE;
	var $NoItem = NULL;
	var $ItemData = array();

	function cMenu($id) {
		$this->Id = $id;
	}

	// Add a menu item
	function AddMenuItem($id, $text, $url, $parentid) {
		$item = new cMenuItem($id, $text, $url, $parentid);
		if (!MenuItem_Adding($item)) return;
		if ($item->ParentId < 0) {
			$this->AddItem($item);
		} else {
			if ($oParentMenu =& $this->FindItem($item->ParentId))
				$oParentMenu->AddItem($item);
		}
	}

	// Add item to internal array
	function AddItem($item) {
		$this->ItemData[] = $item;
	}

	// Find item
	function &FindItem($id) {
		$cnt = count($this->ItemData);
		for ($i = 0; $i < $cnt; $i++) {
			$item =& $this->ItemData[$i];
			if ($item->Id == $id) {
				return $item;
			} elseif (!is_null($item->SubMenu)) {
				if ($subitem =& $item->SubMenu->FindItem($id))
					return $subitem;
			}
		}
		return $this->NoItem;
	}

	// Render the menu
	function Render() {
		echo "<ul";
		if ($this->Id <> "") {
			if (is_numeric($this->Id)) {
				echo " id=\"menu_" . $this->Id . "\"";
			} else {
				echo " id=\"" . $this->Id . "\"";
			}
		}
		if ($this->IsRoot)
			echo " class=\"" . EW_MENUBAR_VERTICAL_CLASSNAME . "\"";
		echo ">\n";
		foreach ($this->ItemData as $item) {
			echo "<li><a";
			if (!is_null($item->SubMenu))
				echo " class=\"" . EW_MENUBAR_SUBMENU_CLASSNAME . "\"";
			if ($item->Url <> "")
				echo " href=\"" . htmlspecialchars(strval($item->Url)) . "\"";
			echo ">" . $item->Text . "</a>\n";
			if (!is_null($item->SubMenu))
				$item->SubMenu->Render();
			echo "</li>\n";
		}
		echo "</ul>\n";
	}
}

// Menu item class
class cMenuItem {
	var $Id;
	var $Text;
	var $Url;
	var $ParentId; 
	var $SubMenu = NULL; // Data type = cMenu

	function cMenuItem($id, $text, $url, $parentid) {
		$this->Id = $id;
		$this->Text = $text;
		$this->Url = $url;
		$this->ParentId = $parentid;
	}

	function AddItem($item) { // Add submenu item
		if (is_null($this->SubMenu))
			$this->SubMenu = new cMenu($this->Id);
		$this->SubMenu->AddItem($item);
	}
}

// MenuItem Adding event
function MenuItem_Adding(&$Item) {

	//var_dump($Item);
	// Return FALSE if menu item not allowed

	return TRUE;
}
?>
<div class="phpmaker">
<?php
// Generate all menu items
$RootMenu = new cMenu("RootMenu");
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(28, "", "", -1);
if ((@$_SESSION[EW_SESSION_MENU_USER_LEVEL] & EW_MENU_ALLOW_ADMIN) == EW_MENU_ALLOW_ADMIN) {
	$RootMenu->AddMenuItem(24, "Rol", "rollist.php", 28);
}
if ((@$_SESSION[EW_SESSION_MENU_USER_LEVEL] & EW_MENU_ALLOW_ADMIN) == EW_MENU_ALLOW_ADMIN) {
	$RootMenu->AddMenuItem(23, "Permiso", "permisolist.php", 28);
}
//if (IsLoggedIn()) {
//	$RootMenu->AddMenuItem(0xFFFFFFFF, "Salir", "logout.php", -1);
//} elseif (substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php") {
//	$RootMenu->AddMenuItem(0xFFFFFFFF, "Ingresar", "login.php", -1);
//}
//if (AllowListMenu('Reporte Mers')) {
//	$RootMenu->AddMenuItem(29, "Reporte Mers", "Reporte_Mersreport.php", -1);
//}
?>
<?php if (IsLoggedIn()) { ?>
<table width="160" border="0" cellspacing="0" cellpadding="0">
 <tr><td>
    <script id="Sothink Widgets:sigma_ewmenu.pgt" type="text/javascript" language="JavaScript1.2">
<!--
stm_bm(["menu502e",720,"","ewmenu/blank.gif",0,"","",0,0,250,0,1000,1,0,0,"","",0,0,1,1,"default","hand",""],this);
stm_bp("p0",[1,4,0,0,1,2,16,18,100,"",-2,"",-2,90,0,0,"#000000","#40546A","",3,1,1,"#40546A"]);
stm_ai("p0i0",[6,1,"transparent","ewmenu/banner_administrador.png",150,120,0]);

stm_ai("p0i1",[0,"Cerrar Sesi\u00f3n","","",-1,-1,0,"logout.php","_self","","","ewmenu/lock_go.png","ewmenu/lock_go.png",16,16,0,"","",0,0,0,0,1,"#F5F5F5",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","9pt Arial","9pt Arial",0,0]);
<?php if (AllowListMenu('usuario')) { ?>
stm_aix("p0i2","p0i1",[0,"Usuarios Sistema","","",-1,-1,0,"#","_self","","","ewmenu/folder.png","ewmenu/folder.png",16,16,0,"ewmenu/37-06_an0.gif","ewmenu/37-06_an.gif",18,13]);
stm_bpx("p1","p0",[1,2,0,0,1,2,16,0,100,"",-2,"",-2,90,0,0,"#000000","#F5F5F5"]);
stm_aix("p1i0","p0i1",[0,"Usuario","","",-1,-1,0,"usuariolist.php?cmd=resetall","_self","","","ewmenu/medal_gold_2.png","ewmenu/medal_gold_2.png"],150,0);
stm_ep();
<?php } ?>
<?php if (AllowListMenu('regional') || AllowListMenu('departamento') || AllowListMenu('municipio') || AllowListMenu('comunidad')) { ?>
stm_aix("p0i2","p0i1",[0,"Regional","","",-1,-1,0,"#","_self","","","ewmenu/folder.png","ewmenu/folder.png",16,16,0,"ewmenu/37-06_an0.gif","ewmenu/37-06_an.gif",18,13]);
stm_bpx("p1","p0",[1,2,0,0,1,2,16,0,100,"",-2,"",-2,90,0,0,"#000000","#F5F5F5"]);
<?php if (AllowListMenu('regional')) { ?>
stm_aix("p1i2","p0i1",[0,"Regional","","",-1,-1,0,"regionallist.php?cmd=resetall","_self","","","ewmenu/world.png","ewmenu/world.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('departamento')) { ?>
stm_aix("p1i3","p0i1",[0,"Departamento","","",-1,-1,0,"departamentolist.php?cmd=resetall","_self","","","ewmenu/world.png","ewmenu/world.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('municipio')) { ?>
stm_aix("p1i4","p0i1",[0,"Municipio","","",-1,-1,0,"municipiolist.php?cmd=resetall","_self","","","ewmenu/world.png","ewmenu/world.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('comunidad')) { ?>
stm_aix("p1i5","p0i1",[0,"Comunidad","","",-1,-1,0,"comunidadlist.php?cmd=resetall","_self","","","ewmenu/world.png","ewmenu/world.png"],150,0);
<?php } ?>
stm_ep();
<?php } ?>
<?php if (AllowListMenu('mer') || AllowListMenu('responsable')) { ?>
stm_aix("p0i2","p0i1",[0,"MERS","","",-1,-1,0,"#","_self","","","ewmenu/folder.png","ewmenu/folder.png",16,16,0,"ewmenu/37-06_an0.gif","ewmenu/37-06_an.gif",18,13]);
stm_bpx("p1","p0",[1,2,0,0,1,2,16,0,100,"",-2,"",-2,90,0,0,"#000000","#F5F5F5"]);
<?php if (AllowListMenu('mer')) { ?>
stm_aix("p1i0","p0i1",[0,"Mers","","",-1,-1,0,"merlist.php","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('responsable')) { ?>
stm_aix("p1i1","p0i1",[0,"Responsable","","",-1,-1,0,"responsablelist.php","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png"],150,0);
<?php } ?>
stm_ep();
<?php } ?>
<?php if (AllowListMenu('consultoria') || AllowListMenu('cronograma') || AllowListMenu('responsable_consultoria') || AllowListMenu('reporte_seguimiento_consultoria') || AllowListMenu('reporte_informe_consultoria')) { ?>
stm_aix("p0i7","p0i1",[0,"CONSULTORIAS","","",-1,-1,0,"#","_self","","","ewmenu/folder.png","ewmenu/folder.png",16,16,0,"ewmenu/37-06_an0.gif","ewmenu/37-06_an.gif",18,13]);
stm_bpx("p1","p0",[1,2,0,0,1,2,16,0,100,"",-2,"",-2,90,0,0,"#000000","#F5F5F5"]);
<?php if (AllowListMenu('consultoria')) { ?>
stm_aix("p1i0","p0i1",[0,"Lista de Consultorias","","",-1,-1,0,"consultorialist.php","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png"],190,0);
<?php } ?>
<?php if (AllowListMenu('responsable_consultoria')) { ?>
stm_aix("p1i1","p0i1",[0,"Asignar Revisor","","",-1,-1,0,"responsable_consultorialist.php","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png"],190,0);
<?php } ?>
<?php if (AllowListMenu('reporte_seguimiento_consultoria')) { ?>
stm_aix("p1i2","p0i1",[0,"Seguimiento Consultorias","","",-1,-1,0,"reporte_seguimiento_consultorialist.php","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png"],190,0);
<?php } ?>
<?php if (AllowListMenu('reporte_informe_consultoria')) { ?>
stm_aix("p1i3","p0i1",[0,"Informe/Revision Consultorias","","",-1,-1,0,"reporte_informe_consultorialist.php","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png"],190,0);
<?php } ?>
stm_ep();
<?php } ?>
stm_aix("p0i2","p0i1",[0,"Tablas Auxiliares","","",-1,-1,0,"#","_self","","","ewmenu/folder.png","ewmenu/folder.png",16,16,0,"ewmenu/37-06_an0.gif","ewmenu/37-06_an.gif",18,13]);
stm_bpx("p1","p0",[1,2,0,0,1,2,16,0,100,"",-2,"",-2,90,0,0,"#000000","#F5F5F5"]);
<?php if (AllowListMenu('rubro')) { ?>
stm_aix("p1i2","p0i1",[0,"Rubro","","",-1,-1,0,"rubrolist.php?cmd=resetall","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('planilla')) { ?>
stm_aix("p1i3","p0i1",[0,"Formularios","","",-1,-1,0,"planillalist.php?cmd=resetall","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png"],150,0);
<?php } ?>
<?php if (IsLoggedIn() && !IsSysAdmin()) { ?>
stm_aix("p1i4","p0i1",[0,"Cambio de Contrase\u00f1a","","",-1,-1,0,"changepwd.php?cmd=resetall","_self","","","ewmenu/wrapping.png","ewmenu/wrapping.png"],150,0);
<?php } ?>
stm_ep();
stm_aix("p0i8","p0i2",[0,"Reportes"]);
stm_bpx("p8","p1",[]);
<?php if (AllowListMenu('matriz_marco_logico')) { ?>
stm_aix("p8i0","p0i1",[0,"Matriz Marco Logico","","",-1,-1,0,"marco_logico.htm","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('resumen_linea_base')) { ?>
stm_aix("p8i0","p0i1",[0,"Resumen Linea Base","","",-1,-1,0,"linea_base.htm","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('reporte_mml')) { ?>
stm_aix("p8i1","p0i1",[0,"Reporte MML","","",-1,-1,0,"reporte_mmllist.php","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png"],150,0);
<?php } ?>

<?php if (AllowListMenu('reporte_indicadores')) { ?>
stm_aix("p8i1","p0i1",[0,"Reporte Grafico Indicadores","","",-1,-1,0,"reporte_indicadoreslist.php","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png"],150,0);
<?php } ?>

<?php if (AllowListMenu('reporte_rubros')) { ?>
stm_aix("p8i1","p0i1",[0,"Reporte Rubros","","",-1,-1,0,"reporte_rubroslist.php","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('mers_fortalecidas')) { ?>
stm_aix("p8i2","p0i1",[0,"Reporte Mers Fortalecidas","","",-1,-1,0,"mers_fortalecidaslist.php","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('reporte_general')) { ?>
stm_aix("p8i3","p0i1",[0,"Reporte General","","",-1,-1,0,"reporte_generallist.php","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('indicador_impacto')) { ?>
stm_aix("p8i3","p0i1",[0,"Indicador de Impacto","","",-1,-1,0,"indicador_impactolist.php","_self","","","ewmenu/indicador.png","ewmenu/click_indicador.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('indicador1')) { ?>
stm_aix("p8i4","p0i1",[0,"Proposito I.1","","",-1,-1,0,"indicador1list.php","_self","","","ewmenu/indicador.png","ewmenu/click_indicador.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('indicador2')) { ?>
stm_aix("p8i5","p0i1",[0,"Proposito I.2","","",-1,-1,0,"indicador2list.php","_self","","","ewmenu/indicador.png","ewmenu/click_indicador.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('indicador3')) { ?>
stm_aix("p8i6","p0i1",[0,"Proposito I.3","","",-1,-1,0,"indicador3list.php","_self","","","ewmenu/indicador.png","ewmenu/click_indicador.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('indicador4')) { ?>
stm_aix("p8i7","p0i1",[0,"Proposito I.4","","",-1,-1,0,"indicador4list.php","_self","","","ewmenu/indicador.png","ewmenu/click_indicador.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('indicador5')) { ?>
stm_aix("p8i8","p0i1",[0,"Indicador C.1-I.1","","",-1,-1,0,"indicador5list.php","_self","","","ewmenu/indicador.png","ewmenu/click_indicador.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('indicador6')) { ?>
stm_aix("p8i9","p0i1",[0,"Indicador C.1-I.2","","",-1,-1,0,"indicador6list.php","_self","","","ewmenu/indicador.png","ewmenu/click_indicador.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('indicador7')) { ?>
stm_aix("p8i10","p0i1",[0,"Indicador C.1-I.3","","",-1,-1,0,"indicador7list.php","_self","","","ewmenu/indicador.png","ewmenu/click_indicador.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('indicador8')) { ?>
stm_aix("p8i11","p0i1",[0,"Indicador C.1-I.4","","",-1,-1,0,"indicador8list.php","_self","","","ewmenu/indicador.png","ewmenu/click_indicador.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('indicador9')) { ?>
stm_aix("p8i12","p0i1",[0,"Indicador C.2-I.1","","",-1,-1,0,"indicador9list.php","_self","","","ewmenu/indicador.png","ewmenu/click_indicador.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('indicador10')) { ?>
stm_aix("p8i13","p0i1",[0,"Indicador C.2-I.2","","",-1,-1,0,"indicador10list.php","_self","","","ewmenu/indicador.png","ewmenu/click_indicador.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('indicador11')) { ?>
stm_aix("p8i14","p0i1",[0,"Indicador C.2-I.3","","",-1,-1,0,"indicador11list.php","_self","","","ewmenu/indicador.png","ewmenu/click_indicador.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('indicador12')) { ?>
stm_aix("p8i15","p0i1",[0,"Indicador C.3-I.1","","",-1,-1,0,"indicador12list.php","_self","","","ewmenu/indicador.png","ewmenu/click_indicador.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('indicador13')) { ?>
stm_aix("p8i16","p0i1",[0,"Indicador C.3-I.2","","",-1,-1,0,"indicador13list.php","_self","","","ewmenu/indicador.png","ewmenu/click_indicador.png"],150,0);
<?php } ?>
<?php if (AllowListMenu('indicador14')) { ?>
stm_aix("p8i17","p0i1",[0,"Indicador C.3-I.3","","",-1,-1,0,"indicador14list.php","_self","","","ewmenu/indicador.png","ewmenu/click_indicador.png"],150,0);
<?php } ?>
stm_ep();
stm_em();
//-->
    </script>
     </td></tr></table>
</div>

<?php if($_GET['idMer']){
mysql_select_db($database_conexion, $conexion);
$query_planilla = "SELECT * FROM planilla";
$mostrar_planilla = mysql_query($query_planilla, $conexion) or die(mysql_error());
$row_planilla=mysql_fetch_assoc($mostrar_planilla);
    ?>
<div>
<script id="Sothink Widgets:sigma_ewmenu.pgt" type="text/javascript" language="JavaScript1.2">
stm_bm(["menu502e",720,"","ewmenu/blank.gif",0,"","",0,0,250,0,1000,1,0,0,"","",0,0,1,1,"default","hand",""],this);
stm_bp("p0",[1,4,0,0,1,2,16,18,100,"",-2,"",-2,90,0,0,"#000000","#40546A","",3,1,1,"#40546A"]);
//stm_ai("p0i0",[6,1,"transparent","ewmenu/banner_administrador.png",150,120,0]);
//stm_ai("p0i1",[0,"Cerrar Sesi\u00f3n","","",-1,-1,0,"logout.php","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",16,16,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","9pt Arial","9pt Arial",0,0]);
stm_ai("p0i1",[0,"Monitoreo","","",-1,-1,0,"formulariolist.php?idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
  stm_ai("p0i1",[0,"<?php echo $row_planilla['idPlanilla']." - ".$row_planilla['Nombre']?>","","",-1,-1,0,"formulariolist.php?idPlanilla=<?php echo $row_planilla['idPlanilla'];?>&idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
  <?php $row_planilla=mysql_fetch_assoc($mostrar_planilla);?>
  stm_ai("p0i1",[0,"<?php echo $row_planilla['idPlanilla']." - ".$row_planilla['Nombre']?>","","",-1,-1,0,"formulariolist.php?idPlanilla=<?php echo $row_planilla['idPlanilla'];?>&idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
  <?php $row_planilla=mysql_fetch_assoc($mostrar_planilla);?>
  stm_ai("p0i1",[0,"<?php echo $row_planilla['idPlanilla']." - ".$row_planilla['Nombre']?>","","",-1,-1,0,"formulariolist.php?idPlanilla=<?php echo $row_planilla['idPlanilla'];?>&idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
  <?php $row_planilla=mysql_fetch_assoc($mostrar_planilla);?>
  stm_ai("p0i1",[0,"<?php echo $row_planilla['idPlanilla']." - ".$row_planilla['Nombre']?>","","",-1,-1,0,"formulariolist.php?idPlanilla=<?php echo $row_planilla['idPlanilla'];?>&idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
  <?php $row_planilla=mysql_fetch_assoc($mostrar_planilla);?>
  stm_ai("p0i1",[0,"<?php echo $row_planilla['idPlanilla']." - ".$row_planilla['Nombre']?>","","",-1,-1,0,"formulariolist.php?idPlanilla=<?php echo $row_planilla['idPlanilla'];?>&idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
  <?php $row_planilla=mysql_fetch_assoc($mostrar_planilla);?>
  stm_ai("p0i1",[0,"<?php echo $row_planilla['idPlanilla']." - ".$row_planilla['Nombre']?>","","",-1,-1,0,"formulariolist.php?idPlanilla=<?php echo $row_planilla['idPlanilla'];?>&idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
  <?php $row_planilla=mysql_fetch_assoc($mostrar_planilla);?>
  stm_ai("p0i1",[0,"<?php echo $row_planilla['idPlanilla']." - ".$row_planilla['Nombre']?>","","",-1,-1,0,"formulariolist.php?idPlanilla=<?php echo $row_planilla['idPlanilla'];?>&idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
  <?php $row_planilla=mysql_fetch_assoc($mostrar_planilla);?>
  stm_ai("p0i1",[0,"<?php echo $row_planilla['idPlanilla']." - ".$row_planilla['Nombre']?>","","",-1,-1,0,"formulariolist.php?idPlanilla=<?php echo $row_planilla['idPlanilla'];?>&idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
  <?php $row_planilla=mysql_fetch_assoc($mostrar_planilla);?>
  stm_ai("p0i1",[0,"<?php echo $row_planilla['idPlanilla']." - ".$row_planilla['Nombre']?>","","",-1,-1,0,"formulariolist.php?idPlanilla=<?php echo $row_planilla['idPlanilla'];?>&idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
  <?php $row_planilla=mysql_fetch_assoc($mostrar_planilla);?>
  stm_ai("p0i1",[0,"<?php echo $row_planilla['idPlanilla']." - ".$row_planilla['Nombre']?>","","",-1,-1,0,"formulariolist.php?idPlanilla=<?php echo $row_planilla['idPlanilla'];?>&idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
  <?php $row_planilla=mysql_fetch_assoc($mostrar_planilla);?>
  stm_ai("p0i1",[0,"<?php echo $row_planilla['idPlanilla']." - ".$row_planilla['Nombre']?>","","",-1,-1,0,"formulariolist.php?idPlanilla=<?php echo $row_planilla['idPlanilla'];?>&idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
  <?php $row_planilla=mysql_fetch_assoc($mostrar_planilla);?>
  stm_ai("p0i1",[0,"<?php echo $row_planilla['idPlanilla']." - ".$row_planilla['Nombre']?>","","",-1,-1,0,"formulariolist.php?idPlanilla=<?php echo $row_planilla['idPlanilla'];?>&idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
  <?php $row_planilla=mysql_fetch_assoc($mostrar_planilla);?>
  stm_ai("p0i1",[0,"<?php echo $row_planilla['idPlanilla']." - ".$row_planilla['Nombre']?>","","",-1,-1,0,"formulariolist.php?idPlanilla=<?php echo $row_planilla['idPlanilla'];?>&idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
  <?php $row_planilla=mysql_fetch_assoc($mostrar_planilla);?>
  stm_ai("p0i1",[0,"<?php echo $row_planilla['idPlanilla']." - ".$row_planilla['Nombre']?>","","",-1,-1,0,"formulariolist.php?idPlanilla=<?php echo $row_planilla['idPlanilla'];?>&idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
  <?php $row_planilla=mysql_fetch_assoc($mostrar_planilla);?>
  stm_ai("p0i1",[0,"<?php echo $row_planilla['idPlanilla']." - ".$row_planilla['Nombre']?>","","",-1,-1,0,"formulariolist.php?idPlanilla=<?php echo $row_planilla['idPlanilla'];?>&idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
  <?php $row_planilla=mysql_fetch_assoc($mostrar_planilla);?>
  stm_ai("p0i1",[0,"<?php echo $row_planilla['idPlanilla']." - ".$row_planilla['Nombre']?>","","",-1,-1,0,"formulariolist.php?idPlanilla=<?php echo $row_planilla['idPlanilla'];?>&idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
  <?php $row_planilla=mysql_fetch_assoc($mostrar_planilla);?>
  stm_ai("p0i1",[0,"<?php echo $row_planilla['idPlanilla']." - ".$row_planilla['Nombre']?>","","",-1,-1,0,"formulariolist.php?idPlanilla=<?php echo $row_planilla['idPlanilla'];?>&idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
  <?php $row_planilla=mysql_fetch_assoc($mostrar_planilla);?>
  stm_ai("p0i1",[0,"<?php echo $row_planilla['idPlanilla']." - ".$row_planilla['Nombre']?>","","",-1,-1,0,"formulariolist.php?idPlanilla=<?php echo $row_planilla['idPlanilla'];?>&idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
  <?php $row_planilla=mysql_fetch_assoc($mostrar_planilla);?>
  stm_ai("p0i1",[0,"<?php echo $row_planilla['idPlanilla']." - ".$row_planilla['Nombre']?>","","",-1,-1,0,"formulariolist.php?idPlanilla=<?php echo $row_planilla['idPlanilla'];?>&idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
  <?php $row_planilla=mysql_fetch_assoc($mostrar_planilla);?>
  stm_ai("p0i1",[0,"<?php echo $row_planilla['idPlanilla']." - ".$row_planilla['Nombre']?>","","",-1,-1,0,"formulariolist.php?idPlanilla=<?php echo $row_planilla['idPlanilla'];?>&idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
  <?php $row_planilla=mysql_fetch_assoc($mostrar_planilla);?>
  stm_ai("p0i1",[0,"<?php echo $row_planilla['idPlanilla']." - ".$row_planilla['Nombre']?>","","",-1,-1,0,"formulariolist.php?idPlanilla=<?php echo $row_planilla['idPlanilla'];?>&idMer=<?php echo $_GET['idMer'];?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png",15,15,0,"","",0,0,0,0,1,"#f5cd8d",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","8pt Arial","8pt Arial",0,0]);
stm_ep();
//}
stm_em();

//-->
         </script></div>
  <?php } }
$RootMenu->Render();
?>