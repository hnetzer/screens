<?php

	session_start();
	
	include '../models/utility_model.php';
	include '../models/connection_model.php';
	include '../models/user_model.php';
	include '../models/theatre_model.php';
	include '../models/reel_model.php';
	
	$method = $_POST['method'];
	
	if($method == 'upvoted'){
		Upvote();
	}else if($method == 'downvoted'){
		Downvote();
	}else if($method == 'remove_upvote'){
		RemoveUpvote();
	}else if($method == 'remove_downvote'){
		RemoveDownvote();
	}else if($method == 'update_rating'){
		UpdateRating();
	}
	
	function Upvote(){
		//Increments the reel's upvote number
		$reel = Reel::FindById($_POST['reel_id']);
		$reel->Upvote();
	}
	
	function RemoveUpvote(){
		//Decrements the reel's upvote number
		$reel = Reel::FindById($_POST['reel_id']);
		$reel->RemoveUpvote();		
	}
	
	function Downvote(){
		//Increments the reel's downvote number
		$reel = Reel::FindById($_POST['reel_id']);
		$reel->Downvote();		
	}

	function RemoveDownvote(){
		//Decrements the reel's downvote number
		$reel = Reel::FindById($_POST['reel_id']);
		$reel->RemoveDownvote();		
	}

	function UpdateRating(){
		//Calculates and returns the current rating for the theatre
		$reel = Reel::FindById($_POST['reel_id']);
		if($reel) {
			$up = $reel->GetUpvotes();
			$down = $reel->GetDownvotes();
			$total = $up['upvotes']+$down['downvotes'];
			if($total != 0) {
				$percent = round($up['upvotes']/$total, 2); 
			}
			else { 
				$percent = 0;
			}
			echo ($percent*100);
		} else {
			echo(0);
		}
	}
	