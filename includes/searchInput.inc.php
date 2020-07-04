<?php require_once 'checkSession.inc.php';
if($is_login):?>
	<div class="search_area">
		<div class="search">
			<input type="search" class="search_bar" onkeyup="searchControl(this)" onchange="searchControl(this)">
			<input type="button" class="search_send_title " value="Поиск" onclick="searchPeople()">
			<div class="search_send">
				<input type="button" class="search_type active_btn" value="Друзья" onclick="callbackFunction(this,this.nextElementSibling)">
				<input type="button" class="search_type pasive_btn" value="Мир" onclick="callbackFunction(this,this.previousElementSibling)">
			</div>
		</div>
	</div>
<?php endif;?>