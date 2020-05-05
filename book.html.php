<?php include "includes/db.inc.php";
	  include "book_control.php";
	  //include "showtest.php";
	  session_start();
	   if (isset($_SESSION['data-user'])){
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
	<link rel="stylesheet" href="style/cssforbook.css" type="text/css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" id="MathJax-script" async
			src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js">
	</script>

	<?php include 'includes/script_for_nav_menu.php';?>
	
	<script>

		let count;
		let tasks;
		let error;
		let flagAnswers;
		$(document).ready(function(index,el){
			count=Number.parseInt(<?=count($dataTest)?>);
			tasks=new Array(count);
			for (i=0;i<count;i++){
				tasks[i]=false;
			}
			registeringResponses();
			$('#answer').click(function(){
				if(!flagAnswers){
					error=document.getElementById("error");
					error.innerHTML="Вы не ответили на все задания";
				}
			});
		});
		function registeringResponses(){
			$('.task').each(function(index,el){
				let className=$(this).attr('class');
				className=className.split(" ");
				console.log(className);
				if (className[1]=='textarea'){
					if($(this).children('textarea').val().length>0){
						tasks[Number.parseInt(className[2])-1]=true;
					}
					else{
						tasks[Number.parseInt(className[2])-1]=false;
					}
				}
				else if (className[1]=='input'){
					if($(this).children('input').val().length>0){
						tasks[Number.parseInt(className[2])-1]=true;
					}
					else{
						tasks[Number.parseInt(className[2])-1]=false;
					}				
				}
				else if (className[1]=='radio'){
					$(this).children('.radio').each(function(index,el){
						if($(this).children(':radio').prop("checked")){
							tasks[Number.parseInt(className[2])-1]=true;
						}
					});
				}
				else if (className[1]=='checkbox'){
					$(this).children('.checkbox').each(function(index,el){
						if($(this).children(':checkbox').prop("checked")){
							tasks[Number.parseInt(className[2])-1]=true;
						}
					});
				}
			});
			flagAnswers=true;
			for (i=0;i<count;i++){
				if(tasks[i]===false){
					flagAnswers=false;
				}
			}
			console.log(tasks);
			if (flagAnswers){
				$('#answer').attr('type','submit').attr("id","send");
			}
			else{
				$('#answer').attr('type','button').attr("id","answer");
			}
			error=document.getElementById("error");
			error.innerHTML="";
		}
	</script>
	<script>
		let $className;
		$(document).ready(function(){
			$('.task').not('.task:first').css("display","none");
			$('.zaklad:first').attr('src','img/zaclact.png');//темная
			$('.zaklad').click(function(){
				$('.task').css("display","none");
				$('.zaklad').attr('src','img/zacl.png'); //светлая
				$(this).attr('src','img/zaclact.png');//темная
				$className=$(this).attr("class");
				$className=$className.split(" ");
				$('#book .'+$className[1]).slideDown();				
			});
			$('.zaklad_title').click(function(){
				$('.task').css("display","none");
				$('.zaklad').attr('src','img/zacl.png'); //светлая
				$(this).next().attr('src','img/zaclact.png');//темная
				$className=$(this).next().attr("class");
				$className=$className.split(" ");
				$('#book .'+$className[1]).slideDown();				
			});
		});
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
								<input type="button" id="answer" class="submit_btn" value="Продолжить">
							</div>
						</form>
					</div>
				<div id="zaklad_menu">
				<?php for($i=1;$i<=count($dataTest);$i++):?>
					<p class="zaklad_title ">Задание <?=$i?></p>
					<img class="zaklad <?=$i?>" src="img/zacl.png" alt="" style="display:block;" >


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