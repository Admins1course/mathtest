<?php
	/*require_once 'db.inc.php';
	session_start();
	if(!$_SESSION['data-user']['id']){
		if(isset($_COOKIE['id'])&&
		   isset($_COOKIE['randomCookie'])){
			$sql="SELECT `randomCookie`,`name`,`surname`,`root` FROM `users` WHERE `id`=:id AND `randomCookie`=:randomCookie";
			$result=$pdo->query($sql);
			$result=$result->fetchAll(PDO::FETCH_ASSOC);
			if($result){
				$randomCookie=bin2hex(openssl_random_pseudo_bytes(20));
				$sql="UPDATE `users`
					  SET `randomCookie`=:randomCookie WHERE `id`=:id";
				$pdo->prepare($sql)->execute(['randomCookie'=>$randomCookie,
											  'id'=>$_COOKIE['id']]);
			    setcookie("id", $_COOKIE["id"], time()+60*60*24*30);
				setcookie("randomCookie", $randomCookie, time()+60*60*24*30);
				
				$_SESSION['data-user']['id']=$_COOKIE['id'];
				$_SESSION['data-user']['name']=$result[0]['name'];
				$_SESSION['data-user']['surname']=$result[0]['surname'];
				$_SESSION['data-user']['root']=$result[0]['root'];
				$_SESSION['invitation']=false;			  
			}
			else header("Location: nevEnter.html.php");
		}
		else header("Location: nevEnter.html.php");
	}