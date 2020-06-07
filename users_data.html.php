<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Cache-Control" content="no-cache" charset="UTF-8">
	<link rel="stylesheet" href="style/NevRegistratoin.css?<?=time()?>" type="text/css">

	<title>Регистрация</title>
	
	<?php require_once "includes/data_handler.inc.php";?>
	<script>
	$(document).ready(function(){
		//при загрузке страницы окно один раз мигнет 
		$('.popup-fade').not('.popup-fade:first').stop(true).fadeTo(2000,1);
		$('.popup-fade').not('.popup-fade:first').stop(true).fadeTo(3000,0.3)
		//обработчик событий с всплывающим окном
		$('.popup-fade').not('.popup-fade:first').mouseout(function(){ $(this).stop(true).fadeTo(2000,0.4 );});
		$('.popup-fade').not('.popup-fade:first').mouseover(function(){ $(this).stop(true).fadeTo(10,1);});
	});
	</script>
</head>
<body style="width: 2000px; height: 1000px;">

    <!--эти 3 элемента появляются при вводе отсутствии данных-->
    
	
	<div class="container">
		<div class="popup-fade" style="display:none">
			<div class="popup">
				<p>Заполните поле</p>
			</div>		
		</div>
		<img class="avatar" src="style/img/regavatar.png" width="100" height="100" alt="">
		<div class="enter_text_div">
			<div class="enter_text">РЕГИСТРАЦИЯ</div>
		</div>
		<form action="nevRegistaration.html.php" method="post" autocomplete="off">
			<div class="dws-input">
				
				<img class="userpng" src="style/img/user.png" width="20" height="20" alt="">
				<input type="text" id="name" name="name" placeholder="Введите имя" maxlength="20">
				<p id="p_name" style="display:none">Разрешено использовать только символы русского и английского алфавита, цифры и знак подчеркивания</p>
			</div>
			<div class="dws-input">
				
				<img class="userpng" src="style/img/user.png" width="20" height="20" alt="">
				<input type="text" id="surname" name="surname" placeholder="Введите фамилию" maxlength="20">
				<p id="p_surname" style="display:none">Разрешено использовать только символы русского и английского алфавита, цифры и знак подчеркивания</p>
			</div>
			<select name="root" id="select">
					<option selected value="Кто вы такой ааа?" disabled="" class="gg">Кто вы такой ааа?</option>
					<option class="option" 	value="cтудент">Студент</option>
					<option class="option" value="преподаватель">Преподаватель</option>
			</select>
			<div class="dws-input">

			</div>
			<input id="continue" class="dws-submit" type="submit" placeholder="Регистрация" value="Продолжить">
		</form>
		<div class="change-panel">
				<p>Зарегистрироваться</p>
				<a href="nevEnter.html.php">Авторизация</a>
		</div>		
	</div>
	
</body>
</html>