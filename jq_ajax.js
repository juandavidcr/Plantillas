
var query="UPDATE bab_usu_perfil SET idIns='"+idIns+"' WHERE (id=<?php echo $_SESSION["id"]; ?>)";
//prompt("",query);
query = Base64.encode(query);
$.ajax({
    type: "POST",
    url: "P_Query.php",
    data: "sqlQuery=" + query,
    success: function(res) {
        alert(res);
    },
    error: function(xhr, ajaxOptions, thrownError) {
    }
});
//<script type="text/javascript" src="js/base64encode.js"></script>