<?php
	require_once 'includes/db.inc.php';
	
	if($_POST){  //Проверка на принятие данных с форм
		session_start();
		$_SESSION['is_wrong_password']=false;
		$_SESSION['login_exist']=false;
	    //Проверяем наличие всех необходимых значений и присваиваем сессии, т.к. он нужен если хотя бы одно из значений не указано
		if($_POST['login']) $_SESSION['login']=$_POST['login'];
		else                $_SESSION['login']=null;
		
		if($_POST['password_first']) $_SESSION['password_first']=md5($_POST['password_first']);
		else                         $_SESSION['password_first']=null;
		
		if($_POST['password_second']) $_SESSION['password_second']=md5($_POST['password_second']);
		else                          $_SESSION['password_second']=null;
		//Проверяем все ли поля были заполнены
		foreach($_SESSION as $empty){
			if($empty===null){ // если поле не заполнено, возвращаемся на предыдущую страницу, чтобы пользователь ввел все данные
				header('Location: /mathtest/nevRegistaration.html.php');
				exit();
			}
		}
		try{
			$sql='SELECT login FROM users WHERE login=:login';
			$result=$pdo->prepare($sql);
			$result->execute(['login'=>$_POST['login']."_exist"]);
			$row = $result->fetchAll();
			if (count($row)){
				$_SESSION['login_exist']=true;
				header('Location: /mathtest/nevRegistaration.html.php');
				exit();
			}
		}
		catch(PDOException $e){
			$error="Невозможно извлечь данные из базы данных: ".$e->getMessage();
			include 'error.html.php';
			exit();
		}
		if ($_POST['password_first']!==$_POST['password_second']){//проверка на то, что пароль был повторен верно
			$_SESSION['is_wrong_password']=true;
			header('Location: /mathtest/nevRegistaration.html.php');
			exit();
		}
		try{
			$pdo->beginTransaction();
			$sql='INSERT INTO `users`(`login`,`userPassword`,`name`,`surname`,`root`,`dateRegistration`) 
					VALUES(:login,:userPassword,:name,:surname,:root,NOW())';
			$pdo->prepare($sql)->execute(['login'=>$_SESSION['login'],
										  'userPassword'=>$_SESSION['password_first'],
										  'name'=>trim($_SESSION['users_data']['name']),
										  'surname'=>trim($_SESSION['users_data']['surname']),
										  'root'=>$_SESSION['users_data']['root']]);
			$query="SELECT id FROM users WHERE login=:login";
			$result=$pdo->prepare($query);
			$result->execute(['login'=>$_SESSION['login']]);
			$id=$result->fetchAll();
			$sql="INSERT INTO `avatars`(`id_User`) VALUES(:id)";
			$pdo->prepare($sql)->execute(['id'=>$id[0]['id']]);
			$pdo->commit();
			echo var_dump($_SESSION);
			setcookie("id", $id[0]["id"], time()+60*60*24*10);
			setcookie("login",$_POST['login'], time()+60*60*24*10);
			setcookie("password",$_POST['password_first'], time()+60*60*24*10);
			setcookie("name", trim($_POST["name"]), time()+60*60*24*10);
			setcookie("surname", trim($_POST['surname']), time()+60*60*24*10);
			setcookie("root", $_POST['root'], time()+60*60*24*10);

			$_SESSION['data-user']['id']=$id[0]['id'];
			$_SESSION['data-user']['name']=trim($_POST[0]['name']);
			$_SESSION['data-user']['surname']=trim($_POST[0]['surname']);
			$_SESSION['data-user']['root']=trim($_POST[0]['root']);
			header("Location: index.php");
		}
		catch(PDOException $e){
			$pdo->rollBack();
			$error="Невозможно отправить данные базе данных: ".$e->getMessage();
			include 'error.html.php';
			exit();
		}
	}