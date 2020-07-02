<?php
if ($_POST){
	require_once 'includes/db.inc.php';
	session_start();
	try{
		$pdo->beginTransaction();
		foreach ($_POST as $k=>$v){
			if($_POST[$k]['add_friends']){
				$sql="UPDATE notifications
						SET _unread=0
						WHERE id_User=:idUser AND message=:message AND add_friends=:add_friends";
			}
			else{
				$sql="UPDATE notifications
						SET _unread=0
						WHERE id_User=:idUser AND message=:message AND invitations=:invitations";
			}
			$result=$pdo->prepare($sql);
			$result->execute(['idUser'=>$_SESSION['data-user']['id'],
							  'message'=>$_POST[$k]['message'],
							  'add_friends'=>$_POST[$k]['add_friends'],
							  'invitations'=>$_POST[$k]['invitations']]);
			}
		$pdo->commit();
		echo json_encode($_POST);
	}
	catch(Exception $e){
		$pdo->rollBack();
	}
}