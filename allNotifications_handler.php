<?php
try{
	session_start();
	$pdo->beginTransaction();
	$query="SELECT message, add_friends, invitations, dateOfSend 
			FROM notifications
			WHERE id_User=:idUser AND cancel_add=0 ORDER BY dateOfSend DESC";
	$result=$pdo->prepare($query);
	$result->execute(['idUser'=>$_SESSION['data-user']['id']]);
	$data['notif']=$result->fetchAll(PDO::FETCH_ASSOC);
	$sql="SELECT id_Friend FROM friends WHERE id_User=:idUser AND waiting=0";
	$result=$pdo->prepare($sql);
	$result->execute(['idUser'=>$_SESSION['data-user']['id']]);
	$data['friends']=$result->fetchAll(PDO::FETCH_ASSOC);
	$pdo->commit();
	for ($i=0;$i<count($data['friends']);$i++){
		$data['friends'][$i]=$data['friends'][$i]['id_Friend'];
	}
}
catch(PDOException $e){
	$pdo->rollBack();
}