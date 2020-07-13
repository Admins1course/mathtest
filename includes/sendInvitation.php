<?php
if ($_POST){
	require_once "db.inc.php";
	try{
		@session_start();
		$pdo->beginTransaction();
		for ($i=0;$i<count($_POST['friends']);$i++){
			if (preg_match("/[\D]+/",$_POST['friends'][$i])){
				echo json_encode(['answer'=>'serverError']);
				exit();
			}
		}
		for($i=0;$i<count($_POST['tests']);$i++){
			if (!preg_match("/book\.html\.php\?idUser=[\d]&idTest=[a-f0-9]/",$_POST['tests'][$i])){
				echo json_encode(['answer'=>'serverError']);
				exit();
			}
		}
		if(preg_match("/[\D]+/",$_POST['recipient'])){
			echo json_encode(['answer'=>'serverError']);
			exit();
		}
		for ($i=0;$i<count($_POST['friends']);$i++){
			for ($j=0;$j<count($_POST['tests']);$j++){
				$idNotif=md5(uniqid($_SESSION['data-user']['id'],1));
				$sql="INSERT INTO `notifications`(`idNotif`,`id_User`,`message`,`unread`,`dateOfSend`) 
					  VALUES(:idNotif,:id_User,:message,1,NOW())";
				$pdo->prepare($sql)->execute(['idNotif'=>$idNotif,
											  'id_User'=>$_POST['friends'][$i],
											  'message'=>$_SESSION['data-user']['name']." ".$_SESSION['data-user']['surname']." приглашает вас пройти тест"]);
				$sql="INSERT INTO `inviteNotif` VALUES(:idNotif,:invitations,:recipient)";
				$pdo->prepare($sql)->execute(['idNotif'=>$idNotif,
											  'invitations'=>$_POST['tests'][$j],
											  'recipient'=>$_POST['recipient']]);
			}
		}
		$pdo->commit();
		echo json_encode(['answer'=>'success']);
	}
	catch(Exception $e){
		$pdo->rollBack();
		echo json_encode(['answer'=>'serverError']);
	}
}
