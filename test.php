<?php


	include 'models/utility_model.php';
	include 'models/connection_model.php';
	include 'models/user_model.php';
	include 'models/theatre_model.php';
	include 'models/reel_model.php';
	
	$theatre = Theatre::FindById(29);
	$theatre->IncrementNumViewers();
	echo($theatre->NumViewers());
	
	