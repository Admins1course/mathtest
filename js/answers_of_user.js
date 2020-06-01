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
	if (flagAnswers){
		$('#answer').attr('type','submit').attr("id","send");
	}
	else{
		$('#answer').attr('type','button').attr("id","answer");
	}
	error=document.getElementById("error");
	error.innerHTML="";
}