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
			$(this).find('.swipe_left')[0].disabled=true;
			$(this).find('.swipe_right')[0].disabled=true;
			$('form .textarea_template:last .main_text').attr('name','task'+tasks+'[total_task]');
			$('form .textarea_template:last .inputfile').attr('name','task'+tasks+'[icontest1][myPhoto]');
			lenghts['task'+tasks]={'icontest':1};
			$('form .textarea_template:last .areatext #answer').attr('name','task'+tasks+'[textarea_answer]');
			$('form .textarea_template:last .textForPoints').attr('for','points'+tasks);
			$('form .textarea_template:last .points').attr('id','points'+tasks).attr('name','task'+tasks+'[points]');
			document.getElementById('task_menu_body').innerHTML+='<p class="'+this.id+' task_number_menu" onclick="showTask(this)">Задание '+this.id.slice(4)+'</p>';
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
			$(this).find('.swipe_left')[0].disabled=true;
			$(this).find('.swipe_right')[0].disabled=true;
			$('form .radiobutton_template:last .main_text').attr('name','task'+tasks+'[total_task]');
			$('form .radiobutton_template:last .inputfile').attr('name','task'+tasks+'[icontest1][myPhoto]');
			$('form .radiobutton_template:last .radio .button_radio').attr('name','task'+tasks+'[radio]').attr('value',1);
			$('form .radiobutton_template:last .radio .input_text').attr('name','task'+tasks+'[text_answer1]');
			lenghts['task'+tasks]={}
			lenghts['task'+tasks]['radio_answer']=1;
			lenghts['task'+tasks]['icontest']=1;
			$('form .radiobutton_template:last .textForPoints').attr('for','points'+tasks);
			$('form .radiobutton_template:last .points').attr('id','points'+tasks).attr('name','task'+tasks+'[points]');
			document.getElementById('task_menu_body').innerHTML+='<p class="'+this.id+' task_number_menu" onclick="showTask(this)">Задание '+this.id.slice(4)+'</p>';
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
			$(this).find('.swipe_left')[0].disabled=true;
			$(this).find('.swipe_right')[0].disabled=true;
			$('form .checkboxbutton_template:last .main_text').attr('name','task'+tasks+'[total_task]');
			$('form .checkboxbutton_template:last .inputfile').attr('name','task'+tasks+'[icontest1][myPhoto]');
			$('form .checkboxbutton_template:last .check .button_checkbox').attr('name','task'+tasks+'[checkbox_answer1][checkbox]').attr('value',1);
			$('form .checkboxbutton_template:last .check .input_text').attr('name','task'+tasks+'[checkbox_answer1][text_answer]');
			lenghts['task'+tasks]={}
			lenghts['task'+tasks]['checkbox_answer']=1;
			lenghts['task'+tasks]['icontest']=1;
			$('form .checkboxbutton_template:last .textForPoints').attr('for','points'+tasks);
			$('form .checkboxbutton_template:last .points').attr('id','points'+tasks).attr('name','task'+tasks+'[points]');
			document.getElementById('task_menu_body').innerHTML+='<p class="'+this.id+' task_number_menu" onclick="showTask(this)">Задание '+this.id.slice(4)+'</p>';
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
			$(this).find('.swipe_left')[0].disabled=true;
			$(this).find('.swipe_right')[0].disabled=true;
			$('form .input_template:last .main_text').attr('name','task'+tasks+'[total_task]');
			$('form .input_template:last .inputfile').attr('name','task'+tasks+'[icontest1][myPhoto]');
			$('form .input_template:last .inp input').attr('name','task'+tasks+'[input_answer]');
			$('form .input_template:last .textForPoints').attr('for','points'+tasks);
			lenghts['task'+tasks]={}
			lenghts['task'+tasks]={'icontest':1};
			$('form .input_template:last .points').attr('id','points'+tasks).attr('name','task'+tasks+'[points]');
			document.getElementById('task_menu_body').innerHTML+='<p class="'+this.id+' task_number_menu" onclick="showTask(this)">Задание '+this.id.slice(4)+'</p>';
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
		$('.'+className[1]+' .add_button_answer:hidden:last').prev().clone('deepWithDataAndEvents').css('display','none').insertBefore(
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

function closeIcontest(el){
	let parentEl=el.parentElement;
	let prevparentEl=parentEl.parentElement.parentElement;
	swipeRight=$(prevparentEl).children('.swipe_right');
	swipeLeft=swipeRight.prev();
	parentEl.parentElement.removeChild(parentEl);
	first_el=$(swipeRight[0]['parentElement']).children('.all_icon_load').children('.icontest:visible:first');
	last_el=$(swipeRight[0]['parentElement']).children('.all_icon_load').children('.icontest:visible:last');
	if (!(swipeRight[0].disabled)){
		last_el[0].nextElementSibling.hidden=false;
		last_el=last_el[0].nextElementSibling;
		if (last_el.nextElementSibling===null){
			swipeRight[0].disabled=true;
			swipeRight.removeClass('active_swipe');
		}
	}
	else if(!(swipeLeft[0].disabled)){
		first_el[0].previousElementSibling.hidden=false;
		first_el=first_el[0].previousElementSibling;
		if (first_el.previousElementSibling===null){
			swipeLeft[0].disabled=true;
			swipeLeft.removeClass('active_swipe');
		}
	}
}

function closeRC(el){
	let parentEl=el.parentElement;
	let prevparentEl=parentEl.parentElement;
	swipeUp=$(prevparentEl).children('.swipe_up');
	swipeDown=$(prevparentEl).children('.swipe_down');
	$(parentEl).slideUp(1000, function(){
		parentEl.parentElement.removeChild(parentEl);
	});
	let classAnswer=swipeUp.closest('[class^="task"]').attr('class').split(' ');
	classAnswer=classAnswer[1].substring(0,5);
	first_el=$(swipeUp[0]['parentElement']).children('.'+classAnswer+':visible:first');
	last_el=$(swipeUp[0]['parentElement']).children('.'+classAnswer+':visible:last');
	if (!(swipeDown[0].disabled)){
		$(last_el[0].nextElementSibling).slideDown(1000);
		last_el=last_el[0].nextElementSibling;
		if (!$(last_el.nextElementSibling).hasClass(classAnswer)){
			swipeDown[0].disabled=true;
			swipeDown.removeClass('active_swipe');
		}
	}
	else if(!(swipeUp[0].disabled)){
		$(first_el[0].previousElementSibling).slideDown(1000);
		first_el=first_el[0].previousElementSibling;
		if (!$(first_el.previousElementSibling).hasClass(classAnswer)){
			swipeUp[0].disabled=true;
			swipeUp.removeClass('active_swipe');
		}
	}
}

function closeTask(el){
	let parentEl=el.parentElement;
	let prevparentEl=parentEl.parentElement;
	swipeUp=$('#arrow-up');
	swipeDown=$('#arrow-down');
	thisTask.slideUp(1000, function(){
		parentEl.parentElement.removeChild(parentEl);
	});
	taskName=document.getElementsByClassName(thisTask[0].id);
	document.getElementById('task_menu_body').removeChild(taskName[0]);
	if ((swipeDown[0].disabled!==undefined)&&(!Number(swipeDown.prop('disabled')))){
		console.log('hi');
		thisTask=$(thisTask[0].nextElementSibling);
		thisTask.slideDown(1000);
		if(!thisTask.next().hasClass('task')){
			swipeDown[0].disabled=true;
			swipeDown.removeClass('active_swipe');
		}
	}
	else if ((swipeUp[0].disabled!==undefined)&&(!Number(swipeUp.prop('disabled')))){
		console.log('ki');
		thisTask=$(thisTask[0].previousElementSibling);
		thisTask.slideDown(1000);
		if(!thisTask.prev().hasClass('task')){
			swipeUp[0].disabled=true;
			swipeUp.removeClass('active_swipe');
		}
	}
	else{
		thisTask=undefined;
		swipeDown[0].style.display="none";
		swipeUp[0].style.display="none";
	}
}

function showTask(el){
	console.log(el);
	if(thisTask[0]!=$('#'+el.classList[0])[0]){
		thisTask.slideUp(1000);
		$('#'+el.classList[0]).slideDown(1000);
		thisTask=$('#'+el.classList[0]);
		$('#arrow-down')[0].disabled=false;
		$('#arrow-down').addClass('active_swipe');
		$('#arrow-up')[0].disabled=false;
		$('#arrow-up').addClass('active_swipe');
		if (!thisTask.prev().hasClass('task')){
			$('#arrow-up')[0].disabled=true;
			$('#arrow-up').removeClass('active_swipe');
			$('#arrow-down')[0].disabled=false;
			$('#arrow-down').addClass('active_swipe');
		}
		else if (!thisTask.next().hasClass('task')){
			$('#arrow-down')[0].disabled=true;
			$('#arrow-down').removeClass('active_swipe');
			$('#arrow-up')[0].disabled=false;
			$('#arrow-up').addClass('active_swipe');
		}
	}
}

function sendData(){
	let d=document;
	let btns=d.getElementsByClassName('form_btn_send');
	for(let i=0;i<btns.length;i++){
		btns[i].style.display='none';
	}
	d.getElementById('check-test').style.display='block';

	function testing(value){
    return new Promise(function(resolve, reject){
        masOfPromis=[new Promise(function(resolve, reject){
        	id=value[0].id;
        	let imagesFlag=0;
        	for(let i=0; i<$("#"+id+" .inputfile" ).length; i++){
        		let files = $("#"+id+" .inputfile" )[i].files;
        		if(files.length){
        			imagesFlag=1;
        			break;
        		}
        	}
        	if(($("#"+id+" .requirement_of_job textarea" )[0].value!=="")||(imagesFlag)){
        		resolve(value);
        	}
        	else{
        		reject($("#"+id+" .requirement_of_job"));
        	}
        })];
        /*switch(value){
		    case 'areatext':masOfPromis.push(
		            new Promise(function(resolve,reject){
		            resolve()
		        }));
		        break;
		    case 'radio':masOfPromis.push(
		            new Promise(function(resolve,reject){
		                resolve()
		            }));
		        break;
		}
    	masOfPromis.push(new Promise)*/
    	Promise.all(masOfPromis).then(resolve).catch(reject);
    }) 
}

function addClass(value){
    $(value).addClass('text_fade');
    $('.popup-fade').fadeOut(0);
     showTask($("."+$(value).closest('.task')[0].id)[0]);
    //value[0].scrollIntoView();
    let top=value[0].offsetTop;
    window.scrollTo({
    top: top + 500,
    behavior: "smooth"
});
    //скролл к value[0]
}
function recursion(value){
    if (value[0].next().hasClass('task')){
        testing(value[0].next()).then(recursion).catch(addClass);}
    }
$('.text_fade').removeClass('text_fade');
testing($('form .task:first')).then(recursion).catch(addClass);
}
