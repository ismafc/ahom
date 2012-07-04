<?php header('P3P: CP="CAO PSA OUR"'); session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>Ejemplo</title>
        <?php
        if (isset($_GET['height']))
            $_SESSION["heightClubOferting"] = $_GET['height'];
        else
            $_SESSION["heightClubOferting"] = 500;
        $_SESSION["pageOneClubOferting"] = "ClubOfertingHabitos.php";
        //$_SESSION["pageOneClubOferting"] = "http://www.ahorramovil.com/ClubOferting/ClubOfertingHabitos.php";
        ?>
    </head>
    <body>
        <div align="center" style="width:100%">
            <table style="width:518px">
                <tr>
                    <td style="height:<?php echo ($_SESSION["heightClubOferting"] + 1); ?>px">
                        <!--<iframe height="100%" width="100%" src="http://www.ahorramovil.com/ClubOferting/ClubOfertingHabitosahorramovil.php" scrolling="auto" frameborder="0">No Frames</iframe>-->
                        <iframe height="100%" width="100%" src="ClubOfertingHabitosahorramovil.php" scrolling="auto" frameborder="0">No Frames</iframe>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>