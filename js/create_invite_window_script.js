$(document).ready(function () {
	let timerId;
	let invitationPages=document.getElementsByClassName("invitation-page");
	$( "#dialog_window_1" ).dialog({
		autoOpen: false,
		modal:true
	});
	if (sessionStorage.getItem('ivitation'))openDialog();
	$("#create-invite").click(openDialog);
 
	$("div[aria-describedby=dialog_window_1] .ui-button-icon").click(function(){
		console.log("hi");
	});
	$("#dialog_window_1").bind("dialogopen", function(){
		changeOverlay();
		if ((document.location.pathname!="/myCatalog.php")&&(document.location.pathname!="/TestList.php")){
			showTestMenu();
			inclInSession();
			animTestMenu();
		}
	});
    $( "#dialog_window_1" ).on( "dialogbeforeclose", function( event, ui ) {
		clearInterval(timerId);
		invitationPages[0].style.backgroundColor="";
		invitationPages[1].style.backgroundColor="";
		hideTestMenu();
		inclInSession();
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
	
	function inclInSession(){
		sessionStorage.setItem("invitation",!sessionStorage.getItem("invitation"));
	}
});

