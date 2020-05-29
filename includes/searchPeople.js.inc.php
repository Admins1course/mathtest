<?php @session_start();?>
<script>
var searchFunction=searchForFriends;
	
function callbackFunction(element1,element2){
	element1.disabled=true;
	let friendsList;
	let searchList;
	if (element1.value==="Друзья") {
		searchFunction=searchForFriends;
		friendsList = document.getElementById('friendsList');
		searchList = document.getElementById('searchList');
		friendsList.style.display="block";
		searchList.style.display="none";
		searchList.innerHTML='';
	}
	if (element1.value==="Мир") {
		searchFunction=searchForPiece;
		friendsList = document.getElementById('friendsList');
		searchList = document.getElementById('searchList');
		friendsList.style.display="none";
		searchList.style.display="block";
	}
	let list1 = element1.classList; 
	let list2 = element2.classList; 
	if (list1.contains('pasive_btn')){
		list1.remove('pasive_btn');
		list1.add('active_btn');
		list2.remove('active_btn');
		list2.add('pasive_btn');
	}
	element1.disabled=false;
}
	
function searchPeople(){
	if ((valueOfSearch=$('[type="search"]').val())!=='')
		return searchFunction(valueOfSearch);
}
	
function searchForPiece(searchValue){
	$.ajax({
		url:document.location.origin+"/searchForPiece.php",
		dataType:'json',
		cache:false,
		data:{searchValue:searchValue},
		type:'POST',
		error:function(data){console.log(data)},
		success:function(data){
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
						'<input type="button" value="'+buttonValue+'" onclick="'+buttonFunction+'" id="user'+
						data['people'][i]['id']+'">'+'</li>';
				}
				$('#searchList').html(listOfPeople);
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