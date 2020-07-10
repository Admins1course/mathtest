<?php
if ($_POST){
	require_once "db.inc.php";
	try{
		@session_start();
		$pdo->beginTransaction();
		$sql="INSERT INTO `notifications`(`id_User`,`message`,`_unread`,`invitations`,`recipient`,`dateOfSend`) VALUES";
		$replacement=[];
		for ($i=0;$i<count($_POST['friends']);$i++){
			for ($j=0;$j<count($_POST['tests']);$j++){
				$sql.="(".$_POST['friends'][$i].",'".$_SESSION['data-user']['name']." ";
				$sql.=$_SESSION['data-user']['surname']." приглашает вас пройти тест',1,'";
				$sql.=$_POST['tests'][$j]."',".$_POST['recipient'].",NOW())";
				if((($i+1)<count($_POST['friends']))||(($j+1)<count($_POST['tests']))){
					$sql.=",";
				}
			}
		}
		$pdo->exec($sql);
		$pdo->commit();
		echo json_encode(['answer'=>'success']);
	}
	catch(Exception $e){
		$pdo->rollBack();
		echo json_encode(['answer'=>"serverError"]);
	}
}
