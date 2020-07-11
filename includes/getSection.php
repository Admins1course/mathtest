<?php
if ($_POST){
	require_once 'db.inc.php';
	$sql="SELECT `section` FROM `sections` WHERE id_subject=:id";
	$result=$pdo->prepare($sql);	
	$result->execute(['id'=>$_POST['section']]);
	$result=$result->fetchAll(PDO::FETCH_ASSOC);
	for($i=0;$i<count($result);$i++){
		foreach($result[$i] as $k=>$v){
			$result[$i][$k]=htmlspecialchars($result[$i][$k]);
		}
	}
	echo json_encode($result);
}