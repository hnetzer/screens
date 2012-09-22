<?php

		
	include '../models/utility_model.php';
	include '../models/connection_model.php';
	include '../models/reel_model.php';

	$reel = reel::FindById(3);
	$reel->Upvotes(5);
	$reel->DownVotes(6);
	$reel->UpdateVotes();
	echo(json_encode($reel->GetDownvotes()));

?>