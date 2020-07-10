<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		//Скрываем подсказки о вводимых символах
		$("#p_name").slideUp();
		$("#p_surname").slideUp();
		$("#p_login").slideUp();
		$("#p_password_first").slideUp();
		$("#p_password_second").slideUp();
	});
</script>    
	<?php 
	    if (@basename($_SERVER['HTTP_REFERER'])==@basename($_SERVER['PHP_SELF'])){  //проверяем произошел ли переход на эту страницу по причине отсутствия всех данных  
			switch (basename($_SERVER['PHP_SELF'])){
				case 'user_data.html.php':
					$usersData=array("name","surname","root");
					break;
				case 'nevRegistaration.html.php':
					$usersData=array("login","password_first","password_second");
					break;
			}
			@session_start();
			if (isset($_SESSION['users_data'])){
				foreach ($_SESSION['users_data'] as $k=>$v){
					if (in_array($k,$usersData)&&($_SESSION['users_data'][$k]==null)){?><!--Если какое-то поле не было заполнено, запускаем всплывающее окно-->
						<script type="text/javascript">
							$(document).ready(function(){
								$('.popup-fade:first').clone('deepWithDataAndEvents').insertAfter('.popup-fade:last').attr(
									'id', <?='"'.htmlspecialchars($k).'_error"'?>);
							});
						</script>
				<?php }
				}
			}
			//Если пароли не совпадают, то выводим сообщение о несовпадении паролей
			$errors=array("is_wrong_password","login_exist");
			foreach ($_SESSION as $k=>$v){
				if (in_array($k,$errors)&&$_SESSION[$k]===true):?>
					<script type="text/javascript">
						id="#"+<?="\"".$k."\""?>;
						$(function(){
							$(id).css('display','block');
						})
					</script>
				<?php endif;
			}
		}?>
<script type="text/javascript">
		$(document).ready(function(){
			/*
			*Данная функция будет запрещать ввод всех недопустимых символов
			*Ввод допустимых символов скрывает подсказки о вводимых символах
			*/
			$(":text,:password").keyup(function(){   
				$(this).val(function(){
					//Скрываем подсказку при вводе символа
					let id_name="#p_"+$(this).attr('id');
					$(id_name).stop(true).slideUp();
					//Разрешаем определенные символы в зависимости от типа input
					let rep;
					if ($(this).attr('type')=='text'&&$(this).attr('id')!='login')
						rep = /[^a-zA-Zа-яА-Я0-9_]+/us;
					else rep = /[^a-zA-Z0-9_]+/us;
					let result=$(this).val();
					if (rep.test(result)) { 
						result=result.replace(rep, '');
						$(id_name).stop(true).slideDown();
						}
					return result;
				});
			});
		});
</script>