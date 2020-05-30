<?php require_once 'includes/db.inc.php';
	  require_once 'registration_control.php';
	  require_once 'includes/incl_session.inc.php';
	  include_once 'includes/getUserImage.inc.php';
	  require_once 'includes/getFriends.inc.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Cache-Control" content="no-cache" charset="UTF-8">

	<link rel="stylesheet" href="style/Main.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="style/Cssforindex.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
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
    <?php include 'includes/script_for_nav_menu.php';?>
    <script type='text/javascript'>
	$(function (){
	    var hg=$('body').height();
	    hg=hg+550+'px';
	    $('body').height(hg);
	});
	</script>

	<script src="js/load_avatars.js?<?=time();?>"></script>
	<script src="js/create_invite_window_script.js?<?=time();?>"></script>
</head>
<body>
	<?php include 'includes/create_invite_window.php'?>
	<div id="page">
		<div id="main_content" style="height: auto;">
		</div>
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
		</div>
		<div class="all_right_block">
			<div id="right_block_title"></div>
			<div id="right_block"></div>
		</div>
			<div id="left_block_title">
				<?php if($_SESSION['data-user']):?>
				<div class="search_area">
					<div class="search">
						<input type="search" class="search_bar" onkeyup="searchControl(this)" onchange="searchControl(this)">
						<input type="button" class="search_send_title " value="Поиск" onclick="searchPeople()">
						<div class="search_send">

							<input type="button" class="search_type active_btn" value="Друзья" onclick="callbackFunction(this,this.nextElementSibling)">
							<input type="button" class="search_type pasive_btn" value="Мир" onclick="callbackFunction(this,this.previousElementSibling)">
						</div>
					</div>
					
				</div>
				<?php endif;?>
			</div>
			<div id="left_block" class="left_block">
			<?php if($_SESSION['data-user']):?>

					<div class="friends_bar">
						<p>Друзья</p>
					</div>
						<div class="friends_select_div">
							<label for="friends" class="friends_element">Группа</label>
							<select id="friends" class="friends_element friends_select">
								<option label="Все друзья"></option>
								<option label="Студенты"></option>
								<option label="Преподаватели"></option>
							</select>
							<ul class="listOfPeople" id="friendsList">
							<?php if ($friends!=[]):
								for ($i=0;$i<count($friends);$i++):?>
								<li id="userId<?=$friends[$i]['id_Friend']?>"><?=$friends[$i]['name']?> <?=$friends[$i]['surname']?></li>	
							<?php endfor;
							endif;
							?>
							</ul>
							<ul class="listOfPeople" id="searchList" style="display:none">
							</ul>
						</div>
					<?php endif;?>
			</div>
			<?php include 'includes/nav_menu.php';?>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</body>
	<div id="footer">
			<div class="text">
				2020
			</div>
		</div>
</html>