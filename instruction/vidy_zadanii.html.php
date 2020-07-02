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
		
		<div id="main_content">
			<p>Виды заданий<p>
			<p>В ассортимент сайта входит 4 различных вида заданий:</p>
			<ul>
				<li>1) Задание с развернутым ответом. При создании тестов у данного типа не нужно заполнять "Варианты ответов". 
				Поле для развернутого ответа создано, чтобы пользователь понимал к какому ввиду относится данное задание.</li>
				<li>2) Задание, в котором есть несколько вариантов ответов, но правильный только один. Данное задание 
				может иметь произвольное количество вариантов ответов, по желанию пользователю.</li>
				<li>3) Задание, в котором есть несколько вариантов ответов, но правильных ответов уже несколько. Данное задание 
				может иметь произвольное количество вариантов ответов, по желанию пользователю.</li>
				<li>4) Задание без возможного варианта ответа. Пользователю нужно решить задачу и записать ответ соответствующее поле.</li> 
			</ul>
			<p>Чтобы создать новое задание нужно нажать на одну из 4 форм. !ВНИМАНИЕ! Задание сохранится при отправке только в том случае,
			если у Вас есть условие задачи и указан правильный ответ (!ВНИМАНИЕ! Для 1 вида заданий достаточно только заполнить условие 
			задачи. Причина заключается в проверке прохождения тестов, которая будет указана ниже). Для 2 и 3 вида заданий, если в соотвествующем поле с указанием варианта ответа ничего не написать, то есть оставить 
			поле незаполненным, этот вариант сохранен не будет, то есть задание сохранится, но данный вариант ответа будет опущен. Таким образом,
			можно не пугаться того, что было создано лишнее задание или лишний вариант ответа, просто не заполняйте его, тогда его не будет
			в итоговом тесте.</p>
			<p>Для 1 и 4 вида заданий есть некоторые различия при проверке результатов прохождения тестов. Дело в том, что 4 вариант 
			проверяется сразу, и студент может увидеть результат сразу после прохождения теста. Но 1 вариант сразу не проверяется, так как сначала 
			он отправляется на проверку преподавателю</p>
			<p>Ниже представлены примеры заполненных тестов.</p>
			<a href="podgotovka.html.php">&lsaquo;&lsaquo;</a><a href="vidy_zadanii.html.php">&rsaquo;&rsaquo;</a>
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