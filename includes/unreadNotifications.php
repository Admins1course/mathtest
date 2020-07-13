<?php
	@session_start();
	require_once 'db.inc.php';
	if ($_POST){
		try{
			$pdo->beginTransaction();
			foreach ($_POST as $k=>$v){
				try{
					if(preg_match("/[^A-Za-z0-9]/",$_POST[$k])){
						throw new Exception();
					}
				}
				catch(Exception $e){
					echo json_encode(['answer'=>'errorData']);
					exit();
				}
				$sql="UPDATE notifications
					  SET unread=0
					  WHERE idNotif=:idNotif";
				$result=$pdo->prepare($sql)->execute(['idNotif'=>$_POST[$k]]);
			}
			$pdo->commit();
			echo json_encode(['answer'=>'success']);
		}
		catch(Exception $e){
			$pdo->rollBack();
			echo json_encode(['answer'=>'serverError']);
			exit();
		}
	}
	else echo json_encode(['answer'=>'serverError']);