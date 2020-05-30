<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Cache-Control" content="no-cache" charset="UTF-8">
	<link rel="stylesheet" href="style/Neventer.css?<?=time()?>" type="text/css">
	<title>Войти</title>
</head>
<body>
	<div class="container">
		<img class="avatar" src="style/img/regavatar.png" width="100" height="100" alt="">
		<div class="enter_text_div">
			<div class="enter_text">АВТОРИЗАЦИЯ</div>
		</div>
		<form action="nevEnter_control.php" method="post">
			<div class="dws-input">
				<img class="userpng" src="style/img/user.png" width="20" height="20" alt="">
				<input type="text" name="login" placeholder="Введите логин" >
			</div>
			<div class="dws-input">
				<img class="lockpng" src="style/img/lock.png" width="20" height="20" alt="">
				<input type="password" name="password" placeholder="Введите пароль">
				<?php if (isset($_SESSION['data'])&&$_SESSION['data']):?>
					<p class="wrong_password">Неверный логин или пароль</p>
				<?php unset($_SESSION['data']);
					session_destroy();
				endif?>
			</div>
			<div class="dws-input">
				
			</div>
				<input class="dws-submit" type="submit" name="submit" value="Войти">
				<br />
				<a href="nevtest.html.php">Восстановление пароля</a>
			<div class="change-panel">
				
				<a href="users_data.html.php">Зарегистрироваться</a>
				<p>Авторизация</p>
			</div>		
		</form>
		
	</div>
	
</body>
</html>