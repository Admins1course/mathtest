<?php @session_start();?>
<script>
function addFriend(element){
	console.log('hi');
	$idFriend=$(element).attr('id').replace('user','');
	friendMessage={message:<?="'".htmlspecialchars($_SESSION['data-user']['name'])."'"?>+' '+<?="'".htmlspecialchars($_SESSION['data-user']['surname'])."'"?>+' хочет добавить вас в друзья.',
				   idFriend:$idFriend};
	console.log('ki');
	$.ajax({
		url:document.location.origin+"/includes/addFriend.php",
		cache:false,
		dataType:'json',
		data:friendMessage,
		type:'POST',
		error:function(data){console.log(data)},
		success:function(data){
			console.log(data);
			switch(data['answer']){
				case 'success':
					$(element).val('Отменить заявку').attr("onclick","cancelAddFriend(this)");
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
function cancelAddFriend(element){
	$idFriend=$(element).attr('id').replace('user','');
	dataPost={id:$idFriend};
	$.ajax({
		url:document.location.origin+"/includes/cancelAddFriend.php",
		cache:false,
		type:'POST',
		dataType:'json',
		data:dataPost,
		error:function(data){console.log(data)},
		success:function(data){
			switch(data['answer']){
				case 'success':
					$(element).val('+ В друзья').attr("onclick","addFriend(this)");
					break;
				case 'errorDataFriend':
					alert("Невозможно добавить несуществующего пользователя");
					break;
				case 'serverError':
					alert("Произощла ошибка на сервере");
					break;
			}
		}
	});
}
</script>