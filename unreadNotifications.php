<?php
if ($_POST){
	require_once 'includes/db.inc.php';
	session_start();
	try{
		$pdo->beginTransaction();
		foreach ($_POST as $k=>$v){
			$sql="UPDATE notifications_".$_SESSION['data-user']['id']."
					SET _read=1, _unread=0
					WHERE message=:message AND add_friends=:add_friends";
			$result=$pdo->prepare($sql);
			$result->execute(['message'=>$_POST[$k]['message'],
							'add_friends'=>$_POST[$k]['add_friends']]);
			}
		$pdo->commit();
		echo json_encode($_POST);
	}
	catch(Exception $e){
		$pdo->rollBack();
	}
}