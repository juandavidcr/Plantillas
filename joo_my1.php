$sqlQuery = " SELECT #__users.id FROM #__users WHERE #__users.id = '$user->id' ";
//echo $sqlQuery;
$db->setQuery($sqlQuery);
$row = $db->loadAssoc();
$id=$row["id"];