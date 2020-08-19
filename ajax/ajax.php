<?php
session_start(); 
include('../connections/localhost.php');
//LLAMAR EL JSON SERIALIZAR
$sqlQuery=base64_decode(str_replace("\\","",$_POST['sqlQuery']));
mysql_select_db($database_localhost, $localhost);
$result = mysql_query($sqlQuery, $localhost) or die(mysql_error());
if($result)
{
  while ($rowEmp = mysql_fetch_assoc($result)) 
  {
    $data[] = $rowEmp;
  }
  echo json_encode($data);
}
else echo "0".$sqlQuery.mysqli_error($conn);
?>
