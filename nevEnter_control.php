<?php
include 'includes/db.inc.php';
if (@isset($_POST)){
	if (trim($_POST['login'])&&trim($_POST['password'])){
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
		//echo var_dump($dataUser);
		
		if (md5($_POST['password'])==$dataUser[0]['userPassword']){
			//setcookie("login", "",time()-1);//секунды*минуты*часы*дни trim($_POST['login'])
			//setcookie("password", "", time()-1);//$_POST['password']
			setcookie("id", $dataUser[0]["id"], time()+60*60*24*10);
			setcookie("name", $dataUser[0]["name"], time()+60*60*24*10);
			setcookie("surname", $dataUser[0]['surname'], time()+60*60*24*10);
			setcookie("root", $dataUser[0]['root'], time()+60*60*24*10);
			session_start();
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
		}
	}
	else{
		session_start();
		$_SESSION['data']=true;
		header('Location: nevEnter.html.php');
	}
}
else{
	header('Location: nevEnter.html.php');
}