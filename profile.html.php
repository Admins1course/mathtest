<?php require_once 'includes/db.inc.php';
	  require_once 'registration_control.php';
	  require_once 'includes/incl_session.inc.php';
	  include_once 'includes/getUserImage.inc.php';
	  require_once 'includes/getFriends.inc.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Cache-Control" content="no-cache" charset="UTF-8">

	<link rel="stylesheet" href="style/Main.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="style/Cssforindex.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="style/CssforDialogWindow.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="style/Cssforprofile.css?<?=time()?>" type="text/css">
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
   
	<script src="js/load_avatars.js?<?=time();?>"></script>
	<script src="js/create_invite_window_script.js?<?=time();?>"></script>
</head>
<body>
	<?php include 'includes/create_invite_window.php'?>
	<?php include 'includes/nav_menu.php';?>
	<div id="main_content_div">
		<div id="profile_div">
			<div id="profile_block">
				<div id="profile_title_div">
					<div id="profile_title">
						
					</div>
					
				</div>
				<div id="profile_img_block">
					<div id="profile_img">
						
					</div>
					
				</div>
				<div id="profile_elements_div">
					<div class="profile_elements_all">
						<div class="profile_elements">
							
						</div>

					</div>
					<div class="profile_elements_all">
						<div class="profile_elements">
							
						</div>
						
					</div>
					<div class="profile_elements_all">
						<div class="profile_elements">
							
						</div>
						
					</div>
					<div class="profile_elements_all">
						<div class="profile_elements">
							
						</div>
						
					</div>
					<div class="profile_elements_all">
						<div class="profile_elements">
							
						</div>
						
					</div>
					
				</div>
				<div id="profile_footer_div">
					<div id="profile_footer">
						
					</div>
					
				</div>
			</div>
			
		</div>
	</div>
</body>
	<div id="footer">
			<div class="text">
				2020
			</div>
		</div>
</html>