<?php
	session_start();
		
	include 'models/utility_model.php';
	include 'models/connection_model.php';
	include 'models/user_model.php';
	
	$user = null;
	if (isset($_SESSION['user_id'])) {
		$user = User::FindById($_SESSION['user_id']);
	}
	
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<html>
<head>	
	<script type="text/javascript" src="script/dojo-release-1.7.1-src/dojo/dojo.js" djconfig="parseOnLoad:true, isDebug:true"></script>
	<script type="text/javascript" src="script/utility.js"></script>
	<script type="text/javascript" src="script/search.js"></script>
	<link rel="stylesheet" type="text/css" href="script/dojo-release-1.7.1-src/dijit/themes/claro/claro.css"/>
	<link rel="stylesheet" type="text/css" href="css/search.css" />
	
</head>
<body class="claro body_style">
<div class="top_bar">
	<a href="search.php"><img src="/images/screens.png" id="logo" style="top: 0px;"></a>
	<div style="float:right">
		<div class="username" >logged in as <span class="name"><?php if($user != null) echo $user->Username(null); ?></span></div>
		<div class="sign_out" onclick="signOut()">Sign Out</div>
	</div>
</div>
<div class="main_box">

<div class='search_wrapper'>
	<input class='searchBox' onkeyup="search()" type="text" name="search_string" value="" dojoType="dijit.form.TextBox" trim="true" id="id_searchString">
	<span><div data-dojo-type="dijit.form.Button" class="search_button" onclick="search();">Search</div</span>
</div>
<div id="id_topics_container" class='topics_container'></div>


<div class="theatre_content">
	<div class="theatre_section_top">
		<span class= "create_new_button_wrapper">
			<div id="id_createTheatre" dojo-data-type="dijit.Dialog" >
				<button data-dojo-type="dijit.form.DropDownButton">
    				<span>Create New</span><!-- Text for the button -->
    				<div data-dojo-type="dijit.TooltipDialog" id="ttDialog">
    					<form id="id_form_create_theatre" style="padding:10px;">
							<div>topic</div>
							<input type="text" name="new_topic" maxlength="50" trim="true"
								 data-dojo-type="dijit.form.ValidationTextBox"
    							 data-dojo-props="required:true"
							></input>					
							<div>description</div>
							<textarea name="new_description" rows="5" cols="70"></textarea> <br/>
							<div data-dojo-type="dijit.form.Button" onclick="createTheatre()">Create</div>
						</form>
					</div>
				</button>
			</div>
		</span>
		<span class="theatre_header">theatres</span>
	</div>
	<div id="id_allTheatres"></div>
</div>
</div><!-- end main box -->
</body>
</html>