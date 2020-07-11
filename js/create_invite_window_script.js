$(document).ready(function () {

	let timerId;
	let invitationPages=document.getElementsByClassName("invitation-page");

	$( "#dialog_window_1" ).dialog({
		resizable: false,
		height: 450,
		maxHeight: 450,
		minHeight: 450,
		width: 350,
		maxWidth: 350,
		minWidth: 350,
		autoOpen: false,
		modal:true,
		buttons:{
			"Отменить":closeDialog,
			"Отправить":sendInvitation
		}
	});
	if (sessionStorage.getItem('ivitation'))openDialog();
	$("#create-invite").click(openDialog);
 
	$("#dialog_window_1").bind("dialogopen", function(){
		changeOverlay();
		if ((document.location.pathname!="/myCatalog.php")&&(document.location.pathname!="/TestList.php")){
			showTestMenu();
			inclInSession();
			animTestMenu();
		}
		else{
			showMainContent();
			changeMainContent();
		}
	});
    $( "#dialog_window_1" ).on( "dialogbeforeclose", function( event, ui ) {
		if ((document.location.pathname!="/myCatalog.php")&&(document.location.pathname!="/TestList.php")){
			clearInterval(timerId);
			invitationPages[0].style.backgroundColor="";
			invitationPages[1].style.backgroundColor="";
			hideTestMenu();
		}
		else{
			deleteZIndex();
			returnMainContent();
		}
		deleteFromSession()
	});
	
	function openDialog(){
		$("#dialog_window_1").dialog('open');
	}
	
	function changeOverlay(){
		let elem=document.getElementsByClassName("ui-widget-overlay");
		elem[0].style.background="#000";
		elem[0].style.opacity="0.7";
	}

	function showTestMenu(){
		let testmenu=document.getElementById("testmenu");
		testmenu.style.display="block";
		testmenu.style.top="60px";
		for (i=0;i<testmenu.children.length;i++){
			testmenu.children[i].style.display="block";
		}
		let parTestMenu=testmenu.parentElement;
		while (parTestMenu.id!="nav_menu"){
			parTestMenu=parTestMenu.parentElement;
		}
		parTestMenu.style.zIndex="101";
	}

	function hideTestMenu(){
		let testmenu=document.getElementById("testmenu");
		testmenu.style.display="";
		testmenu.style.top="";
		for	(i=0;i<testmenu.children.length;i++){
			testmenu.children[i].style.display="";
		}
		let parTestMenu=testmenu.parentElement;
		while (parTestMenu.id!="nav_menu"){
			parTestMenu=parTestMenu.parentElement;
		}
		parTestMenu.style.zIndex="";
	}

	function animTestMenu(){
		timerId=setTimeout(animTestMenu,1000);
		if (invitationPages[0].style.backgroundColor==""){
			invitationPages[0].style.backgroundColor="yellow";
			invitationPages[1].style.backgroundColor="";
		}
		else{
			invitationPages[1].style.backgroundColor="yellow";
			invitationPages[0].style.backgroundColor="";
		}
	}
	
	function showMainContent(){
		document.getElementById('main_content').style.zIndex="101";
	}
	
	function changeMainContent(){
		$('.test_href').each(function(index,elem){
			href=$(this).closest('a').attr('href');
			$(this).append('<input type="hidden" value="'+href+'">');
			$(this).unwrap();
			$(this).wrap("<div class='div_test_href'></div>");
			$(this).addClass('div_list').append('<div class="checkbox-div"><input type="checkbox" class="checkbox_list"></div>');
		});
	} 
	
	function deleteZIndex(){
		document.getElementById('main_content').style.zIndex="";
	}
	
	function returnMainContent(){
		$('.div_list').each(function(index,elem){
			href=$(this).children(':hidden').val();
			$(this).children('.checkbox-div').remove();
			$(this).children('input').remove();
			$(this).unwrap();
			$(this).wrap('<a href="'+href+'"></a>');
			$(this).removeClass('div_list');
			if($(this).hasClass('test_href_min')){
				$(this).removeClass('test_href_min');
				$(this).addClass('test_href');
			}
		});
	}
	
	function inclInSession(){
		sessionStorage.setItem("invitation",true);
	}
	
	function deleteFromSession(){
		sessionStorage.setItem("invitation",false);
	}
	
	function closeDialog(){
		$(this).dialog('close');
	}
	
	function sendInvitation(e){
		let tests=collectTests();
		let friends=collectFriends();
		dataPost={"tests":tests,
			      "friends":friends,
				  "recipient":document.getElementById('recipient').value}
		console.log(dataPost);
		if ((tests!=[])&&(friends!=[])){
			$.ajax({
				url:document.location.origin+"/includes/sendInvitation.php",
				cache:false,
				type:'POST',
				dataType:'json',
				data:dataPost,
				error:function(data){console.log(data)},
				success:function(data){
					switch(data['answer']){
						case 'success':break;
						case 'serverError':alert('Произошла ошибка на сервере, приглашнение не отправлено');
										   break;
					}
				}
			});
		}
	}
	
	function collectTests(){
		let tests=[];
		$('.checkbox_list').each(function(){
			if (this.checked)
				tests.push(this.parentElement.previousElementSibling.value);
		});
		return tests;
	}
	
	function collectFriends(){
		let friends=[];
		let idUser;
		$('.choose-friends').each(function(){
			if(this.checked){
				idUser=this.nextElementSibling.nextElementSibling.id;
				friends.push(idUser.replace("userId",""));
			}
		});
		return friends;
	}
});
$(document).ready(function() {
    $(".ui-dialog").css("position", "relative");
});

$(window).scroll(function() {
    $(".ui-dialog").css("top", $(window).scrollTop() + "px");
});