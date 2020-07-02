<?php
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