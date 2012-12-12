<?php 

require_once ('../model/login.php');

session_start();

$username = trim($_POST['username']);
$password = trim($_POST['password']);
$pwd = md5($password);

$login = new Login($username, $pwd);


	if ($login->checkUser())
	{		
		$_SESSION["user"] = $username;
		$_SESSION["password"] = $pwd;
		$id = $login->getUserid($username, $pwd);
		$_SESSION["id"] = $id;
		header("Location: ../view/userhome.php");
	}
	else
	{
	header("Location: ../index.php?error=INVALID ACCOUNT");
	}
?>