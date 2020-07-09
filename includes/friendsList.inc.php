<?php if($_SESSION['data-user']):?>
	<script>
		$(document).ready(function(){
			$('.dots').click( function(e) {
				$(this).siblings(".FriendsMenuDiv").stop().slideToggle(500);
				return false;
			});
			$(document).mouseup(function (e) {
			    let dotDiv =$('.dots');
			    if ($('.FriendsMenuDiv').has(e.target).length === 0){
        			$(".FriendsMenuDiv").stop().hide(500);
    			}
			});
		})
	</script>
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
		<ul class="listOfPeople" id="friendsList">
			<?php if ($friends!=[]):
				for ($i=0;$i<count($friends);$i++):?>
					<div class="friends_div">
						<div class="people_avatar">
							
						</div>
						<div class="friends_names">
							<li id="userId<?=$friends[$i]['id_Friend']?>"> 
								<div class="friend_name">
									<?=$friends[$i]['name']?>
								</div>
								<div class="friend_surname">
									<?=$friends[$i]['surname']?>
								</div>
								<div class="dots">
									<i class="fa fa-ellipsis-v dotsHover" aria-hidden="true"></i>
								</div>
								<div class="FriendsMenuDiv">
									<div class="FriendsMenuDivAll">
										<div class="FriendsMenuDivElements">
											<div class="FriendsMenuElementsText">
												
											</div>
										</div>
										<div class="FriendsMenuDivElements">
											<div class="FriendsMenuElementsText">
												
											</div>
										</div>
										<div class="FriendsMenuDivElements">
											<div class="FriendsMenuElementsText">
												
											</div>
										</div>
									</div>
								</div>
							</li>	
						</div>
					</div>
					
					
				<?php endfor;
			endif;?>
		</ul>
		<ul class="listOfPeople" id="searchList" style="display:none">
		</ul>
	</div>
<?php endif;?>