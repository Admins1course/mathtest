<?php require_once 'includes/db.inc.php';
	  require_once 'registration_control.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Cache-Control" content="no-cache" charset="UTF-8">
	<link rel="stylesheet" href="style/Main.css" type="text/css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$('.exit_menu').click(function(){
			$('.exit_menu_body').slideToggle(500);
		});
	});
	</script>
</head>
<body>
	<div id="page">
		<div class="forNewFormulas" style="display:none">
			$$
				\newcommand{\tg}{\mathop{\rm tg}\nolimits}
				\newcommand{\arctg}{\mathop{\rm arctg}\nolimits}
				\newcommand{\tgh}{\mathop{\rm tgh}\nolimits}
				\newcommand{\ctg}{\mathop{\rm ctg}\nolimits}
				\newcommand{\arcctg}{\mathop{\rm arcctg}\nolimits}
				\newcommand{\ctgh}{\mathop{\rm ctgh}\nolimits}
				\newcommand{\cosec}{\mathop{\rm cosec}\nolimits}
				\newcommand{\e}{\mathop{\rm e}\nolimits}
				\renewcommand{\Re}{\mathop{\rm Re}\nolimits}
				\renewcommand{\Im}{\mathop{\rm Im}\nolimits}
			$$
		</div>
		<div id="main_content">
			<p>Как создавать формулы</p>
			<p>Формы представления формул</p>
			<p>Создать тест для тестирования по дисциплинам высшей математики невозможно без формул. Вы можете использовать 2 формы записи
			формул:</p>
			<ul>
				<li>строчная;</li>
				<li>выключная.</li>
			</ul>
			<p>Например</p>
			<p>Как видно строчные формулы помещаются внутрь строки, а выключные создают отдельный блок, который располагается по центру</p>
			<p>Панель для создания формул</p>
			<p>Как известно, клавиатура не включает в себя все символы, особенно математические. Данная панель позволит отображать, те символы, 
			которых нет на клавиатуре. Например, /(/alpha/)<p>
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
		<div id="right_block_title"></div>
		<div id="right_block">

		</div>
		<div id="left_block_title"></div>
		<div id="left_block">

		</div>
		<div id="nav_menu">
			<nav id="menu1">
			 <ul>
			  <li><a href="#m1">Главная</a></li>
			  <li><a href="#m2">О нас</a></li>
			  <li><a href="#m3">Тесты</a>
			   <ul>
			    <li><a href="book.html.php">Каталог тестов</a></li>
				<?php if(isset($_COOKIE['root'])&&($_COOKIE['root']=="студент")){?>
					<li><a href="#m3_4">Статистика</a></li>
					<li><a href="#m3_5">Пройти тест по приглашению</a></li>
			    <?php }else if(isset($_COOKIE['root'])&&($_COOKIE['root']=="учитель")){?>
					<li><a href="#m3_3">Мой каталог</a></li>
					<li><a href="#m3_4">Создать тест</a></li>
					<li><a href="#m3_5">Создать приглашение</a></li>
				<?php } ?>
			   </ul>
			  </li>
			  <li><a href="#m4">Новости</a></li>
			  <li><a href="#m5">Контакты</a></li>
			 </ul>
			</nav><!--menu1-->
			<div class="profile">
				<?php
					if (isset($_COOKIE['name'])&&isset($_COOKIE["surname"])):?>
						<p class="exit_menu"><?=htmlspecialchars($_COOKIE['name'])." <br /> ".htmlspecialchars($_COOKIE['surname'])?></p>
						<div class="exit_menu_body">

							<div class="exit_menu_elements">
								<p class="exit_menu_stat">Статус</p>
							</div>
							
							<div class="exit_title exit_menu_elements">

								<p ><a href="vyhod.php">Выход</a></p>
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