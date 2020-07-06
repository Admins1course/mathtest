<?php
    //дополнения
	session_start();
    include 'includes/db.inc.php';
    include 'includes/checkSession.inc.php';
	if($is_login){
		function exist_data($value){
			if ((trim($value)!==false)&&(trim($value)!=='')) return 1;
			else return 0;
		}
		//основная часть обработчика
		/*-----------------------------------------------СТРУКТУРА ТАБЛИЦ-----------------------------------------------------------
		*
		*
		*                                                  tasktest_idUser
		*                                              +-----------------+
		*                                              |id_Test | id_Task|
		*                                              +-----------------+
		*                                                            |
		*                                                            |               
		*    |-------------------------------------------------------+------------------------------
		*    |                                                                                     |
		*    |                                                                                     |
		*    |                                                                                     |
		*	 |    totaltasktable_idUser_idTest                                                     |          answers_idUser_idTest
		*    |        +------------------+                                                         |        +-------------------------------------+
		*    |        |id_Task|total_task|                                                         |        |id_Task|textarea|input|radio|checkbox|
		*    |        +------------------+                                                         |        +-------------------------------------+ 
		*    |            |                                                                        |            |
		*    |            |                                                                        |            |
		*    --------------                                                                        --------------
		*                                                                                                |
		*                                                                                                |         
		*                                 ----------------------------------------------------------------
		*                                 |                                                              |
		*                                 |  radio_idUser_idTest                                         |   checkbox_idUser
		*                              +----------------------------------------+                    +----------------------------------------------+      
		*                              |id_Task|idRadio|radio_answer|text_answer|                    |id_Task|idCheckbox|checkbox_answer|text_answer|
		*                              +----------------------------------------+                    +----------------------------------------------+
		*
		*
		*$db_flags - массив флагов определяющих созданы ли таблицы или нет
		*/
		$db_flags=array(
				 'tests'=>0);
		try{
			$pdo->beginTransaction();	
			//узнаем количество существующих у автора тестов
			$query="SELECT MAX(idTest) FROM tests WHERE idAuthor=".$_SESSION['data-user']['id'];
			$count=$pdo->query($query);
			$rows=$count->fetchAll();
			$count=$rows[0][0];
			//увеличиваем количество на 1, это же количество станет новым id теста
			$count++;
			/*
			*Общие правила определения правильно заполненных заданий:
			*1)должно быть хоть что-то, относящееся к заданию, будь то текст или картинка
			*2)для тестов c input обязательно должен быть указан ответ
			*(для тестов с textarea такое делать не надо)
			*3)для тестов с checkbox и radiobutton обязательно должны быть заполнены все input
			*и обязательно должен быть указан правильный вариант ответа
			*
			*
			*структура $_POST, N-число,количество
			*textarea
			*
			*taskN:
			*     total_task
			*     icontestN:
			*               myPhoto
			*     textarea_answer
			*     points
			* 
			*radiobutton
			*
			*taskN:
			*     total_task
			*     icontestN:
			*               myPhoto
			*     radio
			*	  text_answerN
			*     points
			*			  
			*checkbutton
			*
			*taskN:
			*     total_task
			*     icontestN:
			*               myPhoto
			*     checkbox_answerN:
			*                    checkbox
			*				     text_answer
			*     points
			*
			*input
			*
			*taskN:
			*     total_task
			*     icontestN:
			*               myPhoto
			*     input_answer
			*     points
			*
			*marks - массив оценок
			*
			*Переменные для проверки
			*$task_exist:равно единице, если в задании есть хотя бы какой-то текст или картинка
			*$points_exist:равно единице, если задание оценено баллом
			*$answer_exist:равно единице, если существует возможный ответ
			*$file_exist:равно единице, если существует отправленное изображение
			*$post:массив данных, которые будут добавлены в базу данных (это значит, что будут отсеиваться незаполненные данные)
			*$numberTask: номер задания
			*/
			$numberTask=1;
			$post=[];
			foreach ($_POST as $k1=>$v1){
				$task_exist=0;
				$answer_exist=0;
				$points_exist=0;
				$file_exist=0;
				//1-й проход для определения существования задания
				foreach($_POST[$k1] as $k2=>$v2){
					//1 блок: проверяем есть ли минимальные требования для существования задания к тесту
					if ($k2=="total_task"){
						if (exist_data($v2)) {
							$task_exist=1;
						}	
					}
					//2 блок: проверяем есть ли баллы за задание
					else if ($k2=="points"){
						if (exist_data($v2)){
							$points_exist=1;
						}
					}
					//3 блок: проверяем есть ли минимальные требования по ответам к заданию
					else if ($k2=="input_answer"){
						if (exist_data($v2)){
							$answer_exist=1;
						}
					}
					else if ($k2=="textarea_answer"){
						$answer_exist=1;
					}
					else if (@$k2=='radio'&&@exist_data($v2)){
						if (@exist_data($_POST[$k1]['text_answer'.$v2])){
							$answer_exist=1;
						}
					}
					else if (is_array($_POST[$k1][$k2])){
						if (@exist_data($_POST[$k1][$k2]['checkbox'])&&@exist_data($_POST[$k1][$k2]['text_answer'])){
							$answer_exist=1;
						}
					}
				}
					
				//4 блок: проверяем есть ли изображения
				if (isset($_FILES[$k1])){
					$file_exist=1;
					echo "file_exist";
				}
				//2-й проход для внесения задания в список, который будет отправлен в базу данных
				if (($task_exist||$file_exist)&&$answer_exist&&$points_exist){
				
					$radioCount=1;
					$checkboxCount=1;
					
					if (!$db_flags['tests']){
						$db_flags['tests']=1;
						$sql="INSERT INTO tests(`idAuthor`,`idTest`,`taskName`,`dataRegistration`) VALUES (:idUser,:count,'new_task',NOW())";
						$result=$pdo->prepare($sql);
						$result->execute(['idUser'=>$_SESSION['data-user']['id'],'count'=>$count]);
					}
									
					if ($task_exist||$file_exist){
						if ($task_exist){
						//добавляем запись о новом задании				
						$sql="INSERT INTO totaltasktable(id_User,id_Test,id_Task,total_task) VALUES (:idUser,:idTest,:numberTask,:data)";
						$result=$pdo->prepare($sql)->execute(["idUser"=>$_SESSION['data-user']['id'],
															  "idTest"=>$count,
															  "numberTask"=>$numberTask,
															  "data"=>$_POST[$k1]["total_task"]]);
						}
						else{
							$sql="INSERT INTO totaltasktable(id_User,id_Test,id_Task) VALUES (:idUser,:idTest,:numberTask)";
							$result=$pdo->prepare($sql)->execute(["idUser"=>$_SESSION['data-user']['id'],
																  "idTest"=>$count,
																  "numberTask"=>$numberTask]);
						}
					}
					
					//добавляем новую запись об ответах
					$sql="INSERT INTO answers(id_User,id_Test,id_Task,points) 
						  VALUES(:idUser,:idTest,:numberTask,:points)";
					$result=$pdo->prepare($sql);
					$result->execute(['idUser'=>$_SESSION['data-user']['id'],
									  'idTest'=>$count,
									  'numberTask'=>$numberTask,
									  'points'=>$_POST[$k1]['points']]);
					
					foreach($_POST[$k1] as $k2=>$v2){
						if ($k2=="input_answer"){
							if (exist_data($v2)){
								$sql="UPDATE answers SET input=:data 
										WHERE id_User=:idUser AND id_Test=:idTest AND id_Task=:numberTask";
								$pdo->prepare($sql)->execute(['data'=>trim($v2),
															  'idUser'=>$_SESSION['data-user']['id'],
															  'idTest'=>$count,
															  'numberTask'=>$numberTask]);
							}
						}
						
						else if ($k2=="textarea_answer"){
							$sql="UPDATE answers SET textarea=1 
									WHERE id_User=:idUser AND id_Test=:idTest AND id_Task=:numberTask";
							$pdo->prepare($sql)->execute(['idUser'=>$_SESSION['data-user']['id'],
														  'idTest'=>$count,
														  'numberTask'=>$numberTask]);
						}
						
						else if (strpos($k2,'text_answer')!==false){
							if (exist_data($_POST[$k1][$k2])){
								$sql="UPDATE answers SET radio=1 
										WHERE id_User=:idUser AND id_Test=:idTest AND id_Task=:numberTask";
								$pdo->prepare($sql)->execute(['idUser'=>$_SESSION['data-user']['id'],
															  'idTest'=>$count,
															  'numberTask'=>$numberTask]);
								$radio=0;//переменная отвечающая, за то была ли радиокнопка выделена как ответ
								if ('text_answer'.$_POST[$k1]['radio']==$k2){
									$radio=1;
								}
								else{
									$radio=0;
								}
								$sql="INSERT INTO radio VALUES(:idUser,:idTest,:numberTask,:radioCount,:radio,:text_answer)";
								$pdo->prepare($sql)->execute(['idUser'=>$_SESSION['data-user']['id'],
															  'idTest'=>$count,
															  'numberTask'=>$numberTask, 
															  'radioCount'=>$radioCount, 
															  'radio'=>$radio, 
															  'text_answer'=>trim($_POST[$k1][$k2])]);
								
								$radioCount++;
							}
						}
						
						else if (is_array($_POST[$k1][$k2])){
							if (exist_data($_POST[$k1][$k2]['text_answer'])){
								$sql="UPDATE answers SET checkbox=1 
										WHERE id_User=:idUser AND id_Test=:idTest AND id_Task=:numberTask";
								$pdo->prepare($sql)->execute(['idUser'=>$_SESSION['data-user']['id'],
															  'idTest'=>$count,
															  'numberTask'=>$numberTask]);
								
								$checkbox=0;//переменная отвечающая, за то был ли чекбокс выделен как ответ
								if (isset($_POST[$k1][$k2]['checkbox'])){
									$checkbox=1;
								}
								else{
									$checkbox=0;
								}
								$sql="INSERT INTO checkbox
										VALUES(:idUser,:idTest,:numberTask,:checkboxCount,:checkbox,:text_answer)";
								$pdo->prepare($sql)->execute(['idUser'=>$_SESSION['data-user']['id'],
															  'idTest'=>$count,
															  'numberTask'=>$numberTask, 
															  'checkboxCount'=>$checkboxCount, 
															  'checkbox'=>$checkbox, 
															  'text_answer'=>trim($_POST[$k1][$k2]['text_answer'])]);
								$checkboxCount++;
							}
						}
					}
					if (isset($_FILES[$k1])){
						$sql="UPDATE totaltasktable	SET icontest=1 WHERE id_User=:idUser AND id_Test=:idTest AND id_Task=:id_Task";
						$pdo->prepare($sql)->execute(['idUser'=>$_SESSION['data-user']['id'],
													  'idTest'=>$count,
													  'id_Task'=>$numberTask]);
						$numberOfFile=0;
						foreach($_FILES[$k1]['tmp_name'] as $k2=>$v2){
							if(is_uploaded_file($_FILES[$k1]['tmp_name'][$k2]['myPhoto'])){
								mkdir('./user-img/'.$_SESSION['data-user']['id'].'/'.$count.'/'.$numberTask,0777,true);
								$nameAndType=explode('.',$_FILES[$k1]['name'][$k2]['myPhoto']);
								$numberOfFile++;
								if(move_uploaded_file
								(
									$_FILES[$k1]['tmp_name'][$k2]['myPhoto'],
									__DIR__ . DIRECTORY_SEPARATOR .'user-img'. DIRECTORY_SEPARATOR .$_SESSION['data-user']['id']. DIRECTORY_SEPARATOR .$count. DIRECTORY_SEPARATOR .$numberTask. DIRECTORY_SEPARATOR .$numberOfFile.".".end($nameAndType)
								)){
									$idIcontest=str_replace('icontest',"",$k2);
									$sql="INSERT INTO icontest VALUES(
											:idUser,:idTest,:numberTask,:idIcontest,:myPhoto)";
									$pdo->prepare($sql)->execute([
										'idUser'=>$_SESSION['data-user']['id'],
										'idTest'=>$count,
										'numberTask'=>$numberTask,
										'idIcontest'=>$idIcontest,
										'myPhoto'=>$numberOfFile.".".end($nameAndType)
									]);
								}
							}
						}
					}
					$numberTask++;
				}
			}
			if ($numberTask>1){
				$sql="INSERT INTO tasktest VALUES(:idUser,:id_Test,:countTask,:mark_1,:mark_2,:mark_3,:mark_4,:mark_5)";
				$pdo->prepare($sql)->execute(['idUser'=>$_SESSION['data-user']['id'],
											  'id_Test'=>$count,
											  'countTask'=>(--$numberTask),
											  'mark_1'=>$_POST['marks'][0],
											  'mark_2'=>$_POST['marks'][1],
											  'mark_3'=>$_POST['marks'][2],
											  'mark_4'=>$_POST['marks'][3],
											  'mark_5'=>$_POST['marks'][4],
											  ]);
			}
			$pdo->commit();
			header('Location: createtest.html.php');
		}
		catch(PDOException $e){
			$pdo->rollBack();
			$error="Невозможно подключиться к базе данных: ".$e->getMessage();
			include 'error.html.php';
			exit();
		}
	}
	else{
		header('Location: createtest.html.php?dataUser=1');
	}