function enterTheatre() {
	var params = {method: 'user_enter', theatre_id: document.$_GET['theatre_id'] };
	callServerPostSync(THEATRE_CONTROLLER, params , displayNumViewers, 'Entering THEATRE' );
	function displayNumViewers(numViewers){
		var text = '';
		if(numViewers > 1) {
			text = numViewers + ' viewers';
		} else {
			text = numViewers + ' viewer';
		}
		dojo.byId('id_num_viewers').innerHTML = text;
	}	
}

function exitTheatre(){
	callServerPostSync(THEATRE_CONTROLLER, {method: 'user_exit', theatre_id: document.$_GET['theatre_id'] }, confirmLeft, 'EXITING THEATRE' );
	function confirmLeft(id){ }	
}

function getUsersInTheatre(){
	
	callServerPost(THEATRE_CONTROLLER, { method: 'get_users_in_theatre'}, showUsersInTheatre, 'GETTING USERS IN THEATRE');
	function showUsersInTheatre(jsonUser) {//array of usernames
		//jsonUser[i].username
		console.log(jsonUser);
		//dojo.byId('id_usersInTheatre').innerHTML = jsonUser.topic;
	}
}

function getViewers(){
	//returns the number of viewers in the theatre
	callServerPost(THEATRE_CONTROLLER, {method: 'get_viewers'}, confirm, 'GETTING VIEWERS');
	function confirm(response){
		
	}

}

function signOut() {
	callServerPost(SEARCH_CONTROLLER, { method: 'sign_out'}, signOutRedirect, 'SIGNING OUT');
	function signOutRedirect() {
		window.location = '/index.php?theatre_id='+ document.$_GET['theatre_id'];
	}
}


function signIn() {
	
	var username = dojo.attr('username_email', 'value');
	var password = dojo.attr('password', 'value');
	
	callServerPostForm(INDEX_CONTROLLER, {method:'sign_in'}, redirect, 'SIGNING IN', 'id_form_signIn');
}

function createAccount() {

	var username = dojo.attr('id_new_username', 'value');
	var email = dojo.attr('id_new_email', 'value');
	var pass = dojo.attr('id_new_password', 'value');
	var verifyPass = dojo.attr('id_verify_password', 'value');	
		
	if(pass == verifyPass){
		dojo.byId('id_join_error').innerHTML = "";
		var params = {method:'create_account'};
		callServerPostForm(INDEX_CONTROLLER, params, redirect, 'CREATING ACCOUNT', 'id_form_create_account');
	}
	else{
		var verifyPass = dojo.attr('id_verify_password', 'value');	
		dojo.byId('id_join_error').innerHTML = "passwords do not match";
	}
}

function displayLogin() {
	
	var display = dojo.style('id_login_box', 'display');
	
	if(display == 'none') {
		dojo.style('id_sign_up_box', 'display', 'none');
		dojo.style('id_login_box', 'display', 'inline');
	} else {
		dojo.style('id_login_box', 'display', 'none');
	}
}

function displaySignUp() {
	var display = dojo.style('id_sign_up_box', 'display');
	
	if(display == 'none') {
		dojo.style('id_login_box', 'display', 'none');
		dojo.style('id_sign_up_box', 'display', 'inline');
	} else {
		dojo.style('id_sign_up_box', 'display', 'none');
	}
}

function redirect(id) {
	if(id==-1) {
		console.log("username already exists");
		dojo.byId('id_join_error').innerHTML = "username already exists";

	} else if (id==-2){
		console.log("failure logging in");
		dojo.byId('id_login_error').innerHTML = "error logging in";
		
	} else if(id){
		window.location = '/index.php?theatre_id='+ document.$_GET['theatre_id'];
	} else {
		console.log("error returning");
	}
}
