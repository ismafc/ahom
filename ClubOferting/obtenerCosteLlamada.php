<?php header('P3P: CP="CAO PSA OUR"'); session_start();

if (!isset($mainFolder))
   $mainFolder = "../";
include($mainFolder . "Lib/library.inc");
include($mainFolder . "Lib/facturas.inc");
include($mainFolder . "Lib/baseServicioClubOferting.inc");
include($mainFolder . "Lib/main.inc");
include("./Lib/ClubOfertingLlamada.inc");
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
unset ($operadorDestino);
if ($_GET["operadorDestino"] <= 3)
	$operadorDestino = obtenerNombreOperador ($_GET["operadorDestino"]);

if (!isset ($operadorDestino))
	devolverXMLError ("operadorDestino incorrecto");

// Comprobamos la fecha
if (strlen ($_GET["fecha"]) != 12)
	devolverXMLError ("fecha incorrecta");

if (!ereg("^[0-9]+$", $_GET["fecha"])) 
	devolverXMLError ("fecha incorrecta");

$dia = substr ($_GET["fecha"], 0, 2);
$mes = substr ($_GET["fecha"], 2, 2);
$año = substr ($_GET["fecha"], 4, 4);
$hora = substr ($_GET["fecha"], 8, 2);
$minuto = substr ($_GET["fecha"], 10, 2);

if ($hora > 59 || $hora < 0 || $minuto > 59 || $minuto < 0 || checkdate ($mes,$dia,$año) == FALSE)
	devolverXMLError ("fecha incorrecta");

$tipo = $_GET["tipo"];
if ($tipo != "VOZ" && $tipo != "SMS")
	devolverXMLError ("tipo incorrecto");

$duracion = $_GET["duracion"];
if ($tipo == "VOZ"){
	if (!ereg("^[0-9]+$", $_GET["fecha"]) || $duracion <= 0)
		devolverXMLError ("duracion incorrecta");
}else
	$duracion = 0;


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

$xml = crearXMLLlamada ($login, $operadorOrigen, $operadorDestino, $tipo, $dia, $mes, $año, $hora, $minuto, $duracion);
$n = procesarXMLLlamada ($idMiembro, $xml);
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
crearXMLResultadoLlamada ($idMiembro, $numero_movil_llamante);

if (esProvisional ($login, $password)){
    borrarUsuario ($login, $password);
    unset ($_SESSION['miembroClubOferting'], $_SESSION['passwordClubOferting']);
}
?>
