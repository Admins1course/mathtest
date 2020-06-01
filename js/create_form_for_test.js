var thisTask;
$(document).ready(function(){
	let tasks=0;//количество заданий
	let lenghts={};//массив, фиксирующий количество элементов в заданиях, которые можно добавлять
	//форма с textarea
	$('#form_1').click(function(){
		tasks++;
		if (thisTask!==undefined){
			thisTask.slideUp(1000);
			$('#arrow-up').prop('disabled',false);
			$('#arrow-up').addClass('active_swipe');
			$('#arrow-down').prop('disabled',true);
			$('#arrow-down').removeClass('active_swipe');
		}
		else{
			document.getElementById("arrow-up").style.display="block";
			document.getElementById("arrow-down").style.display="block";
		}
		thisTask=$('.textarea_template:hidden:last').clone('deepWithDataAndEvents').insertBefore('#arrow-down').attr('id','task'+tasks).slideDown(1000,function(){
			//формируем аттрибут name для элементов, значение которых отправится на сервер
			$('form .textarea_template:last .main_text').attr('name','task'+tasks+'[total_task]');
			$('form .textarea_template:last .inputfile').attr('name','task'+tasks+'[icontest1][myPhoto]');
			lenghts['task'+tasks]={'icontest':1};
			$('form .textarea_template:last .areatext #answer').attr('name','task'+tasks+'[textarea_answer]');
			$('form .textarea_template:last .textForPoints').attr('for','points'+tasks);
			$('form .textarea_template:last .points').attr('id','points'+tasks).attr('name','task'+tasks+'[points]');
		});
	});
	//аналогично предыдущему, но форма с radiobutton
	$('#form_2').click(function(){
		tasks++;
		if (thisTask!==undefined){
			thisTask.slideUp(1000);
			$('#arrow-up').prop('disabled',false);
			$('#arrow-up').addClass('active_swipe');
			$('#arrow-down').prop('disabled',true);
			$('#arrow-down').removeClass('active_swipe');
		}
		else{
			document.getElementById("arrow-up").style.display="block";
			document.getElementById("arrow-down").style.display="block";
		}
		thisTask=$('.radiobutton_template:hidden:last').clone('deepWithDataAndEvents').insertBefore('#arrow-down').attr('id','task'+tasks).slideDown(1000,function(){
			$('form .radiobutton_template:last .main_text').attr('name','task'+tasks+'[total_task]');
			$('form .radiobutton_template:last .inputfile').attr('name','task'+tasks+'[icontest1][myPhoto]');
			$('form .radiobutton_template:last .radio .button_radio').attr('name','task'+tasks+'[radio]').attr('value',1);
			$('form .radiobutton_template:last .radio .input_text').attr('name','task'+tasks+'[text_answer1]');
			lenghts['task'+tasks]={}
			lenghts['task'+tasks]['radio_answer']=1;
			lenghts['task'+tasks]['icontest']=1;
			$('form .radiobutton_template:last .textForPoints').attr('for','points'+tasks);
			$('form .radiobutton_template:last .points').attr('id','points'+tasks).attr('name','task'+tasks+'[points]');
		});
	});
	//аналогично предыдущему, но форма с checkboxbutton
	$('#form_3').click(function(){
		tasks++;
		if (thisTask!==undefined){
			thisTask.slideUp(1000);
			$('#arrow-up').prop('disabled',false);
			$('#arrow-up').addClass('active_swipe');
			$('#arrow-down').prop('disabled',true);
			$('#arrow-down').removeClass('active_swipe');
		}
		else{
			document.getElementById("arrow-up").style.display="block";
			document.getElementById("arrow-down").style.display="block";
		}
		thisTask=$('.checkboxbutton_template:hidden:last').clone('deepWithDataAndEvents').insertBefore('#arrow-down').attr('id','task'+tasks).slideDown(1000,function(){
			$('form .checkboxbutton_template:last .main_text').attr('name','task'+tasks+'[total_task]');
			$('form .checkboxbutton_template:last .inputfile').attr('name','task'+tasks+'[icontest1][myPhoto]');
			$('form .checkboxbutton_template:last .check .button_checkbox').attr('name','task'+tasks+'[checkbox_answer1][checkbox]').attr('value',1);
			$('form .checkboxbutton_template:last .check .input_text').attr('name','task'+tasks+'[checkbox_answer1][text_answer]');
			lenghts['task'+tasks]={}
			lenghts['task'+tasks]['checkbox_answer']=1;
			lenghts['task'+tasks]['icontest']=1;
			$('form .checkboxbutton_template:last .textForPoints').attr('for','points'+tasks);
			$('form .checkboxbutton_template:last .points').attr('id','points'+tasks).attr('name','task'+tasks+'[points]');
		});
	});
	//аналогично предыдущему, но форма с input
	$('#form_4').click(function(){
		tasks++;
		if (thisTask!==undefined){
			thisTask.slideUp(1000);
			$('#arrow-up').prop('disabled',false);
			$('#arrow-up').addClass('active_swipe');
			$('#arrow-down').prop('disabled',true);
			$('#arrow-down').removeClass('active_swipe');
		}
		else{
			document.getElementById("arrow-up").style.display="block";
			document.getElementById("arrow-down").style.display="block";
		}
		thisTask=$('.input_template:hidden:last').clone('deepWithDataAndEvents').insertBefore('#arrow-down').attr('id','task'+tasks).slideDown(1000,function(){
			$('form .input_template:last .main_text').attr('name','task'+tasks+'[total_task]');
			$('form .input_template:last .inputfile').attr('name','task'+tasks+'[icontest1][myPhoto]');
			$('form .input_template:last .inp input').attr('name','task'+tasks+'[input_answer]');
			$('form .input_template:last .textForPoints').attr('for','points'+tasks);
			lenghts['task'+tasks]={}
			lenghts['task'+tasks]={'icontest':1};
			$('form .input_template:last .points').attr('id','points'+tasks).attr('name','task'+tasks+'[points]');
		});
	});
	$('.button').click(function(){
		if(this.disabled===false){
			this.disabled=true;
			let className=$(this).closest('[class^="task"]').attr('class');//получаем значение класса родительского diva для данной кнопки
			let idName=$(this).closest('[class^="task"]').attr('id');//извлекаем все классы
			className=className.split(' ');//получаем также id, генерируемое при создании diva
			//добавляем div icontest
			let idTask=$(this).closest('[class^="task"]').attr('id');
			let first_el=$('#'+idTask+' .icontest:visible:first');
			let count_icon=$('#'+idTask+' .all_icon_load').children().length;
			if (count_icon>2) {
				first_el[0].hidden=true;
				$('#'+idTask+' .swipe_left').prop('disabled',false);
				$('#'+idTask+' .swipe_left').addClass('active_swipe');
				$('#'+idTask+' .swipe_right').prop('disabled',true);
			}
			$('.'+className[1]+':hidden:last div[class="icontest"]').clone('deepWithDataAndEvents').css('display','none').insertBefore(
				this).slideDown(1000).children().not('#uploadPreview').each(function(index, el){
				//подготавливаем для элементов diva аттрибут name
				if($(this).attr('class')=='inputfile'){
					len=++lenghts[idName]['icontest'];
					$(this).attr('name','task'+tasks+'[icontest'+len+'][myPhoto]');
				}
			});
			this.disabled=false;
		}
	});
	$('.add_button_answer').click(function(){
		let className=$(this).closest('[class^="task"]').attr('class');
		className=className.split(' ');
		let idTask=$(this).closest('[class^="task"]').attr('id');
		let classAnswer;
		if (className[1]=='radiobutton_template') classAnswer='radio';
		else classAnswer='check';
		let idName=$(this).closest('[class^="task"]').attr('id');
		let first_el=$('#'+idTask+' .'+classAnswer+':visible:first');
		let count_icon=$('#'+idTask).children('.'+classAnswer).length;
		if (count_icon>4){
			first_el.slideUp(1000);
			$('#'+idTask+' .swipe_up').prop('disabled',false);
			$('#'+idTask+' .swipe_up').addClass('active_swipe');
			$('#'+idTask+' .swipe_down').prop('disabled',true);
		}
		$('.'+className[1]+' .add_button_answer:hidden').prev().clone('deepWithDataAndEvents').css('display','none').insertBefore(
			this).slideDown(1000).children().each(function(index,el){
			if (className[1]=='radiobutton_template'){
				if($(this).children('input').attr('id')=='radiobutton'){
					len=++lenghts[idName]['radio_answer'];
					$(this).children('input').attr('name','task'+tasks+'[radio]').attr('value',len);
				}
				else if($(this).attr('class')=='input_text'){
					len=lenghts[idName]['radio_answer'];
					$(this).attr('name','task'+tasks+'[text_answer'+len+']');
				}
			}
			else if (className[1]=='checkboxbutton_template'){
				if($(this).children('input').attr('id')=='checkboxbutton'){
					len=++lenghts[idName]['checkbox_answer'];
					$(this).children('input').attr('name','task'+tasks+'[checkbox_answer'+len+'][checkbox]').attr('value',len);
				}
				else if($(this).attr('class')=='input_text'){
					len=lenghts[idName]['checkbox_answer'];
					$(this).attr('name','task'+tasks+'[checkbox_answer'+len+'][text_answer]');
				}
			}
		});
	});
});
function swipeTask(element){
	if(element.id=="arrow-up"){
		if ((element.disabled!==undefined)&&(!Number($(element).prop('disabled')))){
			thisTask.slideUp(1000);
			thisTask=$(thisTask[0].previousElementSibling);
			thisTask.slideDown(1000);
			document.getElementById('arrow-down').disabled=false;
			$('#arrow-down').addClass('active_swipe');
			if(!thisTask.prev().hasClass('task')){
				element.disabled=true;
				$(element).removeClass('active_swipe');
				$('#arrow-down').addClass('active_swipe');
			}
		}
	}
	if(element.id=="arrow-down"){
		if ((element.disabled!==undefined)&&(!Number($(element).prop('disabled')))){
			thisTask.slideUp(1000);
			thisTask=$(thisTask[0].nextElementSibling);
			thisTask.slideDown(1000);
			document.getElementById('arrow-up').disabled=false;
			$('#arrow-up').addClass('active_swipe');
			if(!thisTask.next().hasClass('task')){
				element.disabled=true;
				$(element).removeClass('active_swipe');
				$('#arrow-up').addClass('active_swipe');
			}
		}
	}
}