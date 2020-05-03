<?php
include 'includes/db.inc.php';
if ($_POST){
	$sql="SELECT add_friends FROM notifications_".$_POST['idFriend']."
			WHERE add_friends=:id";
	$result=$pdo->prepare($sql);
	$result->execute(['id'=>$_POST['myid']]);
	if ($result->fetchAll(PDO::FETCH_ASSOC)==[]){
		$sql="INSERT INTO notifications_".$_POST['idFriend']."(
				message,_unread,add_friends,dateOfSend) VALUES(
				'".$_POST['message']."',1,'".$_POST['myid']."',NOW())";
		$pdo->exec($sql);
	}
	else{
		$sql="UPDATE notifications_".$_POST['idFriend']."
				SET _read=0, _unread=1, cancel_add=0, dateOfSend=NOW()
				WHERE add_friends=:id";
		$result=$pdo->prepare($sql);
		$result->execute(['id'=>$_POST['myid']]);
	}
	if ($_POST['root']==="студент") $root="студенты";
	else $root="преподаватели";
	$message=explode(" ",$_POST['message']);
	$sql="INSERT INTO friends_".$_POST['myid']."(
			id_Friend,waiting,name,surname,".$root.") VALUES(
			".$_POST['idFriend'].",1,'".$message[0]."','".$message[1]."',1)";
	$pdo->exec($sql);
	echo json_encode(['answer'=>'success']);
}		
