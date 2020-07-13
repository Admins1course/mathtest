<?php
require_once 'db.inc.php';
session_start();
if ($_POST){
	try{
		if(preg_match("/[\D]/",$_POST['id_Friend'])){
			throw new Exception();
		}
		if(preg_match("/[^A-Za-zА-Яа-яЁё0-9_]/u",$_POST['message'])&&!strpos($_POST['message'],'хочет добавить вас в друзья.')){
			throw new Exception();
		}
	}
	catch(Exception $e){
		echo json_encode(['answer'=>'errorDataFriend']);
		exit();
	}
	try{
		$idNotif=md5(uniqid($_SESSION['data-user']['id'],1));
		$pdo->beginTransaction();
		$sql="SELECT notifications.idNotif,add_friends FROM `notifications` JOIN `friendsNotif` ON notifications.idNotif=friendsNotif.idNotif
				WHERE id_User=:idFriend AND add_friends=:id FOR UPDATE";
		$result=$pdo->prepare($sql);
		$result->execute(['idFriend'=>$_POST['idFriend'],
						  'id'=>$_SESSION['data-user']['id']]);
		$result=$result->fetchAll(PDO::FETCH_ASSOC);
		if ($result===[]){
			$sql="INSERT INTO notifications(
					idNotif,id_User,message,unread,dateOfSend) VALUES(
					:idNotif,:idFriend,:message,1,NOW())";
			$pdo->prepare($sql)->execute(['idNotif'=>$idNotif,
										  'idFriend'=>$_POST['idFriend'],
										  'message'=>$_POST['message']]);
			$sql="INSERT INTO friendsNotif(
					idNotif,add_friends,cancel_add) VALUES(
					:idNotif,:myid,0)";
			$pdo->prepare($sql)->execute(['idNotif'=>$idNotif,
										  'myid'=>$_SESSION['data-user']['id']]);
		}
		else{
			$sql="UPDATE notifications
					SET unread=1, dateOfSend=NOW()
					WHERE idNotif=:idNotif";
			$pdo->prepare($sql)->execute(['idNotif'=>$result[0]['idNotif']]);
			$sql="UPDATE friendsNotif
					SET cancel_add=0
					WHERE idNotif=:idNotif";
			$pdo->prepare($sql)->execute(['idNotif'=>$result[0]['idNotif']]); 
		}
		$sql="INSERT INTO friends(
				id_User,id_Friend,waiting) VALUES(
				:myid, :idFriend, 1)";
		$pdo->prepare($sql)->execute(['myid'=>$_SESSION['data-user']['id'],
									  'idFriend'=>$_POST['idFriend']]);
		$pdo->commit();
		echo json_encode(['answer'=>'success']);
	}
	catch(Exception $e){
		$pdo->rollBack();
		echo json_encode(['answer'=>$e->getMessage()]);
	}
}		
