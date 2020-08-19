$sqlQuery = "SELECT id,nombre FROM #__compraventa_users";
$db->setQuery($sqlQuery);
$res = $db->loadObjectList();
if ($res) {
    foreach ($res as $key => $value) {
        echo $value->iva;
    }
}
else{
    echo "vacio";
}
