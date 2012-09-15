<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>BuddyChat</title>

<meta name="application-name" content="BuddyChat">
<meta name="description" content="Buddy Chat, chat with your buddies">

<link rel="icon" href="chat1.png">
<link rel="shortcut icon" href="chat1.png" type="image/png">

</head>





<?php

	require_once("head.php");

?>


<style>

.body{
	margin-left:3em;
	margin-top:4em;
	overflow:auto;
	height:34em;


}

.hidden{
	display:none;
}

.lfloat{
	float:left;
}

.rfloat{
	float:right;
}

</style>

	<div class="body">

	<style>
	
	.left_container{
		border:1px solid #cccccc;
		width:14em;
		height:32em;
		float:left;
		display:block;

	}
	
	.online_users{
	
		font-size:2em;
		text-align:center;
		margin-top:4em;
		line-height:1.6em;
		color:#084d9c;
	}
	
	.user_count{
		font-weight:bold;
	}
	</style>
	
	<div class="left_container">

		<div class="online_users">	
		 Online <br/> Users<br/> <span class="user_count">...</span>
		</div>
		
	</div>
	
	
	<style>
	
.chat_container{
	float:left;
	margin-left:1em;
	display:block;
}
.chat_container{
	border:1px solid #656565;
	width:40em;
	height:32em;

}

.chat_history{
/*	border:1px solid #656565;*/
	width:39em;
	height:23.3em;
	margin-top:0.3em;
	margin-left:0.5em;
	line-height:1.7em;
	overflow-y:auto;
}

.chat_message{
	height:1.5em;
/*	border:1px solid red;	*/
}

.reply{
	margin-top:0.3em;
	border:1px solid #656565;
	resize:none;
	border-radius:0.2em;
	width:52.6em;
	height:6em;
	margin-left:0.3em;
	padding:0.3em;
	line-height:1.6em;
}

.chat_title{
	background-color:lightyellow;
	font-weight:bold;
	height:1.5em;
	text-align:center;
	margin-top:0.3em
}

.dt{
	float:right;
	display:inline-block;
	color:#AAAAAA;
	margin-right:0.5em;
}
.chat_user_me{
	color:#656565;
	font-weight:bold;
	width:3em;
	display:inline-block;
	text-align:right;
	float:left;
}

.chat_user_buddy{
	color:maroon;
	font-weight:bold;
	display:inline-block;
	float:left;


}

.chat_user_message{
	display:inline-block;
	float:left;
	margin-left:3em;
	width:34.5em;
	font-family:Bookman, serif;
}

.reply_message .chat_user_message{
	color:#084d9c;
}
.my_message .chat_user_message{
	color:#656565;
}

.my_message,.reply_message{
	border-bottom:1px solid #eeeeee;
	
}

.my_message:hover,.reply_message:hover{
	background-color:lightyellow;
}
.clearfix{
	clear:both;
}

.chat_message{
	font-weight:bold;
	color:maroon;
}

	</style>
	
	
	<div class="chat_container">
	
	<div class="chat_title">Chat History</div>
	
	<div class="chat_message"></div>
	
	<div class="chat_history">
	

		
	</div><!-- chat_shitory -->
	
	<textarea class="reply" placeholder="Type your Message Here"></textarea>
	
	</div><!-- CHat container -->
	
	
	
	
		<style>
	
	.right_container{
		border:1px solid #cccccc;
		width:13em;
		height:31em;
		float:left;
		display:block;
		margin-left:1em;
		padding:0.5em;
	}
	
	.userstatus{
		margin-top:8em;
	
	}
	
	.userstatus_status{
		font-weight:bold;
	}
	
	.report_user{
		font-size:1em;
		color:maroon;
		font-weight:bold;
		text-align:center;
		margin-top:3em;
	}
	
	.org_contact{
		text-align:center;
		margin-top:3em;
		font-weight:bold;
		cursor:pointer;
	}
	
	.pair_user,.disconnect_user{
		color:white;
		background-color:#084d9c;
		text-align:center;
		font-weight:bold;
		cursor:pointer;
		height:1.5em;
		margin-bottom:1em;
	}

	.pair_user:hover,.disconnect_user:hover{
		color:#084d9c;
		background-color:white;
	}

	</style>
	
	<div class="right_container">
	

	<div class="userstatus">
	
	<div class="pair_user" >Connect a Buddy</div>
	<div class="disconnect_user hidden" >Disconnect Buddy</div>
	

	Status: <span class="userstatus_status">Not Connected	</span>
	

	
	</div>
	
<!--
	<div class="report_user">
	
	Report this user?
	
	</div>

	-->

	<div class="org_contact" onclick="javascript:send_suggestion();">
	
	Contact us
	
	</div>
	
	</div>
	
	
	<style>
	
	.footer{
		bottom:0;
		position:fixed;
		width:100%;
		left:0;
		background-color:lightyellow;
		height:2em;
		text-align:center;
		font-style:italic;
		font-size:0.8em;
	}
	</style>

	<div class="footer">
	
			A Product of <a href="http://the-at-team.blogspot.in/" target="_blank">@ Team</a>
	
	</div>
	
	
	<div class="clearfix"></div>
	
	</div> <!-- body -->
	
	<script src="chat.js"></script>
	
	
		<style>
	
		.popup_container{
			left:0;
			height:100%;
			width:100%;
			position:fixed;
			top:0;
			background-color:whitesmoke;
			opacity:0.5;
		}
	
		.popup_content{
			padding:1em;
			position:absolute;
/*			min-width:20em;
			min-height:7em;	*/
			border:0.4em solid grey;
			border-radius:0.3em;
			z-index:300;
			background-color:white;
			margin-left:1em;
		}
		
		.popup_title{
			text-align:center;
			color:#084d9c;
			margin-bottom:0.5em;
			
		}
	</style>

	<div class="popup_content hidden">
	
	</div>

	<div class="popup_container hidden"></div>
	
	<script>
	
		function showpopup(msg){
				$('.popup_content').html(msg);
				
				$('.popup_content').css('left',(($(window).outerWidth()/2) - ($('.popup_content').outerWidth()/2)));
				
				$('.popup_content').css('top',(($(window).outerHeight()/2) - ($('.popup_content').outerHeight()/2)));
				
			$('.popup_content').removeClass("hidden");
			$('.popup_container').removeClass("hidden");
				
		}
		
		function hidepopup(){
			$('.popup_content').addClass("hidden");
			$('.popup_container').addClass("hidden");
		
		}
	</script>
	
	
	
	</html>
