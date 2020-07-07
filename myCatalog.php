<?php require_once 'includes/db.inc.php';
	  require_once 'includes/incl_session.inc.php';
	  include_once 'includes/getUserImage.inc.php';
	  require_once 'includes/getFriends.inc.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Cache-Control" content="no-cache" charset="UTF-8">
	<link rel="stylesheet" href="style/Main.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="style/Cssforprofile.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="style/Cssforindex.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="style/CssforDialogWindow.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="style/CsslistTest.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<?php include 'includes/script_for_nav_menu.php';?>	
	<?php
	if ($path){
	    include_once 'includes/load_user_image.inc.php';
	}
	?>
	<?php if (isset($_SESSION['data-user'])):
	    include 'includes/searchPeople.js.inc.php';
	    include 'includes/friendsControl.js.inc.php';?>
		<script src="js/notifs.js?<?=time();?>"></script>
	<?php endif;?>
	<script type='text/javascript'>
	$(function(){
	    let hg=$('body').height();
	    let main=$('#main_content').height();
	    console.log($('#main_content').height());
	    hg=hg+900+'px';
	    $('body').height(hg);
	});
	</script>
	<script type='text/javascript'>
		$(document).ready(function(){
			$('#result').click(function(){
				$('#tasks').stop().slideToggle();
				bodyHeight();
			})
		})
	function bodyHeight(){
	    let hg=$('body').height();
	    let main=$('#main_content').height();
	    let tasks=$('#tasks').height();
	    let normal = 1490+'px';
	    console.log($('#tasks').height());
	    if($('body').height()<2000){
	    		hg=hg+600+'px';
	    		$('body').height(hg);
	    }
	    else{
	    	$('body').height(normal);
	    }
	};
	</script>
	<script src="js/load_avatars.js?<?=time();?>"></script>
	<script src="js/create_invite_window_script.js?<?=time();?>"></script>
</head>
<body >
	<?php include 'includes/create_invite_window.php'?>
	<div id="page">
	</div>
	
			<div class="slider midle">
				<div class="slides">
					<input type="radio" name="r" id="r1" checked>
					<input type="radio" name="r" id="r2" >
					<input type="radio" name="r" id="r3" >
					<input type="radio" name="r" id="r4" >

					<div class="slide s1"> <img src="style/img/FonBooks.png" alt=""></div>
					<div class="slide"> <img src="style/img/books.png" alt=""></div>
					<div class="slide"> <img src="style/img/rtx.png" alt=""></div>
					<div class="slide"> <img src="style/img/Artem.png" alt=""></div>
				</div>

				<div class="navigation">
					<label for="r1" class="bar"></label>
					<label for="r2" class="bar"></label>
					<label for="r3" class="bar"></label>
					<label for="r4" class="bar"></label>
				</div>
			</div>
			<div id="plus_inform">
				<div class="search_area_list">
					<div class="search_list">
						<input type="text" class="search_bar_list">	
					</div>
					<div class="search_send_list">
						<input type="button" class="search_send_title active_btn" value="Поиск">
					</div>
				</div>
			</div>
			<div id="main_content" style="height: auto; max-height: 600px; overflow-y:scroll; ">
			<?php 
			$sql='SELECT idTest,taskName FROM tests WHERE idAuthor='.$_SESSION['data-user']['id'];
			$result=$pdo->query($sql);
			$tests=$result->fetchAll(PDO::FETCH_ASSOC);
			for($i=0;$i<count($tests);$i++):?>
			<a href="book.html.php?idUser=<?=$_SESSION['data-user']['id']?>&idTest=<?=$tests[$i]['idTest']?>">
				<div class="test_href" style="background: linear-gradient(0deg, rgba(255,145,0,1) 0%, rgba(255,255,255,0) 69%);">
					<p>Название: <?=$tests[$i]['taskName'];?></p>
					<p>Автор: <?=$_SESSION['data-user']['name']?> <?=$_SESSION['data-user']['surname']?></p>
				</div>
			</a>
			<?php endfor;?>
			</div>
			<div id="right_block">
				<ul class="testlist">
					<li class="test_name"><a href="" class="test_title">Математический анализ</a></li>
					<li class="test_name"><a href="" class="test_title">Интегральные и дифферинциальные уравнения</a></li>
					<li class="test_name"><a href="" class="test_title">Прикладная математика</a></li>
				</ul>
			</div>
				<div id="left_block_title">
					<?php require_once "includes/searchInput.inc.php";?>
				</div>
				<div id="left_block" class="left_block">
					<?php require_once "includes/friendsList.inc.php";?>
				</div>
	<?php include 'includes/nav_menu.php';?>
		
</body>
<div class="footerMain">
		<div class="footerWeight">
			<footer>
					<ul>
						<li>
							<p class="main">Главная </p>
							<a class="siteImage" href="#">MathTest <i>&copy; 2020</i></a>
						</li>
						<li>
							<p class="reachus">Контакты </p>

							<ul>
								<li><a href="#">Email <i class="fa fa-envelope-o" aria-hidden="true"></i></a></li>
								<li><a href="#">Vk <i class="fa fa-vk" aria-hidden="true"></i></a></li>
								<li><a href="#">Facebook <i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a href="">Номер можно <i class="fa fa-phone" aria-hidden="true"></i></a></li>
							</ul>
						</li>
						<li>
							<p class="clients">Пользователи </p>

							<ul>
								<li><a href="#">Войти <i class="fa fa-sign-in" aria-hidden="true"></i></a></li>
								<li><a href="#">Поддержка <i class="fa fa-info" aria-hidden="true"></i></a></li>
								<li><a href="#">FAQ <i class="fa fa-question" aria-hidden="true"></i></a></li>
							</ul>
						</li>
					</ul>
			</footer>
		</div>
	</div>
</html>