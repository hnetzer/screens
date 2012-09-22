<?php
	session_start();
		
	include 'models/utility_model.php';
	include 'models/connection_model.php';
	include 'models/user_model.php';
	include 'models/theatre_model.php';
		
	$user =  NULL;
	$theatre = null;
	if (isset($_SESSION['user_id']) && isset($_GET["theatre_id"])) {		
		User::EnterTheater($_SESSION['user_id'],$_GET["theatre_id"]);
		$user = User::FindById($_SESSION['user_id']);
	} else if(isset($_SESSION['user_id']) && !isset($_GET["theatre_id"])) {
		User::EnterTheater($_SESSION['user_id'],1); //the id of the second param=home theatre
		$user = User::FindById($_SESSION['user_id']);
	}
	
	if(isset($_GET["theatre_id"])) {
		$theatre = Theatre::FindById($_GET["theatre_id"]);
	} else {
		$theatre = Theatre::FindById(1);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<html>
<head>	
	<script type="text/javascript" src="script/dojo-release-1.7.1-src/dojo/dojo.js" djconfig="parseOnLoad:true, isDebug:true"></script>
	<script type="text/javascript" src="script/utility.js"></script>
	<script type="text/javascript" src="jwplayer/jwplayer.js"></script>
	<script type="text/javascript" src="script/search.js"></script>
	<script type="text/javascript" src="swfobject/src/swfobject.js"></script>  
	<link rel="stylesheet" type="text/css" href="script/dojo-release-1.7.1-src/dijit/themes/claro/claro.css"/>
	<link rel="stylesheet" type="text/css" href="css/theater.css" />
	 <script type="text/javascript" src="script/prototype.js"></script>
	 <script type="text/javascript" src="script/chat.js"></script>
	<script type="text/javascript" src="script/theatre.js"></script>
	<title><?php echo $theatre->Topic(null);?></title>
</head>
<body class="claro body_style">

<div class="top_bar">
	<a href="search.php"><img src="/images/screens.png" id="logo" style="top: 0px;"></a>
	<div style="float:right">
<?php 
	if($user != null) {
		echo '<span class="lobby_link">' . $user->Username(null) .'</span>'.
			 '<span class="sign_out_link" onClick="signOut()">sign out</span>';
	} else {
		echo '<div class="login_or_sign_up">'.
				'<span class="lobby_link" onClick ="displayLogin()">login</span>' .
			 	'<span class="lobby_link" onClick ="displaySignUp()">sign up</span> ' .
			 '</div>';
	}
?>	
		<div id="id_login_box" class="login_container">
			<form id="id_form_signIn">
				<table>
					<tr>
						<td>username or email</td>
					</tr>
					<tr>
						<td><input class="login_input" id="username_email" type="text" name="username_or_email"
						data-dojo-type="dijit.form.ValidationTextBox"
    					data-dojo-props="required:true">
						</input></td>
					</tr>
					<tr>
						<td>password</td>		
					</tr>
					<tr>
						<td><input id="password" type="password" name="password" class="login_input"
						data-dojo-type="dijit.form.ValidationTextBox"
		    			data-dojo-props="required:true">
						</input></td>
						<td>
					</tr>
					<tr>
						<td><div class="button" data-dojo-type="dijit.form.Button" onclick="signIn()">Sign In</div></td>
					</tr>
					<tr><div id="id_browser_error"></div></tr>
				</table>
			</form>
		</div>
		<div id="id_sign_up_box" class="login_container">
			<form id="id_form_create_account" style="padding:5px;">
				<div>username:</div>
				<input type="text" id="id_new_username" name="new_username" maxlength="50" trim="true"
					data-dojo-type="dijit.form.ValidationTextBox"
    				data-dojo-props="regExp:'\.+', required:true, invalidMessage:'Username too long.'"
				></input>
				<div>email</div>
				<input type="text" id="id_new_email" name="new_email" maxlength="50" trim="true"
					data-dojo-type="dijit.form.ValidationTextBox"
					data-dojo-props="regExp:'\.+[@]\.+\\.\.+', invalidMessage:'Invalid email address.'"
				></input>
				<div>password:</div>
				<input type="password" id="id_new_password" name="new_password" maxlength="64" trim="true"
				 data-dojo-type="dijit.form.ValidationTextBox"
    			data-dojo-props="regExp:'\.{5}\.+', required:true, invalidMessage:'password must be at least 6 characters'"
				></input>
				<div>verify password:</div>
				<input type="password" id="id_verify_password" name="verify_new_password" maxlength="64" trim="true"
				data-dojo-type="dijit.form.ValidationTextBox"
    			data-dojo-props="regExp:'\.{5}\.+', required:true, invalidMessage:'password must be at least 6 characters'"
				></input> <br/>
				<div data-dojo-type="dijit.form.Button" onclick="createAccount()">sign up</div>
				<div id="id_join_error"></div>
			</form>
		</div>
		<span style="display:none"><span class="name" id="id_chat_usr"><?php if($user != null) echo $user->Username(null); ?></span></span>
	</div>
</div>
<div class="main_box">		
	 <div class="player_container">  
		  <div id="ytapiplayer" class="ytplayer">
		    ...loading video player
		  </div>
		<br>
		<div style="float:left">
			<div id="mute_button" class="mute_button_off"  id="mute_button"  onClick="mute()"></div>
		</div>
		<div style="float:right">
<?php 
	if($user != null) { 
		echo '<div class="thumbs_up" id="vote_up_button" onClick="voteUp()"></div>
			<div class="vote_down" id="vote_down_button" onClick="voteDown()"></div>';
	}
?>	
			<div class="rating" id="id_rating">rating</div>
		</div>
	</div>		
</div><!-- end main box -->
<div class="reel" id="id_reel_container">
	<div class="reel_header" onclick="sizeReel()"><span id="id_reel_theatre_name" class="reel_theatre_name"><?php echo $theatre->Topic(null);?></span><span id="id_minimize_reel" class="minimize_button" >+</span></div>
	<div id="id_reelPreview" class="reel_prev_list_container"></div>
<?php   
	if($user != null) {
		echo '<form style="display:inline;" id="id_newUrlForm">' .
				'<div class="add_url_text">contribute by adding a YouTube URL</div>'.
				'<input id="new_url" class="url_input" type="text"></input>'.
			 '</form>' .
			 '<span data-dojo-type="dijit.form.Button" onClick="addUrlToPlaylist()">+</span>';
	} else {
		echo '<div class="add_url_text">please log in to contribute to the reel</div>';
	}

?>
</div>	
<div id="id_chat_container" class="chat_container">	
	<div class="chat_header" onClick="sizeChat()">chat<span class="minimize_button" id="id_minimize_chat" >+</span></div>
	<div id="content" class="chat_content"></div>
<?php 
	if($user != null) {
		echo '<form action="" method="get" onsubmit="comet.doRequest($(\'word\').value);$(\'word\').value=\'\';return false;">'.
				'<textarea type="text" class="chat_textarea" onkeyup="if (event.keyCode == 13) document.getElementById(\'id_submit_chat\').click()" name="word" id="word" value="" ></textarea>'.
				'<input type="submit" class="chat_submit" id="id_submit_chat" name="submit" value="Send" />'.
			 '</form>';
	} else {
		echo '<div class="add_url_text">please log in to contribute to the chat</div>';
	}
?>   	
</div>
<div id="id_switchScreensContainer" class="switch_screens_container">
	<div class="switch_screens_header" onclick="resizeSwitchBox()">switch screen</div>
		<div class='search_wrapper'>
			<input class='searchBox' onkeyup="search()" type="text" name="search_string" value="" dojoType="dijit.form.TextBox" trim="true" id="id_searchString">
			<!-- <span><div data-dojo-type="dijit.form.Button" class="search_button" onclick="search();">Search</div</span>-->
		</div>
	<div id="id_allTheatres" class="all_theatres_container"></div>
<?php 
	if($user != null) {
		echo '<div class="new_screen_button" onClick="showHideCreateScreenBox()">create a new screen</div>'.
			 '<form id="id_form_create_theatre" style="padding:5px;">' .
		     	'<div>screen name</div>' .
				 '<input type="text" name="new_topic" maxlength="50" trim="true"' .
			 	'data-dojo-type="dijit.form.ValidationTextBox"data-dojo-props="required:true"></input>' .
		 		'<div>description</div>' .
				'<input type="text" name="new_description" maxlength="50" trim="true" ' .
				'data-dojo-type="dijit.form.ValidationTextBox" data-dojo-props="required:true"></input>' .
				'<div data-dojo-type="dijit.form.Button" onclick="createTheatre()">Create</div>' .
			'</form>';
	} else {
		echo '<div style="margin-left:10px; margin-top:3px;">sign in to create a new screen! </div>';
	}
?>
</div>
<form id="id_nextVideo">
	<input type="hidden" id="id_hidden_reel" name="reel_id" value="0" />
</form>
</body>
</html>
