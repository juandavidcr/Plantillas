<?php
/* PLANTILLA TABLA MAESTRO ESCLAVO
 * ESTA PLANTILLA SIRBE MOSTRAR TODOS LOS REGISTROS PADRE Y PODER VER LOS HIJOS DE ESTE LLAMANDO A UN IFRAME
 * ESTA PLANTILLA ESTA UBICADA EB C:\xampp\htdocs\Plantillas\tablaPadreHijo.php *
 * ESTE ARCHIVO NO FUNCIONA SOLO, REQUIERE DE SUS COMPONENETE PREVIOS QUE SON LOS SIGUIENTES *
 * 
 * js/jquery.js         LIBRERIA ORIGINAL DE JQUERY
 */
include('connections/localhost.php');
mysql_select_db($database_localhost,$localhost);
header('Content-type: text/html; charset=iso-8859-1');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <style>
        /*CABECERA DE LAS OPORTUNIDADS*/
        #TablaContenido th
        {
            padding: 0px 11px;
            border: 1px solid #95bce2;
            vertical-align: top;
        }
        #TablaContenido td {
            padding: 0px 11px;
            border: 1px solid #95bce2;
            vertical-align: top;

        }
        #TablaContenido tr.over td,#TablaContenido tr:hover td
        {
            background:#bcd4ec;
        }
        .verHijos{
            cursor: pointer;
        }
        </style>
        
        <script src="js/jquery.js"></script>
        <script>
            $(document).ready(function(){
                $(".verHijos").click(function(){
                    var id=$(this).attr("id");
                    if($("#tr-"+id).length==0){
                        $("#"+id).closest( "tr" ).after("<tr id='tr-"+id+"' ><td colspan='5'>\n\
                                            <iframe src='images/editar.png' height='200px;' width='100%;' frameborder='0'></iframe>\n\
                                            </td></tr>");
                    }
                    else{
                        $("#tr-"+id).remove();
                    }    
                });
            });            
        </script>
        <title></title>
    </head>
    <body>
        <?php
        $sqlSelect ="
        SELECT
        cds.id,cds.titel,cds.interpret,cds.jahr
        ";
        $sqlFrom = "
        FROM cds
        ";
        $sqlWhere = "
        WHERE
        cds.id > '0'
        ";
        $sqlGroup = "  ";
        //UNIMOS LAS PARETES DE LAS QUERYS
        $sqlQuery = $sqlSelect . $sqlFrom . $sqlWhere . $sqlGroup;
        $table = mysql_query($sqlQuery, $localhost) or die(mysql_error());
        if ($table) {

            ?>
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="TablaContenido">
            <thead>
            <tr>
                <?php
                for($i = 0; $i < mysql_num_fields($table); $i++) {
                    $field_info = mysql_fetch_field($table, $i);
                        echo "<th>{$field_info->name}</th>";
                }
                ?>
                <th>Ver Hijos</th>
            </tr>
            </thead>
            <tbody>
            <?php
            //SACAMOS LOS REGISTROS DE LA TABLA
            while ($row = mysql_fetch_assoc($table)) {
                ?>
            <tr id="<?php echo $row["id"]; ?>">
                <?php
                for($i = 0; $i < mysql_num_fields($table); $i++) {
                    $field_info = mysql_fetch_field($table, $i);
                    ?>
                    <td><?php    echo $row[$field_info->name]; ?></td>
                    <?php
                }
                ?>
                    <td> <img src="images/editar.png" class="verHijos" id="<?php echo $row["id"]; ?>" /></td>
            </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
            <?php
        }
        ?>
    </body>
</html>