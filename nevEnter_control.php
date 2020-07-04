<?php
include 'includes/db.inc.php';
if (@isset($_POST)){
	if ($_POST['login']&&$_POST['password']){
		$pattern="/[^A-Za-z0-9_]/";
		if (preg_match($pattern,$_POST['login'])||preg_match($pattern,$_POST['password'])){
			session_start();
			$_SESSION['data']=true;
			header('Location: nevEnter.html.php');
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
		$dataUser=$user->fetchAll();
		try{
			$root=array("студент", "преподаватель");
			if (preg_match("/[\D]/",$dataUser[0]['id'])){
				throw new Exception(1);
			}
			if (preg_match("/[^A-Za-z0-9_]/",$dataUser[0]['userPassword'])){
				throw new Exception(2);
			}
			if (preg_match("/[^А-Яа-яЁёA-Za-Z0-9_]/u",$dataUser[0]['name'])){
				throw new Exception(3);
			}
			if (preg_match("/[^А-Яа-яЁёA-Za-z0-9_]/u",$dataUser[0]['surname'])){
				throw new Exception(4);
			}
			if (!in_array($dataUser[0]['root'],$root)){
				throw new Exception(5);
			}
		} 
		catch(Exception $e){
			header('Location: nevEnter.html.php');
			exit();
		}
		
		if (md5($_POST['password'])==$dataUser[0]['userPassword']){
			setcookie("login", $_POST["login"],time()+60*60*24*10);//секунды*минуты*часы*дни 
			setcookie("password", $dataUser[0]["userPassword"], time()+60*60*24*10);//$_POST['password']
			setcookie("id", $dataUser[0]["id"], time()+60*60*24*10);
			setcookie("name", $dataUser[0]["name"], time()+60*60*24*10);
			setcookie("surname", $dataUser[0]['surname'], time()+60*60*24*10);
			setcookie("root", $dataUser[0]['root'], time()+60*60*24*10);
			session_start();
			$_SESSION['data-user']['login']=$dataUser[0]['login'];
			$_SESSION['data-user']['password']=$dataUser[0]['userPassword'];
			$_SESSION['data-user']['id']=$dataUser[0]['id'];
			$_SESSION['data-user']['name']=$dataUser[0]['name'];
			$_SESSION['data-user']['surname']=$dataUser[0]['surname'];
			$_SESSION['data-user']['root']=$dataUser[0]['root'];
			header('Location: index.php');
		}
		else {
			session_start();
			$_SESSION['data']=true;
			header('Location: nevEnter.html.php');
			exit();
		}
	}
	else{
		session_start();
		$_SESSION['data']=true;
		header('Location: nevEnter.html.php');
		exit();
	}
}
else{
	header('Location: nevEnter.html.php');
	exit();
}