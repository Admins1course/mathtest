<?php @session_start();
require_once 'checkSession.inc.php';
if($is_login):?>
	<script>
	function addFriend(element){
		console.log('hi');
		$idFriend=$(element).attr('id').replace('user','');
		friendMessage={message:<?="'".$_SESSION['data-user']['name']."'"?>+' '+<?="'".$_SESSION['data-user']['surname']."'"?>+' хочет добавить вас в друзья.',
					   idFriend:$idFriend};
		$.ajax({
			url:document.location.origin+"/addFriend.php",
			cache:false,
			dataType:'json',
			data:friendMessage,
			type:'POST',
			error:function(data){console.log(data)},
			success:function(data){
				switch(data['answer']){
					case 'success':
						$(element).val('Отменить заявку').attr("onclick","cancelAddFriend(this)");
						break;
					case 'errorDataUser':
						alert("Данные вашего аккаунта не подтверждены");
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
	function cancelAddFriend(element){
		$idFriend=$(element).attr('id').replace('user','');
		dataPost={id:$idFriend};
		$.ajax({
			url:document.location.origin+"/cancelAddFriend.php",
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
	</script>
<?php endif;?>