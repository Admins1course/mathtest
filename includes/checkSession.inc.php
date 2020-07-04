<?php
require_once 'db.inc.php';
@session_start();
function checkSession($pdo){
	$query="SELECT `name`,`surname`,`root`
					FROM `users`
					WHERE `id`=:id AND `login`=:login AND `userPassword`=:password";
	$result=$pdo->prepare($query);
	$result->execute(['id'=>$_SESSION['data-user']['id'],
					  'login'=>$_SESSION['data-user']['login'],
					  'password'=>$_SESSION['data-user']['password']]);
	$result=$result->fetchAll(PDO::FETCH_ASSOC);
	if ($is_login=!empty($result)){
		$_SESSION['data-user']['name']=$result[0]['name'];
		$_SESSION['data-user']['surname']=$result[0]['surname'];
		$_SESSION['data-user']['root']=$result[0]['root'];
	}
	else{
		session_destroy();
		$_SESSION=[];
	}
	return $is_login;
}
$is_login=checkSession();