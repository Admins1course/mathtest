$(document).ready(function(){setInterval(notifications,10000);});
var dataNotifications=0;
var clearNot=true;
function notifications(){
	$.ajax({
		url:document.location.origin+"/includes/getNotifications.php",
		cache:false,
		dataType:'json',
		type:'POST',
		error:function(data){console.log(data)},
		success:function(data){
			if ((clearNot)||(data!==[])){
				console.log(data);
				dataNotifications=data['notif'];
				if ((data['notif']['add_friends'].length+data['notif']['invitations'])==0) return;
				if ((data['notif']['add_friends'].length+data['notif']['invitations'])>9) count="9+";
				else count=data['notif']['add_friends'].length+data['notif']['invitations'].length;
				countNotifications='Оповещения<div class="notifications">';
				
				countNotifications+='<div class="notific_num"><p>'+count+'</p></div></div>';
				$('.open_notifications_body a').html(countNotifications);
				htmlMessage='<div class="notifications_body_title">';
				htmlMessage+='<div class="notifications_body_title_elements_div">';
				htmlMessage+='<div class="notifications_body_text">';
				htmlMessage+='<p class="text_notification_body">Оповещения</p>';
				htmlMessage+='</div><div class="notifications_body_title_element_bar">';
				htmlMessage+='</div></div></div>';
				for (i=0;i<data['notif']['add_friends'].length;i++){
					htmlMessage+='<div class="notifications_bar"><p class="text_notifications_bar">';
					htmlMessage+=data['notif']['add_friends'][i]['message'];
					htmlMessage+='</p>';
					htmlMessage+='<div class="button_friend "><input type="button" class="notifications_buttons" id="userId'+data['notif']['add_friends'][i]['add_friends']+'" value="Принять" onclick="acceptApp(this)" id-notification="'+data['add_friends']['notif'][i]['idNotif']+'">';
					htmlMessage+='<input type="button" class="notifications_buttons" id="userId'+data['notif']['add_friends'][i]['add_friends']+'" value="Отменить" onclick="cancelApp(this)" id-notification="'+data['notif']['add_friends'][i]['idNotif']+'">';
					htmlMessage+='</div></div>';
				}
				for (i=0;i<data['notif']['invitations'].length;i++){
					htmlMessage+='<div class="notifications_bar"><p class="text_notifications_bar">';
					htmlMessage+=data['notif']['invitations'][i]['message'];
					htmlMessage+='</p>';
					htmlMessage+='<div class="button_test notifications_buttons"><input type="button" value="Принять" recipient="'+data['notif']['invitations'][i]['recipient']+'" onclick="document.location=document.location.origin+\'/'+data['notif']['invitations'][i]['invitations']+'&recipient='+data['notif']['invitations'][i]['recipient']+'\'">';
					htmlMessage+='</div></div>';
				}

				htmlMessage+='<div class="notifications_body_info_div">'+'<div class="ShowAllNotifications">'+'<a style="padding: 0px; margin: 10px;"  href="allNotifications.html.php">Посмотреть прочтенные оповещения</a>'+'</div>'+'</div>';
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
			htmlMessage+='</div></div></div>'+'<div class="notifications_body_info_div">'+'<div class="ShowAllNotifications">'+'<a style="padding: 0px; margin: 10px;"  href="allNotifications.html.php">Посмотреть прочтенные оповещения</a>'+'</div>'+'</div>';
			$('.notifications_body').html(htmlMessage);
			unreadNot();
		}
		else unreadNot();
	});
});

function unreadNot(){
	dataNot={};
	if (dataNotifications.length){
		for (i=0;i<dataNotifications['add_friends'].length;i++){				
			dataNot[String(i)]=dataNotifications['add_friends'][i]['idNotif'];
		}
		for (i=0;i<dataNotifications['invitations'].length;i++){				
			dataNot[String(dataNotifications['add_friends'].length+i)]=dataNotifications['invitations'][i]['idNotif'];
		}
		$.ajax({
			url:document.location.origin+"/includes/unreadNotifications.php",
			cache:false,
			type:'POST',
			dataType:'json',
			data:dataNot,
			error:function(data){console.log(data);},
			success:function(data){console.log(data);}
		});
	}
	clearNot=true;
}
	
function acceptApp(element){
	$idFriend=$(element).attr('id').replace('userId','');
	console.log(element.getAttribute('id-notification'));
	$.ajax({
		url:document.location.origin+"/includes/acceptApp.php",
		cache:false,
		type:'POST',
		dataType:'json',
		data:{id:$idFriend,idNotif:element.getAttribute('id-notification')},
		error:function(data){console.log(data);},
		success:function(data){console.log(data);
			switch(data['answer']){
				case 'success':
					app="<p>Заявка принята</p>";
					$(element).closest('.notifications_bar').html(app);
					break;
				case 'errorDataFriend':
					alert("Невозможно добавить несуществующего пользователя");
					break;
				case 'serverError':
					alert("Произошла ошибка на сервере");
					break;
			}
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