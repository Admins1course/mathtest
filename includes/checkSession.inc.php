<?php
require_once 'db.inc.php';
@session_start();
function checkSession($pdo){
	if (isset($_SESSION['data-user']['id'])&&isset($_SESSION['data-user']['login'])&&isset($_SESSION['data-user']['password'])){
		$query="SELECT `name`,`surname`,`root`
						FROM `users`
						WHERE `id`=:id AND `login`=:login AND `userPassword`=:password";
		$result=$pdo->prepare($query);
		$result->execute(['id'=>$_SESSION['data-user']['id'],
						  'login'=>$_SESSION['data-user']['login'],
						  'password'=>$_SESSION['data-user']['password']]);
		$result=$result->fetchAll(PDO::FETCH_ASSOC);
		$is_login=(!empty($result));
		if ($is_login){
			$_SESSION['data-user']['name']=$result[0]['name'];
			$_SESSION['data-user']['surname']=$result[0]['surname'];
			$_SESSION['data-user']['root']=$result[0]['root'];
		}
		else{
			session_destroy();
			$_SESSION=[];
		}
	}
	else $is_login=false;
	return $is_login;
}
$is_login=checkSession($pdo);