$(document).ready(function(){setInterval(notifications,10000);});
var dataNotifications=0;
var clearNot=true;
function notifications(){
	$.ajax({
		url:document.location.origin+"/getNotifications.php",
		cache:false,
		dataType:'json',
		type:'POST',
		error:function(data){console.log(data)},
		success:function(data){
			if ((clearNot)||(data!==[])){
				dataNotifications=data;
				if (data.length==0) return;
				if (data.length>9) count="9+";
				else count=data.length;
				countNotifications='Оповещения<div class="notifications">';
				countNotifications+='<div class="notific_num"><p>'+count+'</p></div></div>';
				$('.open_notifications_body a').html(countNotifications);
				htmlMessage='<div class="notifications_body_title">';
				htmlMessage+='<div class="notifications_body_title_elements_div">';
				htmlMessage+='<div class="notifications_body_text">';
				htmlMessage+='<p class="text_notification_body">Оповещения</p>';
				htmlMessage+='</div><div class="notifications_body_title_element_bar">'
				htmlMessage+='</div></div></div>';
				for (i=0;i<data.length;i++){
					htmlMessage+='<div class="notifications_bar"><p class="text_notifications_bar">';
					htmlMessage+=data[i]['message'];
					htmlMessage+='</p>';
					htmlMessage+='<input type="button" id="userId'+data[i]['add_friends']+'" value="Принять" onclick="acceptApp(this)">';
					htmlMessage+='<input type="button" id="userId'+data[i]['add_friends']+'" value="Отменить" onclick="cancelApp(this)">';
					htmlMessage+='</div>';
				}
				$('.notifications_body').html(htmlMessage);
				clearNot=false;
			}
		}
	});
}
	
$(document).ready(function(){$('#notif').click(function(){
		
		if ($('.notifications_body').is(':visible')){
			$('.open_notifications_body a').html('Оповещения');
			htmlMessage='<div class="notifications_body_title">';
			htmlMessage+='<div class="notifications_body_title_elements_div">';
			htmlMessage+='<div class="notifications_body_text">';
			htmlMessage+='<p class="text_notification_body">Оповещения</p>';
			htmlMessage+='</div><div class="notifications_body_title_element_bar">'
			htmlMessage+='</div></div></div>';
			$('.notifications_body').html(htmlMessage);
			unreadNot();
		}
		else unreadNot();
	});
});

function unreadNot(){
	dataNot={};
		if (dataNotifications.length){
		for (i=0;i<dataNotifications.length;i++){				
			dataNot[String(i)]=dataNotifications[i];
		}
		$.ajax({
			url:document.location.origin+"/mathtest/unreadNotifications.php",
			cache:false,
			type:'POST',
			dataType:'json',
			data:dataNot,
			error:function(data){console.log(data);},
			success:function(data){}
		});
	}
	clearNot=true;
}
	
function acceptApp(element){
	$idFriend=$(element).attr('id').replace('userId','');
	$.ajax({
		url:document.location.origin+"/mathtest/acceptApp.php",
		cache:false,
		type:'POST',
		dataType:'json',
		data:{id:$idFriend},
		error:function(data){console.log(data);},
		success:function(data){
			app="<p>Заявка принята</p>";
			$(element).closest('.notifications_bar').html(app);
		}
	});
}
	
function cancelApp(element){/*
	$idFriend=$(element).attr('id').replace('userId','');
	$.ajax({
		url:document.location.origin+"/mathtest/cancelApp.php",
		cache:false,
		type:'POST',
		dataType:'json',
		data:{id:$idFriend},
		error:function(data){console.log(data);},
		success:function(data){
			app="<p>Заявка принята</p>";
			$(element).closest('.notifications_bar').html(app);
		}
	});*/
}