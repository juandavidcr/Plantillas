<?php
$hostname_localhost = "localhost";
$database_localhost = "cdcol";
$username_localhost = "ejemplo";
$password_localhost = "123456";
$localhost = mysql_connect($hostname_localhost, $username_localhost, $password_localhost) or trigger_error(mysql_error(),E_USER_ERROR); 
header('Content-type: text/html; charset=iso-8859-1');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>Ejemplo de debug</title>
    </head>
    <body>
        <?php
        //LLENAMOS LA BASE DE DATOS
        mysql_select_db($database_localhost, $localhost);
        $sqlSelect ="SELECT md5('hola') as dato";
        $sqlFrom = "  ";
        $sqlWhere = "  ";
        $sqlGroup = "  ";
        //UNIMOS LAS PARETES DE LAS QUERYS
        $sqlQuery = $sqlSelect . $sqlFrom . $sqlWhere . $sqlGroup;
        $table = mysql_query($sqlQuery, $localhost) or die(mysql_error());
        if ($table) {
            //SACAMOS LOS REGISTROS DE LA TABLA
            while ($row = mysql_fetch_assoc($table)) {
                echo $row["dato"];
            }            
        }
        ?>
    </body>
</html>