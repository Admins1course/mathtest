<!--  Выподающее меню -->
		<div id="nav_menu">
				<nav id="menu1">
				 <ul>
				  <li><a href="index.php" class="nav_menu_bar">Главная</a></li>
				  <li><a href="#m2" class="nav_menu_bar">О нас</a></li>
				  <li><a href="#m3" class="nav_menu_bar">Тесты</a>
				   <ul>
				    <li><a href="TestList.php" class="nav_menu_bar">Каталог тестов</a></li>
					<?php if(isset($_SESSION['data-user']['root'])&&($_SESSION['data-user']['root']=="студент")){?>
						<li><a href="#m3_4" class="nav_menu_bar">Статистика</a></li>
						<li><a href="#m3_5" class="nav_menu_bar">Пройти тест по приглашению</a></li>
				    <?php }else if(isset($_SESSION['data-user']['root'])&&($_SESSION['data-user']['root']=="преподаватель")){?>
						<li><a href="#m3_3" class="nav_menu_bar">Мой каталог</a></li>
						<li><a href="createtest.html.php" class="nav_menu_bar">Создать тест</a></li>
						<li><a href="#m3_5" class="nav_menu_bar">Создать приглашение</a></li>
					<?php } ?>
				   </ul>
				  </li>
				  <li><a href="#m4" class="nav_menu_bar">Новости</a></li>
				  <li><a href="#m5" class="nav_menu_bar">Контакты</a></li>
				  <li>
				  	<div class="open_notifications_body">
					  	<a id="notif" href="#m5" class="open_notifications nav_menu_bar">Оповещения	
						</a>
					</div>
						<div class="notifications_body" style="display: none;">
							<div class="notifications_body_title">
								<div class="notifications_body_title_elements_div">
									<div class="notifications_body_text">
										<p class="text_notification_body">Оповещения</p>
									</div>
									<div class="notifications_body_title_element_bar">
										
									</div>
								</div>
							</div>
						</div>
					

				  </li>
				 </ul>
				 
				</nav><!--menu1-->
				<div class="profile">
					<?php
						if (isset($_SESSION['data-user']['name'])&&isset($_SESSION['data-user']["surname"])):?>
							
							<div class="load_avatar_fade">
								<div class="load_avatar">
									<div class="preview_image_div">
										<div class="preview_image" id="img-preview" >
											
										</div>
										
									</div>
									<div class="load_image">
									  <label for="custom-file-upload" class="filupp">
									    <span class="filupp-file-name js-value" >Загрузить файл</span>
									    <input type="file" name="attachment-file " value="1"  id="custom-file-upload"  >
									  </label>
									</div>
		
									
									<a class="load_avatar_close" href="">X</a>
								</div>

								
							</div>
							<div class="profile_avatar load_avatar_open">
								<p class="plus_photo">+</p>
							</div>
							<div class="user_profile_title">
						
								<p class="exit_menu"><?=htmlspecialchars($_SESSION['data-user']['name'])." <br /> ".htmlspecialchars($_SESSION['data-user']['surname'])?></p>
							</div>
							<div class="exit_menu_body" style="display:none">

										<div><p>Роль: <?php $_SESSION['data-user']['root'];?></p></div>
										
									

								<div class=" exit_menu_elements exit_menu_elements_bar ">
									<div class="image_elements">
										
									</div>
									<div>
										<p><a href="" class="exit_menu_elements_text">Настройки</a></p>
									</div>
									
								</div>

								<div class=" exit_menu_elements exit_menu_elements_bar">
									<div class="image_elements">
										
									</div>
									<div>
										<p><a href="" class="exit_menu_elements_text">Настройки</a></p>
									</div>
									
								</div>

								<div class="exit_title exit_menu_elements ">
									<div class="image_elements">
										
									</div>

									<div>
										<p><a href="vyhod.php" class="exit_menu_elements_text">Выход</a></p>
									</div>
								</div>
							</div>
						<?php 
						else:?>
							<div class="enter_site_btn">
								<a  href="nevEnter.html.php">Войти</a>
							</div>
					<?php endif?>
				</div>
			</div>