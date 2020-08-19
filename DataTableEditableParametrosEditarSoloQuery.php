<?php
/* PLANTILLA DATTATBLE DITABLE CON PARAMETROS DONDE SOLO SE TIENE QUE EDITAR EL QUERY Y LA CONEXION ("include('connections/")
 * ESTA PLANTILLA CUNETA CON PARAMETROS COMO DATEPICKER DE JQUERY, BOTONES GUARDAR Y <SELECT><OPTION>
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
        <script src="js/jquery.jeditable.datepicker.js" type="text/javascript"></script>
        <script>
            $(document).ready(function() {
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

                    , "aoColumns": [
                        {
                            type: 'text',
                            submit: 'Guardar'
                        },
                        {
                            type: 'datepicker',
                            submit: 'Guardar'
                        },
                        /*
                         {
                         type: 'select',
                         submit: 'submit',
                         //data: "{'':'Please select...', '1':'Si','0':'No'}"
                         data: "{'accounts':'accounts','dashAuditor':'dashAuditor'}"
                         },
                         */
                        {
                            //indicator: 'Saving Engine Version...',
                            tooltip: 'Click to select engine version',
                            loadtext: 'loading...',
                            type: 'select',
                            onblur: 'cancel',
                            submit: 'Ok',
                            loadurl: 'listData/EngineVersionList.php',
                            loadtype: 'GET',
                            cssclass: "aaa"
                        }
                    ]
                });
                $("#interpret").datepicker();
                //LLAMAMSO A LOS INPUTS QUE ESTAN EN EL PIE DE LA TABLA
                
                $(".buscar").keyup(function() {
                    var numero = $(this).attr("numero");
                    oTable.fnFilter(this.value, numero);
                });
                
                /*
                 $("tfoot input").keyup( function () {
                 oTable.fnFilter( this.value, $("tfoot input").index(this) );
                 });
                 */
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
        mysql_select_db($database_localhost, $localhost);
        $sqlSelect = "
        SELECT
        id,titel,interpret,jahr
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
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                    
                    <tr>
                        <th><input class="buscar" numero="0" type="text" placeholder="Buscar por title"></th>
                        <th><input class="buscar" numero="1" type="text" placeholder="Buscar por interpret"></th>
                        <th><input class="buscar" numero="2" type="text" placeholder="Buscar por jhar"></th>
                    </tr>
                    
                    <tr>
                        <?php
                        for ($i = 0; $i < mysql_num_fields($table); $i++) {
                            $field_info = mysql_fetch_field($table, $i);
                            if ($field_info->name != "id") {
                                ?>
                                <th><?php echo $field_info->name; ?></th>
                                <?php
                            }
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //SACAMOS LOS REGISTROS DE LA TABLA
                    while ($row = mysql_fetch_assoc($table)) {
                        ?>
                        <tr id="<?php echo $row["id"]; ?>">
                            <?php
                            for ($i = 0; $i < mysql_num_fields($table); $i++) {
                                $field_info = mysql_fetch_field($table, $i);
                                if ($field_info->name != "id") {
                                    ?>
                                    <td><?php echo $row[$field_info->name]; ?></td>
                                    <?php
                                }
                            }
                            ?>
                        </tr>
                        <?php
                    }
                    ?>                
                </tbody>
            </table>
            <!--        CADA TEXT Y LABEL DEBE DE ESTAR VINCULADO CON CADA COLUMNA DE LA BASE DE DATOS
                    LOS rel="0" DEBEN DE TENER UN ORDEN CONSECUTIVO-->
            <form id="formAddNewRow" action="#" title="Agregar registro">
                <?php
                $contColum = 0;
                for ($i = 0; $i < mysql_num_fields($table); $i++) {
                    $field_info = mysql_fetch_field($table, $i);
                    if ($field_info->name != "id") {
                        ?>
                        <label for="<?php echo $field_info->name; ?>"><?php echo $field_info->name; ?></label><br />
                        <input type="text" name="COLUMN_<?php echo $field_info->name; ?>" 
                               id="<?php echo $field_info->name; ?>" class="required" rel="<?php echo $contColum; ?>" />
                        <br />            
                        <?php
                        $contColum++;
                    }
                }
                ?>
            </form>
            <?php
        }
        ?>
    </body>
</html>