<?php
	
	if($_POST){  //Проверка на принятие данных с форм
		session_start();
		$_SESSION['is_wrong_password']=false;
		$_SESSION['login_exist']=false;
		
		try{
			$pattern="/[^A-Za-z0-9_]/";
			if(preg_match($pattern,$_POST['login'])){
				throw new Exception();
			}
			if(preg_match($pattern,$_POST['password_first'])){
				throw new Exception();
			}
			if(preg_match($pattern,$_POST['password_second'])){
				throw new Exception();
			}
		}
		catch(Exception $e){
			header('Location: http://mathtest.rfpgu.ru/nevRegistaration.html.php');
			exit();
		}
		$pattern="/[^А-Яа-яЁёA-Za-Z0-9_]/u";
		$root=array('студент','преподаватель');
		try{
			if(preg_match($pattern,$_POST['name'])){
				throw new Exception();
			}
			if(preg_match($pattern,$_POST['surname'])){
				throw new Exception();
			}
			if(!in_array($_POST['root'],$root)){
				throw new Exception();
			}
		}
		catch(Exception $e){
			header('Location: http://mathtest.rfpgu.ru/users_data.html.php');
			exit();
		}
		
	    //Проверяем наличие всех необходимых значений и присваиваем сессии, т.к. он нужен если хотя бы одно из значений не указано
		if($_POST['login']) $_SESSION['users_data']['login']=true;
		else               	$_SESSION['users_data']['login']=null;
		
		if($_POST['password_first']) $_SESSION['users_data']['password_first']=true;
		else                         $_SESSION['users_data']['password_first']=null;
		
		if($_POST['password_second']) $_SESSION['users_data']['password_second']=true;
		else                          $_SESSION['users_data']['password_second']=null;
		//Проверяем все ли поля были заполнены
		foreach($_SESSION['users_data'] as $empty){
			if($empty===null){ // если поле не заполнено, возвращаемся на предыдущую страницу, чтобы пользователь ввел все данные
				header('Location: http://mathtest.rfpgu.ru/nevRegistaration.html.php');
				exit();
			}
		}
		try{
			$sql='SELECT login FROM users WHERE login=:login';
			$result=$pdo->prepare($sql);
			$result->execute(['login'=>$_POST['login']]);
			$row = $result->fetchAll();
			if (count($row)){
				$_SESSION['login_exist']=true;
				header('Location: http://mathtest.rfpgu.ru/nevRegistaration.html.php');
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
			header('Location: http://mathtest.rfpgu.ru/nevRegistaration.html.php');
			exit();
		}
		try{
			$randomCookie=bin2hex(openssl_random_pseudo_bytes(20));
			$pdo->beginTransaction();
			$sql='INSERT INTO `users`(`login`,`userPassword`,`randomCookie`,`name`,`surname`,`root`,`dateRegistration`) 
					VALUES(:login,:userPassword,:randomCookie,:name,:surname,:root,NOW())';
			$pdo->prepare($sql)->execute(['login'=>$_POST['login'],
										  'userPassword'=>password_hash($_POST['password_first'],PASSWORD_DEFAULT),
										  'randomCookie'=>$randomCookie,
										  'name'=>$_SESSION['users_data']['name'],
										  'surname'=>$_SESSION['users_data']['surname'],
										  'root'=>$_SESSION['users_data']['root']]);
			$query="SELECT id FROM users WHERE login=:login";
			$result=$pdo->prepare($query);
			$result->execute(['login'=>$_SESSION['users_data']['login']]);
			$id=$result->fetchAll();
			$sql="INSERT INTO `avatars`(`id_User`) VALUES(:id)";
			$pdo->prepare($sql)->execute(['id'=>$id[0]['id']]);
			$pdo->commit();
			setcookie("id", $id[0]["id"], time()+60*60*24*10*30,'/','mathtest.rfpgu.ru');
			setcookie("randomCookie",$randomCookie, time()+60*60*24*10*30,'/','mathtest.rfpgu.ru');
			
			unset($_SESSION['users_data']);
			
			$_SESSION['data-user']['id']=$id[0]['id'];
			$_SESSION['data-user']['name']=$_POST[0]['name'];
			$_SESSION['data-user']['surname']=$_POST[0]['surname'];
			$_SESSION['data-user']['root']=$_POST[0]['root'];
			$_SESSION['invitation']=false;
			header("Location: http://mathtest.rfpgu.ru/index.php");
		}
		catch(PDOException $e){
			$pdo->rollBack();
			$error="Невозможно отправить данные базе данных: ".$e->getMessage();
			include 'error.html.php';
			exit();
		}
	}