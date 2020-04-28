<?php require_once 'includes/db.inc.php';
	  require_once 'registration_control.php';
	  session_start();
	  if (!$_SESSION['data-user']){
		  if ($_COOKIE['name']){//достаточно name, чтобы были и остальные
			  $_SESSION['data-user']['id']=$_COOKIE['id'];
			  $_SESSION['data-user']['name']=$_COOKIE['name'];
			  $_SESSION['data-user']['surname']=$_COOKIE['surname'];
			  $_SESSION['data-user']['root']=$_COOKIE['root'];
		  }
	  }?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Cache-Control" content="no-cache" charset="UTF-8">

	<link rel="stylesheet" href="style/Main.css" type="text/css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$('.exit_menu').click(function(){
			$('.exit_menu_body').slideToggle(500);
		});
	});
	</script>
		<script>
	$(document).ready(function($) {
	$('.load_avatar_open').click(function() {
		$('.load_avatar_fade').fadeIn();
		return false;
	});	
	
	$('.load_avatar_close').click(function() {
		$(this).parents('.load_avatar_fade').fadeOut();
		return false;
	});		
 
	$(document).keydown(function(e) {
		if (e.keyCode === 27) {
			e.stopPropagation();
			$('.load_avatar_fade').fadeOut();
		}
	});
	
	
});
</script>
</head>
<body>
	<div id="page">
		
		<div id="main_content">

		</div>
		<div class="slider midle">
			<div class="slides">
				<input type="radio" name="r" id="r1" checked>
				<input type="radio" name="r" id="r2" >
				<input type="radio" name="r" id="r3" >
				<input type="radio" name="r" id="r4" >

				<div class="slide s1"> <img src="img/FonBooks.png" alt=""></div>
				<div class="slide"> <img src="img/books.png" alt=""></div>
				<div class="slide"> <img src="img/rtx.png" alt=""></div>
				<div class="slide"> <img src="img/Artem.png" alt=""></div>
			</div>

			<div class="navigation">
				<label for="r1" class="bar"></label>
				<label for="r2" class="bar"></label>
				<label for="r3" class="bar"></label>
				<label for="r4" class="bar"></label>
			</div>
		</div>



		<div id="plus_inform">
			
		</div>
		<div class="all_right_block">
			<div id="right_block_title"></div>
			<div id="right_block"></div>
		</div>

		<div class="all_left_block">
			<div id="left_block_title">
				<div class="search_area">
					<div class="search">
						<input type="text" class="search_bar">
					
					</div>
					<div class="search_send">
						<input type="button" class="search_send_title" value="Поиск">
						<input type="button" value="Друзья">
						<input type="button" value="Мир">
					</div>
				</div>
			</div>
			<div id="left_block" class="left_block">
			<p>Друзья</p>
			<label for="friends">Группа</label>
			<select id="friends">
				<option label="Все друзья"></option>
				<option label="Студенты"></option>
				<option label="Преподаватели"></option>
			</select>
			<ul>
			</ul>
			</div>
		</div>

		
		<div id="nav_menu">
			<nav id="menu1">
			 <ul>
			  <li><a href="index.php">Главная</a></li>
			  <li><a href="#m2">О нас</a></li>
			  <li><a href="#m3">Тесты</a>
			   <ul>
			    <li><a href="TestList.php">Каталог тестов</a></li>
				<?php if(isset($_SESSION['data-user']['root'])&&($_SESSION['data-user']['root']=="студент")){?>
					<li><a href="#m3_4">Статистика</a></li>
					<li><a href="#m3_5">Пройти тест по приглашению</a></li>
			    <?php }else if(isset($_SESSION['data-user']['root'])&&($_SESSION['data-user']['root']=="преподаватель")){?>
					<li><a href="#m3_3">Мой каталог</a></li>
					<li><a href="createtest.html.php">Создать тест</a></li>
					<li><a href="#m3_5">Создать приглашение</a></li>
				<?php } ?>
			   </ul>
			  </li>
			  <li><a href="#m4">Новости</a></li>
			  <li><a href="#m5">Контакты</a></li>
			  <li>
			  	<a href="#m5">Оповещения
				  	<div class="notifications">
						<div class="notific_num">
							<p>99+</p>
						</div>
				  	</div>
				</a>
			  </li>
			 </ul>
			</nav><!--menu1-->
			<div class="profile">
				<?php
					if (isset($_SESSION['data-user']['name'])&&isset($_SESSION['data-user']["surname"])):?>
						<div class="profile_avatar load_avatar_open">
							<p class="plus_photo">+</p>
						</div>
						<div class="load_avatar_fade">
							<div class="load_avatar">
								<div class="preview_image_div">
									<div class="preview_image" id="img-preview" >
										
									</div>
									
								</div>
								<div class="load_image">
								  <label for="custom-file-upload" class="filupp">
								    <span class="filupp-file-name js-value" >Загрузить файл</span>
								    <input type="file" name="attachment-file " value="1"  id="custom-file-upload"  >
								  </label>
								</div>
	
								
								<a class="load_avatar_close" href="">Закрыть</a>
							</div>
							
						</div>
						<div class="user_profile_title">
					
							<p class="exit_menu"><?=htmlspecialchars($_SESSION['data-user']['name'])." <br /> ".htmlspecialchars($_SESSION['data-user']['surname'])?></p>
						</div>
						<div class="exit_menu_body" style="display:none">

							<div class="exit_menu_elements">
								<p class="exit_menu_stat">Роль: <?php $_SESSION['data-user']['root'];?></p>
							</div>
							
							<div class="exit_title exit_menu_elements">

								<p><a href="vyhod.php">Выход</a></p>
							</div>
						</div>
					<?php 
					else:?>
						<div class="enter_site_btn">
							<a  href="nevEnter.html.php">Войти</a>
						</div>
				<?php endif?>
			</div>
		</div>
	</div>
	
	
	<div id="footer">
		<div class="text">
			2020
		</div>
	</div>


	
	
</body>
</html>