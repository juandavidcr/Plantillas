<?php
/*PLANTILLA DATTATBLE DITABLE
 * ESTA PLANTILLA ESTA UBICADA EB C:\xampp\htdocs\Plantillas\DataTableEditable.php *
 * ESTE ARCHIVO NO FUNCIONA SOLO, REQUIERE DE SUS COMPONENETE PREVIOS QUE SON LOS SIGUIENTES *
 * 
 * css/demo_table.css   LE DAFORMA A LA TABLA
 * css/jquery-ui.css    TRABAJA EN CONJUNTO CON JQUERY UI PARA DARLE CIERTO COLOR A LOS COMPONENETE RESULTANTES DE JEQUERY UI
 * 
 * js/jquery.js         LIBRERIA ORIGINAL DE JQUERY
 * js/jquery.dataTables.min.js  LE DA FORMATO Y FUNCIONES A LA TABLA
 * js/jquery-ui-1.8.18.custom.min.js    PROVEE CALENDARIOS,SCROLLBAR Y OTROS COMPONENETES
 * js/jquery.validate.js        VALIDA VALORES INGRESADOS
 * js/jquery.jeditable.js       HACE QUE SE PUEDA EDITAR DESDE JS
 * js/jquery.dataTables.editable.js     HACE QUE SE PUEDA EDITAR DESDE JS EN AYUDA CON jquery.jeditable.js
 */
include('connections/localhost.php');
mysql_select_db($database_localhost, $localhost);
header('Content-type: text/html; charset=iso-8859-1');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <link href="css/demo_table.css" rel="stylesheet"  type="text/css"/>
        <link href="css/jquery-ui.css" rel="stylesheet"  type="text/css"/>

        <script src="js/jquery.js"></script>
        <script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="js/jquery-ui-1.8.18.custom.min.js" type="text/javascript"></script>
        <script src="js/jquery.validate.js" type="text/javascript"></script>
        <script src="js/jquery.jeditable.js" type="text/javascript"></script>
        <script src="js/jquery.dataTables.editable.js" type="text/javascript"></script>
        <script>
            $(document).ready(function(){
                //DAMOS FORMATO A LA TABLA example Y LA CONVERTIMOS EN PARAMETRO EN oTable
                var oTable = $('#example').dataTable({
                    bJQueryUI: true
                }).makeEditable({
                    /*
                     *LA CONEXION A LA BD SE ENCUENTRA EN  connections/localhost.php
                     *ajax/Mysql.php  UBICACION DL ARCHVO QUE RESIBIRA LOS PARAMETROS A EDITAR EN LA BD
                     *STATEMENT=UPDATE (o DELETE o INSERT)  ES EL TIPO DE QUERY PUEDE SER UPDTE,INSERT, O DELETE (SELECT NOOOO) 
                     *TABLE     ES EL NOMBRE DE LA TABLA
                     *IDNAME    ES EL ID QUE SE VA A ACTUALIZAR O BORRAR (INSERT OVBIO NO LLEVA IDNAME)
                    */
                    sUpdateURL: "ajax/Mysql.php?STATEMENT=UPDATE&TABLE=cds&IDNAME=id",
                    sDeleteURL: "ajax/Mysql.php?STATEMENT=DELETE&TABLE=cds&IDNAME=id",
                    sAddURL: "ajax/Mysql.php?STATEMENT=INSERT&TABLE=cds",
                    sDeleteHttpMethod: "GET",
                    sAddHttpMethod: "GET"               
                });
                //LLAMAMSO A LOS INPUTS QUE ESTAN EN EL PIE DE LA TABLA
                $("tfoot input").keyup( function () {
                    oTable.fnFilter( this.value, $("tfoot input").index(this) );
                } );
                
            });            
        </script>
        <title></title>
    </head>
    <body>
        <!-- BOTONES AGREGAR Y BORRAR  -->
        <button id="btnAddNewRow" class="add_row ui-button-text">Add</button>
        <button id="btnDeleteRow">Delete</button>
        <?php
        //LLENAMOS LA BASE DE DATOS
        
        $sqlSelect ="
        SELECT cds.id,cds.titel,cds.interpret,cds.jahr
        ";
        $sqlFrom = "
        FROM cds
        ";
        $sqlWhere = "
        WHERE cds.id > '0'
        ";
        $sqlGroup = "  ";
        //UNIMOS LAS PARETES DE LAS QUERYS
        $sqlQuery = $sqlSelect . $sqlFrom . $sqlWhere . $sqlGroup;
        $table = mysql_query($sqlQuery, $localhost) or die(mysql_error());
        if ($table) {
            ?>
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
            <tr>
                <th>titel</th><th>interpret</th><th>jahr</th>
            </tr>
            </thead>
            <tbody>
            <?php
            //SACAMOS LOS REGISTROS DE LA TABLA
            while ($row = mysql_fetch_assoc($table)) {
                ?>
            <tr id="<?php echo $row["id"]; ?>">
                <td><?php echo $row["titel"]; ?></td>
                <td><?php echo $row["interpret"]; ?></td>
                <td><?php echo $row["jahr"]; ?></td>
            </tr>                
                <?php
            }
            ?>
            </tbody>
            <tfoot>
		<tr>
                    <th><input type="text"></th>
                    <th><input type="text"></th>
                    <th><input type="text"></th>
                </tr>
            </tfoot>                        
        </table>
<!--        CADA TEXT Y LABEL DEBE DE ESTAR VINCULADO CON CADA COLUMNA DE LA BASE DE DATOS
        LOS rel="0" DEBEN DE TENER UN ORDEN CONSECUTIVO-->
        <form id="formAddNewRow" action="#" title="Add new record">        
                <label for="titel">titel</label><br />
                <input type="text" name="COLUMN_titel" id="titel" class="required" rel="0" />
                <br />
                <label for="interpret">interpret</label><br />
                <input type="text" name="COLUMN_interpret" id="interpret" rel="1" />
                <br />
                <label for="jahr">jahr</label><br />
                <input type="text" name="COLUMN_jahr" id="jahr" rel="2" />
                <br />
        </form>
            <?php
        }
        ?>
    </body>
</html>