<?php
require_once('../includes/db.inc.php');
if (@isset($_POST)){
	if ($_POST['login']&&$_POST['password']){
		$pattern="/[^A-Za-z0-9_]/";
		if (preg_match($pattern,$_POST['login'])||preg_match($pattern,$_POST['password'])){
			session_start();
			$_SESSION['data']=true;
			header('Location: http://mathtest.rfpgu.ru/nevEnter.html.php');
			exit();
		}
		try{
			$query="SELECT id,userPassword,name,surname,root FROM users WHERE login=:login";
			$user=$pdo->prepare($query);
			$user->execute(['login'=>trim($_POST['login'])]);
		}
		catch(PDOException $e){
			$error="Невозможно извлечь данные из базы данных: ".$e->getMessage();
			include 'error.html.php';
			exit();
		}
		$dataUser=$user->fetchAll(PDO::FETCH_ASSOC);
		if(!$dataUser){
			session_start();
			$_SESSION['data']=true;
			header('Location: http://mathtest.rfpgu.ru/nevEnter.html.php');
			exit();
		}
		try{
			if (password_verify($_POST['password'],$dataUser[0]['userPassword'])){
				$randomCookie=bin2hex(openssl_random_pseudo_bytes(20));
				$sql="UPDATE `users`
					  SET `randomCookie`=:randomCookie WHERE `id`=:id";
				$pdo->prepare($sql)->execute(['randomCookie'=>$randomCookie,
											  'id'=>$dataUser[0]["id"]]);
				setcookie("id", $dataUser[0]["id"], time()+60*60*24*30,'/','mathtest.rfpgu.ru');
				setcookie("randomCookie", $randomCookie, time()+60*60*24*30, '/','mathtest.rfpgu.ru');
				session_start();
				$_SESSION['data-user']['id']=$dataUser[0]['id'];
				$_SESSION['data-user']['name']=$dataUser[0]['name'];
				$_SESSION['data-user']['surname']=$dataUser[0]['surname'];
				$_SESSION['data-user']['root']=$dataUser[0]['root'];
				$_SESSION['invitation']=false;
				header('Location: http://mathtest.rfpgu.ru/index.php');
			}
			else {
				session_start();
				$_SESSION['data']=true;
				header('Location: http://mathtest.rfpgu.ru/nevEnter.html.php');
				exit();
			}
		}
		catch(PDOException $e){
			$pdo->rollBack();
			$error="Невозможно отправить данные базе данных: ".$e->getMessage();
			include 'error.html.php';
			exit();
		}
	}
	else{
		session_start();
		$_SESSION['data']=true;
		header('Location: http://mathtest.rfpgu.ru/nevEnter.html.php');
		exit();
	}
}
else{
	header('Location: http://mathtest.rfpgu.ru/nevEnter.html.php');
	exit();
}