function setUpEmbededSWF(){
	var params = { allowScriptAccess: "always" };
	var atts = { id: "myytplayer" };
	swfobject.embedSWF("http://www.youtube.com/apiplayer?enablejsapi=1&version=3&playerapiid=ytplayer&wmode=opaque",
	                   "ytapiplayer", "748", "495", "8", null, null, params, atts);
	
}


function onYouTubePlayerReady(playerId){
	   ytplayer = document.getElementById("myytplayer");//get reference to the player
	   ytplayer.addEventListener("onStateChange", "onytplayerStateChange");
	   setInterval(updateRating, 30000);
	   getReelPreview();
	   initializeReel();
}

function initializeReel(){
	var theatreId = document.$_GET['theatre_id'];
	callServerPost(THEATRE_CONTROLLER, { method: 'get_first_video', theatre_id: theatreId }, reelResponse, 'INITIALIZING REELS');
	function reelResponse(jsonReel){
		if(jsonReel){
			//exists playable video, begin playing it
			dojo.attr('id_hidden_reel', 'value', jsonReel.id);
			var activeId = 'id_'+jsonReel.id;
			dojo.attr(activeId, 'class', 'video_prev_container_active');
			
			current_id=jsonReel.id;
			play(jsonReel.url, jsonReel.start_time);
   		    updateRating();
   			displayVideoInfo(jsonReel.submitter, jsonReel.title);


		}		
	}
}

function onytplayerStateChange(newState) {
	if(newState==0){
		   loadNextVideo();
	}
}

function loadNextVideo(){
	
	//ask database for next video
	upvoted=0;
	downvoted=0;
	
	callServerPostForm(THEATRE_CONTROLLER, { method: 'get_next_video', theatre_id: document.$_GET['theatre_id']}, getNextVideo, 'GETTING NEXT VIDEO ', 'id_nextVideo');
	function getNextVideo(jsonReel) {

		dojo.attr('id_hidden_reel', 'value', jsonReel.id);
		//document.getElementById('now_playing').innerHTML = 'Now Playing:  ' + jsonReel.title;
		activeId = 'id_'+jsonReel.id;
		dojo.attr(activeId, 'class', 'video_prev_container_active');
		currentId = 'id_'+current_id;
		dojo.attr(currentId, 'class', 'video_prev_container');
		current_id=jsonReel.id;
		//dojo.attr(current_id, 'class', 'video_prev_container');
		//current_id=jsonReel.id;
		play(jsonReel.url, 0);
	}
	
	updateRating();
	displayVideoInfo(jsonReel.submitter, jsonReel.title);
}


function play(videoId, startPoint){
	if(ytplayer){
		var out = 'playing video: ' + videoId + ' starting from time: ' + startPoint;
		console.log(out);
		ytplayer.loadVideoById(videoId, startPoint, "default");
	}
	else{
		console.log("failed to play");
	}
}

function mute(){
	
	if(ytplayer.isMuted()){
		ytplayer.unMute();
		dojo.attr('mute_button', 'class', 'mute_button_off');
	}
	else{
		ytplayer.mute();
		dojo.attr('mute_button', 'class', 'mute_button_on');
	}
}

function volumeUp(){

	var vol = ytplayer.getVolume();
	console.log(vol);
	if(vol != 100){
		ytplayer.setVolume(vol+10);
	}
}

function volumeDown(){

	var vol = ytplayer.getVolume();
	console.log(vol);
	if(vol != 0){
		console.log("setting volume");
		ytplayer.setVolume(vol-10);
	}
}