<?php
include 'db.inc.php';
@session_start();
if ($_POST){
	try{
		$pdo->beginTransaction();
		
		$sql="SELECT id, name, surname FROM `users` 
				WHERE name LIKE '".strtolower($_POST['searchValue'])."%' OR
					  surname LIKE '".strtolower($_POST['searchValue'])."%'
				FOR UPDATE";
		$result=$pdo->query($sql);
		$people=$result->fetchAll(PDO::FETCH_ASSOC);
		for($i=0;$i<count($people);$i++){
			foreach($people[$i] as $k=>$v){
				$people[$i][$k]=htmlspecialchars($people[$i][$k]);
			}
		}
		$sql="SELECT id_Friend, waiting FROM `friends` WHERE id_User=:idUser";
		$result=$pdo->prepare($sql);
		$result->execute(['idUser'=>$_SESSION['data-user']['id']]);
		$friends=$result->fetchAll(PDO::FETCH_ASSOC);
		for($i=0;$i<count($friends);$i++){
			foreach($friends[$i] as $k=>$v){
				$friends[$i][$k]=htmlspecialchars($friends[$i][$k]);
			}
		}
		$jsonResult['people']=$people;
		foreach ($friends as $k=>$v){
			$jsonResult['friends']['id'][]=$friends[$k]['id_Friend'];
			$jsonResult['friends']['waiting'][]=$friends[$k]['waiting'];
		}
		$pdo->commit();
		echo json_encode($jsonResult);
	}
	catch (Exception $e){
	$pdo->rollBack();
		echo json_encode(['answer'=>'serverError']);
	}
}		