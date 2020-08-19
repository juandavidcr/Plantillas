<?php
/*PLANTILLA CARGA SELECT CON JSON
 * ESTE ARCHIVO NO FUNCIONA SOLO, REQUIERE DE SUS COMPONENETE PREVIOS QUE SON LOS SIGUIENTES *
 *
 * js/jquery.js         LIBRERIA ORIGINAL DE JQUERY
 * connections/localhost.php
 */
include('connections/localhost.php');
header('Content-type: text/html; charset=iso-8859-1');
?>
<!DOCTYPE html>
<html>
    <head>
        <script src="js/jquery.js"></script>
        <script>
            $(document).ready(function(){
                cargaSelect("<?php echo base64_encode(" SELECT cds.id,cds.titel,cds.interpret,cds.jahr FROM cds WHERE cds.id > '0'; "); ?>","#selectCarga");
                
            });
            function cargaSelect(query,idTag){
                $.ajax({
                    url:"ajax/ajax.php",
                    type:"POST",
                    dataType: 'json',
                    data:"sqlQuery="+query,
                    success:function(data){
                        $.each(data,function(index,value) {
                            $(idTag).append("<option id='"+data[index].id+"'>"+data[index].titel+"</option>")
                        });
                    }
                });
            }
            
        </script>
        <title></title>
    </head>
    <body>
        <select id="selectCarga">
        </select>
    </body>
</html>