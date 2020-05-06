<?php
if ($_POST){
	require_once 'includes/db.inc.php';
	session_start();
	try{
		
		$pdo->beginTransaction();
		
		$sql="SELECT login,name,surname,root FROM `users` WHERE id=:id FOR UPDATE";
		$result=$pdo->prepare($sql);
		$result->execute(['id'=>$_POST['id']]);
		$friend=$result->fetchAll(PDO::FETCH_ASSOC);
		
		$sql="SELECT login FROM `users` WHERE id=:id FOR UPDATE";
		$result=$pdo->prepare($sql);
		$result->execute(['id'=>$_SESSION['data-user']['id']]);
		$mylogin=$result->fetchAll(PDO::FETCH_ASSOC);
		
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
				SET waiting=0, login=:login
				WHERE id_Friend=:id";
		$result=$pdo->prepare($sql);
		$result->execute(['id'=>$_SESSION['data-user']['id'],
						  'login'=>$mylogin[0]['login']]);
		
		$sql="UPDATE notifications_".$_SESSION['data-user']['id']."
				SET _unread=0, _read=1
				WHERE add_friends=:id";
		$result=$pdo->prepare($sql);
		$result->execute(['id'=>$_SESSION['data-user']['id']]);
		
		$pdo->commit();
		
		echo json_encode(['answer'=>'success']);
	}
	catch(Exciption $e){
		$pdo->rollBack();
	}
}