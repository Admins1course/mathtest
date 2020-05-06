<?php
	require_once 'includes/db.inc.php';
	session_start();
	if ($_SESSION['data-user']){
		try{
			$pdo->beginTransaction();
			$sql="SELECT message,add_friends FROM `notifications_".$_SESSION['data-user']['id']."`
				WHERE _unread=1 AND cancel_add=0 FOR UPDATE";
			$result=$pdo->query($sql);
			$pdo->commit();
			echo json_encode($result->fetchAll(PDO::FETCH_ASSOC));
		}
		catch(Exception $e){
			$pdo->rollBack();
		}
	}