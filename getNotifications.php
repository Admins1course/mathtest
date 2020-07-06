<?php
	@session_start();
	require_once 'includes/db.inc.php';
	require_once 'includes/checkSession.inc.php';
	if ($is_login){
		try{
			$pdo->beginTransaction();
			$sql="SELECT message,add_friends,invitations,recipient FROM `notifications`
				WHERE id_User=:idUser AND _unread=1 AND cancel_add!=1";
			$result=$pdo->prepare($sql);
			$result->execute(['idUser'=>$_SESSION['data-user']['id']]);
			$json['notif']=$result->fetchAll(PDO::FETCH_ASSOC);
			$sql="SELECT id_Friend FROM friends WHERE id_User=:idUser AND waiting=0";
			$result=$pdo->prepare($sql);
			$result->execute(['idUser'=>$_SESSION['data-user']['id']]);
			$json['friends']=$result->fetchAll(PDO::FETCH_ASSOC);
			$pdo->commit();
			echo json_encode($json);
		}
		catch(Exception $e){
			$pdo->rollBack();
		}
	}
	else json_encode(['answer'=>'errorDataUser']);