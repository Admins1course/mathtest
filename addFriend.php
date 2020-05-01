<?php
include 'includes/db.inc.php';
if ($_POST){
	$sql="INSERT INTO notifications_".$_POST['idFriend']."(
			message,_unread,add_friends,dateOfSend) VALUES(
			'".$_POST['message']."',1,'".$_POST['myid']."',NOW())";
	$pdo->exec($sql);
}		