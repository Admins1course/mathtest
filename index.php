<?php require_once 'includes/db.inc.php';
	  require_once 'registration_control.php';
	  session_start();
	  if (!isset($_SESSION['data-user'])){
		  if ($_COOKIE['name']){//достаточно name, чтобы были и остальные
			  $_SESSION['data-user']['id']=$_COOKIE['id'];
			  $_SESSION['data-user']['name']=$_COOKIE['name'];
			  $_SESSION['data-user']['surname']=$_COOKIE['surname'];
			  $_SESSION['data-user']['root']=$_COOKIE['root'];
		  }
	  }?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Cache-Control" content="no-cache" charset="UTF-8">

	<link rel="stylesheet" href="style/Main.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="style/Cssforindex.css?<?=time()?>" type="text/css">
	

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>

	<?php include 'includes/script_for_nav_menu.php';?>
<script>
	//setInterval(,10000)
	var searchFunction=searchForFriends;
	
	function callbackFunction(element){
		element.disabled=true;
		if (element.value==="Друзья") searchFunction=searchForFriends;
		if (element.value==="Мир") searchFunction=searchForPiece;
		element.disabled=false;
	}
	
	function searchPeople(){
		if ((valueOfSearch=$('[type="search"]').val())!=='')
			return searchFunction(valueOfSearch);
	}
	
	function searchForPiece(searchValue){
		$.ajax({
			url:document.location.origin+"/mathtest/searchForPiece.php",
			dataType:'json',
			cache:false,
			data:{searchValue:searchValue},
			type:'POST',
			error:function(data){console.log(data)},
			success:function(data){
				console.log(data);
				var listOfPeople='';
				for (i=0;i<data['people'].length;i++){
					if (data['people'][i]['id']!=<?=$_SESSION['data-user']['id']?>){
						buttonValue="+ В друзья";
						buttonFunction="addFriend(this)";
						if (data['friends'])
							if (~data['friends']['id'].indexOf(data['people'][i]['id'])){
								if(data['friends']['waiting'][data['friends']['id'].indexOf(data['people'][i]['id'])]==1){
									buttonValue="Отменить заявку";
									buttonFunction="cancelAddFriend(this)";
								}
								else{
									buttonValue="В друзьях";
									buttonFunction="cancelAddFriend(this)";
								}
							}
						listOfPeople+='<li>'+
							data['people'][i]['name']+" "+
							data['people'][i]['surname']+
							'<input type="button" name="'+
							data['people'][i]['root']+
							'" value="'+buttonValue+'" onclick="'+buttonFunction+'" id="user'+
							data['people'][i]['id']+'">'+'</li>';
					}
				$('#friendsList').html(listOfPeople);
				}
			}
		})
	}
	
	function searchForFriends(){}
	
	function searchControl(element){
		var re=/[^a-zA-Zа-яА-Я0-9_]+/gus;
		if (re.test(element.value)) 
			element.value=element.value.replace(re, '');
	}
</script>
<script>
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
</script>
<script>
	$(document).ready(function(){setInterval(notifications,10000);});
	dataNotifications=0;
	function notifications(){
		$.ajax({
			url:document.location.origin+"/mathtest/getNotifications.php",
			cache:false,
			dataType:'json',
			type:'POST',
			error:function(data){console.log(data)},
			success:function(data){
				dataNotifications=data;
				if (data.length==0) return;
				if (data.length>9) count="9+";
				else count=data.length;
				countNotifications='Оповещения<div class="notifications">';
				countNotifications+='<div class="notific_num"><p>'+count+'</p></div></div>';
				$('.open_notifications_body a').html(countNotifications);
				htmlMessage='';
				for (i=0;i<data.length;i++){
					htmlMessage+='<div class="notifications_bar"><p class="text_notifications_bar">';
					htmlMessage+=data[i]['message'];
					htmlMessage+='</p></div>';
					htmlMessage+='<input type="button" id="userId'+data[i]['add_friends']+'" value="Принять" onclick="acceptApp(this)">';
					htmlMessage+='<input type="button" id="userId'+data[i]['add_friends']+'" value="Отменить">';
				}
				$('.notifications_body').html(htmlMessage);
			}
		});
	}
	
	$(document).ready(function(){$('#notif').click(function(){
			if ($('.notifications_body').is(':visible')){
				if (dataNotifications.length){
					$('.open_notifications_body a').html('Оповещения');
					$('.notifications_body').html('');
					dataNot={};
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
			}
		});
	});
	
	function acceptApp(element){
		$idFriend=$(element).attr('id').replace('userId','');
		$.ajax({
			url:document.location.origin+"/mathtest/acceptApp.php",
			cache:false,
			type:'POST',
			dataType:'json',
			data:{id:$idFriend},
			error:function(data){console.log(data);},
			success:function(data){}
		});
	}
</script>
</head>
<body style="height: 1500px;">
	<div id="page">
		
		<div id="main_content" style="height: 700px;">

		</div>
	</div>
		<div class="slider midle">
			<div class="slides">
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



		<div id="plus_inform">
			
		</div>
		<div class="all_right_block">
			<div id="right_block_title"></div>
			<div id="right_block"></div>
		</div>

		
			<div id="left_block_title">
				<div class="search_area">
					<div class="search">
						<input type="search" class="search_bar" onkeyup="searchControl(this)" onchange="searchControl(this)">
						<input type="button" class="search_send_title " value="Поиск" onclick="searchPeople()">
					
					</div>
					
				</div>
			</div>

			<div id="left_block" class="left_block">
					<div class="search_send">

						<input type="button" class="search_type" value="Друзья" onclick="callbackFunction(this.value)">
						<input type="button" class="search_type" value="Мир" onclick="callbackFunction(this.value)">
					</div>
					<div class="friends_bar">
						<p>Друзья</p>
					</div>
						<div class="friends_select_div">
							<label for="friends" class="friends_element">Группа</label>
							<select id="friends" class="friends_element friends_select">
								<option label="Все друзья"></option>
								<option label="Студенты"></option>
								<option label="Преподаватели"></option>
							</select>
							<ul id="friendsList">
							</ul>
						</div>

		
			</div>
				
		

	
			<?php include 'includes/nav_menu.php';?>
		
	
	
	
	


	
	
</body>
	<div id="footer">
			<div class="text">
				2020
			</div>
		</div>
</html>