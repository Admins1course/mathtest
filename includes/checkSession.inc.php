<?php
require_once 'db.inc.php';
@session_start();
function checkSession(){
	$query="SELECT CASE WHEN EXISTS (
					SELECT *
					FROM `users`
					WHERE `id`=:id AND `login`=:login AND `userPassword`=:password
			)
			THEN CAST(1 AS BIT)
			ELSE CAST(0 AS BIT) END";
	$result=$pdo->prepare($query);
	$result->execute(['id'=>$_SESSION['data-user']['id'],
					  'login'=>$_SESSION['data-user']['login'],
					  'password'=>$_SESSION['data-user']['password']]);
	$result=$result->fetchAll(FETCH_ASSOC);
	return $result;
}
echo var_dump(checkSession());