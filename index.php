<?php require_once 'includes/db.inc.php';
	  require_once 'registration_control.php';
	  session_start();
	  if (isset($_SESSION['data-user'])){
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
	
	function callbackFunction(element1,element2){
		switchbutton(element1,element2);
		if (element1.value==="Друзья") searchFunction=searchForFriends;
		if (element1.value==="Мир") searchFunction=searchForPiece;

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
			error:function(){console.log('error')},
			success:function(data){
				console.log(data);
				var listOfPeople='';
				for (i=0;i<data.length;i++){
					listOfPeople+='<li>'+
						data[i]['name']+" "+
						data[i]['surname']+
						'<input type="button" name="'+
						data[i]['root']+
						'" value=" + В друзья" onclick="addFriend(this)" id="user'+
						data[i]['id']+'">'+'</li>';
				}
				$('#friendsList').html(listOfPeople);
			}
		})
	}
	
	function searchForFriends(){}
</script>

<script>
      $(document).ready(function(){
	$('.search_type').click(function () {
		$(this).toggleClass('.search_type_1');
		});
	});

    </script>

<script>
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
			error:function(){console.log('error')},
			success:function(){console.log(data);
				$(element).val('Заявка отправлена').prop('disabled', true);
			}
		});
	}
</script>
<script>
	function switchbutton(element1,element2){
		console.log(element1)
		console.log(element2)
		element1.attr('id','active_btn');
		element2.attr('id','pasive_btn');


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
						<div class="search_send">
							<input type="button" class="search_type " id="pasive_btn" value="Друзья" onclick="callbackFunction($(this),$(this).next())">
							<input type="button" class="search_type "  id="active_btn" value="Мир" onclick="callbackFunction($(this),$(this).prev())">
						</div>
					
					</div>
					
				</div>
			</div>

			<div id="left_block" class="left_block">
					
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