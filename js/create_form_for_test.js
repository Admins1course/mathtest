$(document).ready(function(){
	let tasks=0;//количество заданий
	let lenghts={};//массив, фиксирующий количество элементов в заданиях, которые можно добавлять
	//форма с textarea
	$('#form_1').click(function(){
		tasks++;
		$('.textarea_template:hidden').clone('deepWithDataAndEvents').insertBefore('#form_handler').attr('id','task'+tasks).slideDown(1000,function(){
			//формируем аттрибут name для элементов, значение которых отправится на сервер
			$('form .textarea_template:last .main_text').attr('name','task'+tasks+'[total_task]');
			$('form .textarea_template:last #inputfile').attr('name','task'+tasks+'[icontest1][myPhoto]');
			lenghts['task'+tasks]={'icontest':1};
			$('form .textarea_template:last .areatext #answer').attr('name','task'+tasks+'[textarea_answer]');
			$('form .textarea_template:last .textForPoints').attr('for','points'+tasks);
			$('form .textarea_template:last .points').attr('id','points'+tasks).attr('name','task'+tasks+'[points]');
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
			$('.radiobutton_template:last .textForPoints').attr('for','points'+tasks);
			$('.radiobutton_template:last .points').attr('id','points'+tasks).attr('name','task'+tasks+'[points]');
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
			$('.checkboxbutton_template:last .textForPoints').attr('for','points'+tasks);
			$('.checkboxbutton_template:last .points').attr('id','points'+tasks).attr('name','task'+tasks+'[points]');
		});
	});
	//аналогично предыдущему, но форма с input
	$('#form_4').click(function(){
		tasks++;
		$('.input_template:hidden').clone('deepWithDataAndEvents').insertBefore('#form_handler').attr('id','task'+tasks).slideDown(1000,function(){
			$('.input_template:last .main_text').attr('name','task'+tasks+'[total_task]');
			$('.input_template:last .inp input').attr('name','task'+tasks+'[input_answer]');
			$('.input_template:last .textForPoints').attr('for','points'+tasks);
			lenghts['task'+tasks]={}
			$('.input_template:last .points').attr('id','points'+tasks).attr('name','task'+tasks+'[points]');
		});
	});
	$('.button').click(function(){
		let className=$(this).closest('[class^="task"]').attr('class');//получаем значение класса родительского diva для данной кнопки
		let idName=$(this).closest('[class^="task"]').attr('id');//извлекаем все классы
		className=className.split(' ');//получаем также id, генерируемое при создании diva
		//добавляем div icontest
		idTask=$(this).closest('[class^="task"]').attr('id');
		first_el=$('#'+idTask+' .icontest:visible:first');
		last_el=$('#'+idTask+' .icontest:visible:last');
		count_icon=$('#'+idTask+' .all_icon_load').children().length;
		if (count_icon>2) {
			first_el[0].hidden=true;
			$('#'+idTask+' .swipe_left').prop('disabled',false);
			$('#'+idTask+' .swipe_right').prop('disabled',true);
		}
		$('.'+className[1]+':hidden div[class="icontest"]').clone('deepWithDataAndEvents').css('display','none').insertBefore(
			this).slideDown(1000).children().not('#uploadPreview').each(function(index, el){
			//подготавливаем для элементов diva аттрибут name
			if($(this).attr('id')=='inputfile'){
				len=++lenghts[idName]['icontest'];
				$(this).attr('name','task'+tasks+'[icontest'+len+'][myPhoto]');
			}
		});
		if (count_icon>2) {
			  $('#'+idTask+' .swipe_left').prop('disabled','false');
		}
	});
	$('.add_button_answer').click(function(){
		let className=$(this).closest('div').attr('class');
		className=className.split(' ');
		let idName=$(this).closest('div').attr('id');
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
			else{
				if($(this).children('input').attr('id')=='checkboxbutton'){
					len=++lenghts[idName]['checkbox_answer'];
					$(this).attr('name','task'+tasks+'[checkbox_answer'+len+'][checkbox]');
				}
				else if($(this).attr('class')=='input_text'){
					len=lenghts[idName]['checkbox_answer'];
					$(this).attr('name','task'+tasks+'[checkbox_answer'+len+'][text_answer]');
				}
			}
		});
	});
});