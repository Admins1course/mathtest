<?php
require_once 'includes/db.inc.php';
require_once "includes/checkSession.inc.php";
if ($is_login){
	if ($_POST){
		session_start();
		try{
			$pdo->beginTransaction();
			foreach ($_POST as $k=>$v){
				if($_POST[$k]['add_friends']){
					$sql="UPDATE notifications
							SET _unread=0
							WHERE id_User=:idUser AND message=:message AND add_friends=:add_friends";
					$result=$pdo->prepare($sql)->execute(['idUser'=>$_SESSION['data-user']['id'],
														'message'=>$_POST[$k]['message'],
														'add_friends'=>$_POST[$k]['add_friends']]);
				}
				else{
					$sql="UPDATE notifications
							SET _unread=0
							WHERE id_User=:idUser AND message=:message AND invitations=:invitations";
					$result=$pdo->prepare($sql)->execute(['idUser'=>$_SESSION['data-user']['id'],
														'message'=>$_POST[$k]['message'],
														'invitations'=>$_POST[$k]['invitations']]);
				}
			}
			$pdo->commit();
			echo json_encode($_POST);
		}
		catch(Exception $e){
			$pdo->rollBack();
			echo json_encode(['answer'=>$e->getMessage()]);
		}
	}
}