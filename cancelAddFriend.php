<?php
if ($_POST){
	session_start();
	require_once 'includes/db.inc.php';
	require_once 'includes/checkSession.inc.php';
	if($is_login){
		try{
			try{
				if(preg_match('/[\D]/',$_POST['id'])){
					throw new Exception();
				}
			}
			catch(Exception $e){
				echo json_encode(['answer'=>'errorDataFriend']);
				exit();
			}
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
			echo json_encode(['answer'=>'success']);
		}
		catch(Exception $e){
			$pdo->rollBack();
			echo json_encode(['answer'=>'serverError']);
			exit();
		}
	}
	else{
		echo json_encode(['answer'=>'errorDataUser']);
	}
}