<?php require_once 'includes/db.inc.php';
	  require_once 'includes/incl_session.inc.php';
	  require_once 'includes/checkSession.inc.php';
	  include_once 'includes/getUserImage.inc.php';
	  require_once 'includes/getFriends.inc.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Cache-Control" content="no-cache" charset="UTF-8">
	<link rel="stylesheet" href="style/Main.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="style/Cssforindex.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="style/CsslistTest.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="style/CssforDialogWindow.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<?php
	if ($path){
	    include_once 'includes/load_user_image.inc.php';
	}
	?>
	<?php if ($is_login):?>
		<script src="js/notifs.js?<?=time();?>"></script>
	<?php endif;?>
	<?php include 'includes/searchPeople.js.inc.php';
	      include 'includes/friendsControl.js.inc.php';?>
	<?php include 'includes/script_for_nav_menu.php';?>	
	<script type='text/javascript'>
	$(document).ready(function (){
	    var hg=$('#main_content').height();
	    hg=hg+550+'px';
	    $('body').height(hg);
	});
	</script>
	<script>
	$(document).on('click', '.div_list', function (e) {
		e=e||window.event;
		var $checkbox = $(':checkbox', this);
		if (e.target !== $checkbox[0]) {
			$checkbox.prop('checked', !$checkbox.prop('checked'));
		}
	});
	</script>
	<script>
	$(document).on('click', '.div_list', function (e) {
		$(this).toggleClass('test_href_min');
		$(this).toggleClass('test_href');
	});
	</script>
	<?php if($is_login):?>
	<script src="js/load_avatars.js?<?=time();?>"></script>
	<script src="js/create_invite_window_script.js?<?=time();?>"></script>
	<?php endif;?>
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
			<div id="main_content">
			<?php 
			$sql='SELECT idAuthor,idTest,taskName FROM tests';
			$result=$pdo->query($sql);
			$tests=$result->fetchAll(PDO::FETCH_ASSOC);
			for($i=0;$i<count($tests);$i++){
				$sql="SELECT name,surname FROM users WHERE id=:idAuthor";
				$result=$pdo->prepare($sql);
				$result->execute(['idAuthor'=>$tests[$i]['idAuthor']]);
				$users=$result->fetchAll(PDO::FETCH_ASSOC);?>
				<a href="book.html.php?idUser=<?=$tests[$i]['idAuthor']?>&idTest=<?=$tests[$i]['idTest']?>">	
					<div class="test_href" style="background: linear-gradient(0deg, rgba(255,145,0,1) 0%, rgba(255,255,255,0) 69%);">
						<p>Название: <?=htmlspecialchars($tests[$i]['taskName']);?></p>
						<p>Автор: <?=htmlspecialchars($users[0]['name'])?> <?=htmlspecialchars($users[0]['surname'])?></p>
					</div>
				</a>
			<?php }?>
			</div>
			<div id="right_block">
				<ul class="testlist">
				<?php 
				$sql='SELECT `subject` from `subjects`';
				$result=$pdo->query($sql);
				$subjects=$result->fetchAll(PDO::FETCH_ASSOC);
				for ($i=0;$i<count($subjects);$i++):
				?>
					<li class="test_name"><a href="" class="test_title"><?=htmlspecialchars($subjects[$i]['subject'])?></a></li>
				<?php endfor;?>
				</ul>
			</div>
				<div id="left_block_title">
					<?php require_once "includes/searchInput.inc.php";?>
				</div>
				<div id="left_block" class="left_block">
					<?php require_once "includes/friendsList.inc.php";?>
				</div>
	<?php include 'includes/nav_menu.php';?>
		<div id="footer">
			<div class="text">
				2020
			</div>
		</div>
	
</body>
</html>