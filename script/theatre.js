dojo.require("dijit.form.TextBox");
dojo.require("dijit.form.Button");
dojo.require("dijit.form.ValidationTextBox");

var THEATRE_CONTROLLER = 'controllers/theatre_controller.php';
var SEARCH_CONTROLLER = 'controllers/search_controller.php';
var INDEX_CONTROLLER = 'controllers/index_controller.php';
var upvoted = 0;
var downvoted = 0;
var current_id;

dojo.addOnLoad(function() {

	var theatreId = document.$_GET['theatre_id'];
	if(theatreId == null) {
		document.$_GET['theatre_id'] = 28;
		//console.log(document.$_GET['theatre_id']);
	}
	setUpEmbededSWF();	
	enterTheatre();
	dojo.addOnWindowUnload(exitTheatre);
	getTheatres();
});


function sizeChat() {
	var buttonType = dojo.byId('id_minimize_chat').innerHTML;
	if(buttonType == '-') {
		dojo.style('id_chat_container', 'height', '23px');
		dojo.byId('id_minimize_chat').innerHTML = '+';
	} else {
		dojo.style('id_chat_container', 'height', '200px');
		dojo.byId('id_minimize_chat').innerHTML = '-';
	}
}

function getTheatres() {
	callServerPost(SEARCH_CONTROLLER, { method: 'get_all_theatres'}, showAllTheatres, 'GETTING THEATRES');
	function showAllTheatres(jsonTheatres) {
		var allTheatres = "";
		if(jsonTheatres) {
			for(i=0; i<jsonTheatres.length; i++) {
				var event = "goToTheatre(" + jsonTheatres[i].id + ")";
				var	 theatreDiv = dojo.create("div", { onClick: event, class: 'theatreInList' });
				var countHTML = '<div class="reel_count_num">' + jsonTheatres[i].reel_count + '</div>' + ' videos ';
				dojo.create("div", {innerHTML: countHTML, class:'reel_count_container'}, theatreDiv);
				var topicDiv = dojo.create("div", {innerHTML: jsonTheatres[i].topic +'<br/>', class:'topic_container' }, theatreDiv);
				dojo.create("div", {innerHTML: jsonTheatres[i].description, class:'desc_container' }, topicDiv);
				dojo.place(theatreDiv, dojo.byId('id_allTheatres'));
			}
		}
	}
}

function search() {
	searchString = dojo.attr('id_searchString', 'value');
	callServerPost(SEARCH_CONTROLLER, {method: 'search', search_string:searchString}, displayTopicList, 'LOADING TOPICS');
	function displayTopicList(jsonTheatres) {
		console.log('displaying');
		dojo.byId('id_allTheatres').innerHTML = "";
		//dojo.byId('id_topics_container').innerHTML = '';
		if(jsonTheatres) {
			for(i=0; i<jsonTheatres.length; i++) {
				var event = "goToTheatre(" + jsonTheatres[i].id + ")";
				var theatreDiv = dojo.create("div", { onClick: event, class: 'theatreInList' });
				var countHTML = '<div class="reel_count_num">' + jsonTheatres[i].reel_count + '</div>' + ' videos ';
				dojo.create("div", {innerHTML: countHTML, class:'reel_count_container'}, theatreDiv);
				var topicDiv = dojo.create("div", {innerHTML: jsonTheatres[i].topic +'<br/>', class:'topic_container' }, theatreDiv);
				dojo.create("div", {innerHTML: jsonTheatres[i].description, class:'desc_container' }, topicDiv);
				console.log(theatreDiv);
				dojo.place(theatreDiv, dojo.byId('id_allTheatres'));
			}

		} 
	}
}

function goToTheatre(theatreId) {
	window.location = '/index.php?theatre_id=' + theatreId;
}

function resizeSwitchBox() {
	
	var switchHeight = dojo.style('id_switchScreensContainer', 'height');
	console.log(switchHeight);
	if(switchHeight == '30') {
		console.log('iside thirty');
		dojo.style('id_switchScreensContainer', 'height', '370px');
	} else {
		dojo.style('id_switchScreensContainer', 'height', '30px');
	}
}

function showHideCreateScreenBox() {
	var switchHeight = dojo.style('id_switchScreensContainer', 'height');
	console.log(switchHeight);
	if(switchHeight == '370') {
		console.log('iside thirty');
		dojo.style('id_switchScreensContainer', 'height', '490px');
	} else {
		dojo.style('id_switchScreensContainer', 'height', '370px');
	}
	
}

function createTheatre() {
	callServerPostForm(SEARCH_CONTROLLER, {method: 'create_theatre'},createTheatreResponse,
						'CREATING THEATRE', 'id_form_create_theatre');
	function createTheatreResponse(jsonTheatre) {
		if(jsonTheatre) {
			window.location = '/index.php?theatre_id=' + jsonTheatre.id;
		} else {
			console.log('theatre allready exists');
		}
	}
}

function displayVideoInfo(username, title) {

	document.getElementById('id_video_submitter').innerHTML = "'"+title+"'" + " Submitted by " + username;
	
}

