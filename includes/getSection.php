<?php
if ($_POST){
	require_once 'db.inc.php';
	$sql="SELECT `section` FROM `sections` WHERE id_subject=:id";
	$result=$pdo->prepare($sql);	
	$result->execute(['id'=>$_POST['section']]);
	echo json_encode($result->fetchAll(PDO::FETCH_ASSOC));
}