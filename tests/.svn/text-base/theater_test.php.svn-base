<?php

		
	include '../models/utility_model.php';
	include '../models/connection_model.php';
	include '../models/user_model.php';
	include '../models/theatre_model.php';

	$user = new User();
	$user->Username('Chuck');
	$user->Email('asdasdas.edu');
	$user->Password('fuckyou');
	$user->Save();
	User::EnterTheater($user->Id(),6);
	$user->Username('Henry');
	$user->Email('hnetz@umich.edu');
	$user->Password('fuckyou');
	$user->Save();
	User::EnterTheater($user->Id(),6);
	$user->Username('Tom');
	$user->Email('jaccapp@umich.edu');
	$user->Password('fuckyou');
	$user->Save();
	User::EnterTheater($user->Id(),6);
	User::ExitTheater($user->Id(),6);
	$allUsers=Theatre::GetUsersByTheater(6);
	echo(stripslashes(json_encode($allUsers)));
?>