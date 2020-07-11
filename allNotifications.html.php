<?php require_once 'includes/db.inc.php';
	  require_once 'includes/incl_session.inc.php';
	  require_once 'handlers/allNotifications_handler.php';
	  require_once 'includes/getUserImage.inc.php';
	  require_once 'includes/getFriends.inc.php';
	  ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Cache-Control" content="no-cache" charset="UTF-8">

	<link rel="stylesheet" href="style/Main.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="style/Cssforindex.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>	
	<script src="js/notifs.js?<?=time();?>"></script>
	<script src="js/load_avatars.js?<?=time();?>"></script>
	<script src="js/create_invite_window_script.js?<?=time();?>"></script>
	<?php
	  if (isset($path)){
	    require_once 'includes/load_user_image.inc.php';
	  }
	  require_once 'includes/searchPeople.js.inc.php';
	  require_once 'includes/friendsControl.js.inc.php';
      require_once 'includes/script_for_nav_menu.php';
	?>
    <script type='text/javascript'>
	$(function (){
	    var hg=$('body').height();
	    hg=hg+550+'px';
	    $('body').height(hg);
	});
	</script>
</head>
<body>
	<?php require_once 'includes/create_invite_window.php';?>
	<div id="page">
		<div id="main_content" style="height: auto;">
		<?php for($i=0;$i<count($data['notif']);$i++){
			if ($data['notif'][$i]['add_friends']):?>
				<div class="notifications_bar">
					<p class="text_notifications_bar"><?=htmlspecialchars($data['notif'][$i]['dateOfSend'])?> <?=htmlspecialchars($data['notif'][$i]['message'])?>
					<?php if(!in_array($data['notif'][$i]['add_friends'],$data['friends'])):?>
					</p>
					<div class="button_friend">
						<input type="button" id="userId<?=htmlspecialchars($data['notif'][$i]['add_friends'])?>" value="Принять" onclick="acceptApp(this)">
						<input type="button" id="userId<?=htmlspecialchars($data['notif'][$i]['add_friends'])?>" value="Отменить" onclick="cancelApp(this)">
					</div>
					<?else:?>
					Вы приняли заявку.</p>
					<?php endif;?>
				</div>
			<?php else:?>
				<div class="notifications_bar">
					<p class="text_notifications_bar"><?=htmlspecialchars($data['notif'][$i]['dateOfSend'])?></p>
					<div class="button_friend">
						<a href="<?=htmlspecialchars($data['notif'][$i]['invitations'])?>&recipient=<?=htmlspecialchars($data['notif'][$i]['recipient'])?>">Перейти к прохождению теста</a>
					</div>
				</div>
			<?php endif;?>
		<?php }?>
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
				<?php require_once "includes/searchInput.inc.php";?>
			</div>
			<div id="left_block" class="left_block">
				<?php require_once "includes/friendsList.inc.php";?>
			</div>
			<?php require_once 'includes/nav_menu.php';?>
</body>
	<div id="footer">
			<div class="text">
				2020
			</div>
		</div>
</html>