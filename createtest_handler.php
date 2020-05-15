<?php
    //дополнения
    include 'includes/db.inc.php';
	session_start();
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
	         'tests'=>0,
			 'totaltasktable'=>0,
			 'icontest'=>0,
			 'answers'=>0,
			 'radio'=>0,
			 'checkbox'=>0);
	if (isset($_SESSION['data-user']['id'])){
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
				}
				//2-й проход для внесения задания в список, который будет отправлен в базу данных
				if (($task_exist||$file_exist)&&$answer_exist&&$points_exist){
				
					$radioCount=1;
					$checkboxCount=1;
					
					if (!$db_flags['tests']){
						echo 'q';
						echo "<br>";
						$db_flags['tests']=1;
						$sql="INSERT INTO tests VALUES (:idUser,:count,'new_task',NOW())";
						$result=$pdo->prepare($sql);
						$result->execute(['count'=>$count,'idUser'=>$_SESSION['data-user']['id']]);
					}
									
					//если нет таблицы TOTALTASKTABLE, создаем ее
					if (!$db_flags['totaltasktable']){
						echo 'h';
						echo "<br>";
						$db_flags['totaltasktable']=1;
						$sql="CREATE TABLE totaltasktable_".$_SESSION['data-user']['id']."_".$count."(
								id_Task	int not null,
								total_task text DEFAULT null,
								icontest int DEFAULT null
							  )DEFAULT CHARACTER SET utf8 ENGINE=InnoDB";
						$pdo->exec($sql);
					}
					if ($task_exist){
						echo "w";
						echo '<br>';
						//добавляем запись о новом задании				
						$sql="INSERT INTO totaltasktable_".$_SESSION['data-user']['id']."_".$count." (id_Task) VALUES (".$numberTask.",:data)";
						$result=$pdo->prepare($sql);
						$result->execute(["data"=>$_POST[$k1]["total_task"]]);
					}
					//если нет таблицы answers, то создаем ее
					if (!$db_flags['answers']){
						echo "e";
						echo "<br>";
						$db_flags['answers']=1;
						$sql="CREATE TABLE answers_".$_SESSION['data-user']['id']."_".$count."(
								id_Task tinyint not null,
								textarea int DEFAULT 0,
								input tinytext DEFAULT null,
								radio tinyint DEFAULT 0,
								checkbox tinyint DEFAULT 0,
								points real NOT NULL
							  )DEFAULT CHARACTER SET utf8 ENGINE=InnoDB";
						$pdo->exec($sql);
					}
					
					//добавляем новую запись об ответах
					$sql="INSERT INTO answers_".$_SESSION['data-user']['id']."_".$count." (id_Task,points) 
						  VALUES(".$numberTask.",".$_POST[$k1]['points'].")";
					$pdo->exec($sql);
					
					foreach($_POST[$k1] as $k2=>$v2){
						if ($k2=="input_answer"){
							if (exist_data($v2)){
								$sql="UPDATE answers_".$_SESSION['data-user']['id']."_".$count." SET
									  input=:data WHERE id_Task=".$numberTask;
								$pdo->prepare($sql)->execute(['data'=>trim($v2)]);
							}
						}
						
						else if ($k2=="textarea_answer"){
							$sql="UPDATE answers_".$_SESSION['data-user']['id']."_".$count." SET
								  textarea=1 WHERE id_Task=".$numberTask;
							$pdo->exec($sql);
						}
						
						else if (strpos($k2,'text_answer')!==false){
							if (exist_data($_POST[$k1][$k2])){
								if (!$db_flags['radio']){
									$db_flags['radio']=1;
									$sql="CREATE TABLE radio_".$_SESSION['data-user']['id']."_".$count."(
											id_Task int not null,
											idRadio int not null,
											radio_answer tinyint DEFAULT 0,
											text_answer text not null
										  )";
									$pdo->exec($sql);
								}
								
								$sql="UPDATE answers_".$_SESSION['data-user']['id']."_".$count." SET
										radio=1 WHERE id_Task=".$numberTask;
								$pdo->exec($sql);
								
								$radio=0;//переменная отвечающая, за то была ли радиокнопка выделена как ответ
								if ('text_answer'.$_POST[$k1]['radio']==$k2){
									$radio=1;
								}
								else{
									$radio=0;
								}
								$sql="INSERT INTO radio_".$_SESSION['data-user']['id']."_".$count." VALUES(:numberTask,:radioCount,:radio,:text_answer)";
								$pdo->prepare($sql)->execute(['numberTask'=>$numberTask, 
															  'radioCount'=>$radioCount, 
															  'radio'=>$radio, 
															  'text_answer'=>trim($_POST[$k1][$k2])]);
								
								$radioCount++;
							}
						}
						
						else if (is_array($_POST[$k1][$k2])){
							if (exist_data($_POST[$k1][$k2]['text_answer'])){
								if (!$db_flags['checkbox']){
									$db_flags['checkbox']=1;
									$sql="CREATE TABLE checkbox_".$_SESSION['data-user']['id']."_".$count."(
											id_Task int not null,
											idCheckbox int not null,
											checbox tinyint DEFAULT 0,
											text_answer text not null
										  )";
									$pdo->exec($sql);
								}
								
								$sql="UPDATE answers_".$_SESSION['data-user']['id']."_".$count." SET
										checkbox=1 WHERE id_Task=".$numberTask;
								$pdo->exec($sql);
								
								$checkbox=0;//переменная отвечающая, за то был ли чекбокс выделен как ответ
								if (@exist_data($_POST[$k1][$k2]['checkbox'])){
									$checkbox=1;
								}
								else{
									$checkbox=0;
								}
								$sql="INSERT INTO checkbox_".$_SESSION['data-user']['id']."_".$count." VALUES(:numberTask,:checkboxCount,:checkbox,:text_answer)";
								$pdo->prepare($sql)->execute(['numberTask'=>$numberTask, 
															  'checkboxCount'=>$checkboxCount, 
															  'checkbox'=>$checkbox, 
															  'text_answer'=>trim($_POST[$k1][$k2]['text_answer'])]);
								$checkboxCount++;
							}
						}
					}
					if (isset($_FILES[$k1])){
						if (!$db_flags['icontest']){
							$db_flags['icontest']=1;
							$sql="CREATE TABLE icontest_".$_SESSION['data-user']['id']."_".$count."(
									id_Task int not null,
									idIcontest int not null,
									myPhoto tinytext DEFAULT null
								)DEFAULT CHARACTER SET utf8 ENGINE=InnoDB";
							$pdo->exec($sql);
						}
						$numberOfFile=0;
						echo "<pre>";
						echo var_dump($_FILES);
						echo "</pre>";
						foreach($_FILES[$k1]['tmp_name'] as $k2=>$v2){
							if(is_uploaded_file($_FILES[$k1]['tmp_name'][$k2]['myPhoto'])){
								mkdir('./user-img/'.$_SESSION['data-user']['id'].'/'.$numberTask,0777,true);
								$nameAndType=explode('.',$_FILES[$k1]['name'][$k2]['myPhoto']);
								$numberOfFile++;
								if(move_uploaded_file
								(
									$_FILES[$k1]['tmp_name'][$k2]['myPhoto'],
									__DIR__ . DIRECTORY_SEPARATOR .'user-img'. DIRECTORY_SEPARATOR .$_SESSION['data-user']['id']. DIRECTORY_SEPARATOR .$numberTask. DIRECTORY_SEPARATOR .$numberOfFile.".".end($nameAndType)
								)){
									$idIcontest=str_replace('icontest',"",$k2);
									$sql="INSERT INTO icontest_".$_SESSION['data-user']['id']."_".$count." VALUES(
											:numberTask,:idIcontest,:myPhoto)";
									$pdo->prepare($sql)->execute([
										'numberTask'=>$numberTask,
										'idIcontest'=>$idIcontest,
										'myPhoto'=>$numberOfFile.".".end($nameAndType)
									]);
								}
							}
						}
						echo "<pre>";
						echo var_dump(scandir('.'));
						echo "</pre>";
					}
					$numberTask++;
				}
			}
			if ($numberTask>1){
				echo '<br>';
				echo "hey";
				$sql="INSERT INTO tasktest_".$_SESSION['data-user']['id']." 
						VALUES(:id_Test,:countTask,:mark_1,:mark_2,:mark_3,:mark_4,:mark_5)";
				$pdo->prepare($sql)->execute(['id_Test'=>$count,
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
		header('Location: createtest.html.php');
	}