<?php
 include 'includes/db.inc.php';
 $sql="SELECT VERSION()";
 $result=$pdo->query($sql);
 echo var_dump($result->fetchAll());