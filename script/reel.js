


function getReelPreview(){
	dojo.byId('id_reelPreview').innerHTML = '';
	var theatreId = document.$_GET['theatre_id'];
	var params = { method: 'get_reel', theatre_id: theatreId};
	callServerPost(THEATRE_CONTROLLER, params, reelResponse, 'GETTING REEL');
	function reelResponse(jsonReels){
		if(jsonReels){
			for(i=0; i<jsonReels.length; i++) {
				var container = dojo.create("div", {class:'video_prev_container', id: 'id_'+jsonReels[i].vid_id});
				var container2 = dojo.create("div", {class:'video_prev_inner'}, container);
				var thumbWrapper = dojo.create("div", {class:'video_prev_thumbWrapper'}, container2);
				var idDiv = dojo.create("div", {innerHTML: jsonReels[i].title, class:'video_prev_title' }, container2);
				var thumb = dojo.create("img", {src: stripslashes(jsonReels[i].thumb_url), class:'video_prev_thumb' }, thumbWrapper);	
				//dojo.place(thumbWrapper, container2);
				//dojo.place(container2, container);
				dojo.place(container, dojo.byId('id_reelPreview'));
			}
		}		
	}
}



function addUrlToPlaylist() {
	
	//get ID out of url
	var url = dojo.attr("new_url", "value");
	var video_id = url.split('v=')[1];
	var ampersandPosition = video_id.indexOf('&');
	if(ampersandPosition != -1){
		video_id = video_id.substring(0, ampersandPosition);
	}
	
	//add ID to database
	newId = video_id;
	var params = { method: 'add_to_playlist', url: newId, theatre_id: document.$_GET['theatre_id'] };
	callServerPostText(THEATRE_CONTROLLER, params , showInPlaylist, 'ADDING VIDEO');
	

}

function showInPlaylist(jsonRT) {
	
	dojo.byId("id_newUrlForm").reset();
	
	//if theater has no videos playing
	if(dojo.attr('id_hidden_reel', 'value') == 0){
		play(newId, 0);
		dojo.attr('id_hidden_reel', 'value', jsonRT.id);
	}
	//ytplayer.loadVideoById(videoId, 0, "medium");
	
	getReelPreview()
	
}

function sizeReel() {	
	var buttonType = dojo.byId('id_minimize_reel').innerHTML;
	if(buttonType == '-') {
		dojo.style('id_reel_container', 'height', '23px');
		dojo.byId('id_minimize_reel').innerHTML = '+';
	} else {
		dojo.style('id_reel_container', 'height', '400px');
		dojo.byId('id_minimize_reel').innerHTML = '-';
	}
}
