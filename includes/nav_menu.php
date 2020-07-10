<!--  Выподающее меню -->
<?php require_once "checkSession.inc.php";?>
		<div id="nav_menu">
				<nav id="menu1">
				 <ul>
				  <li><a href="index.php" class="nav_menu_bar">Главная</a></li>
				  <li><a href="#m2" class="nav_menu_bar">О нас</a></li>
				  <li><a href="#m3" class="nav_menu_bar">Тесты</a>
				   <ul id="testmenu">
				    <li class="invitation-page"><a href="TestList.php" class="nav_menu_bar">Каталог тестов</a></li>
					<?php if($is_login&&isset($_SESSION['data-user']['root'])&&($_SESSION['data-user']['root']=="студент")){?>
						<li><a href="#m3_4" class="nav_menu_bar">Статистика</a></li>
						<li><a href="#m3_5" class="nav_menu_bar">Пройти тест по приглашению</a></li>
				    <?php }else if($is_login&&isset($_SESSION['data-user']['root'])&&($_SESSION['data-user']['root']=="преподаватель")){?>
						<li class="invitation-page"><a href="myCatalog.php" class="nav_menu_bar">Мой каталог</a></li>
						<li><a href="createtest.html.php" class="nav_menu_bar">Создать тест</a></li>
						<li><a href="#m3_5" id="create-invite" class="nav_menu_bar ">Создать приглашение</a></li>
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
							<div>
								<a style="padding: 0px; margin: 10px;" class="ShowAllNotifications" href="allNotifications.html.php">Посмотреть прочтенные оповещения</a>
							</div>
						</div>
					

				  </li>
				 </ul>
				 
				</nav><!--menu1-->
				<div class="profile">
					<?php
						if ($is_login):?>
							
							<div class="load_avatar_fade"> 
								<div class="load_avatar"> 
									<div>
										<img id="avatar-full-size" class="preview_image_div">
										<img id="file-img-preview"class="preview_image">
									</div>
									
									<div class="load_image" id="load_image">
									  <label for="custom-file-upload" class="filupp" id="filupp">
									    <span class="filupp-file-name js-value" >Загрузить файл</span>
									    <input type="file" name="attachment-file " id="custom-file-upload"  accept="image/*">
									  </label>
									  <span class="Loading-image-text" id="Loading-image-text" style="display:none">ПОДОЖДИТЕ ИДЁТ ЗАГРУЗКА...</span>
									</div>
		
									
									<a class="load_avatar_close" href="">X</a>
								</div>

								
							</div>
							<div class="profile_avatar load_avatar_open" id="profile_avatar">
								<p class="plus_photo">+</p>
							</div>
							<div class="user_profile_title">
						
								<p class="exit_menu"><?=htmlspecialchars($_SESSION['data-user']['name'])." <br /> ".htmlspecialchars($_SESSION['data-user']['surname'])?></p>
							</div>
							<div class="exit_menu_body" style="display:none">
								<div id="profile_div">
									<div id="profile_block">
										<div id="profile_title_div">
											<div id="profile_title">
												<div class="exit_title">
													<p><a href="vyhod.php">Выход <i class="fa fa-sign-out" aria-hidden="true"></i></a></p>
												</div>
											</div>
											
										</div>
										<div id="profile_img_block">
											<div id="profile_img">
												
											</div>
											
										</div>
										<div id="profile_elements_div">
											<div class="profile_elements_all">
												<div class="profile_elements">
													<div class="exit_menu_elements">
														<p class="exit_menu_stat"><i class="fa fa-star-o" aria-hidden="true"></i> Роль: <?=htmlspecialchars($_SESSION['data-user']['root']);?></p>
													</div>
												</div>
											</div>
											<div class="profile_elements_all">
												<div class="profile_elements">
												</div>
												
											</div>
											<div class="profile_elements_all">
												<div class="profile_elements">
												</div>
												
											</div>
											<div class="profile_elements_all">
												<div class="profile_elements">
													
												</div>
												
											</div>
											<div class="profile_elements_all">
												<div class="profile_elements">
													
												</div>
												
											</div>
											
											</div>
										<div id="profile_footer_div">
											<div id="profile_footer">
												
											</div>
										</div>
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