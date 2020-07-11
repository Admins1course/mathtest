<?php
require_once "http://mathtest.rfpgu.ru/includes/db.inc.php";
@session_start();
$message='';
if (isset($_REQUEST['idTest'])){
	try{
		if(preg_match("/[\D]/",$_REQUEST['idUser'])){
			throw new Exception();
		}
		$sql="SELECT * FROM 'tests' WHERE id=:idTest";
		$result=$pdo->prepare($sql)->execute(['idTest'=>$_REQUEST['idTest']]);
		if (empty($result->fetchAll(PDO::FETCH_ASSOC))){
			throw new Exception();
		}
	}
	catch(Exception $e){
		$message="Данный тест не существует";
	}
	$idTest=$_REQUEST['idTest'];
	$query="SELECT countTask FROM tasktest WHERE id_Test=:idTest";
	$result=$pdo->prepare($query);
	$result->execute(['idTest'=>$idTest]);
	$tasks=$result->fetchAll();
	$dataTest=[];
	if (@count($tasks)){
		try{
			$query="SELECT total_task,icontest FROM totaltasktable WHERE id_Test=:idTest";
			$result=$pdo->prepare($query);
			$result->execute(['idTest'=>$idTest]);
			$data=$result->fetchAll(PDO::FETCH_ASSOC);
			for ($i=1; $i<=(int)$tasks[0]['countTask']; $i++){
				$dataTest[$i]=[];
				if ($data[$i-1]["total_task"]!==null){
					$dataTest[$i]["total_task"]=$data[$i-1]["total_task"];
				}
				else {
					$dataTest[$i]["total_task"]='';
				}
				if ($data[$i-1]["icontest"]==1){
					$dataTest[$i]['icontest']=[];
					$query="SELECT myPhoto FROM icontest
							WHERE id_Test=:idTest AND myPhoto IS NOT NULL AND id_Task=:idTask";
					$result=$pdo->prepare($query);
					$result->execute(['idTest'=>$idTest,
									  'idTask'=>$i]);
					$icontest=$result->fetchAll(PDO::FETCH_ASSOC);
					for ($j=1;$j<=count($icontest);$j++){
						$dataTest[$i]['icontest'][$j]=$icontest[$j-1]['myPhoto'];
					}
				}
				else $dataTest[$i]["icontest"]='';
			}
			$query="SELECT textarea, input, radio, checkbox FROM answers WHERE id_Test=:idTest";
			$result=$pdo->prepare($query);
			$result->execute(['idTest'=>$idTest]);
			$data=$result->fetchAll(PDO::FETCH_ASSOC);
			for ($i=1; $i<=count($data);$i++){
				$dataTest[$i]["answer"]=[];
				
				if ($data[$i-1]["textarea"]!=0){
					$dataTest[$i]["answer"]["textarea"]=1;
				}
				else $dataTest[$i]["answer"]["textarea"]=0;
				
				if ($data[$i-1]["input"]!==null){
					$dataTest[$i]["answer"]["input"]=$data[$i-1]["input"];
				}
				else $dataTest[$i]["answer"]["input"]=0;
				
				if ($data[$i-1]["radio"]!=="0"){
					$query="SELECT text_answer FROM radio 
					        WHERE id_Test=:idTest AND id_Task=:idTask";
					$result=$pdo->prepare($query);
					$result->execute(['idTest'=>$idTest,
									  'idTask'=>$i]);
					$radio=$result->fetchAll();
					$dataTest[$i]["answer"]["radio"]=[];
					for ($j=1; $j<=count($radio); $j++){
						$dataTest[$i]["answer"]["radio"][$j]=[];
						if ($radio[$j-1]["text_answer"]!==null){
							$dataTest[$i]["answer"]["radio"][$j]["text_answer"]=$radio[$j-1]["text_answer"];
						}
						else $dataTest[$i]["answer"]["radio"][$j]["text_answer"]=0;
					}
				}
				else $dataTest[$i]["answer"]["radio"]=0;
				
				if ($data[$i-1]["checkbox"]!=0){
					$query="SELECT checkbox, text_answer FROM checkbox 
							WHERE id_Test=:idTest AND id_Task=:idTask";
					$result=$pdo->prepare($query);
					$result->execute(['idTest'=>$idTest,
									  'idTask'=>$i]);
					$checkbox=$result->fetchAll(PDO::FETCH_ASSOC);
					$dataTest[$i]["answer"]["checkbox"]=[];
					for ($j=1; $j<=count($checkbox); $j++){
						$dataTest[$i]["answer"]["checkbox"][$j]=[];
						if ($checkbox[$j-1]["text_answer"]!==null){
							$dataTest[$i]["answer"]["checkbox"][$j]["text_answer"]=$checkbox[$j-1]["text_answer"];
						}
						else $dataTest[$i]["answer"]["checkbox"][$j]["text_answer"]=0;
					}
				}
				else $dataTest[$i]["answer"]["checkbox"]=0;
			}
		}
		catch(PDOException $e){
			$error="Невозможно получить данные из базы данных: ".$e->getMessage();
			include 'error.html.php';
			exit();
		}
	}
}
require_once "http://mathtest.rfpgu.ru/includes/question.inc.php";