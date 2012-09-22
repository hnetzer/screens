<?php
	session_start();
		
	include 'models/utility_model.php';
	include 'models/connection_model.php';
	include 'models/user_model.php';
	include 'models/theatre_model.php';
	
	$HOME_ID = 28;
	if (!isset($_SESSION['user_id'])) { //if user_id is not set go to index page
		if(isset($_GET["theatre_id"])) {
			$index_page = 'Location: /index.php?theatre_id=' . $_GET["theatre_id"];
		} else {
			$index_page = 'Location: /index.php?theatre_id=' . $HOME_ID;
		}
		header($index_page);
	} 
	
	$THEATRE_ID = null;
	if(isset($_GET["theatre_id"])) {
		$THEATRE_ID = $_GET["theatre_id"];
	} else {
		$THEATRE_ID = $HOME_ID;
	}
		
	$theatre = Theatre::FindById($THEATRE_ID);
	$user = User::FindById($_SESSION['user_id']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<html>
<head>
	<script type="text/javascript" src="script/dojo-release-1.7.1-src/dojo/dojo.js" djconfig="parseOnLoad:true, isDebug:true"></script>
	<script type="text/javascript" src="script/utility.js"></script>
	<script type="text/javascript" src="jwplayer/jwplayer.js"></script>
	<script type="text/javascript" src="script/player.js"></script>
	<script type="text/javascript" src="script/ratings.js"></script>
	<script type="text/javascript" src="script/user.js"></script>
	<script type="text/javascript" src="script/reel.js"></script>
	<script type="text/javascript" src="swfobject/src/swfobject.js"></script>  
	<link rel="stylesheet" type="text/css" href="script/dojo-release-1.7.1-src/dijit/themes/claro/claro.css"/>
	<link rel="stylesheet" type="text/css" href="css/theater.css" />
	 <script type="text/javascript" src="script/prototype.js"></script>
	 <script type="text/javascript" src="script/chat.js"></script>
	<script type="text/javascript" src="script/theatre.js"></script>
	<title><?php echo 'screens - '. $theatre->Topic(null);?></title>
</head>
<body class="claro body_style">
	<div class="top_bar">
		<img src="/images/screens.png" id="logo" style="top: 0px;">
		<div class="login_or_sign_up">
			<span class="user_name"><?php echo $user->Username(null); ?></span>
			<span class="sign_out_link" onClick="signOut()">sign out</span>
		</div>
	</div>
	<span class="name" style="display:none" id="id_chat_usr"><?php if($user != null) echo $user->Username(null); ?></span>
	<div class="main_box">		
		 <div class="player_container">  
			  <div id="ytapiplayer" class="ytplayer">
			    ...loading video player
			  </div>
			<br>
			<div style="float:left">
				<div id="mute_button" class="mute_button_off"  id="mute_button"  onClick="mute()"></div>
			</div>
			<div class="video_submitter" id="id_video_submitter"></div>
			<div style="float:right">
				<div class="thumbs_up" id="vote_up_button" onClick="voteUp()"></div>
				<div class="vote_down" id="vote_down_button" onClick="voteDown()"></div>
				<div class="rating" id="id_rating">rating</div>
			</div>
	</div>		
</div>

<div class="reel" id="id_reel_container">
	<div class="reel_header" onclick="sizeReel()"><span id="id_reel_theatre_name" class="reel_theatre_name"><?php echo $theatre->Topic(null);?></span><span id="id_minimize_reel" class="minimize_button" >+</span></div>
	<div id="id_reelPreview" class="reel_prev_list_container"></div>
	<form style="display:inline;" id="id_newUrlForm">
		<div class="add_url_text">contribute by adding a YouTube URL</div>
		<input id="new_url" class="url_input" type="text"></input>
	</form>
	<span data-dojo-type="dijit.form.Button" onClick="addUrlToPlaylist()">+</span>
</div>	

<div id="id_chat_container" class="chat_container">	
	<div class="chat_header" onClick="sizeChat()">chat <span id="id_num_viewers" class="num_viewers"></span><span class="minimize_button" id="id_minimize_chat" >+</span></div>
	<div id="content" class="chat_content"></div>
	<form action="" method="get" onsubmit="comet.doRequest($('word').value);$('word').value='';return false;">
		<textarea type="text" class="chat_textarea" onkeyup="if (event.keyCode == 13) document.getElementById('id_submit_chat').click()" name="word" id="word" value="" ></textarea>
		<input type="submit" class="chat_submit" id="id_submit_chat" name="submit" value="Send" />
	</form>
</div>

<div id="id_switchScreensContainer" class="switch_screens_container">
	<div class="switch_screens_header" onclick="resizeSwitchBox()">switch screen</div>
		<div class='search_wrapper'>
			<input class='searchBox' onkeyup="search()" type="text" name="search_string" value="" dojoType="dijit.form.TextBox" trim="true" id="id_searchString">
			<!-- <span><div data-dojo-type="dijit.form.Button" class="search_button" onclick="search();">Search</div</span>-->
		</div>
	<div id="id_allTheatres" class="all_theatres_container"></div>
	<div class="new_screen_button" onClick="showHideCreateScreenBox()">create a new screen</div>
	<form id="id_form_create_theatre" style="padding:5px;">
		<div>screen name</div>
		<input type="text" name="new_topic" maxlength="50" trim="true"
		 data-dojo-type="dijit.form.ValidationTextBox"data-dojo-props="required:true"></input>
		<div>description</div>
		<input type="text" name="new_description" maxlength="50" trim="true" 
		data-dojo-type="dijit.form.ValidationTextBox" data-dojo-props="required:true"></input>
		<div data-dojo-type="dijit.form.Button" onclick="createTheatre()">Create</div>
	</form>
</div>

<form id="id_nextVideo">
	<input type="hidden" id="id_hidden_reel" name="reel_id" value="0" />
</form>

</body>
</html>