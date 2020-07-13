<?php
	@session_start();
	require_once 'db.inc.php';
	try{
		$pdo->beginTransaction();
		$sql="SELECT notifications.idNotif, message,add_friends FROM `notifications`
				JOIN `friendsNotif` ON notifications.idNotif=friendsNotif.idNotif
				WHERE id_User=:idUser AND unread=1 AND cancel_add!=1";
		$add_friends=$pdo->prepare($sql);
		$add_friends->execute(['idUser'=>$_SESSION['data-user']['id']]);
		$json['notif']['add_friends']=$add_friends->fetchAll(PDO::FETCH_ASSOC);
		$sql="SELECT notifications.idNotif, message,invitations,recipient FROM `notifications`
				JOIN `inviteNotif` ON notifications.idNotif=inviteNotif.idNotif
				WHERE id_User=:idUser AND unread=1";
		$invitations=$pdo->prepare($sql);
		$invitations->execute(['idUser'=>$_SESSION['data-user']['id']]);
		$json['notif']['invitations']=$invitations->fetchAll(PDO::FETCH_ASSOC);
		$sql="SELECT id_Friend FROM friends WHERE id_User=:idUser AND waiting=0";
		$result=$pdo->prepare($sql);
		$result->execute(['idUser'=>$_SESSION['data-user']['id']]);
		$json['friends']=$result->fetchAll(PDO::FETCH_ASSOC);
		$pdo->commit();
		foreach($json as $k=>$v){
			for ($i=0;$i<count($json[$k]);$i++){
				foreach($json[$k][$i] as $k1=>$v1){
					$json[$k][$i][$k1]=htmlspecialchars($json[$k][$i][$k1]);
				}
			}
		}
		echo json_encode($json);
	}
	catch(Exception $e){
		$pdo->rollBack();
	}