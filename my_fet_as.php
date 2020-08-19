$sql = "select nombre,direccion from x";
$result = mysql_query($sql);
if (mysql_num_rows($result) == 0) {
  echo "No hay registros";
}
else{
  while ($row = mysql_fetch_assoc($result)) {
    echo $row["nombre"];
    echo $row["direccion"];
  }
}