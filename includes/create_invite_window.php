
        <div id="dialog_window_1" class="dialog_window" title="Диалоговое окно">
			<div class="search_area">
				<div class="search">
					<input type="search" class="search_bar" onkeyup="searchControl(this)" onchange="searchControl(this)">
					<input type="button" class="search_send_title " value="Поиск" onclick="if(this.previousElementSibling.value!=='')searchForFriends(this.previousElementSibling.value,'inviteFriends');">
				</div>		
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
				<ul class="listOfPeople" id="inviteFriends">
				<?php if ($friends!=[]):

					for ($i=0;$i<count($friends);$i++):?>
						<input class="choose-friends" type="checkbox" value="<?=$friends[$i]['id_Friend']?>">
						<div class="people_avatar"></div>
						<li class="friends_names_invite" id="userId<?=$friends[$i]['id_Friend']?>"><?=$friends[$i]['name']?> <?=$friends[$i]['surname']?></li>	
					<?php endfor;
				endif;?>
				</ul>
			</div>
			<div>
				<select>
					<option selected disabled>Выберите получателя ответов</option>
					<?php if ($friends!=[]):
						for ($i=0;$i<count($friends);$i++):?>
							<option id="UID<?=$friends[$i]['id_Friend']?>"><?=$friends[$i]['name']?> <?=$friends[$i]['surname']?></option>
						<?php endfor;
					else:?>
					<option>У Вас нет друзей</option>
					<?php endif;?>
				</select>
			</div>
        </div>
 
  