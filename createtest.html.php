<?php include 'includes/db.inc.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Cache-Control" content="no-cache" charset="UTF-8">
	<link rel="stylesheet" href="style/main.css?123" type="text/css">
	<link rel="stylesheet" href="style/Ccssfort.css?323" type="text/css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" id="MathJax-script" async
			src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js">
	</script>
	<script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
	<script>
		function auto_grow(element) {
			console.log(this[navigator]);
    		element.style.height = "5px";
    		element.style.height = (element.scrollHeight)+"px";}
	</script>
	<script>
		$(document).ready(function(){$('textarea').val('');})
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			let tasks=0;//количество заданий
			let lenghts={};//массив, фиксирующий количество элементов в заданиях, которые можно добавлять
			//форма с textarea
			$('#form_1').click(function(){
				tasks++;
				$('.textarea_template:hidden').clone('deepWithDataAndEvents').insertBefore('#form_handler').attr('id','task'+tasks).slideDown(1000,function(){
					//формируем аттрибут name для элементов, значение которых отправится на сервер
					$('.textarea_template:last .main_text').attr('name','task'+tasks+'[total_task]');
					$('.textarea_template:last .areatext #answer').attr('name','task'+tasks+'[textarea_answer]');
				});
			});
			//аналогично предыдущему, но форма с radiobutton
			$('#form_2').click(function(){
				tasks++;
				$('.radiobutton_template:hidden').clone('deepWithDataAndEvents').insertBefore('#form_handler').attr('id','task'+tasks).slideDown(1000,function(){
					$('.radiobutton_template:last .main_text').attr('name','task'+tasks+'[total_task]');
					$('.radiobutton_template:last .radio .button_radio').attr('name','task'+tasks+'[radio]').attr('value',1);
					$('.radiobutton_template:last .radio .input_text').attr('name','task'+tasks+'[text_answer1]');
					lenghts['task'+tasks]={}
					lenghts['task'+tasks]['radio_answer']=1;
				});
			});
			//аналогично предыдущему, но форма с checkboxbutton
			$('#form_3').click(function(){
				tasks++;
				$('.checkboxbutton_template:hidden').clone('deepWithDataAndEvents').insertBefore('#form_handler').attr('id','task'+tasks).slideDown(1000,function(){
					$('.checkboxbutton_template:last .main_text').attr('name','task'+tasks+'[total_task]');
					$('.checkboxbutton_template:last .check .button_checkbox').attr('name','task'+tasks+'[checkbox_answer1][checkbox]');
					$('.checkboxbutton_template:last .check .input_text').attr('name','task'+tasks+'[checkbox_answer1][text_answer]');
					lenghts['task'+tasks]={}
					lenghts['task'+tasks]['checkbox_answer']=1;
				});
			});
			//аналогично предыдущему, но форма с input
			$('#form_4').click(function(){
				tasks++;
				$('.input_template:hidden').clone('deepWithDataAndEvents').insertBefore('#form_handler').attr('id','task'+tasks).slideDown(1000,function(){
					$('.input_template:last .main_text').attr('name','task'+tasks+'[total_task]');
					$('.input_template:last .inp input').attr('name','task'+tasks+'[input_answer]');
				});
			});
			

			$('.add_button_answer').click(function(){
				let className=$(this).closest('div').attr('class');
				className=className.split(' ');
				let idName=$(this).closest('div').attr('id');
				$('.'+className[1]+' .add_button_answer:hidden').prev().clone('deepWithDataAndEvents').css('display','none').insertBefore(
				this).slideDown(1000).children().each(function(index,el){
					if (className[1]=='radiobutton_template'){
						if($(this).attr('id')=='radiobutton'){
							len=++lenghts[idName]['radio_answer'];
							$(this).attr('name','task'+tasks+'[radio]').attr('value',len);
						}
						else{
							len=lenghts[idName]['radio_answer'];
							$(this).attr('name','task'+tasks+'[text_answer'+len+']');
						}
					}
					else{
						if($(this).attr('id')=='checkboxbutton'){
							len=++lenghts[idName]['checkbox_answer'];
							$(this).attr('name','task'+tasks+'[checkbox_answer'+len+'][checkbox]');
						}
						else{
							len=lenghts[idName]['checkbox_answer'];
							$(this).attr('name','task'+tasks+'[checkbox_answer'+len+'][text_answer]');
						}
					}
				});
			});
		});
		
	</script>
	<script>
	var $activeContainer='';
	var activeContainer1='';
	function getData(){
		$activeContainer=$('textarea:focus');
		activeContainer1=document.querySelectorAll('textarea:focus');
	}
	function strForConvert(str){
		data={};
		data['str']='';
		data['len']=0;
		data['option']=false;
		if (/^$/.test(str)){
			data['str']=false;
			return data;
		}
		else if (/^\\\(/u.test(str)){ //ищем начало строчной формулы
			if (/^\\\(.+?\\\)/us.test(str)){//проверяем имеет ли конец строчная формула
				data['str']=str.match(/^\\\((.+?)\\\)/us)[1];
				data['length']=data['str'].length+4;//4=/(/)
				data['option']='in-row formula';
				return data; //возвращаем строчную формулу
			}
			else{
				data['str']=str.match(/^\\\((.+?)$/)[1];
				data['str']=data['str'].length+4;//4=/(/)
				data['option']='in-row formula';
				return data;
			}
		}
		else if (/^\$\$/u.test(str)){ //ищем начало выключной формулы
			if (/^\$\$.+?\$\$/us.test(str)){ //проверяем имеет ли конец выключная формула
				data['str']=str.match(/^\$\$(.+?)\$\$/us)[1];
				data['length']=data['str'].length+4;//4=$$$$
				data['option']='alternative formula';
				return data; //возвращаем выключную формулу
			}
			else
				data['str']=str.match(/^\$\$(.+?)$/us)[1];
				data['length']=data['str'].length+4;//4=$$$$
				data['option']='alternative formula';
				return data;
		}
		else if (/^./us){
			data['str']=str.match(/^(.+?)(?=\\\(|\$\$|$)/us)[1];
			data['length']=data['str'].length;
			data['option']='text';
			return data;
		}
	}
	
	function convert() {
		//
		//  Get the TeX input
		//
		var input = $activeContainer.val().trim();
		var str='';
		var count=0;
	    //
		//  Disable the display and render buttons until MathJax is done
		//
		var button = document.querySelectorAll('.btnpastepre');
		button.disabled = true;
		//
		//  Clear the old output
		//
		output = activeContainer1[0]['nextElementSibling'];//document.getElementById('left_block');
		output.innerHTML = '';
		//
		//  Reset the tex labels (and automatic equation numbers, though there aren't any here).
		//  Get the conversion options (metrics and display settings)
		//  Convert the input to CommonHTML output and use a promise to wait for it to be ready
		//    (in case an extension needs to be loaded dynamically).
		//
		MathJax.texReset();
		var options = MathJax.getMetricsFor(output);
		while (strForConvert(input)['str']){
			str=strForConvert(input);
			input=input.slice(str['length']);
			if (str['option']=='in-row formula')       options.display=0;
			if (str['option']=='alternative formula')  options.display=1;
			if (str['option']=='text'){
				str['str']='\\mbox\{'+str['str']+'\}';
				options.display=0;
			}
			console.log(str['str']);
			MathJax.tex2chtmlPromise(str['str'], options).then(function (node) {
				//
				//  The promise returns the typeset node, which we add to the output
				//  Then update the document to include the adjusted CSS for the
				//    content of the new equation.
				//
				output.appendChild(node);
				MathJax.startup.document.clear();
				MathJax.startup.document.updateDocument();
			}).catch(function (err) {
				//
				//  If there was an error, put the message into the output instead
				//
				output.appendChild(document.createElement('pre')).appendChild(document.createTextNode(err.message));
			}).then(function () {
				//
				//  Error or not, re-enable the display and render buttons
				//
				button.disabled = false;
			});
		}
    }
	
	jQuery.fn.extend({
    insertAtCaret: function(myValue){
        return this.each(function(i) {
            if (document.selection) {
                //For browsers like Internet Explorer
                this.focus();
                sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
            }
            else if (this.selectionStart || this.selectionStart == '0') {
                //For browsers like Firefox and Webkit based
                var startPos = this.selectionStart;
                var endPos = this.selectionEnd;
                var scrollTop = this.scrollTop;
                this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
                this.focus();
                this.selectionStart = startPos + myValue.length;
                this.selectionEnd = startPos + myValue.length;
                this.scrollTop = scrollTop;
            } 
            else {
                this.value += myValue;
                this.focus();
            }
        })
    }
	});

	var countOfElements= 0;

	$(window).load(function(){
		$('button').click(function() {
			var myhtml=$(this).attr('value');
			$activeContainer.insertAtCaret(myhtml);
			console.log($activeContainer.val().trim());
			convert();
			var flagOfExist=false;
			if (countOfElements){
				console.log(countOfElements);
				if (countOfElements<=9){
					$('.formul_body:first').children('button').each(function(){
						if (myhtml==$(this).attr('value')){
							flagOfExist=true;
						}
					});
					if(!flagOfExist){
						$(this).clone('withDataAndEvents').insertBefore('button:first');
						countOfElements++;
					}
				}
				else{
					$('.formul_body:first').children('button').each(function(){
						if (myhtml==$(this).attr('value')){
							flagOfExist=true;
						}
					});
					if(!flagOfExist){
						$('.formul_body:first').children('button:last').remove();
						$(this).clone('withDataAndEvents').insertBefore('button:first');
					}
				}
			}
			else{
				$button=$(this).clone('withDataAndEvents');
				$('.formul_body:first').append(function(){return $button});
				countOfElements++;
			}
    })
})
	</script>
	<script>
	
	$(document).ready(function() {
		$('.formul_preview').click(function(){
			$(this).closest('.prev_menu').next().slideUp(100).next().slideDown(100);
		});

	});
	$(document).ready(function() {
		$('.task_show').click(function(){
			$(this).closest('.prev_menu').next().slideDown(100).next().slideUp(100);
		});

	});
	$(function(){
		$(window).scroll(function() {
			if($(this).scrollTop() >= 500) {
				$('#left_block').addClass('stickytop');
			}
			else{
				$('#left_block').removeClass('stickytop');
			}
		});
	});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.exit_menu').click(function(){
				$('.exit_menu_body').slideToggle(500);
			});
		});
	</script>
	<script type="text/javascript">
	$(document).ready(function(){
		$('.formul').click(function(){
			console.log($(this).children('.formul_body'));
			$(this).next().stop().slideToggle(500);
		});
	});
	</script>
</head>
<body>
	
	<div id="page">
		<div id="main_content"><!--  Основной див  сайта -->
			<div class="task textarea_template">
				<p class="text_title">Задание</p>
				<div class="prev_menu">
					<input type="button" class="task_show" value="Задание">
					<input type="button" class="formul_preview" value="Превью" class="prev_btn" onclick="convert()">
				</div>			
				<textarea  oninput="auto_grow(this)"
					name="task[total_task]"  class="main_text" style="resize:none" onfocus="getData()"> 
				</textarea><!-- Общее задание -->
				<div class="preview">
				</div>			
					<p class="text_title">Варианты ответов</p>						
				<div class="areatext">
					<textarea oninput="auto_grow(this)" name="task[textarea_answer]" id="answer" style="resize:none" class="text_answer">
					</textarea><!--  Развернутый ответ -->
				</div>
							
			</div>
			<div class="task radiobutton_template">
				<p class="text_title">Задание</p>
				<div class="prev_menu">
					<input type="button" class="task_show" value="Задание">
					<input type="button" class="formul_preview" value="Превью" class="prev_btn" onclick="convert()">
				</div>
				<textarea oninput="auto_grow(this)"
					name="task[total_task]"class="main_text" style="resize:none" onfocus="getData()"> 
				</textarea><!-- Общее задание -->
				<div class="preview">
				</div>		
				<p class="text_title">Варианты ответов</p>						
				
				<div class="radio">
					<label class="radio_button">
						<input id="radiobutton" name="task[radio]" value="answer" type="radio" class="button_radio">  <!--  радио кнопка -->
						<span class="radiomark"></span>
					</label>
					<div class="prev_menu prev_menu_box">
						<input type="button" class="task_show" value="Задание">
						<input type="button" class="formul_preview" value="Превью" class="prev_btn" onclick="convert()">
					</div>
					<textarea  oninput="auto_grow(this)"
						class="input_text" id="text" name="task[text_answer]" style="resize:none" onfocus="getData()">
					</textarea><!--  задание1 -->
					<div class="preview">
					</div>
				</div>
				
				<input type="button" class="add_button_answer" value="+"><!--  Кнопка добавить -->
							
			</div>
		
			<div class="task checkboxbutton_template">
				<p class="text_title">Задание</p>
				<div class="prev_menu ">
					<input type="button" class="task_show" value="Задание">
					<input type="button" class="formul_preview" value="Превью" class="prev_btn" onclick="convert()">
				</div>
				<textarea oninput="auto_grow(this)"
					name="task[total_task]" class="main_text" style="resize:none" onfocus="getData()"> 
				</textarea><!-- Общее задание -->
				<div class="preview">
				</div>
				<p class="text_title">Варианты ответов</p>	
			
				<div class="check">
					<label class="checkbox">
						<input id="checkboxbutton"type="checkbox" name="task[checkbox_answer][checkbox]" value="answer" class="button_checkbox" > <!--  чекбокс -->
						<span class="checkmark"></span>
					</label>

                    <div class="prev_menu prev_menu_box">
						<input type="button" class="task_show" value="Задание">
						<input type="button" class="formul_preview" value="Превью" class="prev_btn" onclick="convert()">
					</div>
					<textarea oninput="auto_grow(this)"
						class="input_text" id="text" name="task[checkbox_answer][text_answer]" style="resize:none" onfocus="getData()">
					</textarea><!--  задание1 -->
					<div class="preview">
					</div>
				</div>
				<input type="button" class="add_button_answer" value="+"><!--  Кнопка добавить -->
			</div>
		
			<div class="task input_template">
				<p class="text_title">Задание</p>
				<div class="prev_menu">
					<input type="button" class="task_show" value="Задание">
					<input type="button" class="formul_preview" value="Превью" class="prev_btn" onclick="convert()">
				</div>
				<textarea oninput="auto_grow(this)"
					name="task[total_task]" class="main_text" style="resize:none" onfocus="getData()"> 
				</textarea><!-- Общее задание -->
				<div class="preview">
				</div>
				<p class="text_title">Варианты ответов</p>	
				
				<div class="inp">
					<input  type="text" name="task[input_answer]" value="" placeholder="ответ" style="margin-left: 2%; height: 20px; margin-top: 2%;"> <!--  Поле для ввода ответа -->
				</div>
							
			</div>
			
			<?php if (isset($_COOKIE['name'])&&isset($_COOKIE['surname'])):?>
				<form action="createtest_handler.php" method="post">
					<div>
						<div id="form_handler">
							<input type="button" value="1 форма" id="form_1" class="form_btn form_btn_1">
							<input type="button" value="2 форма" id="form_2" class="form_btn form_btn_2">
							<input type="button" value="3 форма" id="form_3" class="form_btn form_btn_3">
							<input type="button" value="4 форма" id="form_4" class="form_btn _4">
						</div>
						<input type="button" value="Продолжить">
						<div id="nameTest">
							<p>Введите название теста</p>
							<input type="text">
							<p>Выберите дисциплину (и если нужно раздел дисциплины)<p>
							<select name="" id="subjects">
								<option selected value="Выберите дисциплину" class="option_subject">Выберите дисциплину</option>
								<option class="option_subject" style="display:none"></option>
							</select>
							<select name="" id="sections" style="display:none">
								<option selected value="Выберите дисциплину" class="option_section">Выберите раздел</option>
								<option class="option_section" style="display:none"></option>
							</select>

							<input type="button" value="Отменить">
							<input type="submit" value="Отправить" class="form_btn form_btn_send">
						</div>
					</div>
				</form>
			<?php endif ?>
		</div>
	</div>
		<div class="slider midle"><!--  Слайдер -->
			<div class="slides"><!--  Радиокнопки и изображения -->
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


		<div id="plus_inform"><!-- Доп. информация -->
			
		</div>
		<div id="right_block_title"></div>
		<div id="right_block" ><!--  левый  див  сайта -->

		</div>
		<div id="left_block_title"></div>
		<div id="left_block" class="left_block"><!--  правый див  сайта -->
		    <?php if (isset($_COOKIE['name'])&&isset($_COOKIE['surname'])):?>
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
				<p class="formul_buttons formul ">►Последние использованные символы</p>
				<div class="formul_buttons_body formul_body last_using_buttons"></div>
				<p class="formul_buttons formul">►Создать формулу</p>
				<div class="formul_buttons_body formul_body">
					<button class="btnpastepre" value="\( \)">Создать формулу(строчную)</button>
					<button class="btnpastepre" value="$$ $$">Создать формулу(выключную)</button>
					<button class="btnpastepre" value="^{}">Степень</button>
					<button class="btnpastepre" value="_{}">Индекс</button>
					<button class="btnpastepre" value="\sqrt{}">Квадратный корень</button>
					<button class="btnpastepre" value="\qquad">Длинный пробел</button>
					<button class="btnpastepre" value="\mbox{}">Текст внутри формулы</button>
					<button class="btnpastepre" value="\cfrac{}{}">Дробь постоянной величины</button>
					<button class="btnpastepre" value="\frac{}{}">Дробь переменной величины</button>
				</div>
				<p class="formul_buttons formul">►Греческие буквы</p>
				<div class="formul_buttons_body formul_body">
					<button class="btnpastepre" value="\alpha">\(\alpha\)</button>
					<button class="btnpastepre" value="\beta">\(\beta\)</button>
					<button class="btnpastepre" value="\gamma">\(\gamma\)</button>
					<button class="btnpastepre" value="\delta">\(\delta\)</button>
					<button class="btnpastepre" value="\varepsilon">\(\varepsilon\)</button>
					<button class="btnpastepre" value="\zeta">\(\zeta\)</button>
					<button class="btnpastepre" value="\eta">\(\eta\)</button>
					<button class="btnpastepre" value="\theta">\(\theta\)</button>
					<button class="btnpastepre" value="\vartheta">\(\vartheta\)</button>
					<button class="btnpastepre" value="\iota">\(\iota\)</button>
					<button class="btnpastepre" value="\kappa">\(\kappa\)</button>
					<button class="btnpastepre" value="\varkappa">\(\varkappa\)</button>
					<button class="btnpastepre" value="\lambda">\(\lambda\)</button>
					<button class="btnpastepre" value="\mu">\(\mu\)</button>
					<button class="btnpastepre" value="\nu">\(\nu\)</button>
					<button class="btnpastepre" value="\xi">\(\xi\)</button>
					<button class="btnpastepre" value="\pi">\(\pi\)</button>
					<button class="btnpastepre" value="\varpi">\(\varpi\)</button>
					<button class="btnpastepre" value="\rho">\(\rho\)</button>        
					<button class="btnpastepre" value="\varrho">\(\varrho\)</button>
					<button class="btnpastepre" value="\sigma">\(\sigma\)</button>
					<button class="btnpastepre" value="\varsigma">\(\varsigma\)</button>   
					<button class="btnpastepre" value="\tau">\(\tau\)</button>
					<button class="btnpastepre" value="\upsilon">\(\upsilon\)</button>
					<button class="btnpastepre" value="\phi">\(\phi\)</button>
					<button class="btnpastepre" value="\varphi">\(\varphi\)</button>
					<button class="btnpastepre" value="\chi">\(\chi\)</button>
					<button class="btnpastepre" value="\psi">\(\psi\)</button>
					<button class="btnpastepre" value="\omega">\(\omega\)</button>
					<button class="btnpastepre" value="\Gamma">\(\Gamma\)</button>
					<button class="btnpastepre" value="\Delta">\(\Delta\)</button>
					<button class="btnpastepre" value="\Theta">\(\Theta\)</button>
					<button class="btnpastepre" value="\Lambda">\(\Lambda\)</button>
					<button class="btnpastepre" value="\Xi">\(\Xi\)</button>
					<button class="btnpastepre" value="\Pi">\(\Pi\)</button>
					<button class="btnpastepre" value="\Sigma">\(\Sigma\)</button>
					<button class="btnpastepre" value="\Upsilon">\(\Upsilon\)</button>
					<button class="btnpastepre" value="\Phi">\(\Phi\)</button>
					<button class="btnpastepre" value="\Psi">\(\Psi\)</button>
					<button class="btnpastepre" value="\Omega">\(\Omega\)</button>
				</div>
				<p class="formul_buttons formul" >►Символы бинарных операций</p>
				<div class="formul_buttons_body formul_body">
					<button class="btnpastepre" value="+">\(+\)</button>
					<button class="btnpastepre" value="-">\(-\)</button>
					<button class="btnpastepre" value="*">\(*\)</button>
					<button class="btnpastepre" value="\pm">\(\pm\)</button>
					<button class="btnpastepre" value="\mp">\(\mp\)</button>
					<button class="btnpastepre" value="\times">\(\times\)</button>
					<button class="btnpastepre" value="\div">\(\div\)</button>
					<button class="btnpastepre" value="\setminus">\(\setminus\)</button>
					<button class="btnpastepre" value="\cdot">\(\cdot\)</button>
					<button class="btnpastepre" value="\circ">\(\circ\)</button>
					<button class="btnpastepre" value="\bullet">\(\bullet\)</button>
					<button class="btnpastepre" value="\cap">\(\cap\)</button>
					<button class="btnpastepre" value="\cup">\(\cup\)</button>
					<button class="btnpastepre" value="\uplus">\(\uplus\)</button>
					<button class="btnpastepre" value="\sqcap">\(\sqcap\)</button>
					<button class="btnpastepre" value="\sqcup">\(\sqcup\)</button>
					<button class="btnpastepre" value="\vee">\(\vee\)</button>
					<button class="btnpastepre" value="\wedge">\(\wedge\)</button>
					<button class="btnpastepre" value="\oplus">\(\oplus\)</button>
					<button class="btnpastepre" value="\ominus">\(\ominus\)</button>
					<button class="btnpastepre" value="\otimes">\(\otimes\)</button>
					<button class="btnpastepre" value="\odot">\(\odot\)</button>
					<button class="btnpastepre" value="\oslash">\(\oslash\)</button>
					<button class="btnpastepre" value="\triangleleft">\(\triangleleft\)</button>
					<button class="btnpastepre" value="\triangleright">\(\triangleright\)</button>
					<button class="btnpastepre" value="\amalg">\(\amalg\)</button>
					<button class="btnpastepre" value="\diamond">\(\diamond\)</button>
					<button class="btnpastepre" value="\wr">\(\wr\)</button>
					<button class="btnpastepre" value="\star">\(\star\)</button>
					<button class="btnpastepre" value="\dagger">\(\dagger\)</button>
					<button class="btnpastepre" value="\ddagger">\(\ddagger\)</button>
					<button class="btnpastepre" value="\bigtriangleup">\(\bigtriangleup\)</button>
					<button class="btnpastepre" value="\triangle">\(\triangle\)</button>
					<button class="btnpastepre" value="\bigtriangledown">\(\bigtriangledown\)</button>
					<button class="btnpastepre" value="\bigcirc">\(\bigcirc\)</button>
					<button class="btnpastepre" value="\mod">\(\bmod\)</button>
					<button class="btnpastepre" value="\\boxdot">\(\boxdot\)</button>
					<button class="btnpastepre" value="\boxplus">\(\boxplus\)</button>
					<button class="btnpastepre" value="\boxtimes">\(\boxtimes\)</button>
					<button class="btnpastepre" value="\boxminus">\(\boxminus\)</button>
					<button class="btnpastepre" value="\\centerdot">\(\centerdot\)</button>
					<button class="btnpastepre" value="\veebar">\(\veebar\)</button>
					<button class="btnpastepre" value="\\barwedge">\(\barwedge\)</button>
					<button class="btnpastepre" value="\doublebarwedge">\(\doublebarwedge\)</button>
					<button class="btnpastepre" value="\Cup">\(\Cup\)</button>
					<button class="btnpastepre" value="\Cap">\(\Cap\)</button>
					<button class="btnpastepre" value="\curlywedge">\(\curlywedge\)</button>
					<button class="btnpastepre" value="\curlyvee">\(\curlyvee\)</button>
					<button class="btnpastepre" value="\leftthreetimes">\(\leftthreetimes\)</button>
					<button class="btnpastepre" value="\rightthreetimes">\(\rightthreetimes\)</button>
					<button class="btnpastepre" value="\dotplus">\(\dotplus\)</button>
					<button class="btnpastepre" value="\intercal">\(\intercal\)</button>
					<button class="btnpastepre" value="\circledcirc">\(\circledcirc\)</button>
					<button class="btnpastepre" value="\circledast">\(\circledast\)</button>
					<button class="btnpastepre" value="\circleddash">\(\circleddash\)</button>
					<button class="btnpastepre" value="\divideontimes">\(\divideontimes\)</button>
					<button class="btnpastepre" value="\lessdot">\(\lessdot\)</button>
					<button class="btnpastepre" value="\trdot">\(\gtrdot\)</button>
					<button class="btnpastepre" value="\ltimes">\(\ltimes\)</button>
					<button class="btnpastepre" value="\rtimes">\(\rtimes\)</button>
					<button class="btnpastepre" value="\smallsetminus">\(\smallsetminus\)</button>
				</div>
				<p class="formul_buttons formul">►Символы бинарных отношений</p>
				<div class="formul_buttons_body formul_body">
					<button class="btnpastepre" value="<">\(<\)</button>
					<button class="btnpastepre" value=">">\(>\)</button>
					<button class="btnpastepre" value="=">\(=\)</button>
					<button class="btnpastepre" value=":">\(:\)</button>
					<button class="btnpastepre" value="\colon">\(\colon\)</button>
					<button class="btnpastepre" value="\le">\(\le\)</button>
					<button class="btnpastepre" value="\ge">\(\ge\)</button>
					<button class="btnpastepre" value="\leqslant">\(\leqslant\)</button>
					<button class="btnpastepre" value="\geqslant">\(\geqslant\)</button>
					<button class="btnpastepre" value="\ne">\(\ne\)</button>
					<button class="btnpastepre" value="\sim">\(\sim\)</button>
					<button class="btnpastepre" value="\simeq">\(\simeq\)</button>
					<button class="btnpastepre" value="\approx">\(\approx\)</button>
					<button class="btnpastepre" value="\cong">\(\cong\)</button>
					<button class="btnpastepre" value="\equiv">\(\equiv\)</button>
					<button class="btnpastepre" value="\ll">\(\ll\)</button>
					<button class="btnpastepre" value="\gg">\(\gg\)</button>
					<button class="btnpastepre" value="\doteq">\(\doteq\)</button>
					<button class="btnpastepre" value="\parallel">\(\parallel\)</button>
					<button class="btnpastepre" value="\|">\(\|\)</button>
					<button class="btnpastepre" value="\top">\(\top\)</button>
					<button class="btnpastepre" value="\bot">\(\bot\)</button>
					<button class="btnpastepre" value="\in">\(\in\)</button>
					<button class="btnpastepre" value="\notin">\(\notin\)</button>
					<button class="btnpastepre" value="\ni">\(\ni\)</button>
					<button class="btnpastepre" value="\subset">\(\subset\)</button>
					<button class="btnpastepre" value="\subseteq">\(\subseteq\)</button>
					<button class="btnpastepre" value="\supset">\(\supset\)</button>
					<button class="btnpastepre" value="\supseteq">\(\supseteq\)</button>
					<button class="btnpastepre" value="\succ">\(\succ\)</button>
					<button class="btnpastepre" value="\prec">\(\prec\)</button>
					<button class="btnpastepre" value="\succeq">\(\succeq\)</button>
					<button class="btnpastepre" value="\preceq">\(\preceq\)</button>
					<button class="btnpastepre" value="\asymp">\(\asymp\)</button>
					<button class="btnpastepre" value="\sqsubset">\(\sqsubset\)</button>
					<button class="btnpastepre" value="\sqsubseteq">\(\sqsubseteq\)</button>
					<button class="btnpastepre" value="\sqsupset">\(\sqsupset\)</button>
					<button class="btnpastepre" value="\sqsupseteq">\(\sqsupseteq\)</button>
					<button class="btnpastepre" value="\models">\(\models\)</button>
					<button class="btnpastepre" value="\vdash">\(\vdash\)</button>
					<button class="btnpastepre" value="\dashv">\(\dashv\)</button>
					<button class="btnpastepre" value="\smile">\(\smile\)</button>
					<button class="btnpastepre" value="\frown">\(\frown\)</button>
					<button class="btnpastepre" value="\mid">\(\mid\)</button>
					<button class="btnpastepre" value="\bowtie">\(\bowtie\)</button>
					<button class="btnpastepre" value="\propto">\(\propto\)</button>
					<button class="btnpastepre" value="\lhd">\(\lhd\)</button>
					<button class="btnpastepre" value="\unlhd">\(\unlhd\)</button>
					<button class="btnpastepre" value="\rhd">\(\rhd\)</button>
					<button class="btnpastepre" value="\unrhd">\(\unrhd\)</button>
					<button class="btnpastepre" value="\Join">\(\Join\)</button>
					<button class="btnpastepre" value="\rightleftharpoons">\(\rightleftharpoons\)</button>
					<button class="btnpastepre" value="\leftrightharpoons">\(\leftrightharpoons\)</button>
					<button class="btnpastepre" value="\Vdash">\(\Vdash\)</button>
					<button class="btnpastepre" value="\Vvdash">\(\Vvdash\)</button>
					<button class="btnpastepre" value="\vDash">\(\vDash\)</button>
					<button class="btnpastepre" value="\upharpoonright">\(\upharpoonright\)</button>
					<button class="btnpastepre" value="\downharpoonright">\(\downharpoonright\)</button>
					<button class="btnpastepre" value="\upharpoonleft">\(\upharpoonleft\)</button>
					<button class="btnpastepre" value="\downharpoonleft">\(\downharpoonleft\)</button>
					<button class="btnpastepre" value="\Lsh">\(\Lsh\)</button>
					<button class="btnpastepre" value="\Rsh">\(\Rsh\)</button>
					<button class="btnpastepre" value="\circeq">\(\circeq\)</button>
					<button class="btnpastepre" value="\succsim">\(\succsim\)</button>
					<button class="btnpastepre" value="\gtrsim">\(\gtrsim\)</button>
					<button class="btnpastepre" value="\gtrapprox">\(\gtrapprox\)</button>
					<button class="btnpastepre" value="\multimap">\(\multimap\)</button>
					<button class="btnpastepre" value="\therefore">\(\therefore\)</button>
					<button class="btnpastepre" value="\because">\(\because\)</button>
					<button class="btnpastepre" value="\doteqdot">\(\doteqdot\)</button>
					<button class="btnpastepre" value="\triangleq">\(\triangleq\)</button>
					<button class="btnpastepre" value="\precsim">\(\precsim\)</button>
					<button class="btnpastepre" value="\lesssim">\(\lesssim\)</button>
					<button class="btnpastepre" value="\lessapprox">\(\lessapprox\)</button>
					<button class="btnpastepre" value="\eqslantless">\(\eqslantless\)</button>
					<button class="btnpastepre" value="\eqslantgtr">\(\eqslantgtr\)</button>
					<button class="btnpastepre" value="\curlyeqprec">\(\curlyeqprec\)</button>
					<button class="btnpastepre" value="\curlyeqsucc">\(\curlyeqsucc\)</button>
					<button class="btnpastepre" value="\preccurlyeq">\(\preccurlyeq\)</button>
					<button class="btnpastepre" value="\leqq">\(\leqq\)</button>
					<button class="btnpastepre" value="\leqslant">\(\leqslant\)</button>
					<button class="btnpastepre" value="\lessgtr">\(\lessgtr\)</button>
					<button class="btnpastepre" value="\risingdotseq">\(\risingdotseq\)</button>
					<button class="btnpastepre" value="\fallingdotseq">\(\fallingdotseq\)</button>
					<button class="btnpastepre" value="\succcurlyeq">\(\succcurlyeq\)</button>
					<button class="btnpastepre" value="\geqq">\(\geqq\)</button>
					<button class="btnpastepre" value="\geqslant">\(\geqslant\)</button>
					<button class="btnpastepre" value="\gtrless">\(\gtrless\)</button>
					<button class="btnpastepre" value="\sqsubset">\(\sqsubset\)</button>
					<button class="btnpastepre" value="\sqsupset">\(\sqsupset\)</button>
					<button class="btnpastepre" value="\vartriangleright">\(\vartriangleright\)</button>
					<button class="btnpastepre" value="\vartriangleleft">\(\vartriangleleft\)</button>
					<button class="btnpastepre" value="\trianglerighteq">\(\trianglerighteq\)</button>
					<button class="btnpastepre" value="\trianglelefteq">\(\trianglelefteq\)</button>
					<button class="btnpastepre" value="\between">\(\between\)</button>
					<button class="btnpastepre" value="\blacktriangleright">\(\blacktriangleright\)</button>
					<button class="btnpastepre" value="\blacktriangleleft">\(\blacktriangleleft\)</button>
					<button class="btnpastepre" value="\vartriangle">\(\vartriangle\)</button>
					<button class="btnpastepre" value="\eqcirc">\(\eqcirc\)</button>
					<button class="btnpastepre" value="\lesseqgtr">\(\lesseqgtr\)</button>
					<button class="btnpastepre" value="\gtreqless">\(\gtreqless\)</button>
					<button class="btnpastepre" value="\lesseqqgtr">\(\lesseqqgtr\)</button>
					<button class="btnpastepre" value="\gtreqqless">\(\gtreqqless\)</button>
					<button class="btnpastepre" value="\varpropto">\(\varpropto\)</button>
					<button class="btnpastepre" value="\smallsmile">\(\smallsmile\)</button>
					<button class="btnpastepre" value="\smallfrown">\(\smallfrown\)</button>
					<button class="btnpastepre" value="\Subset">\(\Subset\)</button>
					<button class="btnpastepre" value="\Supset">\(\Supset\)</button>
					<button class="btnpastepre" value="\subseteqq">\(\subseteqq\)</button>
					<button class="btnpastepre" value="\supseteqq">\(\supseteqq\)</button>
					<button class="btnpastepre" value="\bumpeq">\(\bumpeq\)</button>
					<button class="btnpastepre" value="\Bumpeq">\(\Bumpeq\)</button>
					<button class="btnpastepre" value="\lll">\(\lll\)</button>
					<button class="btnpastepre" value="\ggg">\(\ggg\)</button>
					<button class="btnpastepre" value="\pitchfork">\(\pitchfork\)</button>
					<button class="btnpastepre" value="\backsim">\(\backsim\)</button>
					<button class="btnpastepre" value="\backsimeq">\(\backsimeq\)</button>
					<button class="btnpastepre" value="\lvertneqq">\(\lvertneqq\)</button>
					<button class="btnpastepre" value="\gvertneqq">\(\gvertneqq\)</button>
					<button class="btnpastepre" value="\lneqq">\(\lneqq\)</button>
					<button class="btnpastepre" value="\gneqq">\(\gneqq\)</button>
					<button class="btnpastepre" value="\lneq">\(\lneq\)</button>
					<button class="btnpastepre" value="\gneq">\(\gneq\)</button>
					<button class="btnpastepre" value="\precnsim">\(\precnsim\)</button>
					<button class="btnpastepre" value="\succnsim">\(\succnsim\)</button>
					<button class="btnpastepre" value="\lnsim">\(\lnsim\)</button>
					<button class="btnpastepre" value="\gnsim">\(\gnsim\)</button>
					<button class="btnpastepre" value="\precneqq">\(\precneqq\)</button>
					<button class="btnpastepre" value="\succneqq">\(\succneqq\)</button>
					<button class="btnpastepre" value="\precnapprox">\(\precnapprox\)</button>
					<button class="btnpastepre" value="\succnapprox">\(\succnapprox\)</button>
					<button class="btnpastepre" value="\lnapprox">\(\lnapprox\)</button>
					<button class="btnpastepre" value="\gnapprox">\(\gnapprox\)</button>
					<button class="btnpastepre" value="\varsubsetneq">\(\varsubsetneq\)</button>
					<button class="btnpastepre" value="\varsupsetneq">\(\varsupsetneq\)</button>
					<button class="btnpastepre" value="\subsetneqq">\(\subsetneqq\)</button>
					<button class="btnpastepre" value="\supsetneqq">\(\supsetneqq\)</button>
					<button class="btnpastepre" value="\varsubsetneqq">\(\varsubsetneqq\)</button>
					<button class="btnpastepre" value="\varsupsetneqq">\(\varsupsetneqq\)</button>
					<button class="btnpastepre" value="\subsetneq">\(\subsetneq\)</button>
					<button class="btnpastepre" value="\supsetneq">\(\supsetneq\)</button>
					<button class="btnpastepre" value="\eqsim">\(\eqsim\)</button>
					<button class="btnpastepre" value="\shortmid">\(\shortmid\)</button>
					<button class="btnpastepre" value="\shortparallel">\(\shortparallel\)</button>
					<button class="btnpastepre" value="\thicksim">\(\thicksim\)</button>
					<button class="btnpastepre" value="\thickapprox">\(\thickapprox\)</button>
					<button class="btnpastepre" value="\approxeq">\(\approxeq\)</button>
					<button class="btnpastepre" value="\succapprox">\(\succapprox\)</button>
					<button class="btnpastepre" value="\precapprox">\(\precapprox\)</button>
					<button class="btnpastepre" value="\backepsilon">\(\backepsilon\)</button>
				</div>
				<p class="formul_buttons formul">►Стрелки</p>
					<div class="formul_buttons_body formul_body">
					<button class="btnpastepre" value="\to">\(\to\)</button>
					<button class="btnpastepre" value="\longrightarrow">\(\longrightarrow\)</button>
					<button class="btnpastepre" value="\Rightarrow">\(\Rightarrow\)</button>
					<button class="btnpastepre" value="\Longrightarrow">\(\Longrightarrow\)</button>
					<button class="btnpastepre" value="\hookrightarrow">\(\hookrightarrow\)</button>
					<button class="btnpastepre" value="\mapsto">\(\mapsto\)</button>
					<button class="btnpastepre" value="\longmapsto">\(\longmapsto\)</button>
					<button class="btnpastepre" value="\gets">\(\gets\)</button>
					<button class="btnpastepre" value="\longleftarrow">\(\longleftarrow\)</button>
					<button class="btnpastepre" value="\Leftarrow">\(\Leftarrow\)</button>
					<button class="btnpastepre" value="\Longleftarrow">\(\Longleftarrow\)</button>
					<button class="btnpastepre" value="\hookleftarrow">\(\hookleftarrow\)</button>
					<button class="btnpastepre" value="\leftrightarrow">\(\leftrightarrow\)</button>
					<button class="btnpastepre" value="\longleftrightarrow">\(\longleftrightarrow\)</button>
					<button class="btnpastepre" value="\Leftrightarrow">\(\Leftrightarrow\)</button>
					<button class="btnpastepre" value="\Longleftrightarrow">\(\Longleftrightarrow\)</button>
					<button class="btnpastepre" value="\uparrow">\(\uparrow\)</button>
					<button class="btnpastepre" value="\Uparrow">\(\Uparrow\)</button>
					<button class="btnpastepre" value="\downarrow">\(\downarrow\)</button>
					<button class="btnpastepre" value="\Downarrow">\(\Downarrow\)</button>
					<button class="btnpastepre" value="\updownarrow">\(\updownarrow\)</button>
					<button class="btnpastepre" value="\Updownarrow">\(\Updownarrow\)</button>
					<button class="btnpastepre" value="\nearrow">\(\nearrow\)</button>
					<button class="btnpastepre" value="\searrow">\(\searrow\)</button>
					<button class="btnpastepre" value="\swarrow">\(\swarrow\)</button>
					<button class="btnpastepre" value="\nwarrow">\(\nwarrow\)</button>
					<button class="btnpastepre" value="\leftharpoondown">\(\leftharpoondown\)</button>
					<button class="btnpastepre" value="\leftharpoonup">\(\leftharpoonup\)</button>
					<button class="btnpastepre" value="\rightharpoonup">\(\rightharpoonup\)</button>
					<button class="btnpastepre" value="\rightharpoondown">\(\rightharpoondown\)</button>
					<button class="btnpastepre" value="\rightleftharpoons">\(\rightleftharpoons\)</button>
					<button class="btnpastepre" value="\circlearrowright">\(\circlearrowright\)</button>
					<button class="btnpastepre" value="\curvearrowleft">\(\curvearrowleft\)</button>
					<button class="btnpastepre" value="\twoheadrightarrow">\(\twoheadrightarrow\)</button>
					<button class="btnpastepre" value="\twoheadleftarrow">\(\twoheadleftarrow\)</button>
					<button class="btnpastepre" value="\leftleftarrows">\(\leftleftarrows\)</button>
					<button class="btnpastepre" value="\rightrightarrows">\(\rightrightarrows\)</button>
					<button class="btnpastepre" value="\upuparrows">\(\upuparrows\)</button>
					<button class="btnpastepre" value="\downdownarrows">\(\downdownarrows\)</button>
					<button class="btnpastepre" value="\rightarrowtail">\(\rightarrowtail\)</button>
					<button class="btnpastepre" value="\leftarrowtail">\(\leftarrowtail\)</button>
					<button class="btnpastepre" value="\leftrightarrows">\(\leftrightarrows\)</button>
					<button class="btnpastepre" value="\rightleftarrows">\(\rightleftarrows\)</button>
					<button class="btnpastepre" value="\rightsquigarrow">\(\rightsquigarrow\)</button>
					<button class="btnpastepre" value="\leftrightsquigarrow">\(\leftrightsquigarrow\)</button>
					<button class="btnpastepre" value="\looparrowleft">\(\looparrowleft\)</button>
					<button class="btnpastepre" value="\looparrowright">\(\looparrowright\)</button>
					<button class="btnpastepre" value="\Rrightarrow">\(\Rrightarrow\)</button>
					<button class="btnpastepre" value="\Lleftarrow">\(\Lleftarrow\)</button>
					<button class="btnpastepre" value="\nleftarrow">\(\nleftarrow\)</button>
					<button class="btnpastepre" value="\nrightarrow">\(\nrightarrow\)</button>
					<button class="btnpastepre" value="\nLeftarrow">\(\nLeftarrow\)</button>
					<button class="btnpastepre" value="\nRightarrow">\(\nRightarrow\)</button>
					<button class="btnpastepre" value="\nLeftrightarrow">\(\nLeftrightarrow\)</button>
					<button class="btnpastepre" value="\nleftrightarrow">\(\nleftrightarrow\)</button>
					<button class="btnpastepre" value="\circlearrowleft">\(\circlearrowleft\)</button>
					<button class="btnpastepre" value="\curvearrowright">\(\curvearrowright\)</button>
					<button class="btnpastepre" value="\dashrightarrow">\(\dashrightarrow\)</button>
					<button class="btnpastepre" value="\dashleftarrow">\(\dashleftarrow\)</button>
				</div>
					<p class="formul_buttons formul">►Стандартные функции</p>
					<div class="formul_buttons_body formul_body">
					<button class="btnpastepre" value="\log">\(\log\)</button>
					<button class="btnpastepre" value="\lg">\(\lg\)</button>
					<button class="btnpastepre" value="\ln">\(\ln\)</button>
					<button class="btnpastepre" value="\arg">\(\arg\)</button>
					<button class="btnpastepre" value="\ker">\(\ker\)</button>
					<button class="btnpastepre" value="\dim">\(\dim\)</button>
					<button class="btnpastepre" value="\hom">\(\hom\)</button>
					<button class="btnpastepre" value="\deg">\(\deg\)</button>
					<button class="btnpastepre" value="\exp">\(\exp\)</button>
					<button class="btnpastepre" value="\e">\(\e\)</button>
					<button class="btnpastepre" value="\sin">\(\sin\)</button>
					<button class="btnpastepre" value="\arcsin">\(\arcsin\)</button>
					<button class="btnpastepre" value="\cos">\(\cos\)</button>
					<button class="btnpastepre" value="\arccos">\(\arccos\)</button>
					<button class="btnpastepre" value="\tg">\(\tg\)</button>
					<button class="btnpastepre" value="\arctg">\(\arctg\)</button>
					<button class="btnpastepre" value="\ctg">\(\ctg\)</button>
					<button class="btnpastepre" value="\sec">\(\sec\)</button>
					<button class="btnpastepre" value="\cosec">\(\cosec\)</button>
					<button class="btnpastepre" value="\sinh">\(\sinh\)</button>
					<button class="btnpastepre" value="\cosh">\(\cosh\)</button>
					<button class="btnpastepre" value="\tgh">\(\tgh\)</button>
					<button class="btnpastepre" value="\ctgh">\(\ctgh\)</button>
				</div>
				<p class="formul_buttons formul">►Операции с разным расположением степеней и индексов</p>
				<div class="formul_buttons_body formul_body">
					<p class="formul_title formul_buttons formul ">►Степени и индексы справа от символа(для строчных формул), или сверху и снизу(для выключных)</p>
					<div class="formul_buttons_body formul_body">
						<button class="btnpastepre" value="\sum">\(\sum\)</button>
						<button class="btnpastepre" value="\prod">\(\prod\)</button>
						<button class="btnpastepre" value="\coprod">\(\coprod\)</button>
						<button class="btnpastepre" value="\bigcap">\(\bigcap\)</button>
						<button class="btnpastepre" value="\bigcup">\(\bigcup\)</button>
						<button class="btnpastepre" value="\bigoplus">\(\bigoplus\)</button>
						<button class="btnpastepre" value="\bigotimes">\(\bigotimes\)</button>
						<button class="btnpastepre" value="\bigodot">\(\bigodot\)</button>
						<button class="btnpastepre" value="\bigvee">\(\bigvee\)</button>
						<button class="btnpastepre" value="\bigwedge">\(\bigwedge\)</button>
						<button class="btnpastepre" value="\biguplus">\(\biguplus\)</button>
						<button class="btnpastepre" value="\bigsqcup">\(\bigsqcup\)</button>
						<button class="btnpastepre" value="\lim">\(\lim\)</button>
						<button class="btnpastepre" value="\limsup">\(\limsup\)</button>
						<button class="btnpastepre" value="\liminf">\(\liminf\)</button>
						<button class="btnpastepre" value="\varlimsup">\(\varlimsup\)</button>
						<button class="btnpastepre" value="\varliminf">\(\varliminf\)</button>
						<button class="btnpastepre" value="\injlim">\(\injlim\)</button>
						<button class="btnpastepre" value="\projlim">\(\projlim\)</button>
						<button class="btnpastepre" value="\varinjlim">\(\varinjlim\)</button>
						<button class="btnpastepre" value="\varprojlim">\(\varprojlim\)</button>
						<button class="btnpastepre" value="\max">\(\max\)</button>
						<button class="btnpastepre" value="\min">\(\min\)</button>
						<button class="btnpastepre" value="\sup">\(\sup\)</button>
						<button class="btnpastepre" value="\inf">\(\inf\)</button>
						<button class="btnpastepre" value="\det">\(\det\)</button>
						<button class="btnpastepre" value="\Pr">\(\Pr\)</button>
						<button class="btnpastepre" value="\gcd">\(\gcd\)</button>
					</div>
					<p class="formul_title formul_buttons formul">►Степени и индексы справа от символа(для выключных формул)</p>
					<div class="formul_buttons_body formul_body">
						<button class="btnpastepre" value="\sum\nolimits">\(\sum\nolimits\)</button>
						<button class="btnpastepre" value="\prod\nolimits">\(\prod\nolimits\)</button>
						<button class="btnpastepre" value="\coprod">\(\coprod\nolimits\)</button>
						<button class="btnpastepre" value="\bigcap">\(\bigcap\nolimits\)</button>
						<button class="btnpastepre" value="\bigcup">\(\bigcup\nolimits\)</button>
						<button class="btnpastepre" value="\bigoplus">\(\bigoplus\nolimits\)</button>
						<button class="btnpastepre" value="\bigotimes">\(\bigotimes\nolimits\)</button>
						<button class="btnpastepre" value="\bigodot">\(\bigodot\nolimits\)</button>
						<button class="btnpastepre" value="\bigvee">\(\bigvee\nolimits\)</button>
						<button class="btnpastepre" value="\bigwedge">\(\bigwedge\nolimits\)</button>
						<button class="btnpastepre" value="\biguplus">\(\biguplus\nolimits\)</button>
						<button class="btnpastepre" value="\bigsqcup">\(\bigsqcup\nolimits\)</button>
						<button class="btnpastepre" value="\lim">\(\lim\nolimits\)</button>
						<button class="btnpastepre" value="\limsup">\(\limsup\nolimits\)</button>
						<button class="btnpastepre" value="\liminf">\(\liminf\nolimits\)</button>
						<button class="btnpastepre" value="\varlimsup">\(\varlimsup\nolimits\)</button>
						<button class="btnpastepre" value="\varliminf">\(\varliminf\nolimits\)</button>
						<button class="btnpastepre" value="\injlim">\(\injlim\nolimits\)</button>
						<button class="btnpastepre" value="\projlim">\(\projlim\nolimits\)</button>
						<button class="btnpastepre" value="\varinjlim">\(\varinjlim\nolimits\)</button>
						<button class="btnpastepre" value="\varprojlim">\(\varprojlim\nolimits\)</button>
						<button class="btnpastepre" value="\max">\(\max\nolimits\)</button>
						<button class="btnpastepre" value="\min">\(\min\nolimits\)</button>
						<button class="btnpastepre" value="\sup">\(\sup\nolimits\)</button>
						<button class="btnpastepre" value="\inf">\(\inf\nolimits\)</button>
						<button class="btnpastepre" value="\det">\(\det\nolimits\)</button>
						<button class="btnpastepre" value="\Pr">\(\Pr\nolimits\)</button>
						<button class="btnpastepre" value="\gcd">\(\gcd\nolimits\)</button>
					</div>
				</div>
				<p class="formul_buttons formul">►Интегралы</p>
				<div class="formul_buttons_body formul_body">
					<p class="formul_title formul_buttons formul">►Степени и индексы справа от символа</p>
					<div class="formul_buttons_body formul_body">
						<button class="btnpastepre" value="\int">\(\int\)</button>
						<button class="btnpastepre" value="\oint">\(\oint\)</button>
						<button class="btnpastepre" value="\iint">\(\iint\)</button>
						<button class="btnpastepre" value="\iiint">\(\iiint\)</button>
						<button class="btnpastepre" value="\iiiint">\(\iiiint\)</button>
					</div>
					<p class="formul_title formul_buttons formul">►Степени и индексы сверху и снизу от символа</p>
					<div class="formul_buttons_body formul_body">
						<button class="btnpastepre" value="\int">\(\int\limits\)</button>
						<button class="btnpastepre" value="\oint">\(\oint\limits\)</button>
						<button class="btnpastepre" value="\iint">\(\iint\limits\)</button>
						<button class="btnpastepre" value="\iiint">\(\iiint\limits\)</button>
						<button class="btnpastepre" value="\iiiint">\(\iiiint\limits\)</button>
					</div>
				</div>
				<p class="formul_buttons formul">►Разное</p>
				<div class="formul_buttons_body formul_body">
					<button class="btnpastepre" value="\partial">\(\partial\)</button>
					<button class="btnpastepre" value="\angle">\(\angle\)</button>
					<button class="btnpastepre" value="\infty">\(\infty\)</button>
					<button class="btnpastepre" value="\forall">\(\forall\)</button>
					<button class="btnpastepre" value="\exists">\(\exists\)</button>
					<button class="btnpastepre" value="\emptyset">\(\emptyset\)</button>
					<button class="btnpastepre" value="\neg">\(\neg\)</button>
					<button class="btnpastepre" value="\aleph">\(\aleph\)</button>
					<button class="btnpastepre" value="\prime">\(\prime\)</button>
					<button class="btnpastepre" value="\hbar">\(\hbar\)</button>
					<button class="btnpastepre" value="\nabla">\(\nabla\)</button>
					<button class="btnpastepre" value="\imath">\(\imath\)</button>
					<button class="btnpastepre" value="\jmath">\(\jmath\)</button>
					<button class="btnpastepre" value="\ell">\(\ell\)</button>
					<button class="btnpastepre" value="\surd">\(\surd\)</button>
					<button class="btnpastepre" value="\flat">\(\flat\)</button>
					<button class="btnpastepre" value="\sharp">\(\sharp\)</button>
					<button class="btnpastepre" value="\natural">\(\natural\)</button>
					<button class="btnpastepre" value="\wp">\(\wp\)</button>
					<button class="btnpastepre" value="\Re">\(\Re\)</button>
					<button class="btnpastepre" value="\Im">\(\Im\)</button>
					<button class="btnpastepre" value="\backslash">\(\backslash\)</button>
					<button class="btnpastepre" value="\spadesuit">\(\spadesuit\)</button>
					<button class="btnpastepre" value="\clubsuit">\(\clubsuit\)</button>
					<button class="btnpastepre" value="\diamondsuit">\(\diamondsuit\)</button>
					<button class="btnpastepre" value="\heartsuit">\(\heartsuit\)</button>
					<button class="btnpastepre" value="\S">\(\S\)</button>
					<button class="btnpastepre" value="\mho">\(\mho\)</button>
					<button class="btnpastepre" value="\Box">\(\Box\)</button>
					<button class="btnpastepre" value="\Diamond">\(\Diamond\)</button>
					<button class="btnpastepre" value="\square">\(\square\)</button>
					<button class="btnpastepre" value="\lozenge">\(\lozenge\)</button>
					<button class="btnpastepre" value="\backprime">\(\backprime\)</button>
					<button class="btnpastepre" value="\blacktriangledown">\(\blacktriangledown\)</button>
					<button class="btnpastepre" value="\triangledown">\(\triangledown\)</button>
					<button class="btnpastepre" value="\measuredangle">\(\measuredangle\)</button>
					<button class="btnpastepre" value="\circledS">\(\circledS\)</button>
					<button class="btnpastepre" value="\diagup">\(\diagup\)</button>
					<button class="btnpastepre" value="\varnothing">\(\varnothing\)</button>
					<button class="btnpastepre" value="\Finv">\(\Finv\)</button>
					<button class="btnpastepre" value="\mho">\(\mho\)</button>
					<button class="btnpastepre" value="\beth">\(\beth\)</button>
					<button class="btnpastepre" value="\daleth">\(\daleth\)</button>
					<button class="btnpastepre" value="\varkappa">\(\varkappa\)</button>
					<button class="btnpastepre" value="\hslash">\(\hslash\)</button>
					<button class="btnpastepre" value="\blacksquare">\(\blacksquare\)</button>
					<button class="btnpastepre" value="\blacklozenge">\(\blacklozenge\)</button>
					<button class="btnpastepre" value="\bigstar">\(\bigstar\)</button>
					<button class="btnpastepre" value="\blacktriangle">\(\blacktriangle\)</button>
					<button class="btnpastepre" value="\angle">\(\angle\)</button>
					<button class="btnpastepre" value="\sphericalangle">\(\sphericalangle\)</button>
					<button class="btnpastepre" value="\complement">\(\complement\)</button>
					<button class="btnpastepre" value="\diagdown">\(\diagdown\)</button>
					<button class="btnpastepre" value="\nexists">\(\nexists\)</button>
					<button class="btnpastepre" value="\Game">\(\Game\)</button>
					<button class="btnpastepre" value="\eth">\(\eth\)</button>
					<button class="btnpastepre" value="\gimel">\(\gimel\)</button>
					<button class="btnpastepre" value="\digamma">\(\digamma\)</button>
					<button class="btnpastepre" value="\Bbbk">\(\Bbbk\)</button>
					<button class="btnpastepre" value="\hbar">\(\hbar\)</button>
					<button class="btnpastepre" value="\yen">\(\yen\)</button>
					<button class="btnpastepre" value="\circledR">\(\circledR\)</button>
					<button class="btnpastepre" value="\sqsubset">\(\sqsubset\)</button>
					<button class="btnpastepre" value="\vartriangleleft">\(\vartriangleleft\)</button>
					<button class="btnpastepre" value="\trianglelefteq">\(\trianglelefteq\)</button>
					<button class="btnpastepre" value="\square">\(\square\)</button>
					<button class="btnpastepre" value="\maltese">\(\maltese\)</button>
					<button class="btnpastepre" value="\checkmark">\(\checkmark\)</button>
					<button class="btnpastepre" value="\sqsupset">\(\sqsupset\)</button>
					<button class="btnpastepre" value="\vartriangleright">\(\vartriangleright\)</button>
					<button class="btnpastepre" value="\trianglerighteq">\(\trianglerighteq\)</button>
					<button class="btnpastepre" value="\lozenge">\(\lozenge\)</button>
				</div>
				<p class="formul_buttons formul">►Отрицания</p>
				<div class="formul_buttons_body formul_body">
					<button class="btnpastepre" value="\varnothing">\(\varnothing\)</button>
					<button class="btnpastepre" value="\nleq">\(\nleq\)</button>
					<button class="btnpastepre" value="\ngeq">\(\ngeq\)</button>
					<button class="btnpastepre" value="\nless">\(\nless\)</button>
					<button class="btnpastepre" value="\ngtr">\(\ngtr\)</button>
					<button class="btnpastepre" value="\nprec">\(\nprec\)</button>
					<button class="btnpastepre" value="\nsucc">\(\nsucc\)</button>
					<button class="btnpastepre" value="\nleqslant">\(\nleqslant\)</button>
					<button class="btnpastepre" value="\ngeqslant">\(\ngeqslant\)</button>
					<button class="btnpastepre" value="\npreceq">\(\npreceq\)</button>
					<button class="btnpastepre" value="\nsucceq">\(\nsucceq\)</button>
					<button class="btnpastepre" value="\nleqq">\(\nleqq\)</button>
					<button class="btnpastepre" value="\ngeqq">\(\ngeqq\)</button>
					<button class="btnpastepre" value="\nsim">\(\nsim\)</button>
					<button class="btnpastepre" value="\ncong">\(\ncong\)</button>
					<button class="btnpastepre" value="\nsubseteqq">\(\nsubseteqq\)</button>
					<button class="btnpastepre" value="\nsupseteqq">\(\nsupseteqq\)</button>
					<button class="btnpastepre" value="\nsubseteq">\(\nsubseteq\)</button>
					<button class="btnpastepre" value="\nsupseteq">\(\nsupseteq\)</button>
					<button class="btnpastepre" value="\nparallel">\(\nparallel\)</button>
					<button class="btnpastepre" value="\nmid">\(\nmid\)</button>
					<button class="btnpastepre" value="\nshortmid">\(\nshortmid\)</button>
					<button class="btnpastepre" value="\nshortparallel">\(\nshortparallel\)</button>
					<button class="btnpastepre" value="\nvdash">\(\nvdash\)</button>
					<button class="btnpastepre" value="\nVdash">\(\nVdash\)</button>
					<button class="btnpastepre" value="\nvDash">\(\nvDash\)</button>
					<button class="btnpastepre" value="\nVDash">\(\nVDash\)</button>
					<button class="btnpastepre" value="\ntrianglerighteq">\(\ntrianglerighteq\)</button>
					<button class="btnpastepre" value="\ntrianglelefteq">\(\ntrianglelefteq\)</button>
					<button class="btnpastepre" value="\ntriangleleft">\(\ntriangleleft\)</button>
					<button class="btnpastepre" value="\ntriangleright">\(\ntriangleright\)</button>
					<button class="btnpastepre" value="\nleftarrow">\(\nleftarrow\)</button>
					<button class="btnpastepre" value="\nrightarrow">\(\nrightarrow\)</button> 
					<button class="btnpastepre" value="\nLeftarrow">\(\nLeftarrow\)</button>
					<button class="btnpastepre" value="\nRightarrow">\(\nRightarrow\)</button>
					<button class="btnpastepre" value="\nLeftrightarrow">\(\nLeftrightarrow\)</button>
					<button class="btnpastepre" value="\nleftrightarrow">\(\nleftrightarrow\)</button>
				</div>
				<p class="formul_buttons formul">►Большие скобки</p>
				<div class="formul_buttons_body formul_body">
					<button class="btnpastepre" value="\left(">\((\)</button>
					<button class="btnpastepre" value="\right)">\()\)</button>
					<button class="btnpastepre" value="\left[">\([\)</button>
					<button class="btnpastepre" value="\right]">\(]\)</button>
					<button class="btnpastepre" value="\left\{">\(\{\)</button>
					<button class="btnpastepre" value="\right\}">\(\}\)</button>
					<button class="btnpastepre" value="\left\lfloor">\(\lfloor\)</button>
					<button class="btnpastepre" value="\right\rfloor">\(\rfloor\)</button>
					<button class="btnpastepre" value="\left\lceil">\(\lceil\)</button>
					<button class="btnpastepre" value="\right\rceil">\(\rceil\)</button>
					<button class="btnpastepre" value="\left\langle">\(\langle\)</button>
					<button class="btnpastepre" value="\right\rangle">\(\rangle\)</button>
					<button class="btnpastepre" value="\left\backslash">\(\backslash\)</button>
					<button class="btnpastepre" value="\right/">\(/\)</button>
					<button class="btnpastepre" value="\|">\(\|\)</button>
					<button class="btnpastepre" value="|">\(|\)</button>
					<button class="btnpastepre" value="\ulcorner">\(\ulcorner\)</button>
					<button class="btnpastepre" value="\urcorner">\(\urcorner\)</button>
					<button class="btnpastepre" value="\llcorner">\(\llcorner\)</button>
					<button class="btnpastepre" value="\lrcorner">\(\lrcorner\)</button>
				</div>
				<p class="formul_buttons formul">►Надстрочные знаки</p>
				<div class="formul_buttons_body formul_body">
					<button class="btnpastepre" value="\hat{}">\(\hat a\)</button>
					<button class="btnpastepre" value="\check{}">\(\check a\)</button>
					<button class="btnpastepre" value="\tilde{}">\(\tilde a\)</button>
					<button class="btnpastepre" value="\acute{}">\(\acute a\)</button>
					<button class="btnpastepre" value="\grave{}">\(\grave a\)</button>
					<button class="btnpastepre" value="\dot{}">\(\dot a\)</button>
					<button class="btnpastepre" value="\ddot{}">\(\ddot a\)</button>
					<button class="btnpastepre" value="\breve{}">\(\breve a\)</button>
					<button class="btnpastepre" value="\bar{}">\(\bar a\)</button>
					<button class="btnpastepre" value="\vec{}">\(\vec a\)</button>
					<button class="btnpastepre" value="\overline{}">\(\overline {abcx}\)</button>
				</div>
			<?php endif ?>
		</div>
		<!--  Выподающее меню -->
		<div id="nav_menu">
			<nav id="menu1">
			 <ul>
			  <li><a href="index.php">Главная</a></li>
			  <li><a href="#m2">О нас</a></li>
			  <li><a href="#m3">Тесты</a>
			   <ul>
			    <li><a href="TestList.php">Каталог тестов</a></li>
				<?php if(isset($_COOKIE['root'])&&($_COOKIE['root']=="студент")){?>
					<li><a href="#m3_4">Статистика</a></li>
					<li><a href="#m3_5">Пройти тест по приглашению</a></li>
			    <?php }else if(isset($_COOKIE['root'])&&($_COOKIE['root']=="учитель")){?>
					<li><a href="#m3_3">Мой каталог</a></li>
					<li><a href="createtest.html.php">Создать тест</a></li>
					<li><a href="#m3_5">Создать приглашение</a></li>
				<?php } ?>
			   </ul>
			  </li>
			  <li><a href="#m4">Новости</a></li>
			  <li><a href="#m5">Контакты</a></li>
			 </ul>
			</nav><!--menu1-->
			<div class="profile">
				<?php
					if (isset($_COOKIE['name'])&&isset($_COOKIE["surname"])):?>
						<p class="exit_menu"><?=htmlspecialchars($_COOKIE['name'])." <br /> ".htmlspecialchars($_COOKIE['surname'])?></p>
						<div class="exit_menu_body" style="display:none">

							<div class="exit_menu_elements">
							<p class="exit_menu_stat">Роль: <?=$_COOKIE['root'];?></p>
							</div>
							
							<div class="exit_title exit_menu_elements">

								<p><a href="vyhod.php">Выход</a></p>
							</div>
						</div>
					<?php 
			
			else:?>
						<div class="enter_site_btn">
							<a  href="nevEnter.html.php">Войти</a>
						</div>
				<?php endif?>
			</div>
		</div>

	</div>


	
	
	<div id="footer"><!--  Футер либо подвал сайта -->
		<div class="text">
			2020
		</div>
	</div>


	
	
</body>
</html>