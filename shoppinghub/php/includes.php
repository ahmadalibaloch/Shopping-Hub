<?php
	include('config.php');
	include('functions.php');
	include('Database.php');
	include('Object.php');
	include('Model.php');
	include('Pager.php');
	
	session_start();
	$user_id = isset($_SESSION['uid'])? $_SESSION['uid'] : 1;
	$user = User::getByPK($user_id);
	define('USER_NAME',$user->getName());
	define('USER_ROLE',$user->getRole());
	define('USER_ID',$user->getId());
	if(USER_ROLE == 'owner')
	define('OWNER_ID',Owner::getOne("userId = {$user->getId()}")->getId());
