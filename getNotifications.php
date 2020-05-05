<?php
	require_once 'includes/db.inc.php';
	session_start();
	$sql="SELECT message,add_friends FROM `notifications_".$_SESSION['data-user']['id']."`
			WHERE _unread=1 AND cancel_add=0";
	$result=$pdo->query($sql);
	echo json_encode($result->fetchAll(PDO::FETCH_ASSOC));