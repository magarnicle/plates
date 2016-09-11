<html>
<head>
<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>

<script type='text/javascript'> 

var message = "";
var plateFound = false;

//Validate plate against database as user types
$(document).ready(function(){  
    $("#plate").keyup(function(){ 
        validate_plate($("#plate").val());
		ajax_search();
		canSend();
    }); 

});

//Check for new messages every few seconds
$(document).ready(function(){
	//Do a first check, then at intervals after that
	checkForMessages();
	//5 seconds
   setInterval(checkForMessages, 5*1000);   
});

//When changing user, check for new messages straight away
$(document).ready(function(){
	//Reset when we change user
	$("#user").change(function(){checkForMessages();})
});

//Check if the user has done enough to enable the send button
$(document).ready(function(){  
    $("[type='button']").click(function(){
		if (this.id != 'send')
		{
			message_button(this);
			canSend();
		} else
		{
			send();
		}
    }); 

});

//See if the user has typed in a plate that exists
function ajax_search(){
	
  var plate_val = "";
  plate_val=$("#plate").val(); 
  if (plate_val == "")
  {
	  plate_val = $("#search_results").html("");
  } else{
  if (validate_plate(plate_val=$("#plate").val())){
  $.ajax({url: '/searcher.php', data: {plate : plate_val},
  success: (function(data){
   plateFound = false;
   if (data.length > 0){
	   $("#search_results").html(data[0].plate); 
	   if (data[0].plate == plate_val)
	   {
		   $("#search_results").html("☺");
		   plateFound = true;
		}
  } else
  {
	 $("#search_results").html("‼"); 
  }
  }

  ),
  dataType:'json', type: 'POST'});
  }}
}

//Check that the plate includes only letters and numbers
function validate_plate(plate){
	if (plate.toUpperCase().match(/[A-Z|0-9]+/g) == null && plate.length > 0){
			$("#search_results").html("Use letters and numbers only.");
			return false;
	} else
	{ 
		return true;
	}
	
	
}

//Set the message and change the button colours when a user clicks on mone
function message_button(button){
	var buttons = $("[type='button']")
	for (var i = 0; i < buttons.length; i++) {
		buttons[i].style.color = 'black';
	}
	if (button.id != 'send' && button.id != 'inbox'){
	button.style.color = 'yellow';
	message = button.value;
	}
}

//Enable the send button when appropriate
function canSend(){
	$("send").disabled = !(plateFound && message != "");
}

//Send the message
function send(){
	var plate_val = "";
  plate_val=$("#plate").val(); 
  var user_val = "";
  user_val = $("#user").val();
	  $.ajax({url: '/sender.php', data: {user : user_val, plate : plate_valtoUpperCase(), message : message},
  success: (function(data){
   
  
   $("#send_results").html(data); 
 
  }

  ),
  dataType:'text', type: 'POST'});
}

//See if we have new messages and set the inbox count accordingly
function checkForMessages(){  
  var user_val = "";
  user_val = $("#user").val();
  $.ajax({url: '/messages.php', data: {user : user_val},
  success: (function(data){
	  //If the message count has changed, update the inbox button
	  if ($("#inbox").html() != data)
	  {
		$("#inbox").html(data);
	  }
  }),
  dataType:'json', type: 'POST'});
}
 
</script>


</head> 
<body>  


<h2>Plates</h2>

User: <select id="user">
  <option value="user1">user1</option>
  <option value="user2">user2</option>
</select> 
<p>
Inbox: <button type="button" id="inbox">0</button>

<p>

Send Message
<form method="post" id="plate_form">  
Plate: <input type="text" id="plate">
</form>

<div id="search_results"></div>

<form method="post" id="messages">
<input type="button" id="lights_on" value="You left your lights on.">
<input type="button" id="lights_out" value="One of your lights is broken.">
<input type="button" id="other" value="There appears to be something wrong with your car.">
</form>

<button type="button" id="send">Send Message</button>

<div id="send_results"></div>

</body>
</html>
