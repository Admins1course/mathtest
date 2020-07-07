<?php require_once 'includes/db.inc.php';
	  require_once 'includes/incl_session.inc.php';
	  require_once 'includes/checkSession.inc.php';
	  require_once 'book_control.php';
	  require_once 'result_of_test_handler.php';
	  include_once 'includes/getUserImage.inc.php';
	  require_once 'includes/getFriends.inc.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Cache-Control" content="no-cache" charset="UTF-8">
	<link rel="stylesheet" href="style/Main.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="style/forresult.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" id="MathJax-script" async
			src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js">
	</script>
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
	<script>
		$(document).ready(function(){
			$('#result').click(function(){
				$('#tasks').stop().slideToggle();
			})
		})
	</script>
	<script type='text/javascript'>
	$(function (){
	    var hg=$('#main_content').height();
	    hg=hg+550+'px';
	    $('body').height(hg);
	});
	</script>
	<script src="js/load_avatars.js?<?=time();?>"></script>
	<script src="js/create_invite_window_script.js?<?=time();?>"></script>
</head>
<body >
	<?php include 'includes/create_invite_window.php'?>
	<div id="page">
			<div class="forNewFormulas" style="display:none">
			$$
				\newcommand{\tg}{\mathop{\rm tg}\nolimits}
				\newcommand{\arctg}{\mathop{\rm arctg}\nolimits}
				\newcommand{\tgh}{\mathop{\rm tgh}\nolimits}
				\newcommand{\ctg}{\mathop{\rm ctg}\nolimits}
				\newcommand{\arcctg}{\mathop{\rm arcctg}\nolimits}
				\newcommand{\ctgh}{\mathop{\rm ctgh}\nolimits}
				\newcommand{\cosec}{\mathop{\rm cosec}\nolimits}
				\newcommand{\e}{\mathop{\rm e}\nolimits}
				\renewcommand{\Re}{\mathop{\rm Re}\nolimits}
				\renewcommand{\Im}{\mathop{\rm Im}\nolimits}
			$$
		</div>
		<div id="main_content">
			<p>Результат прохождения теста:</p>
			<p>Решено заданий: <?=$count?> из <?=$_POST["answers"]["count"]?></p>
			<p>Получено баллов: <?=$countOfPoints?> из <?=$allPoints?></p>
			<p>Ваша оценка: <?=$mark?></p>
			<input type="button" id="result" value="Посмотреть результаты">
			<div id="tasks" style="display:none">
				<?php for ($i=1;$i<=count($dataTest);$i++){
					if ($dataTest[$i]["answer"]["textarea"]!=0){?>
						<div class="task textarea <?=$i?>">
							<?php question($i,$dataTest[$i]);?>
							<textarea class="answer" name="answers[task<?=$i?>]" onchange="registeringResponses()"></textarea>
							<p>Получено баллов за задание: <?=htmlspecialchars($right_answers[$i-1][1])?></p>
						</div>
					<?php } 
					if ($dataTest[$i]["answer"]["input"]!=0){?>
						<div class="task input <?=$i?>">
							<?php question($i,$dataTest[$i]);?>
							<p
								<?php if ($right_answers[$i-1][0]):
										echo 'style="background-color:green"';
									else:
										echo 'style="background-color:red"';
									endif;?>>
								<?=htmlspecialchars($_POST['answers']['task'.$i])?>
							</p>
							<p>Получено баллов за задание: <?=htmlspecialchars($right_answers[$i-1][1])?></p>
						</div>
					<?php } 
					if ($dataTest[$i]["answer"]["radio"]!=0){?>
						<div class="task radio <?=$i?>">
							<?php question($i,$dataTest[$i]);?>
							<?php for ($j=1; $j<=count($dataTest[$i]["answer"]["radio"]);$j++){?>
								<div class="radio">
									<p class="possibleAnswer" 
									<?php if($_POST['answers']['task'.$i]===$dataTest[$i]['answer']['radio'][$j]['text_answer']):
											if ($right_answers[$i-1][0]):
												echo 'style="background-color:green"';
											else:
												echo 'style="background-color:red"';
											endif;
										  endif;
									?>>
										<?=htmlspecialchars($dataTest[$i]["answer"]["radio"][$j]["text_answer"])?>
									</p>
								</div>
							<?php } ?>
							<p>Получено баллов за задание: <?=htmlspecialchars($right_answers[$i-1][1])?></p>
						</div>
					<?php } 
					if ($dataTest[$i]["answer"]["checkbox"]!=0){?>
						<div class="task checkbox <?=$i?>">
							<?php question($i,$dataTest[$i]);?>
							<?php for ($j=1; $j<=count($dataTest[$i]["answer"]["checkbox"]);$j++){?>
								<div class="checkbox">
									<p class="possibleAnswer"
									<?php if($_POST['answers']['task'.$i][$j]===$dataTest[$i]['answer']['checkbox'][$j]['text_answer']):
											if ($right_answers[$i-1][0]):
												echo 'style="background-color:green"';
											else:
												echo 'style="background-color:red"';
											endif;
										  endif;
									?>>
										<?=htmlspecialchars($dataTest[$i]["answer"]["checkbox"][$j]["text_answer"])?>
									</p>
								</div>
							<?php } ?>
							<p>Получено баллов за задание: <?=htmlspecialchars($right_answers[$i-1][1])?></p>
						</div>
				<?php } 
				}?>
				</div>
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
		<div id="right_block_title"></div>
		<div id="right_block">
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