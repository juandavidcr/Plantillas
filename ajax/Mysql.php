<?php
session_start(); 
include('../connections/localhost.php');
$id = $_REQUEST['id'] ;
$value = $_REQUEST['value'] ;
$column = $_REQUEST['columnName'] ;
$STATEMENT=$_GET['STATEMENT'];
$TABLE=$_GET['TABLE'];
$IDNAME=$_GET['IDNAME'];
mysql_select_db($database_localhost, $localhost);
if($STATEMENT=="SELECT" || $STATEMENT=="select"){
    $sqlQuery=$STATEMENT." ".$column." FROM ".$TABLE."";
    $result = mysql_query($sqlQuery, $localhost) or die(mysql_error());
    if($result){
        while ($rowEmp = mysql_fetch_assoc($result)){
            $data[] = $rowEmp;
        }
        echo json_encode($data);
    }
    else echo "0".$sqlQuery.mysqli_error($conn);
}
if($STATEMENT=="UPDATE" || $STATEMENT=="update"){
    $sqlQuery=$STATEMENT." ".$TABLE." SET ".$column."='".$value."' WHERE ".$IDNAME."='".$id."';";
    $result = mysql_query($sqlQuery, $localhost) or die(mysql_error());
    if($result){
        echo $value;
    }
    else echo "0".$sqlQuery.mysqli_error($conn);    
}
if($STATEMENT=="INSERT" || $STATEMENT=="insert"){
    $ContColumn=0;
    foreach($_GET as $nombre_campo => $valor){
        $ESCOLUMNA=substr($nombre_campo,0,7);
        $COLUMNA=substr($nombre_campo,7,strlen($nombre_campo));
        if($ESCOLUMNA=="COLUMN_" ){
            if($ContColumn==0){
                $COLUMNS=" ".$COLUMNA." ";
                $VALUES=" '".$valor."' ";
            }else{
                $COLUMNS=$COLUMNS." ,".$COLUMNA." ";
                $VALUES=$VALUES." ,'".$valor."' ";                
            }
            
            $ContColumn++;
        }
    }
    $sqlQuery=$STATEMENT." INTO ".$TABLE." (".$COLUMNS.") VALUES(".$VALUES.");";
    $result = mysql_query($sqlQuery, $localhost) or die(mysql_error());
    if($result){
        echo mysql_insert_id();
    }
    else echo "0".$sqlQuery.mysqli_error($conn);    
}
if($STATEMENT=="DELETE" || $STATEMENT=="delete"){
    $sqlQuery=$STATEMENT." FROM ".$TABLE." WHERE ".$IDNAME."='".$id."';";
    $result = mysql_query($sqlQuery, $localhost) or die(mysql_error());
    if($result){
        //echo 0;
    }
    else echo "0".$sqlQuery.mysqli_error($conn);    
}

?>