<?php
include 'includes/db.inc.php';

$sql="SELECT id, name, surname, root FROM `users` 
		WHERE name LIKE '".strtolower($_POST['searchValue'])."%' OR
			  surname LIKE '".strtolower($_POST['searchValue'])."%'";
		//".strtolower($_POST['searchValue'])."
$result=$pdo->query($sql);
$jsonResult=json_encode($result->fetchAll(PDO::FETCH_ASSOC));
echo $jsonResult;		