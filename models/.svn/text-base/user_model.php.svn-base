<?php

class User 
{
	private $_id;
	private $_username;
	private $_email;
	private $_password;
	private $_theater_id;//Null by default i.e. not in theater

	public function Theater_Id($theater_id)
	{
		if ($theater_id) {
			$this->_theater_id = $theater_id;
		}
		return $this->_theater_id;
	}
	
	public function Id() {
		return $this->_id;
	}
	
	public function GetUsername(){
		return $this->_username;
	}

	public function Email($email) {
		if ($email) {
			$this->_email = $email;
		}	
		return $this->_email;
	}
	
	public function Username($username) {
		if($username) {
			$this->_username = $username;
		}
		return $this->_username;
	}
	
	public function Password($password) {
		if ($password) {
			$this->_password = Util::Hash($password); // defined in utility.php
			$this->_dirty = true;
		}
		
		return $this->_password;
	}
	
	public function TheatreId($theatreId) {
		if($theatreId) {
			$this->_theatre_id = $theatreId;			
		}
		return $this->_theatre_id;
	}
	
	public function ToAssocArray() 
	{
		$arr = array ('id'=> $this->_id, 'email' => $this->_email, 'username' => $this->_username);
		return $arr;
	}
	
	
	public static function EnterTheater($id, $theater_id)
	{
		//Set theater to null to leave theater
		$preparedStatement = DB::Prepare( // defined in connection.php
						"Update users " .
						"SET theater_id = ".$theater_id .
						" WHERE id = ".$id);
		$successful = $preparedStatement->execute();
		return $successful;
	}
	
	public static function ExitTheater($id)
	{
		//Set theater to null to leave theater
		$preparedStatement = DB::Prepare( // defined in connection.php
							"Update users " .
							"SET theater_id = NULL".
							" WHERE id = ".$id);
		$successful = $preparedStatement->execute();
		return $successful;
	}
	
	public static function SignIn($usernameOrEmail, $password) {
		//returns user_id if correct return null if incorrect
		$user = User::FindByUsername($usernameOrEmail);
		if($user) {
			if($user->Password(NULL) == Util::Hash($password)) {
				return $user->Id();
			}
		}
		return NULL;
	}
	
	
	public static function FindByUsername($usernameOrEmail) {
		if($usernameOrEmail) {
			$preparedStatement = DB::Prepare( // defined in connection.php
				"SELECT  * " .
				"FROM users " .
				"WHERE username = :username");
			$successful = $preparedStatement->execute(array(':username' => $usernameOrEmail));
			
			$row = $preparedStatement->fetch(PDO::FETCH_ASSOC);
			if($row) {
				$user = new User();
				$user->_id = $row['id'];
				$user->_username = $row['username'];
				$user->_email = $row['email'];
				$user->_password = $row['password'];
				$user->_theater_id = $row['theater_id'];
				return $user;
			} else {
				return NULL;
			}
		} else {
			return NULL;
		}
	}
	
	public static function FindById($id) {
		if($id) {
			$preparedStatement = DB::Prepare( // defined in connection.php
				"SELECT * " .
				"FROM users " .
				"WHERE id = :id");
			$successful = $preparedStatement->execute(array( ':id' => $id));	
			$row = $preparedStatement->fetch(PDO::FETCH_ASSOC);
			if($row) {
				$user = new User();
				$user->_id = $row['id'];
				$user->_username = $row['username'];
				$user->_email = $row['email'];
				$user->_password = $row['password'];
				$user->_theatre_id = $row['theater_id'];
				return $user;
			} else {
				return NULL;
			}
		} else {
			return NULL;
		}	
	}
	
	public static function FindByTheaterId($theater_id)
	{
		$preparedStatement = DB::Prepare( // defined in connection.php
						"SELECT * " .
						"FROM users " .
						"WHERE theater_id= :theaterId");
		$successful = $preparedStatement->execute(array( ':theaterId' => $theater_id));
		$rows = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);
		$users = array();
		if($rows) {
			foreach($rows as $row) {
				$user = new User();
				$user->_id = $row['id'];
				$user->_username = $row['username'];
				$user->_email = $row['email'];
				$user->_password = $row['password'];
				$user->_theatre_id = $row['theater_id'];
				
				$users[] = $user;
			}
		}
		return $users;
	}
	
	public static function CountUsersInTheater($theater_id)
	{
		$preparedStatement = DB::Prepare( // defined in connection.php
				"SELECT COUNT(*) as UserCount " .
				"FROM users " .
				"WHERE theater_id= :theaterId");
		$successful = $preparedStatement->execute(array( ':theaterId' => $theater_id));
		$row=$preparedStatement->fetch(PDO::FETCH_ASSOC);
		return $row['UserCount'];
	}
	
	public function Save()  {
		if($this->_username && $this->_password ) {
			$preparedStatement = DB::Prepare( // defined in connection.php
				"INSERT INTO users (email, username, password) " .
				"VALUES (:email, :username, :password)");
			$successful = $preparedStatement->execute(array( ':email' => $this->_email,
			 ':username' => $this->_username, ':password' => $this->_password));

			if ($successful) {
				$this->_id = (int)DB::LastInsertId();
				return $this->_id;
			} 
			else
			{
				return NULL;
			}
		}
	}
}