<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<html>
<head>	
	<script type="text/javascript" src="script/dojo-release-1.7.1-src/dojo/dojo.js" djconfig="parseOnLoad:true, isDebug:true"></script>
	<script type="text/javascript" src="script/utility.js"></script>
	<script type="text/javascript" src="script/index.js"></script>
	<link rel="stylesheet" type="text/css" href="script/dojo-release-1.7.1-src/dijit/themes/claro/claro.css"/>
	<link rel="stylesheet" type="text/css" href="css/login.css" />
	
</head>

<body class="claro body_style">
	<div class="top_bar">
	<img src="/images/screens.png" id="logo" style="top: 0px;">
	
	<div style="float:right;">
		<form id="id_form_signIn">
			<table>
				<tr>
					<td><font color="#f8f8f8">username or email</font></td>
					<td><font color="#f8f8f8">password</font</td>		
				</tr>
				<tr>
					<td><input id="username_email" type="text" name="username_or_email"
					data-dojo-type="dijit.form.ValidationTextBox"
    				data-dojo-props="required:true">
					</input></td>
					<td><input id="password" type="password" name="password"
					data-dojo-type="dijit.form.ValidationTextBox"
		    		data-dojo-props="required:true">
					</input></td>
					<td><div class="button" data-dojo-type="dijit.form.Button" onclick="signIn()">Sign In</div></td>
				</tr>
				<tr><div id="id_browser_error"></div></tr>
			</table>
		</form>
		</div>
		</div><!-- end top bar -->
		
	<div>
		<div class="main_box">
				
			<div class="front_text">
			<br><br>
				<div class="welcome">Watch this.</div>
				<div class="discover">Discover and discuss videos together.</div>
				<div class="description">Screens allows you to view, 
					<br>share, and discuss a constant 
					<br>stream of videos in real time. testing</div>
			</div>	
					
		</div><!-- end main box -->
		<div id="id_createAccount" dojo-data-type="dijit.Dialog" data-dojo-props="title:'Terms and Conditions'" >
			<button class="join_button" data-dojo-type="dijit.form.DropDownButton">
    			<span >Join</span><!-- Text for the button -->
    			<div data-dojo-type="dijit.TooltipDialog" id="ttDialog">
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
						<div data-dojo-type="dijit.form.Button" onclick="createAccount()">Submit</div>
						<div id="id_join_error"></div>
					</form>
				</div>
			</button>
		</div>
	</div>
</body>
</html>