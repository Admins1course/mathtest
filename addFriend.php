<?php
include 'includes/db.inc.php';
require_once 'includes/checkSession.inc.php';
if ($is_login){
	if ($_POST){
		try{
			if(preg_match("/[\D]/",$_POST['id_Friend'])){
				throw new Exception();
			}
			if(preg_match("/[^A-Za-zА-Яа-яЁё0-9_]/u",$_POST['message'])&&strpos($_POST['message'],'хочет добавить вас в друзья.')){
				throw new Exception();
			}
		}
		catch(Exception $e){
			echo json_encode(['answer'=>'errorDataFriend']);
			exit();
		}
		try{
			$pdo->beginTransaction();
			$sql="SELECT add_friends FROM notifications
					WHERE id_User=:idFriend AND add_friends=:id FOR UPDATE";
			$result=$pdo->prepare($sql);
			$result->execute(['idFriend'=>$_POST['idFriend'],
							  'id'=>$_SESSION['data-user']['id']]);
			if ($result->fetchAll(PDO::FETCH_ASSOC)===[]){
				$sql="INSERT INTO notifications(
						id_User,message,_unread,add_friends,cancel_add,dateOfSend) VALUES(
						:idFriend,:message,1,:myid,0,NOW())";
				$result=$pdo->prepare($sql)->execute(['idFriend'=>$_POST['idFriend'],
													  'message'=>$_POST['message'],
													  'myid'=>$_SESSION['data-user']['id']]);
			}
			else{
				$sql="UPDATE notifications
						SET _unread=1, cancel_add=0, dateOfSend=NOW()
						WHERE id_User=:idFriend AND add_friends=:id";
				$result=$pdo->prepare($sql)->execute(['idFriend'=>$_POST['idFriend'],
													  'id'=>$_SESSION['data-user']['id']]);
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
			echo json_encode(['answer'=>'serverError']);
		}
	}		
}
else echo json_encode(['answer'=>'errorDataUser']);