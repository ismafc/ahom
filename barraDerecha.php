<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <META name="description" content="Esta página permite conocer cuanto se puede ahorrar en la factura de telefonía móvil. Informando del mejor operador, contrato y servicio de ahorro"> 
        <META name="keywords" content="ahorrar, ahorro, telefonía, móvil, factura, contrato, operador, movistar, vodafone, amena, consumo"> 
        <title>Ahorrar en la factura de telefonía móvil. Aplicación web para calcular el mejor operador, contrato y servicio de ahorro</title>
        <?php
            include("./Lib/main.inc");
            include("./Lib/base.inc");
            include("./Lib/library.inc");
            if (openDatabase() == false) {
                echo "Problemas de acceso a la base de datos<br>";
                exit();
            }
        ?>
        <link rel="stylesheet" href="barraDerecha.css" type="text/css" />
    </head>
    <body>
        <div id="barra_derecha">
            <table id="barra_derecha_tabla_secciones">
                <tr>
                    <td><img src="imagenesmastreces/navegaciond/bola.gif" /></td>
                    <td><a href="faqs.php" target="_parent">Preguntas frecuentes</a></td>
                </tr>
                <tr>
                    <td><img src="imagenesmastreces/navegaciond/bola.gif" /></td>
                    <td><a href="queOfrecemos.php" target="_parent">Servicios</a> </td>
                </tr>
                <tr>
                    <td><img src="imagenesmastreces/navegaciond/bola.gif" /></td>
                    <td><a href="informeReal.html" target="_blank">Ejemplo de informe real</a></td>
                </tr>
                <tr>
                    <td><img src="imagenesmastreces/navegaciond/bola.gif" /></td>
                    <td><a href="comoEnviarFactura.php" target="_parent">Cómo enviar una factura</a></td>
                </tr>
                <tr>
                    <td><img src="imagenesmastreces/navegaciond/bola.gif" /></td>
                    <td><a href="noticias.php" target="_parent">Noticias</a></td>
                </tr>
            </table>
            <div id="vertical_div"></div>
            <table id="barra_derecha_tabla_estadisticas">
                <tr>
                    <td colspan="4">
                        <img src="imagenesmastreces/navegaciond/tabla1a.gif" />
                    </td>
                </tr>
                <tr>
                    <td class="td_left_est"></td>
                    <td class="td_izquierda_est">&nbsp;Usuarios registrados:</td>
                    <td class="td_derecha_est"><strong><?php echo obtenerNumeroDeClientes(); ?></strong></td>
                    <td class="td_right_est"></td>
                </tr>
                <tr>
                    <td class="td_left_est"></td>
                    <td class="td_izquierda_est">&nbsp;Número de facturas:</td>
                    <td class="td_derecha_est"><strong><?php echo obtenerNumeroDeFacturasEstadisticas(); ?></strong></td>
                    <td class="td_right_est"></td>
                </tr>
                <tr>
                    <td class="td_left_est"></td>
                    <td class="td_izquierda_est">&nbsp;Ahorro medio:</td>
                    <td class="td_derecha_est"><strong><?php echo obtenerAhorroMedioEnPorcentaje(); ?> %</strong></td>
                    <td class="td_right_est"></td>
                </tr>
                <tr>
                    <td class="td_left_est"></td>
                    <td class="td_izquierda_est">&nbsp;Ahorro total:</td>
                    <td class="td_derecha_est"><strong><?php echo obtenerAhorroTotal(); ?> €</strong></td>
                    <td class="td_right_est"></td>
                </tr>
                <tr>
                    <td class="td_left_est"></td>
                    <td class="td_izquierda_est">&nbsp;Ahorro anual estimado:</td>
                    <td class="td_derecha_est"><strong><?php echo obtenerAhorroAnualEstimado(); ?> €</strong></td>
                    <td class="td_right_est"></td>
                </tr>
                <tr style="height:30px">
                    <td class="td_left_est"></td>
                    <td class="td_last_est" colspan="2"><a href="masEstadisticas.php" target="_parent">Más estadísticas...</a>&nbsp;</td>
                    <td class="td_right_est"></td>
                </tr>
                <tr>
                    <td colspan="4"><img src="imagenesmastreces/navegaciond/tabla1b.gif" /></td>
                </tr>
            </table>
            <div id="vertical_div"></div>
            <table id="barra_derecha_tabla_operadores">
                <tr>
                    <td colspan="3"><img src="imagenesmastreces/navegaciond/tabla2a.gif" /></td>
                </tr>
                <tr>
                    <td class="td_left_est"></td>
                    <td class="td_center_ope"><a href="http://www.movistar.es" target="_blank">Movistar</a></td>
                    <td class="td_right_est"></td>
                </tr>
                <tr>
                    <td class="td_left_est"></td>
                    <td class="td_center_ope"><a href="http://www.vodafone.es" target="_blank">Vodafone</a></td>
                    <td class="td_right_est"></td>
                </tr>
                <tr>
                    <td class="td_left_est"></td>
                    <td class="td_center_ope"><a href="http://www.orange.es" target="_blank">Orange</a></td>
                    <td class="td_right_est"></td>
                </tr>
                <tr>
                    <td class="td_left_est"></td>
                    <td class="td_center_ope"><a href="http://www.yoigo.es" target="_blank">Yoigo</a></td>
                    <td class="td_right_est"></td>
                </tr>
                <tr>
                    <td class="td_left_est"></td>
                    <td class="td_center_ope"><a href="http://www.carrefour.es/movil" target="_blank">Carrefour</a></td>
                    <td class="td_right_est"></td>
                </tr>
                <tr>
                    <td class="td_left_est"></td>
                    <td class="td_center_ope"><a href="http://www.happymovil.es" target="_blank">Happy Movil</a></td>
                    <td class="td_right_est"></td>
                </tr>
                <tr>
                    <td class="td_left_est"></td>
                    <td class="td_center_ope"><a href="http://www.eroskimovil.es" target="_blank">Eroski Movil</a></td>
                    <td class="td_right_est"></td>
                </tr>
                <tr>
                    <td class="td_left_est"></td>
                    <td class="td_center_ope"><a href="http://www.simyo.es" target="_blank">Simyo</a></td>
                    <td class="td_right_est"></td>
                </tr>
                <tr>
                    <td class="td_left_est"></td>
                    <td class="td_center_ope"><a href="http://www.masmovil.es" target="_blank">M&aacute;smovil</a></td>
                    <td class="td_right_est"></td>
                </tr>
                <tr>
                    <td class="td_left_est"></td>
                    <td class="td_center_ope"><a href="http://www.pepephone.com" target="_blank">Pepephone</a></td>
                    <td class="td_right_est"></td>
                </tr>
                <tr>
                    <td colspan="3"><img src="imagenesmastreces/navegaciond/tabla1b.gif" /></td>
                </tr>
            </table>
	</div>
    </body>
</html>