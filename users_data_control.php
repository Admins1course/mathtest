<?php 
    if($_POST){  //Проверка на принятие данных с форм
		session_start();
		$_SESSION=[];
	    //Проверяем наличие всех необходимых значений и присваиваем сессии, т.к. он нужен если хотя бы одно из значений не указано
		if($_POST['name']) $_SESSION['users_data']['name']=$_POST['name'];
		else               $_SESSION['users_data']['name']=null;
		if($_POST['surname']) $_SESSION['users_data']['surname']=$_POST['surname'];
		else                  $_SESSION['users_data']['surname']=null;
		
		if(isset($_POST['root'])) $_SESSION['users_data']['root']=$_POST['root'];
		else                      $_SESSION['users_data']['root']=null;
		//Проверяем все ли поля были заполнены
		foreach($_SESSION['users_data'] as $empty){
			if($empty===null){ // если поле не заполнено, возвращаемся на предыдущую страницу, чтобы пользователь ввел все данные
				header('Location: /mathtest/users_data.html.php');
				exit();
			}
		}
	}