<?php include 'handlers/users_data_control.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Cache-Control" content="no-cache" charset="UTF-8">
	<link rel="stylesheet" href="style/NevRegistratoin.css?132" type="text/css">

	<title>Регистрация</title>
	
	<?php require_once "includes/data_handler.inc.php";?>
	<script>
	$(document).ready(function(){
		//при загрузке страницы окно один раз мигнет 
		$('.popup-fade').not('.popup-fade:first').stop(true).fadeTo(10000,1,function(){
			$('.popup-fade').not('.popup-fade:first').stop(true).fadeTo(5000,0.3);
		});
		//обработчик событий с всплывающим окном
		$('.popup-fade').not('.popup-fade:first').mouseout(function(){ $(this).stop(true).fadeTo(2000,0.4 );});
		$('.popup-fade').not('.popup-fade:first').mouseover(function(){ $(this).stop(true).fadeTo(10,1);});
	});
	</script>
	
</head>
<body>
    <div class="popup-fade">
		<div class="popup">
			<p>Заполните поле</p>
		</div>		
	</div>
		
		
	<div class="container">
		<img class="avatar" src="style/img/regavatar.png" width="100" height="100" alt="">
		<form action="handlers/registration_control.php" method="post">
			<div class="dws-input">
				<img class="userpng" src="style/img/user.png" width="20" height="20" alt="">
				<input type="text" id="login" name="login" placeholder="Введите логин" maxlength="30" required>
				<p id="login_exist" style="display:none">Данный логин уже существует</p>
				<p id="p_login" style="display:none">Разрешено использовать только символы английского алфавита и цифры</p>
			</div>
			<div class="dws-input">
				<img class="lockpng" src="style/img/lock.png" width="20" height="20" alt="">
				<input type="password" name="password_first" placeholder="Введите пароль" maxlength="30" required>
				<p id="p_password_first" style="display:none">Разрешено использовать только символы английского алфавита и цифры</p>
			</div>
			<div class="dws-input">
				<img class="lockpng" src="style/img/lock.png" width="20" height="20" alt="">
				<input type="password" name="password_second" placeholder="Повторите пароль" maxlength="30" required>
				<p id="is_wrong_password" style="display:none">Пароли не совпадают</p>
				<p id="p_password_second" style="display:none">Разрешено использовать только символы английского алфавита и цифры</p>
			</div>
			<input type="hidden" name="name" value=<?=htmlspecialchars($_SESSION['users_data']['name'])?>>
			<input type="hidden" name="surname" value=<?=htmlspecialchars($_SESSION['users_data']['surname'])?>>
			<input type="hidden" name="root" value=<?=htmlspecialchars($_SESSION['users_data']['root'])?>>
			<input class="dws-submit" type="submit" name="submit" placeholder="Регистрация">
			
			<div class="change-panel">
				<p>Зарегистрироваться</p>
				<a href="nevEnter.html.php">Авторизация</a>
			</div>
		</form>
		
	</div>
	
</body>
</html>