<?php
	session_start();
	
	//headers needed for youtube functions
	$clientLibraryPath = '..';
	$oldPath = set_include_path(get_include_path() . PATH_SEPARATOR . $clientLibraryPath);
	require_once 'Zend/Loader.php';
	Zend_Loader::loadClass('Zend_Gdata_YouTube');
	
	include '../models/utility_model.php';
	include '../models/connection_model.php';
	include '../models/user_model.php';
	include '../models/theatre_model.php';
	include '../models/reel_model.php';
	
	$method = $_POST['method'];
	
	 if($method == 'add_to_playlist') {
		AddToReel();
	}  else if($method == 'user_exit'){
		UserExit();
	} else if($method == 'user_enter'){
		UserEnter(); 
	} else if($method == 'get_first_video') {
		GetFirstVideo();
	}else if($method == 'get_next_video'){
		GetNextVideo();
	}else if($method == 'get_reel') {
		GetReel();
	}
	

	function GetFirstVideo() {	
		$arr = null;
		$theatre = Theatre::FindById($_POST['theatre_id']);
		if($theatre->ReelId(null))
		{ 
			$reel = Reel::FindById($theatre->ReelId(0));
			$delta = date_diff(date_create(), $theatre->StartTime(null));
			$seconds = ($delta->s) + ($delta->i * 60) + ($delta->h * 60 * 60);
			$duration = (integer)$reel->Duration(null);

			$user = User::FindById($reel->UserId(null));
			$submitter = $user->GetUsername();		
			
			if($seconds <= $duration) //if the video isn't over
			{ 
				$arr = array ('id'=> $reel->Id(null), 'url' => $reel->Url(null), 'start_time' => $seconds, 'submitter'=> $submitter);
			} 
			else 
			{
				$reel = Reel::GetNextByTheatreId($theatre->ReelId(null), $theatre->Id());
				$reel->IncrementViewCount();
				$theatre->StartTime(true); //sets the start time to the current time
				$theatre->UpdateCurrentVideo($reel->Id());
				$arr = array ('id'=> $reel->Id(null), 'url' => $reel->Url(null), 'start_time' => 0, 'submitter'=> $submitter, 'title'=>$reel->Title(null));
			} 
		} 
		echo(json_encode($arr));
	}
	
	function GetNextVideo(){
		$reel = Reel::GetNextByTheatreId($_POST['reel_id'], $_POST['theatre_id']);
		$reel->IncrementViewCount();
		$theatre = Theatre::FindById($_POST['theatre_id']);
		$theatre->StartTime(true);
		$theatre->UpdateCurrentVideo($reel->Id());
		
		$user = User::FindById($reel->UserId(null));
		$submitter = $user->GetUsername();		
		
		$arr = array ('id'=> $reel->Id(null), 'url' => $reel->Url(null), 'start_time' => 0, 'submitter'=> $submitter, 'title'=>$reel->Title(null));
		echo(json_encode($arr));
	}
	
	function GetReel(){
		$array = null;
		$reel = Reel::FindByTheaterId($_POST['theatre_id']);
		foreach($reel as $video) {
			$vid = array('title' => $video->Title(null), 'thumb_url'=> stripslashes($video->ThumbUrl(null)), 'vid_id' => $video->Id(null));
			$array[] = $vid;
		}
   		echo(json_encode($array));
	}
			
	function AddToReel() { 
	//this function will take the URL and gather information aboout the video
	//from there it will store this information in the database and add it to the playlist
		$user = User::FindById($_SESSION['user_id']);
		
		//getting the thumbnail for the video from the YouTube API
		$searchTerm = $_POST['url'];	
		$yt = new Zend_Gdata_YouTube();
    	$query = $yt->newVideoQuery();
    	$query->setQuery($searchTerm);
    	$query->setStartIndex(1);
   		$query->setMaxResults(1);
   		$feed = $yt->getVideoFeed($query);
   		$entry = $feed[0];
   		$videoId = $entry->getVideoId();
    	$thumbnailUrl = $entry->getVideoThumbnails(); //this returns and array of thumbnails
    	$thumbnailUrl = $thumbnailUrl[0]['url'];
    	$videoTitle = $entry->getVideoTitle();
    	$videoDuration = $entry->getVideoDuration();
				
		$reel = new Reel();
		$reel->TheaterId($_POST['theatre_id']);
		$reel->Url($_POST['url']);
		$reel->UserId($_SESSION['user_id']);
		$reel->ThumbUrl($thumbnailUrl);
		$reel->Title($videoTitle);
		$reel->Duration($videoDuration);
		$reel_id = $reel->AddVideo();
		
		$theatre = Theatre::FindById($_POST['theatre_id']);
		if(!$theatre->ReelId(null)) {
			$theatre->StartTime(true);
			$theatre->UpdateCurrentVideo($reel_id);
		}
		echo($reel->Url(null));
	}
	
	function UserExit(){
		$theatre = Theatre::FindById($_POST['theatre_id']);
		$theatre->DecrementNumViewers();
		echo($theatre->NumViewers());
		/*if(isset($_SESSION['user_id'])) {		
			$id = User::ExitTheater($_SESSION['user_id']);
			echo($id);
		} else {
			echo(null);
		}*/
	}
	
	function UserEnter() {
		$theatre = Theatre::FindById($_POST['theatre_id']);
		$theatre->IncrementNumViewers();
		echo($theatre->NumViewers());
		/*if(isset($_SESSION['user_id'])) {
			$id = User::EnterTheater($_SESSION['user_id'],$_POST['theatre_id']);
			echo($id);
		} */
	}