<?php
include 'includes/db.inc.php';
require_once 'includes/checkSession.inc.php';
if (checkSession()){
	if ($_POST){
		try{
			$pdo->beginTransaction();
			$sql="SELECT add_friends FROM notifications
					WHERE id_User=:idFriend AND add_friends=:id FOR UPDATE";
			$result=$pdo->prepare($sql);
			$result->execute(['idFriend'=>$_POST['idFriend'],
							  'id'=>$_POST['myid']]);
			if ($result->fetchAll(PDO::FETCH_ASSOC)===[]){
				$sql="INSERT INTO notifications(
						id_User,message,_unread,add_friends,cancel_add,dateOfSend) VALUES(
						:idFriend,:message,1,:myid,0,NOW())";
				$result=$pdo->prepare($sql)->execute(['idFriend'=>$_POST['idFriend'],
													  'message'=>$_POST['message'],
													  'myid'=>$_POST['myid']]);
			}
			else{
				$sql="UPDATE notifications
						SET _unread=1, cancel_add=0, dateOfSend=NOW()
						WHERE id_User=:idFriend AND add_friends=:id";
				$result=$pdo->prepare($sql)->execute(['idFriend'=>$_POST['idFriend'],
													  'id'=>$_POST['myid']]);
			}
			$sql="INSERT INTO friends(
					id_User,id_Friend,waiting) VALUES(
					:myid, :idFriend, 1)";
			$pdo->prepare($sql)->execute(['myid'=>$_POST['myid'],
										  'idFriend'=>$_POST['idFriend']]);
			$pdo->commit();
			echo json_encode(['answer'=>'success']);
			
			
		}
		catch(Exception $e){
			$pdo->rollBack();
			echo 
		}
	}		
}
else echo json_encode(['answer'=>'errorDataUser']);