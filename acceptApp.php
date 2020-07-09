<?php
if ($_POST){
	session_start();
	require_once 'includes/db.inc.php';
	require_once 'includes/checkSession.inc.php';
	if ($is_login){
		try{
			if (preg_match("/\D/",$_POST['id'])){
				echo json_encode(['answer'=>'errorDataFriend']);
			}
			else{
				$pdo->beginTransaction();
			
				$sql="INSERT INTO friends VALUES(
						:idUser,:id_Friend,0)";
				$pdo->prepare($sql)->execute(['idUser'=>$_SESSION['data-user']['id'],
											'id_Friend'=>$_POST['id']]);
			
				$sql="UPDATE friends
						SET waiting=0
						WHERE id_User=:idUser AND id_Friend=:id";
				$pdo->prepare($sql)->execute(['id'=>$_SESSION['data-user']['id'],
											'idUser'=>$_POST['id']]);
			
				$sql="UPDATE notifications
						SET _unread=0
						WHERE id_User=:idUser AND add_friends=:id";
				$pdo->prepare($sql)->execute(['id'=>$_POST['id'],
											  'idUser'=>$_SESSION['data-user']['id']]);
				$pdo->commit();
				echo json_encode(['answer'=>'success']);
			}
		}
		catch(Exception $e){
			$pdo->rollBack();
			echo json_encode(['answer'=>'serverError']);
		}
	}
	else echo json_encode(['answer'=>'errorDataUser']);
}