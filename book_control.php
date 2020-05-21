<?php
session_start();
if (isset($_SESSION['data-user']['name'])){
	if (isset($_REQUEST['idUser'])&&isset($_REQUEST['idTest'])){
		$idUser=$_REQUEST['idUser'];
		$idTest=$_REQUEST['idTest'];
		$query="SELECT countTask FROM tasktest_".$idUser." WHERE id_Test=".$idTest;
		$result=$pdo->query($query);
		$tasks=$result->fetchAll();
		$dataTest=[];
		if (@count($tasks)){
			try{
				$query="SELECT total_task,icontest FROM totaltasktable_".$idUser."_".$idTest;
				$result=$pdo->query($query);
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
						$query="SELECT myPhoto FROM icontest_".$idUser."_".$idTest." WHERE myPhoto IS NOT NULL AND id_Task=".$i;
						$result=$pdo->query($query);
						$icontest=$result->fetchAll(PDO::FETCH_ASSOC);
						for ($j=1;$j<=count($icontest);$j++){
							$dataTest[$i]['icontest'][$j]=$icontest[$j-1]['myPhoto'];
						}
					}
					else $dataTest[$i]["icontest"]='';
				}
				$query="SELECT textarea, input, radio, checkbox FROM answers_".$idUser."_".$idTest;
				$result=$pdo->query($query);
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
						$query="SELECT text_answer FROM radio_".$idUser."_".$idTest." WHERE id_Task=".$i;
						$result=$pdo->query($query);
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
						$query="SELECT checkbox, text_answer FROM checkbox_".$idUser."_".$idTest." WHERE id_Task=".$i;
						$result=$pdo->query($query);
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
}
function question($numberOfTask,$task){
	$html='';
	if ($task['total_task']!==''){
		$html.='<p class="question">'.$task["total_task"].'</p>';
	}
	if ($task['icontest']!==''){
		$html.='<div class="image_answer_div">';
		for ($i=1;$i<=count($task['icontest']);$i++){
			$html.='<div class="image_answer">';
			$html.='<img src="./user-img/'.$_REQUEST['idUser'].'/'.$_REQUEST['idTest'].'/';
			$html.=$numberOfTask.'/'.$task['icontest'][$i].'"';
			$html.='class="image" alt="" style="height: 240px; width: 240px;">';
			$html.='</div>';
		}
		$html.='</div>';
	}
	echo $html;
}