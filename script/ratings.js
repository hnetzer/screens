
var RATING_CONTROLLER = 'controllers/rating_controller.php';

function voteUp(){

	//change color
	document.getElementById("vote_up_button").setAttribute("class", "thumbs_up_clicked");
	if(upvoted==0){

		callServerPostForm(RATING_CONTROLLER, {method: 'upvoted'}, confirm, 'UPDATING VOTES', 'id_nextVideo');
		if(downvoted==1){
			//remove previous downvote
			callServerPostForm(RATING_CONTROLLER, {method: 'remove_downvote'}, confirm, 'UPDATING VOTES', 'id_nextVideo');
			document.getElementById("vote_down_button").setAttribute("class", "vote_down");

		}
		upvoted=1;
		downvoted=0;
	}
	function confirm(result){ }
}

function voteDown(){
	
	//change color
	document.getElementById("vote_down_button").setAttribute("class", "rotton");
	document.getElementById("vote_up_button").setAttribute("class", "thumbs_up");

	if(downvoted==0){
		callServerPostForm(RATING_CONTROLLER, {method: 'downvoted'}, confirm, 'UPDATING VOTES', 'id_nextVideo');
		if(upvoted==1){
			callServerPostForm(RATING_CONTROLLER, {method: 'remove_upvote'}, confirm, 'UPDATING VOTES', 'id_nextVideo');
			document.getElementById("vote_up_button").setAttribute("class", "thumbs_up");

		}
		downvoted=1;
		upvoted=0;
	}
	function confirm(result){ }
}

function updateRating(){	
	callServerPostForm(RATING_CONTROLLER, {method: 'update_rating'}, confirm, 'UPDATING RATING', 'id_nextVideo');
	function confirm(response){
		document.getElementById('id_rating').innerHTML = response+'%';
	}
}