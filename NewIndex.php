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
		let openMenu = document.getElementById('openMenu');
		let openMenuLocation = document.getElementById('openMenu').style.marginLeft;
			$('#arrowPickDiv, #NavMenuIndexSignInDivText').click(function() {
				
				if (document.getElementById('openMenu').style.marginLeft!='50%') {
					document.getElementById("arrowPickDiv").innerHTML = '<i style="font-size: 70px;" class="fa fa-caret-right arrowPick" aria-hidden="true"></i>'; 
					openMenu.animate([
					  {marginLeft : "98%"},
					  {marginLeft : "50%"}
					], {
					  duration: 1000,
					  iteration: 2,
					  delay: 100,
					});
					function getLocateOpenMenuLeft(){
					let openMenuLocation = document.getElementById('openMenu').style.marginLeft;
			   		document.getElementById('openMenu').style.marginLeft = '50%';
			   		
			   		console.log(openMenuLocation);
			    }
			    setTimeout(getLocateOpenMenuLeft, 1000);
				}
				else{
					document.getElementById("arrowPickDiv").innerHTML = '<i style="font-size: 70px;" class="fa fa-caret-left arrowPick" aria-hidden="true"></i>';
					openMenu.animate([
					  {marginLeft : "50%"},
					  {marginLeft : "98%"}
					], {
					  duration: 1000,
					  iteration: 2,
					  delay: 100,
					});
					function getLocateOpenMenuRight(){
					let openMenuLocation = document.getElementById('openMenu').style.marginLeft;
			   		document.getElementById('openMenu').style.marginLeft = '98%';
			   		
			   		console.log(openMenuLocation);
			    }
			    setTimeout(getLocateOpenMenuRight, 1000);
				}
				
			});
			
		});

</script>

<script>
	$(function (){
		let num2 = 1;
	
		   	
	$(window).scroll(function(){
	if($(window).scrollTop()>400){
		if (num2==1) {
			num2=0;
		let div = document.getElementById('site_title_image');
			let style = getComputedStyle(document.querySelector('#site_title_image'));
			let divInfo = document.getElementById('site_title_info');
			let styleInfo = getComputedStyle(document.querySelector('#site_title_info'));
			   div.animate([
				  {left: "1200px"},
				  {left: "800px"}
				], {
				  duration: 500,
				  iteration: 2,
				  delay: 1000,
				});

		   function getLocate(){
		   		document.getElementById('site_title_image').style.left = '800px';
		   }

		   setTimeout(getLocate, 1500);

		   function animateInfoDiv(){
			   	divInfo.animate([
				  {left: "-680px"},
				  {left: "50px"}
				], {
				  duration: 500,
				  iteration: 2,
				  delay: 1000,
				});
			}

		   setTimeout(animateInfoDiv, 500);

		   function getLocateInfoDiv(){
		   		document.getElementById('site_title_info').style.left = '50px';
		   		console.log(divInfo);
		   }
		   setTimeout(getLocateInfoDiv, 2000);
		}
		//if($(window).scrollTop()<300){
		//$('.FirstInfoElementsDiv').slideUp(2000)
		//}
	}
	})})

</script>
<script>
	$(window).scroll(function(){
	if($(window).scrollTop()>1000){
	$('.FirstInfoElementsDiv:eq(0)').slideDown(500, function(){
		$(this).next().slideDown(500, arguments.callee);
	});
	}
	//if($(window).scrollTop()<300){
	//$('.FirstInfoElementsDiv').slideUp(2000)
	//}
})
</script>
<script>
	$(function (){
		let divInfo1 = document.getElementById('FirstInfoDivElement');
		let divInfo2 = document.getElementById('SecondInfoDivElement');
		let divInfo3 = document.getElementById('ThirdInfoDivElement');
		let num1 = 1;
	
	 function InfoDiv21(){
		   	
		}
	
	$(window).scroll(function(){
	if($(window).scrollTop()>1600){
		if (num1==1) {
			num1=0;
			console.log(num1);
			console.log(divInfo1);
			divInfo1.animate([
			  {top: "-520px"},
			  {top: "0px"}
			], {
			  duration: 500,
			  iteration: 2,
			  delay: 1000,
			});
				setTimeout(getLocatedivInfoSecond1, 1000);
		 	function getLocatedivInfoSecond1(){
		   		document.getElementById('FirstInfoDivElement').style.top = '0px';

		   }
		   divInfo2.animate([
			  {top: "520px"},
			  {top: "0px"}
			], {
			  duration: 500,
			  iteration: 2,
			  delay: 1000,
			});
				setTimeout(getLocatedivInfoSecond2, 1000);
		 	function getLocatedivInfoSecond2(){
		   		document.getElementById('SecondInfoDivElement').style.top = '0px';

		   }
		   divInfo3.animate([
			  {top: "-520px"},
			  {top: "0px"}
			], {
			  duration: 500,
			  iteration: 2,
			  delay: 1000,
			});
				setTimeout(getLocatedivInfoSecond3, 1000);
		 	function getLocatedivInfoSecond3(){
		   		document.getElementById('ThirdInfoDivElement').style.top = '0px';

		   }
		}
		
	}
	
})
	})
	
</script>
<script>
	$(function (){
		let divInfo1 = document.getElementById('startAnimation');
		let divInfo2 = document.getElementById('clickmeDiv');
		let divInfoleft = document.getElementById('ThirdInfoLeftDivTitle');
		let divInforight = document.getElementById('ThirdInfoRightDivTitle');
			$('#startAnimation').click(function() {
				divInfo1.animate([
				  {top: "-550px"},
				  {top: "-1500px"}
				], {
				  duration: 1500,
				  iteration: 2,
				  delay: 100,
				});
				divInfo2.animate([
				  {top: "0px"},
				  {top: "1700px"}
				], {
				  duration: 1500,
				  iteration: 2,
				  delay: 100,
				});
				divInfoleft.animate([
				  {right: "670px"},
				  {right: "-40px"}
				], {
				  duration: 1500,
				  iteration: 2,
				  delay: 100,
				});
				divInforight.animate([
				  {left: "670px"},
				  {left: "-40px"}
				], {
				  duration: 1500,
				  iteration: 2,
				  delay: 100,
				});
				setTimeout(getLocatecircul, 1500);
		 	function getLocatecircul(){
		   		document.getElementById('startAnimation').style.top = '-550px';
		   		document.getElementById('startAnimation').style.display = 'none';
		   		document.getElementById('ThirdInfoLeftDivTitle').style.right = '-40px';
		   		document.getElementById('ThirdInfoRightDivTitle').style.left = '-40px';

		   }
		   setTimeout(getLocatetext, 1000);
		 	function getLocatetext(){
		   		document.getElementById('clickmeDiv').style.top = '1100px';

		   }
				});	
			
		});
</script>
<?php include 'includes/bubbleText.js.php';?>
<script>
$(document).ready(function() {    
    var $element = $('#animateText');
    var newText = 'MathTest - Сайт для тестирования студентов';
    bubbleText({
        element: $element,
        newText: newText,
        speed: 500,
        repeat: Infinity,
        timeBetweenRepeat: 10000,
    });
})
</script>



<!--<script>
	window.onscroll = function() {
	posLeft = (window.pageXOffset !== undefined) ? window.pageXOffset : (document.documentElement || document.body.parentNode || document.body).scrollLeft;
	posTop = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
	if (posTop>=600 && posTop<=700) {
		console.log(posTop);
	}
}
</script>-->


	
</head>
<body style="position: relative; background-color: white;">
	<div id="NavMenuIndexDiv">
		<div id="NavMenuIndexDivTitle">
			<div id="NavMenuIndexInfo">
				
			</div>
			<div id="NavMenuIndexSignIn">
				<div id="NavMenuIndexSignInDivText">
					<p id="NavMenuIndexSignInText">
						Меню <i class="fa fa-bars" aria-hidden="true"></i>
					</p>
				</div>
			</div>
		</div>
	</div>
	<div id="BanerDivTitle">
		<div id="BanerDiv">
			<div id="BanerDivBody">
				<div id="BanerDivText">
					<div id="animateText">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="openMenu">
		<div id="arrowPickDiv">
			<i style="font-size: 70px;" class="fa fa-caret-left arrowPick" aria-hidden="true"></i>
		</div>
		<div id="MenuDivTitle">
			<div id="MenuDivContainer">
				<div id="MenuDivContainerElements">
					<div id="MenuDivContainerElementsTitle">
						
					</div>
					<div class="MenuDivContainerElementsDiv">
						<div class="MenuDivContainerElementsTextDiv">
							<div class="MenuDivContainerElementsText">
								<a href="" class="MenuElementsText">
									
								</a>
							</div>
						</div>
					</div>
					<div class="MenuDivContainerElementsDiv">
						<div class="MenuDivContainerElementsTextDiv">
							<div class="MenuDivContainerElementsText">
								<a href="users_data.html.php" class="MenuElementsText">
									Регистрация
								</a>
							</div>
						</div>
					</div>
					<div class="MenuDivContainerElementsDiv">
						<div class="MenuDivContainerElementsTextDiv">
							<div class="MenuDivContainerElementsText">
								<a href="nevEnter.html.php" class="MenuElementsText">
									Войти
								</a>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
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
						<div class="FirstInfoElementsTitleDiv">
							<div class="FirstInfoElementsTitle">
								
							</div>
						</div>
						<div class="FirstInfoElementsInfo">
							
						</div>
					</div>
				</div>
				<div class="FirstInfoElementsDiv">
					<div class="FirstInfoElements">
						<div class="FirstInfoElementsImg">
							
						</div>
						<div class="FirstInfoElementsTitleDiv">
							<div class="FirstInfoElementsTitle">
								
							</div>
						</div>
						<div class="FirstInfoElementsInfo">
							
						</div>
					</div>
				</div>
				<div class="FirstInfoElementsDiv">
					<div class="FirstInfoElements">
						<div class="FirstInfoElementsImg">
							
						</div>
						<div class="FirstInfoElementsTitleDiv">
							<div class="FirstInfoElementsTitle">
								
							</div>
						</div>
						<div class="FirstInfoElementsInfo">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="SecondInfoDivTitle">
		<div id="SecondInfoDiv">
			<div id="SecondInfoDivElements">
				<div class="SecondInfoDivElementsTitle ">
					<div class="SecondInfoDivElementsDiv " id="FirstInfoDivElement">
						
					</div>
				</div>
				<div class="SecondInfoDivElementsTitle ">
					<div class="SecondInfoDivElementsDiv " id="SecondInfoDivElement">
						
					</div>
				</div>
				<div class="SecondInfoDivElementsTitle ">
					<div class="SecondInfoDivElementsDiv " id="ThirdInfoDivElement">
						
					</div>
				</div>
			</div>
		</div>
	</div>


	<div id="ThirdInfoDivTitle">
		<div id="ThirdInfoAllDivTitle">
			<div id="ThirdInfoRightAndLeftDivTitle">
				<div id="ThirdInfoLeftDivTitle">
				
				</div>
				<div id="ThirdInfoRightDivTitle">
					
				</div>
			</div>
			
			<div id="startAnimation" class="text_fade">
				<div id="clickmeDiv">
					<p id="clickme">CLICK ME</p>
				</div>
			</div>
			
		</div>
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