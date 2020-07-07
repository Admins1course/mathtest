<?php require_once 'checkSession.inc.php'; 
if($is_login):?>
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
							<li id="userId<?=htmlspecialchars($friends[$i]['id_Friend'])?>"><?=htmlspecialchars($friends[$i]['name'])?> <?=htmlspecialchars($friends[$i]['surname'])?></li>	
						</div>
					</div>
				<?php endfor;
			endif;?>
		</ul>
		<ul class="listOfPeople" id="searchList" style="display:none">
		</ul>
	</div>
<?php endif;?>