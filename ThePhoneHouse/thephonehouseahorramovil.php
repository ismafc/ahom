<?php header('P3P: CP="CAO PSA OUR"'); session_start(); 
	include("./../Lib/library.inc");
	include("./../Lib/main.inc");
	include("./../Lib/facturas.inc");
	include("./../Lib/base.inc");
	if (openDatabase() == false)
		exit();
	unset($_SESSION['miembro'], $_SESSION['password']);
	session_regenerate_id();
	$_SESSION['miembro'] = session_id();
	$_SESSION['password'] = session_id();
	crearUsuarioProvisionalFrom($_SESSION['miembro'], $_SESSION['password'], "THEPHONEHOUSE");
?>
<html>
<head>
<title>Frame Ahorramovil</title>
<link rel="stylesheet" href="styles.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<body style="background-color:#FFFFFF">
<table id="maintableahorramovil" width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF">
	<tr>
    	<td style="background-color:#FFFFFF">
<iframe src="procesandoAhorramovil.php" id="fahorramovilmsg" name="fahorramovilmsg" width="609" height="0" scrolling="auto" frameborder="0" style="visibility:hidden">No soporta Frames
</iframe>
		</td>
    </tr>
	<tr>
    	<td style="background-color:#FFFFFF">
<iframe src="formularioAhorramovil.php" id="fahorramovil" name="fahorramovil" width="609" height="680" scrolling="auto" frameborder="0">No soporta Frames
</iframe>
		</td>
    </tr>    
</table>
</body>
</html>
