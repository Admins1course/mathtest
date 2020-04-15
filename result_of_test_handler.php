<?php 
$right_answers=[];
$count=0;
//echo var_dump((double)"0.5")." ".var_dump((double)"0,5");
if ($_POST){
	//try{
		$query="SELECT textarea, input, radio, checkbox FROM answers_".$_POST["idUser"]."_".$_POST["idTest"];
		$result=$pdo->query($query);
		$data=$result->fetchAll();
		for ($i=0; $i<count($data);$i++){
			
			/*if ($data[$i-1]["textarea"]!=0){
				$dataTest[$i]["answer"]["textarea"]=1;
			}
			else $dataTest[$i]["answer"]["textarea"]=0;*/
			
			if ($data[$i]["input"]!==null){
				if ($data[$i]["input"]===$_POST["answer"]["task".($i+1)]){
					$right_answers[$i]=true;
				}
				else $right_answers[$i]=false;
			}
			else $dataTest[$i]["answer"]["input"]=0;
			
			if ($data[$i]["radio"]!=="0"){
				$query="SELECT text_answer FROM radio_".$_POST['idUser']."_".$_POST['idTest']." WHERE id_Task=".($i+1)." AND radio_answer=1";
				$result=$pdo->query($query);
				$radio=$result->fetchAll();
				if ($radio[0]["text_answer"]==$_POST['answers']['task'.($i+1)]){
						$right_answers[$i]=true;
				}
				else $right_answers[$i]=false;
			}
			
			if ($data[$i]["checkbox"]!=0){
				$query="SELECT idCheckbox, text_answer FROM checkbox_".$_POST['idUser']."_".$_POST['idTest']." WHERE id_Task=".($i+1)." AND 
						checkbox_answer=1";
				$result=$pdo->query($query);
				$checkbox=$result->fetchAll();
				$right_answers[$i]=true;
				for ($j=1; $j<=count($checkbox); $j++){
					if ($checkbox[$j]["text_answer"]!==$_POST['answers']['task'.($i+1)][$checkbox[$j]['idCheckbox']]){
						$right_answers[$i]=false;
						break;
					}
				}
			}
		}
	for ($i=0;$i<count($right_answers);$i++){
		if ($right_answers[$i]) $count++;
	}
	//}
	/*catch(PDOException $e){
		$error="Невозможно получить данные из базы данных: ".$e->getMessage();
		include 'error.html.php';
		exit();
	}*/
}