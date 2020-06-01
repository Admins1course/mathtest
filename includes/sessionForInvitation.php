<?php
if ($_POST){
	session_start();
	$_SESSION['invitation']=(!$_SESSION['invitation']);
	echo $_SESSION['invitation'];
}