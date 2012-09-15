
/*
	holds the client status if the 
	client is connected to another buddy..
*/
	var dconnect=true;


/*
	XHTML Request object for the pair ajax request

*/
	var pairxhr=null;

/*
	XHTML Request object for the status ajax request

*/
	var statusxhr=null;

/*
	XHTML Request object for the update ajax request

*/
	var updatexhr=null;


	var count=0;


/*

	Function : initialize
	Parameters: none
	
	Description:
		Intializing function
	
	Procedure:
	initalize the webpage...

	bind all the functions
	
		1. bind the reply keydown to send the message to the 
		server	

		2. bind the pairuser button to its function..
		
		3.bind the disconnect button to its function..
	
	
	call the update function which updates the server to the about the user existence..
	
	
	
	
*/


$(function(){

		
	$(".reply").keydown(function(e){
		send_reply(e);
	});
	
	$(".pair_user").click(function(e){ e.preventDefault(); pairuser(); });
	$(".disconnect_user").click(function(e){  e.preventDefault(); disconnect(); });
	
	update_user();
	
	updatexhr=setInterval(update_user,20000);

	$.ajax({async:true});
});


/*

	Function : get_status
	Parameters: none
	
	Description:

		get the status from server like disconnection and new msg
	
	Procedure:
	
	Check if already disconnected then dn get the status..
	
	Form the ajax query and send the status to server
	
	if the request is sucess then..
		if status is disconnected then the update3 the page to 
		show disconnected msg
		
		
		if connected call the get_status again
		
		if any msg is there then display the message to the user..
		
	if fail then retry the status request	
	
*/


function get_status(){

	if (dconnect==1){
		count=0;
		return;
	}

	count= count + 1;
	
	statusxhr = $.ajax({
	  url: "/status",
	  type: "POST",
	  dataType: "json",
	   timeout: 30000
	});

	
	statusxhr.done(function(data) {
	
		count=0;
		
		$.each(data, function(key, val) {
	
			if (key=="status")	{

   			switch(val){
   			
   				case 3:	//disconected
   					unbind_send();

					$(".disconnect_user").addClass("hidden");
					$(".pair_user").removeClass("hidden");

					
					dconnect=1;
					$(".chat_history").prepend('Buddy Disconnected. Connect with another buddy');
					$(".userstatus_status").html('Disconnected..!');
   					break;
   					
   				case 1:
   					get_status();
   					break;
   					
   			}//switch
   			
   			}//key
   			else if (key=="msg"){
   				chat_reply_msg(val);
   				get_status();
   			}
   	
	  	});//each json
	  
	  


	}); //request


	statusxhr.fail(function(jqXHR, textStatus) {
	
		if (dconnect==0) get_status();
	});

}


/*

	Function : alert_user
	Parameters: string-msg
	
	Description:

		display the status message to the user on the top of the chat window
	
	Procedure:
	
	show the message.. 
	
	set the time out to hide the message by caling the messae again with empty message
	
	
*/



function alertuser(msg){

	$(".chat_message").html(msg);
	setTimeout(function(){$(".chat_message").html('');},5000);
	
}


/*

	Function : update_user
	Parameters: none
	
	Description:

		get the status from server like online user account for now..
	
	Procedure:
	
	if there is a old request abort it..
	
	form the aax request and send it to the server
	
	on sucess display the count to the user
	
	on fail reset the ajax request
	
*/

function update_user(){


	if (updatexhr) updatexhr.abort();

	updatexhr = $.ajax({
	  url: "/update",
	  type: "POST",
	  dataType: "json"
	});

	updatexhr.done(function(data) {
	
		$(".user_count").html(data['count']);
		updatexhr=null;
	}); //request


	updatexhr.fail(function(jqXHR, textStatus) {
		updatexhr=null;
	});

}



/*

	Function : bind_send
	Parameters: none
	
	Description:

		bind the read only property of the text area
	
	Procedure:
	
		change the css to the textarea
	
*/


function bind_send(){
		$(".reply").css("readonly","");
}


/*

	Function : unbind_send
	Parameters: none
	
	Description:

		un bind the read only property of the text area
	
	Procedure:
	
		change the css to the textarea
	
*/


function unbind_send(){
		$(".reply").css("readonly","readonly");
}



/*

	Function : semd_reply
	Parameters: keydown event
	
	Description:

		send the reply to the server
	
	Procedure:
	
		check if the user pressed enter key
		
		check if there is some message to the user..
		
		form the request to send the message to the user
		
		on failure display the message to the user
	
*/

function send_reply(e){

		if (e.keyCode==13 && !e.shiftKey && $.trim($(".reply").val())!=""  && $(".reply").css("readonly")=="" ){

			e.preventDefault();
					
			unbind_send();
			
			var request = $.ajax({
			  	url: "/sendmsg",
				type: "POST",
				data:{msg:$.trim($(".reply").val())},
				dataType: "json"
			});

			request.done(function(data) {
			
				if (data['status']==1){
					chat_my_msg($.trim($(".reply").val()));
					$(".reply").val("");

				}else{
					alertuser('Sending Failed.Try again..!').delay(3000).html('');

				}

				bind_send();			

				
			});

			request.fail(function(jqXHR, textStatus) {

				alertuser('Sending Failed.Try again..!').delay(3000).html('');
				
				bind_send();
				$(".reply").focus();


			});

			

			
		}



}	//end of get status



/*

	Function : disconnect
	Parameters: none
	
	Description:

		discconnect the user from the chat on request from the user.
	
	Procedure:
	
		form the ajax request and send the discconect mesage
		
		setup the client that it is disconnected by displaying messages
		and setting the dconnect variable..
		
	
*/


function disconnect(){

	dconnect=1;
	if (statusxhr) statusxhr.abort();

	$.ajax({
	  url: "/disconnect",
	  type: "POST",
	  dataType: "json"
	});
	
	
	$(".disconnect_user").addClass("hidden");
	$(".pair_user").removeClass("hidden");

	$(".userstatus_status").html('Disconnected..!');
	
	$(".chat_history").prepend('Buddy Disconnected. Connect with another buddy');

	
}



/*

	Function : pairuser
	Parameters: none
	
	Description:

		pair the user with another user
	
	Procedure:
	
		display the waiting messages 
		
		form the ajax request and send the data..
		
		on sucess if connected then display connected msg,clear the chat history,diplay the message 
		
		if disconnected then display the disconnected status to the user on the screen
		
		
	
*/


function pairuser(){

	$("pair_user").unbind();
	$(".pair_user").html('Searching a buddy..');

	$(".userstatus_status").html('Waiting...!');
	
	pairxhr = $.ajax({
	  url: "/pairuser",
	  type: "POST",
	  dataType: "json"
	});

	pairxhr.done(function(data) {
		
		if (data['sucess']==1){
			bind_send();
			dconnect=0;


			$(".chat_history").html('');
			
			alertuser('Buddy Connected..! Start Chatting');
			
			$(".pair_user").addClass("hidden");
			$(".disconnect_user").removeClass("hidden");
			dconnect=0;

			$(".userstatus_status").html('Connected');
			
			$(".reply").focus();
			
			get_status();

		}
		else if (data['sucess']==0){
		
			unbind_send();

		
			$(".pair_user").removeClass("hidden");
			$(".disconnect_user").addClass("hidden");
			dconnect=1;
			$(".userstatus_status").html('Search Failed');
			$(".chat_history").prepend('Buddy Disconnected. Connect with another buddy');
			
		}

		$(".pair_user").html('Connect a Buddy');
		pairxhr=null;
	}); //request


	pairxhr.fail(function(jqXHR, textStatus) {
	
		unbind_send();
		
		$(".pair_user").html('Connect a Buddy');
		
		$(".pair_user").removeClass("hidden");
		$(".disconnect_user").addClass("hidden");
		
		$(".userstatus_status").html('Network Error');
		
		dconnect=1;
		pairxhr=null;
	});

	
}


/*

	Function : chat_my_msg
	Parameters: message
	
	Description:

		display the my message on the screen
	
	Procedure:
	
		display the sent message on the screenn
	
*/




function chat_my_msg(message){

	var dt=new Date();
	
	
		var cont='\
			<div class="my_message">				\
			<span class="dt">'+ dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds()  + '</span>\
			<span class="chat_user_me">Me</span>			\
										\
			<span class="chat_user_message">' + message.replace("\n","<br/>") + '</span>	\
										\
				<div class="clearfix"></div>			\
		</div>	';
		
		$(".chat_history").prepend(cont);



}


/*

	Function : chat_reply_msg
	Parameters: message
	
	Description:

		display the my message on the screen
	
	Procedure:
	
		display the received message on the screenn
	
*/


function chat_reply_msg(message){

		var dt=new Date();
		
		var cont='\
			<div class="reply_message">				\
			<span class="dt">'+ dt.getHours() + ":" + dt.getMinutes()+ ":" + dt.getSeconds() + '</span>\
			<span class="chat_user_buddy">Buddy</span>			\
										\
			<span class="chat_user_message">' + message.replace("\n","<br/>") + '</span>	\
										\
				<div class="clearfix"></div>			\
		</div>	';
		
		$(".chat_history").prepend(cont);



}

/*

	Function : send_suggestion
	Parameters: 
	
	Description:
		is for getting suggestion from user..
		gets the javascript from the server and eval it
	
	Procedure:
	
		form the ajax and exute it..
	
*/


function send_suggestion(){



	var suggest=$.ajax({
	  url: "/suggestion",
	  type: "POST",
	});
	
	suggest.done(function(data) {
		eval(data);
	});
}
