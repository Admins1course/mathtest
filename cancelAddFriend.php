<?php
if ($_POST){
	require_once 'includes/db.inc.php';
	session_start();
	try{
		$pdo->beginTransaction();
		$sql="DELETE FROM friends
				WHERE id_User=:idUser AND id_Friend=:id";
		$result=$pdo->prepare($sql);
		$result->execute(['idUser'=>$_SESSION['data-user']['id'],
						  'id'=>$_POST['id']]);
		$sql="UPDATE notifications
				SET _unread=0, cancel_add=1, dateOfSend=NOW()
				WHERE id_User=:idUser AND add_friends=:id";
		$result=$pdo->prepare($sql);
		$result->execute(['idUser'=>$_POST['id'],
						  'id'=>$_SESSION['data-user']['id']]);
		$pdo->commit();
		echo json_encode($_POST);
	}
	catch(Exception $e){
		$pdo->rollBack();
	}
}