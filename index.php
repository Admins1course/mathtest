<?php require_once 'includes/db.inc.php';
	  require_once 'registration_control.php';
	  session_start();
	  if (isset($_SESSION['data-user'])){
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

	<link rel="stylesheet" href="style/Main.css?<?time()?>" type="text/css">
	<link rel="stylesheet" href="style/Cssforindex.css?<?time()?>" type="text/css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$('.exit_menu').click(function(){
			$('.exit_menu_body').slideToggle(500);
		});
	});
	</script>
	<script type="text/javascript">
	$(document).ready(function(){
		$('.open_notifications_body').click(function(){
			$('.notifications_body').slideToggle(500);
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
<script>
	//setInterval(,10000)
	var searchFunction=searchForFriends;
	
	function callbackFunction(value){
		if (value==="Друзья") searchFunction=searchForFriends;
		if (value==="Мир") searchFunction=searchForPiece;
	}
	
	function searchPeople(){
		if ((valueOfSearch=$('[type="search"]').val())!=='')
			return searchFunction(valueOfSearch);
	}
	
	function searchForPiece(searchValue){
		$.ajax({
			url:document.location.origin+"/mathtest/searchForPiece.php",
			dataType:'json',
			cache:false,
			data:{searchValue:searchValue},
			type:'POST',
			error:function(){console.log('error')},
			success:function(data){
				console.log(data);
				var listOfPeople='';
				for (i=0;i<data.length;i++){
					listOfPeople+='<li>'+
						data[i]['name']+" "+
						data[i]['surname']+
						'<input type="button" name="'+
						data[i]['root']+
						'" value=" + В друзья" onclick="addFriend(this)" id="user'+
						data[i]['id']+'">'+'</li>';
				}
				$('#friendsList').html(listOfPeople);
			}
		})
	}
	
	function searchForFriends(){}
</script>
<script>
	function searchControl(element){
		var re=/[^a-zA-Zа-яА-Я0-9_]+/gus;
		if (re.test(element.value)) 
			element.value=element.value.replace(re, '');
	}
</script>
<script>
	function addFriend(element){
		$idFriend=$(element).attr('id').replace('user','');
		friendMessage={message:<?="'".$_SESSION['data-user']['name']."'"?>+' '+<?="'".$_SESSION['data-user']['surname']."'"?>+' хочет добавить вас в друзья',
					   myid:<?="'".$_SESSION['data-user']['id']."'"?>,
					   idFriend:$idFriend,
					   root:$(element).attr('name')};
		$.ajax({
			url:document.location.origin+"/mathtest/addFriend.php",
			cache:false,
			dataType:'json',
			data:friendMessage,
			type:'POST',
			error:function(){console.log('error')},
			success:function(){console.log(data);
				$(element).val('Заявка отправлена').prop('disabled', true);
			}
		});
	}
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
						<input type="search" class="search_bar" onkeyup="searchControl(this)" onchange="searchControl(this)">
						<input type="button" class="search_send_title" value="Поиск" onclick="searchPeople()">
					
					</div>
					
				</div>
			</div>
			<div id="left_block" class="left_block">
					<div class="search_send">
						
						<input type="button" value="Друзья" onclick="callbackFunction(this.value)">
						<input type="button" value="Мир" onclick="callbackFunction(this.value)">
					</div>
				<p>Друзья</p>
				<label for="friends">Группа</label>
				<select id="friends">
					<option label="Все друзья"></option>
					<option label="Студенты"></option>
					<option label="Преподаватели"></option>
				</select>
				<ul id="friendsList">
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
			  	<div class="open_notifications_body">
				  	<a href="#m5">Оповещения
					  	<div class="notifications">

							<div class="notific_num">
								<p>99+</p>
							</div>
					  	</div>	
					</a>

					<div class="notifications_body" style="display: none;">
						<div class="notifications_bar">
							<p class="text_notifications_bar">Привет</p>
						</div>
					</div>
				</div>

			  </li>
			 </ul>
			 
			</nav><!--menu1-->
			<div class="profile">
				<?php
					if (isset($_SESSION['data-user']['name'])&&isset($_SESSION['data-user']["surname"])):?>
						
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
	
								
								<a class="load_avatar_close" href="">X</a>
							</div>

							
						</div>
						<div class="profile_avatar load_avatar_open">
							<p class="plus_photo">+</p>
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