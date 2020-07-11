<?php 
$right_answers=[];
$count=0;
$allPoints=0;
$countOfPoints=0;
$mark=0;
if ($_POST){
	try{
		$query="SELECT textarea, input, radio, checkbox, points FROM answers WHERE id_Test=:idTest";
		$result=$pdo->prepare($query);
		$result->execute(['idUser'=>$_POST['idUser'],
						  'idTest'=>$_POST['idTest']]);
		$data=$result->fetchAll(PDO::FETCH_ASSOC);
		for ($i=0; $i<count($data);$i++){
			
			if ($data[$i-1]["textarea"]!==null){
				if($data[$i]["textarea"]===$_POST["answer"]["task".($i+1)]){
					$right_answers[$i]=[true, $data[$i]["points"]];
				}
				else $right_answers[$i]=[false,0];
			}
			
			if ($data[$i]["input"]!==null){
				if ($data[$i]["input"]===$_POST["answer"]["task".($i+1)]){
					$right_answers[$i]=[true, $data[$i]["points"]];
				}
				else $right_answers[$i]=[false, 0];
			}
			
			if ($data[$i]["radio"]!=="0"){
				$query="SELECT text_answer FROM radio
						WHERE id_User=:idUser AND id_Test=:idTest AND id_Task=:idTask AND radio_answer=1";
				$result=$pdo->prepare($query);
				$result->execute(['idUser'=>$_POST['idUser'],
								  'idTest'=>$_POST['idTest'],
								  'idTask'=>($i+1)]);
				$radio=$result->fetchAll();
				if ($radio[0]["text_answer"]==$_POST['answers']['task'.($i+1)]){
						$right_answers[$i]=[true, $data[$i]["points"]];
				}
				else $right_answers[$i]=[false, 0];
			}
			
			if ($data[$i]["checkbox"]!=0){
				$query="SELECT idCheckbox, text_answer FROM checkbox 
						WHERE id_User=:idUser AND id_Test=:idTest AND id_Task=:idTask AND checkbox=1";
				$result=$pdo->prepare($query);
				$result->execute(['idUser'=>$_POST['idUser'],
								  'idTest'=>$_POST['idTest'],
								  'idTask'=>($i+1)]);
				$checkbox=$result->fetchAll(PDO::FETCH_ASSOC);
				$right_answers[$i]=[true, $data[$i]["points"]];
				for ($j=1; $j<=count($checkbox); $j++){
					if (isset($_POST['answers']['task'.($i+1)][$checkbox[$j]['idCheckbox']])){
						if ($checkbox[$j]["text_answer"]!==$_POST['answers']['task'.($i+1)][$checkbox[$j]['idCheckbox']]){
							$right_answers[$i]=[false, 0];
							break;
						}
					}
					else if(isset($checkbox[$j]["text_answer"])){
						$right_answers[$i]=[false, 0];
						break;
					}
				}
			}
			
			$allPoints+=$data[$i]['points'];
		}
		for ($i=0;$i<count($right_answers);$i++){
			if ($right_answers[$i][0]) $count++;
			$countOfPoints+=$right_answers[$i][1];
		}
		$query="SELECT mark_1, mark_2, mark_3, mark_4, mark_5 FROM tasktest WHERE id_User=:idUser AND id_Test=:idTest";
		$result=$pdo->prepare($query);
		$result->execute(['idUser'=>$_POST['idUser'],
						  'idTest'=>$_POST['idTest']]);
		$mark_data=$result->fetchAll();
		for ($i=4;$i>=0;$i--){
			if ($countOfPoints>=$mark_data[0][$i]){
				$mark=$i+1;
				break;
			}
		}
		
		//отправка данных преподавателю
		//if($_POST['recipient'])
	}
	catch(PDOException $e){
		$error="Невозможно получить данные из базы данных: ".$e->getMessage();
		include 'error.html.php';
		exit();
	}
}
require_once "http://mathtest.rfpgu.ru/includes/question.inc.php";