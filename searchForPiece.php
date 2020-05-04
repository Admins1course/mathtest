<?php
include 'includes/db.inc.php';
if ($_POST){
	session_start();
	$sql="SELECT id, name, surname, root FROM `users` 
			WHERE name LIKE '".strtolower($_POST['searchValue'])."%' OR
				  surname LIKE '".strtolower($_POST['searchValue'])."%'";
	$result=$pdo->query($sql);
	$people=$result->fetchAll(PDO::FETCH_ASSOC);
	$sql="SELECT id_Friend, waiting FROM `friends_".$_SESSION['data-user']['id']."`";
	$result=$pdo->query($sql);
	$friends=$result->fetchAll(PDO::FETCH_ASSOC);
	$jsonResult['people']=$people;
	foreach ($friends as $k=>$v){
		$jsonResult['friends']['id'][]=$friends[$k]['id_Friend'];
		$jsonResult['friends']['waiting'][]=$friends[$k]['waiting'];
	} 
	echo json_encode($jsonResult);
}		