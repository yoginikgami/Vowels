<?php
	session_start();
	if(isset($_SESSION['access_token_google'])){
		require_once "Login_google/config.php";
		unset($_SESSION['access_token_google']);
		$gClient->revokeToken();
		session_destroy();
		header('Location: login');
		exit();
	}else if(isset($_SESSION['access_token'])){
		require_once "Login_facebook/config.php";
		unset($_SESSION['access_token']);
		session_destroy();
		header("Location: login");
		exit();
	}else{
		//require_once "config.php";
		unset($_SESSION['user_id']);
		unset($_SESSION['user_email']);
		//$gClient->revokeToken();
		session_destroy();
		header('Location: login');
		exit();
	}
?>