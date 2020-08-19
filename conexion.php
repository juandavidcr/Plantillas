<?php
include('connections/localhost.php');
header('Content-type: text/html; charset=iso-8859-1');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <link href="../../css/css.css" rel="stylesheet" type="text/css" />
        <script src="../../js/jquery.js"></script>
        <title></title>
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