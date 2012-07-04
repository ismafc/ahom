<?php header('P3P: CP="CAO PSA OUR"'); session_start(); 
if (!isset($_SESSION["heightClubOferting"]))
	$_SESSION["heightClubOferting"] = 600;
if (!isset($_SESSION["pageOneClubOferting"]))
	$_SESSION["pageOneClubOferting"] = "ClubOfertingHabitos.php";
if (!isset($mainFolder))
	$mainFolder = "../";
include($mainFolder . "Lib/library.inc");
include($mainFolder . "Lib/facturas.inc");
include($mainFolder . "Lib/baseServicioClubOferting.inc");
include($mainFolder . "Lib/main.inc");
include("./Lib/ClubOfertingHabitos.inc");
include("./Lib/ClubOfertingAPI.inc");
if (openDatabase() == false)
	exit();

// Comprobamos el operador de origen
unset ($operadorOrigen);
if ($_GET["operadorOrigen"] < 90)
	$operadorOrigen = obtenerNombreOperador ($_GET["operadorOrigen"]);

if (!isset($operadorOrigen))
	devolverXMLError ("operadorOrigen incorrecto");

// Comprobamos el operador de destino
$operadorDestino = "";
switch ($_GET["operadorDestino"]){
	case 0: $operadorDestino = "INDIFERENTE"; break;
	case 1: $operadorDestino = "SOLO_MOVISTAR"; break;
	case 2: $operadorDestino = "SOLO_ORANGE"; break;
	case 3: $operadorDestino = "SOLO_VODAFONE"; break;
	case 101: $operadorDestino = "MOVISTAR"; break;
	case 102: $operadorDestino = "ORANGE"; break;
	case 103: $operadorDestino = "VODAFONE"; break;
	default: devolverXMLError ("operadorDestino incorrecto"); break;
}

// Número de segundos de voz
$segundos_voz = $_GET["minutos"] * 60;

// Número mensajes SMS
$mensajes_SMS = $_GET["sms"];

if ($segundos_voz == 0 && $mensajes_SMS == 0)
	devolverXMLError ("minutos y sms incorrectos");

// Comprobamos la franja
$franja = "";
switch ($_GET["franja"]){
	case 0: $franja = "INDIFERENTE"; break;
	case 1: $franja = "SOLO_MANANAS"; break;
	case 2: $franja = "SOLO_TARDES"; break;
	case 101: $franja = "MANANAS"; break;
	case 102: $franja = "TARDES"; break;
	default: devolverXMLError ("franja incorrecta"); break;
}

// comprobamos el dia
$dia = "";
switch ($_GET["dia"]){
	case 0: $dia = "INDIFERENTE"; break;
	case 1: $dia = "SOLO_LABORAL"; break;
	case 2: $dia = "SOLO_FESTIVOS"; break;
	case 101: $dia = "LABORAL"; break;
	case 102: $dia = "FESTIVOS"; break;
	default: devolverXMLError ("dia incorrecto"); break;
}

// 	Provisionalmente
if (!isset($_SESSION['miembroClubOferting'], $_SESSION['passwordClubOferting'])) {
	$_SESSION['miembroClubOferting'] = session_id();
	$_SESSION['passwordClubOferting'] = session_id();
	crearUsuarioProvisionalFrom($_SESSION['miembroClubOferting'], $_SESSION['passwordClubOferting'], "ClubOferting");
}

$login = $_SESSION['miembroClubOferting'];
$password = $_SESSION['passwordClubOferting'];
$sql = "SELECT id FROM miembros WHERE Login = '$login' AND Password = '$password'";
$result = mysql_query($sql);
if ($result == 0) {
	if (esProvisional ($login, $password)){
		borrarUsuario ($login, $password);
		unset ($_SESSION['miembroClubOferting'], $_SESSION['passwordClubOferting']);
	}
	devolverXMLError ("Error en base de datos");
}
$row_array = mysql_fetch_row($result);
$idMiembro = $row_array[0];

$xml = crearXMLHabitos ($login, $operadorOrigen, $operadorDestino, $franja, $dia, $segundos_voz, $mensajes_SMS);
$n = procesarXMLHabitos ($idMiembro, $xml);
if ($n == "ALREADY_EXISTS") {
	$error = true;
	if (esProvisional ($login, $password)){
		borrarUsuario ($login, $password);
		unset ($_SESSION['miembroClubOferting'], $_SESSION['passwordClubOferting']);
	}
	devolverXMLError ("No ha sido posible realizar los calculos");
}
else if ($n[0] == '!') {
	insertarErrorProcesoFactura($idMiembro, $destination, $n);
	$error = true;
	if (esProvisional ($login, $password)){
		borrarUsuario ($login, $password);
		unset ($_SESSION['miembroClubOferting'], $_SESSION['passwordClubOferting']);
	}
	devolverXMLError ("No ha sido posible realizar los calculos");
}

$numero_movil_llamante = $n;
crearXMLResultadoHabitos ($idMiembro, $numero_movil_llamante);

if (esProvisional ($login, $password)){
    borrarUsuario ($login, $password);
    unset ($_SESSION['miembroClubOferting'], $_SESSION['passwordClubOferting']);
}
?>