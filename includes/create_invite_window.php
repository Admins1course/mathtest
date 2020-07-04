<?php require_once 'checkSession.inc.php';
if($is_login):?>
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
					<input class="choose-friends" type="checkbox" value="<?=htmlspecialchars($friends[$i]['id_Friend'])?>">
					<div class="people_avatar"></div>
					<li class="friends_names_invite" id="userId<?=htmlspecialchars($friends[$i]['id_Friend'])?>"><?=htmlspecialchars($friends[$i]['name'])?> <?=htmlspecialchars($friends[$i]['surname'])?></li>	
				<?php endfor;
			endif;?>
			</ul>
		</div>
		<div>
			<label for="recipient">Выберите получателя ответов(по умолчанию это Вы):</label>
			<select id="recipient">
				<option value="<?=htmlspecialchars($_SESSION['data-user']['id'])?>" selected>По умолчанию</option>
				<?php if ($friends!=[]):
					for ($i=0;$i<count($friends);$i++):?>
						<option value="<?=htmlspecialchars($friends[$i]['id_Friend'])?>"><?=htmlspecialchars($friends[$i]['name'])?> <?=htmlspecialchars($friends[$i]['surname'])?></option>
					<?php endfor;
				else:?>
				<option>У Вас нет друзей</option>
				<?php endif;?>
			</select>
		</div>
    </div>
<?php endif;?>