<?php
if ($_POST){
	require_once 'includes/db.inc.php';
	session_start();
	$sql="DELETE FROM friends_".$_SESSION['data-user']['id']."
			WHERE id_Friend=:id";
	$result=$pdo->prepare($sql);
	$result->execute(['id'=>$_POST['id']]);
	$sql="UPDATE notifications_".$_POST['id']."
			SET _unread=0, _read=1, cancel_add=1, dateOfSend=NOW()
			WHERE add_friends=:id";
	$result=$pdo->prepare($sql);
	$result->execute(['id'=>$_SESSION['data-user']['id']]);
	echo json_encode($_POST);
}