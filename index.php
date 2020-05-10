<?php require_once 'includes/db.inc.php';
	  require_once 'registration_control.php';
	  require_once 'includes/incl_session.inc.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Cache-Control" content="no-cache" charset="UTF-8">

	<link rel="stylesheet" href="style/Main.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="style/Cssforindex.css?<?=time()?>" type="text/css">
	

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>

<script src="js/searchPeople.js"></script>
<script src="js/friendsControl.js"></script>
<script src="js/notifs.js"></script>
<?php include 'includes/script_for_nav_menu.php';?>
</head>
<body style="height: 1500px;">
	<div id="page">
		<div id="main_content" style="height: 700px;">
		</div>
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
			<div id="left_block_title">
				<div class="search_area">
					<div class="search">
						<input type="search" class="search_bar" onkeyup="searchControl(this)" onchange="searchControl(this)">
						<input type="button" class="search_send_title " value="Поиск" onclick="searchPeople()">
					
					</div>
					
				</div>
			</div>
			<div id="left_block" class="left_block">
					<div class="search_send">

						<input type="button" class="search_type" value="Друзья" onclick="callbackFunction(this)">
						<input type="button" class="search_type" value="Мир" onclick="callbackFunction(this)">
					</div>
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
							<ul id="friendsList">
							</ul>
						</div>
			</div>
			<?php include 'includes/nav_menu.php';?>
</body>
	<div id="footer">
			<div class="text">
				2020
			</div>
		</div>
</html>