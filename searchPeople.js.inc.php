<script>var searchFunction=searchForFriends;
	
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