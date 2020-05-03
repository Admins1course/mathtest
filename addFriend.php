<?php
include 'includes/db.inc.php';
if ($_POST){
	$sql="INSERT INTO notifications_".$_POST['idFriend']."(
			message,_unread,add_friends,dateOfSend) VALUES(
			'".$_POST['message']."',1,'".$_POST['myid']."',NOW())";
	$pdo->exec($sql);
	if ($_POST['root']==="студент") $root="студенты";
	else $root="преподаватели";
	$message=explode(" ",$_POST['message']);
	$sql="INSERT INTO friends_".$_POST['myid']."(
			id_Friend,waiting,name,surname,".$root.") VALUES(
			".$_POST['idFriend'].",1,'".$message[0]."','".$message[1]."',1)";
	$pdo->exec($sql);
	
}		
echo json_encode($message);