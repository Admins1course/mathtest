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
	<link rel="stylesheet" href="style/CssForNewIndex.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	
    <script type='text/javascript'>
	$(function (){
	    var hg=$('body').height();
	    hg=hg+150+'px';
	    $('body').height(hg);
	});
	</script>

<script>
	$(function (){
		let div = document.getElementById('site_title_image');
		let style = getComputedStyle(document.querySelector('#site_title_image'));
		let divInfo = document.getElementById('site_title_info');
		let styleInfo = getComputedStyle(document.querySelector('#site_title_info'));
		   div.animate([
			  {left: "1200px"},
			  {left: "800px"}
			], {
			  duration: 1000,
			  iteration: 2,
			  delay: 1000,
			});

	   function getLocate(){
	   		document.getElementById('site_title_image').style.left = '800px';
	   }

	   setTimeout(getLocate, 2000);

	   function animateInfoDiv(){
		   	divInfo.animate([
			  {left: "-680px"},
			  {left: "50px"}
			], {
			  duration: 1000,
			  iteration: 2,
			  delay: 1000,
			});
		}

	   setTimeout(animateInfoDiv, 1000);

	   function getLocateInfoDiv(){
	   		document.getElementById('site_title_info').style.left = '50px';
	   }
	   setTimeout(getLocateInfoDiv, 3000);
	   })


</script>


	
</head>
<body style="position: relative;">
	<div id="site_title_div">
		<div id="site_title">
			<div id="site_title_info">

			</div>
			<div id="site_title_image">

			</div>
			
		</div>
	</div>
	<div id="FirstInfoDivTitle">
		<div id="FirstInfoDiv">
			<div id="FirstInfoElementsDiv">
				<div class="FirstInfoElementsDiv">
					<div class="FirstInfoElements">
						<div class="FirstInfoElementsImg">
							
						</div>
						<div class="FirstInfoElementsInfo">
							
						</div>
					</div>
				</div>
				<div class="FirstInfoElementsDiv">
					<div class="FirstInfoElements">
						<div class="FirstInfoElementsImg">
							
						</div>
						<div class="FirstInfoElementsInfo">
							
						</div>
					</div>
				</div>
				<div class="FirstInfoElementsDiv">
					<div class="FirstInfoElements">
						<div class="FirstInfoElementsImg">
							
						</div>
						<div class="FirstInfoElementsInfo">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="SecontInfoDivTitle">
		
	</div>
	<div id="ThirdInfoDivTitle">
		
	</div>
	<div id="FourthInfoDivTitle">
		
	</div>
	
		

		
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