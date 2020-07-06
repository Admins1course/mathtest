<?php
function question($numberOfTask,$task){
	$html='';
	if (preg_match('/[\D]/',$numberOfTask)){
		$html="Были получены ошибочные данные";
	}
	else{
		if ($task['total_task']!==''){
			$html.='<p class="question">'.htmlspecialchars($task["total_task"]).'</p>';
		}
		if ($task['icontest']!==''){
			$html.='<div class="image_answer_div">';
			for ($i=1;$i<=count($task['icontest']);$i++){
				$html.='<div class="image_answer">';
				$html.='<img src="./user-img/'.htmlspecialchars($_REQUEST['idUser']).'/'.htmlspecialchars($_REQUEST['idTest']).'/';
				$html.=htmlspecialchars($numberOfTask).'/'.htmlspecialchars($task['icontest'][$i]).'"';
				$html.='class="image" alt="" style="height: 240px; width: 240px;">';
				$html.='</div>';
			}
			$html.='</div>';
		}
	}
	echo $html;
}