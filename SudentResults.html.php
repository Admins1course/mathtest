<?php require_once 'includes/db.inc.php';
	  require_once 'registration_control.php';
	  require_once 'includes/incl_session.inc.php';
	  include_once 'includes/getUserImage.inc.php';
	  require_once 'includes/getFriends.inc.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Cache-Control" content="no-cache" charset="UTF-8">
    <link rel="shortcut icon" href="style/img/LOGO.png" type="image/x-icon">
	<link rel="stylesheet" href="style/Cssforprofile.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="style/Main.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="style/Cssforindex.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="style/CssforDialogWindow.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="style/CssForStudentsResults.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
	    hg=hg+750+'px';
	    $('body').height(hg);
	});
	</script>
	<script src="js/load_avatars.js?<?=time();?>"></script>
	<script src="js/create_invite_window_script.js?<?=time();?>"></script>
</head>
<body style="position: relative;">
	<?php include 'includes/create_invite_window.php'?>
	<div id="Student_Info_Div">
		<div id="Student_Info_title">
			<div id="Student_Info">
				<div id="Student_img_title">
					<div id="Student_img">
						
					</div>
				</div>
				<div id="Student_Info_title_div">	
					<div id="Student_Info_title_elemsnts">	
						<div id="Student_left_block_elemsnts">
							<div id="Student_left_block_elemsnts_name_title">
								<div id="Student_left_block_elemsnts_name">
									
								</div>
							</div>
							<div id="Student_left_block_elemsnts_info_title">
								<div id="Student_left_block_elemsnts_info_div">
									
								</div>
							</div>
						</div>
						<div id="Student_right_block_elemsnts" >
							<div id="Student_right_block_elemsnts_info_title">
								
							</div>
						</div>
						
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<div id="page">
		<div id="main_content" style="height: auto;">
			<div id="table_div">
				<div id="table_title">
					<table>
						<tr><th class="first_level">Данные</th><th class="first_level">Результаты</th><th class="first_level">Результаты</th></tr>
						<tr><td>Данные</td><td>Данные</td><td>Данные</td></tr>
						<tr><td>Данные</td><td>Данные</td><td>Данные</td></tr>
						<tr><td>Данные</td><td>Данные</td><td>Данные</td></tr>
						<tr><td>Данные</td><td>Данные</td><td>Данные</td></tr>
						<tr><td>Данные</td><td>Данные</td><td>Данные</td></tr>
						<tr><td>Данные</td><td>Данные</td><td>Данные</td></tr>
						<tr><td>Данные</td><td>Данные</td><td>Данные</td></tr>
					</table>
				</div>
			</div>
			
		</div>
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