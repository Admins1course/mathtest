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
			$sql='SELECT login FROM formuly.users WHERE login=:login';
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
			$sql='INSERT INTO formuly.users SET
				  login=:login,
				  userPassword=:userPassword,
				  name=:name,
				  surname=:surname,
				  root=:root,
				  dateRegistration=NOW()';
			$s=$pdo->prepare($sql);
			$s->execute(['login'=>($_SESSION['login'])."_exist",
						 'userPassword'=>$_SESSION['password_first'],
						 'name'=>trim($_POST['name']),
						 'surname'=>trim($_POST['surname']),
						 'root'=>rawurldecode($_POST['root'])]);
			$query="SELECT id FROM users WHERE login=:login";
			$result=$pdo->prepare($query);
			$result->execute(['login'=>$_SESSION['login']."_exist"]);
			$id=$result->fetchAll();
			$sql="CREATE TABLE tasktest_".$id[0]['id']."(
						id_Test	int(11) not null,
						countTask int(11) not null,
						mark_1 real not null,
						mark_2 real not null,
						mark_3 real not null,
						mark_4 real not null,
						mark_5 real not null
					)DEFAULT CHARACTER SET utf8 ENGINE=InnoDB";
			$pdo->exec($sql);
			$sql="CREATE TABLE `friends_".$id[0]['id']."` (
						`id_Friend` int(8) NOT NULL,
						`login` varchar(255),
						`name` tinytext not null,
						`surname` tinytext not null,
						`студенты` int(1) DEFAULT 0,
						`преподаватели` int(1) DEFAULT 0
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
			$pdo->exec($sql);
			$sql="CREATE TABLE notifications_".$id[0]['id']." (
						id int not null auto_increment primary key,
						_unread tinytext default null,
						_read tinytext default null,
						dateOfSend datetime not null
					)ENGINE=InnoDB DEFAULT CHARSET=utf8";
			$pdo->exec($sql);
			
			setcookie("id", $id[0]["id"], time()+60*60*24*10);
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
			$error="Невозможно отправить данные базе данных: ".$e->getMessage();
			include 'error.html.php';
			exit();
		}
	}