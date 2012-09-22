<?php
	session_start();
	
	include '../models/utility_model.php';
	include '../models/connection_model.php';
	include '../models/user_model.php';
	include '../models/theatre_model.php';
	
	$theatres = Theatre::FindAllWithReelCount();
	
	echo(count($theatres))
		
