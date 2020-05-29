<?php
if (isset($_SESSION['data-user'])){
	try{
		$sql="SELECT `id_Friend` FROM `friends` WHERE `waiting`!=1 AND `id_User`=:id";
		$result=$pdo->prepare($sql);
		$result->execute(['id'=>$_SESSION['data-user']['id']]);
		$friends=$result->fetchAll(PDO::FETCH_ASSOC);
		if ($friends!=[]){
			for ($i=0;$i<count($friends);$i++){
				$sql="SELECT `name`,`surname` FROM `users` 
						WHERE id=:id";
				$result=$pdo->prepare($sql);
				$result->execute(['id'=>$friends[$i]['id_Friend']]);
				$result=$result->fetchAll(PDO::FETCH_ASSOC);
				$friends[$i]['name']=$result[0]['name'];
				$friends[$i]['surname']=$result[0]['surname'];
			}
		}
	}
	catch(PDOException $e){
		
	}
}