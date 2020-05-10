function addFriend(element){
	$idFriend=$(element).attr('id').replace('user','');
	friendMessage={message:<?="'".$_SESSION['data-user']['name']."'"?>+' '+<?="'".$_SESSION['data-user']['surname']."'"?>+' хочет добавить вас в друзья',
				   myid:<?="'".$_SESSION['data-user']['id']."'"?>,
				   idFriend:$idFriend,
				   root:$(element).attr('name')};
	$.ajax({
		url:document.location.origin+"/mathtest/addFriend.php",
		cache:false,
		dataType:'json',
		data:friendMessage,
		type:'POST',
		error:function(data){console.log(data)},
		success:function(data){
			$(element).val('Отменить заявку').attr("onclick","cancelAddFriend(this)");
		}
	});
}
function cancelAddFriend(element){
	$idFriend=$(element).attr('id').replace('user','');
	dataPost={id:$idFriend};
	$.ajax({
		url:document.location.origin+"/mathtest/cancelAddFriend.php",
		cache:false,
		type:'POST',
		dataType:'json',
		data:dataPost,
		error:function(data){console.log(data)},
		success:function(data){
			$(element).val('+ В друзья').attr("onclick","addFriend(this)");
		}
	});
}