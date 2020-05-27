<?php require_once "includes/db.inc.php";
	  require_once "book_control.php";
	  require_once 'includes/incl_session.inc.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Cache-Control" content="no-cache" charset="UTF-8">
	<link rel="stylesheet" href="style/Main.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="style/cssforbook.css?<?=time()?>" type="text/css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" id="MathJax-script" async
			src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js">
	</script>
	<?php include 'includes/script_for_nav_menu.php';?>
	<script src="js/answers_of_user.js"></script>
	<script>
		let $className;
		$(document).ready(function(){
			$('.task').not('.task:first').css("display","none");
			$('.zaklad:first').attr('src','style/img/zaclact.png');//темная
			$('.zaklad').click(function(){
				$('.task').css("display","none");
				$('.zaklad').attr('src','style/img/zacl.png'); //светлая
				$(this).attr('src','style/img/zaclact.png');//темная
				$className=$(this).attr("class");
				$className=$className.split(" ");
				$('#book .'+$className[1]).slideDown();				
			});
			$('.zaklad_title').click(function(){
				$('.task').css("display","none");
				$('.zaklad').attr('src','style/img/zacl.png'); //светлая
				$(this).next().attr('src','style/img/zaclact.png');//темная
				$className=$(this).next().attr("class");
				$className=$className.split(" ");
				$('#book .'+$className[1]).slideDown();				
			});
		});
	</script>
	<script type='text/javascript'>
	$(function (){
	    var hg=$('#main_content').height();
	    hg=hg+550+'px';
	    $('body').height(hg);
	});
</script>
</head>
<body >
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
			<div id="area_book">
					<div id="book">
						<form action="result_of_test.html.php" method="post">
							<?php for ($i=1;$i<=count($dataTest);$i++){
								if ($dataTest[$i]["answer"]["textarea"]!=0){?>
									<div class="task textarea <?=$i?>">
										<p class="question"><?=$dataTest[$i]["total_task"]?></p>
										<textarea class="answer" name="answers[task<?=$i?>]" onchange="registeringResponses()"></textarea>
									</div>
								<?php } 
								if ($dataTest[$i]["answer"]["input"]!=0){?>
									<div class="task input <?=$i?>">
										<p class="question"><?=$dataTest[$i]["total_task"]?></p>
										<input type="text" class="answer" name="answers[task<?=$i?>]" onchange="registeringResponses()">
									</div>
								<?php } 
								if ($dataTest[$i]["answer"]["radio"]!=0){?>
									<div class="task radio <?=$i?>">
										<div class="image_answer_div">
											<div class="image_answer">
													<img class="image" src="" alt="" style="height: 240px; width: 240px;">	
											</div>	

										</div>
										
										
										<p class="question"><?=$dataTest[$i]["total_task"]?></p>
										<?php for ($j=1; $j<=count($dataTest[$i]["answer"]["radio"]);$j++){?>
											<div class="radio">
												
												<input type="radio" class="radio_answer" name="answers[task<?=$i?>]"
												value="<?=$dataTest[$i]["answer"]["radio"][$j]["text_answer"]?>" onchange="registeringResponses()">
												<p class="possibleAnswer"><?=$dataTest[$i]["answer"]["radio"][$j]["text_answer"]?></p>
											</div>
										<?php } ?>
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
									</div>
								<?php } ?>
							<?php } ?>
							<input type="hidden" name="idUser" value="<?=$idUser?>">
							<input type="hidden" name="idTest" value="<?=$idTest?>">
							<input type="hidden" name="answers[count]" value="<?=count($dataTest)?>">
							<div id="error" ></div>
							<div class="submit_btn_div">
								<input type="button" id="answer" class="submit_btn active_btn" value="Продолжить">
							</div>
						</form>
					</div>
				<div id="zaklad_menu">
				<?php for($i=1;$i<=count($dataTest);$i++):?>
					
					<div class="zaklad_div">
						<p class="zaklad_title ">Задание <?=$i?></p>
						<img class="zaklad <?=$i?>" src="style/img/zacl.png" alt="" style="display:block;" >
						
					</div>
					
				<?php endfor?>
				</div>
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