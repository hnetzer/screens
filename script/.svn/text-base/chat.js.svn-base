var Comet = Class.create();
Comet.prototype = {

  timestamp: 0,
  url: 'controllers/chat_controller.php',
  theatre_id: document.$_GET['theatre_id'],
  username : 'p',
  noerror: true,

  initialize: function() {

  },

  connect: function()
  {
    this.ajax = new Ajax.Request(this.url, {
      method: 'get',
      parameters: { 'timestamp' : this.timestamp, 'theatre_id': this.theatre_id },
      onSuccess: function(transport) {
        // handle the server response
        var response = transport.responseText.evalJSON();
        this.comet.timestamp = response['timestamp'];
        this.comet.handleResponse(response);
        this.comet.noerror = true;
      },
      onComplete: function(transport) {
        // send a new ajax request when this request is finished
        if (!this.comet.noerror)
          // if a connection problem occurs, try to reconnect each 5 seconds
          setTimeout(function(){ comet.connect() }, 5000); 
        else
          this.comet.connect();
        this.comet.noerror = false;
      }
    });
    this.ajax.comet = this;
  },

  disconnect: function()
  {
  },

  handleResponse: function(response)
  {
	var fullMsg = response['msg'];
	var userName = fullMsg.substr(0, fullMsg.indexOf(':')+1);
	var realMsg = fullMsg.substr(fullMsg.indexOf(':') + 1);

	userName = stripslashes(userName);
	realMsg = stripslashes(realMsg);
	
	var chatHTML = '<div><span class="chat_username">' + userName + ' </span>';
	chatHTML += '<span class="chat_msg">' + realMsg + '</span></div>';
    $('content').innerHTML += chatHTML;
    
    
    $('content').scrollTop = $('content').scrollHeight;
  },

  doRequest: function(request)
  {
	var user = dojo.byId('id_chat_usr').innerHTML;
	console.log(user);

    new Ajax.Request(this.url, {
      method: 'get',
      parameters: { 'msg' : request, 'theatre_id': this.theatre_id, 'username': user }
    });
  }
}
var comet = new Comet();
comet.connect();
