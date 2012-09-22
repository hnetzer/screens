<?php
	session_start();
	
	include '../models/utility_model.php';
	include '../models/connection_model.php';
	include '../models/user_model.php';
	include '../models/theatre_model.php';
	
	$method = $_POST['method'];
	
	if($method == "sign_out") {
		SignOut();
	}else if($method == "create_theatre") {
		CreateTheatre();
	}else if($method == "get_all_theatres") {
		GetAllTheatres();
	}else if($method == "go_to_theatre") {
		SetTheatreSession();
	}else if($method == "search") {
		Search();
	}
	
	function Search() {
		$searchString = $_POST['search_string'];
		$theatres = Theatre::SearchByName($searchString);//return theatres
		if($theatres) {
			foreach($theatres as $theatre) {
				
				$theatreAssoc = array( 'topic' => $theatre->Topic(null), 'description' => $theatre->Description(null),
								'reel_count' => $theatre->ReelCount(), 'id'=> $theatre->Id());
				
				$array[] = $theatreAssoc;
						}
			echo(json_encode($array));
		} else {
			echo(0);
		}
	}
	
	
	
	function SignOut() {
		$id = User::ExitTheater($_SESSION['user_id']);
		session_destroy();
		echo($id);
	}
	
	function GetAllTheatres() {
		$theatres = Theatre::FindAllWithReelCount();

		if($theatres) {
			foreach($theatres as $theatre) {
				$theatreAssoc = array( 'topic' => $theatre->Topic(null), 'description' => $theatre->Description(null),
								'reel_count' => $theatre->ReelCount(), 'id'=> $theatre->Id());
				$array[] = $theatreAssoc;
			}
			echo(json_encode($array));
		} else {
			echo('happy');
		}
	}
	
	function CreateTheatre() {
		$anotherTheatre = Theatre::FindByTopic($_POST['new_topic']);
		if($anotherTheatre) {
			echo(NULL); //a theatre with that topic already exists
		} else {
						
			$theatre = new Theatre();
			$theatre->Topic($_POST['new_topic']);
			$theatre->Description($_POST['new_description']);
			$theatreId = $theatre->Save();
			if($theatreId) {
				$filename1  = '../data/'. 'chat' . $theatreId . '.txt';
				$filehandle1 = fopen($filename1, 'w');
				$filename2  = '../data/'. 'user' . $theatreId . '.txt';
				$filehandle2 = fopen($filename2, 'w');
				if($filehandle1 && $filename2) {
					fclose($filehandle1);
					fclose($filehandle2);
					echo(json_encode($theatre->ToAssocArray()));
				}else {
					echo(NULL);
				}
			} else {
				echo(NULL);
			}
		}
	}
	
	function SetTheatreSession() {
		$_SESSION['theatre_id'] = $_POST['theatre_id'];
		echo(true);
	}