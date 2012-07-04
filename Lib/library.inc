<?php
function obtenerNumeroFacturas($idUsuario, $llamante) {
	$sql = "SELECT id FROM facturas WHERE idMiembro = '$idUsuario' AND numero_movil_llamante = '$llamante'";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	return mysql_num_rows($result);
}

function correo() {
	return "contacto@ahorramovil.com";
}

?>