<?php
if ($_POST){
	require_once 'includes/db.inc.php';
	session_start();

	$sql="SELECT login,name,surname,root FROM `users` WHERE id=:id";
	$result=$pdo->prepare($sql);
	$result->execute(['id'=>$_POST['id']]);
	$friend=$result->fetchAll(PDO::FETCH_ASSOC);
	
	$root=$friend[0]['root']="студент"?"студенты":"преподаватели";
	
	$sql="INSERT INTO friends_".$_SESSION['data-user']['id']."(
			id_Friend, login, name, surname, ".$root.") VALUES(
			:id_Friend,:login,:name,:surname,1)";
	$result=$pdo->prepare($sql);
	$result->execute(['id_Friend'=>$_POST['id'],
					  'login'=>$friend[0]['login'],
					  'name'=>$friend[0]['name'],
					  'surname'=>$friend[0]['surname']]);
	
	$sql="UPDATE friends_".$_POST['id']."
			SET waiting=0
			WHERE id_Friend=:id";
	$result=$pdo->prepare($sql);
	$result->execute(['id'=>$_SESSION['data-user']['id']]);
	
	echo json_encode(['answer'=>'success']);
}