<?php require_once 'includes/db.inc.php';
	  require_once 'book_control.php';
	  require_once 'result_of_test_handler.php';
	  session_start();
	   if (!isset($_SESSION['data-user'])){
		  if ($_COOKIE['name']){//достаточно name, чтобы были и остальные
			  $_SESSION['data-user']['id']=$_COOKIE['id'];
			  $_SESSION['data-user']['name']=$_COOKIE['name'];
			  $_SESSION['data-user']['surname']=$_COOKIE['surname'];
			  $_SESSION['data-user']['root']=$_COOKIE['root'];
		  }
	  }?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Cache-Control" content="no-cache" charset="UTF-8">
	<link rel="stylesheet" href="style/Main.css" type="text/css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" id="MathJax-script" async
			src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js">
	</script>

	<?php include 'includes/script_for_nav_menu.php';?>
	
	<script>
		$(document).ready(function(){
			$('#result').click(function(){
				$('#tasks').slideToggle();
			})
		})
	</script>

</head>
<body style="height: 2000px;">
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
							<p class="question"><?=$dataTest[$i]["total_task"]?></p>
							<textarea class="answer" name="answers[task<?=$i?>]" onchange="registeringResponses()"></textarea>
							<p>Получено баллов за задание: <?=$right_answers[$i-1][1]?></p>
						</div>
					<?php } 
					if ($dataTest[$i]["answer"]["input"]!=0){?>
						<div class="task input <?=$i?>">
							<p class="question"><?=$dataTest[$i]["total_task"]?></p>
							<p
								<?php if ($right_answers[$i-1][0]):
										echo 'style="background-color:green"';
									else:
										echo 'style="background-color:red"';
									endif;?>>
								<?=$_POST['answers']['task'.$i]?>
							</p>
							<p>Получено баллов за задание: <?=$right_answers[$i-1][1]?></p>
						</div>
					<?php } 
					if ($dataTest[$i]["answer"]["radio"]!=0){?>
						<div class="task radio <?=$i?>">
							<p class="question"><?=$dataTest[$i]["total_task"]?></p>
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
										<?=$dataTest[$i]["answer"]["radio"][$j]["text_answer"]?>
									</p>
								</div>
							<?php } ?>
							<p>Получено баллов за задание: <?=$right_answers[$i-1][1]?></p>
						</div>
					<?php } 
						if ($dataTest[$i]["answer"]["checkbox"]!=0){?>
							<div class="task checkbox <?=$i?>">
								<p class="question"><?=$dataTest[$i]["total_task"]?></p>
								<?php for ($j=1; $j<=count($dataTest[$i]["answer"]["checkbox"]);$j++){?>
									<div class="checkbox">
										<input type="checkbox" class="checkbox_answer" name="answers[task<?=$i?>][<?=$j?>]"
										value="<?=$dataTest[$i]["answer"]["checkbox"][$j]["text_answer"]?>" onchange="registeringResponses()">
										<p class="possibleAnswer"><?=$dataTest[$i]["answer"]["checkbox"][$j]["text_answer"]?></p>
									</div>
								<?php } ?>
								<p>Получено баллов за задание: <?=$right_answers[$i-1][1]?></p>
							</div>
					<?php } ?>
				<?php } ?>
			</div>
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
		<div id="right_block_title"></div>
		<div id="right_block">

		</div>
		<div id="left_block_title"></div>
		<div id="left_block" class="left_block">

		</div>
		<?php include 'includes/nav_menu.php';?>
	
	
	
	<div id="footer">
		<div class="text">
			2020
		</div>
	</div>
</body>
</html>