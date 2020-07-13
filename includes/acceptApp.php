<?php
if ($_POST){
	session_start();
	require_once 'db.inc.php';
	try{
		if (preg_match("/\D/",$_POST['id'])){
			echo json_encode(['answer'=>'errorDataFriend']);
			exit();
		}
		if (preg_match("/[^a-f0-9]/",$_POST['idNotif'])){
			echo json_encode(['answer'=>'errorDataFriend']);
			exit();
		}
		$sql="SELECT idNotif FROM friendsNotif WHERE idNotif=:idNotif AND add_friends=:idFriend";
		$result=$pdo->prepare($sql);
		$result->execute(['idNotif'=>$_POST['idNotif'],
						  'idFriend'=>$_POST['id']]);
		if ($result->fetchAll(PDO::FETCH_ASSOC)!==[]){
			$pdo->beginTransaction();
			
			$sql="INSERT INTO `friends` VALUES(
					:idUser,:id_Friend,0)";
			$pdo->prepare($sql)->execute(['idUser'=>$_SESSION['data-user']['id'],
										  'id_Friend'=>$_POST['id']]);
		
			$sql="UPDATE friends
					SET waiting=0
					WHERE id_User=:idUser AND id_Friend=:id";
			$pdo->prepare($sql)->execute(['id'=>$_SESSION['data-user']['id'],
										  'idUser'=>$_POST['id']]);
		
			$sql="UPDATE notifications
					SET unread=0
					WHERE idNotif=:idNotif";
			$pdo->prepare($sql)->execute(['idNotif'=>$_POST['idNotif']]);
			$pdo->commit();
			echo json_encode(['answer'=>'success']);
		}
		else{
			echo json_encode(['answer'=>'errorDataFriend']);
			exit();
		}
	}
	catch(Exception $e){
		$pdo->rollBack();
		echo json_encode(['answer'=>$e->getMessage()]);
	}
}