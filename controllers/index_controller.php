<?php
	session_start();
	
	include '../models/utility_model.php';
	include '../models/connection_model.php';
	include '../models/user_model.php';
	
	$method = $_POST['method'];
	

	if($method == 'create_account') {
		$newUsername = $_POST['new_username'];
		$newEmail = $_POST['new_email'];
		$newPassword = $_POST['new_password'];
		CreateAccount($newUsername, $newEmail, $newPassword);
	} else if($method == 'sign_in') {
		SignIn();
	}
	
	function CreateAccount($username, $email, $password) {	
		
		$alreadyCreatedUser = User::FindByUsername($username);
		if($alreadyCreatedUser){
			echo "-1";
			return NULL; // a user with this username already exists
		} 


		$newUser = new User();
		$newUser->Username($username);
		$newUser->Email($email);
		$newUser->Password($password);
		
		$id = $newUser->Save();

		if($id) {  // a new User was successfuly saved to the DB with id = $id
			$_SESSION['user_id'] = $id;
			$_SESSION['username'] = $username;
			echo($id); 
		} else { // an error occured while saving user the the DB
			 echo(NULL);
		}
	}
	
	function SignIn() {
		$usernameOrEmail = $_POST['username_or_email'];
		$password = $_POST['password'];
		
		$id = User::SignIn($usernameOrEmail, $password);
		if($id) { //the password matched the username or email
			$_SESSION['user_id'] = $id;
			$_SESSION['username'] = $usernameOrEmail;
			echo($id);
		} else { //either the username/email did not exist or the password was wrong
			echo("-2");
		}
		
	}
	
	

	