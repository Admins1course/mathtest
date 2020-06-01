<?php if($_SESSION['data-user']):?>
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
					<li id="userId<?=$friends[$i]['id_Friend']?>"><?=$friends[$i]['name']?> <?=$friends[$i]['surname']?></li>	
				<?php endfor;
			endif;?>
		</ul>
		<ul class="listOfPeople" id="searchList" style="display:none">
		</ul>
	</div>
<?php endif;?>