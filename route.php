

<?php


	/*
		route the request to the prescribed file
		
		routed by .htaccess
	*/

	if ($_SERVER['REQUEST_URI']=='/'){
		include_once('index.php');
		die();
	}

	/*
		if requset is directly to some file..
		redirect as error
		
		prevents the guessing of orginal file name by the users
		
	*/
	
	if ($_SERVER['REQUEST_URI']=='/sendmsg.php' || $_SERVER['REQUEST_URI']=='/disconnect.php' ||$_SERVER['REQUEST_URI']=='/status.php' || $_SERVER['REQUEST_URI']=='/suggestion.php' || $_SERVER['REQUEST_URI']=='/update.php')
	{
		echo '1invalid Request';
		die();
	}

	

	/*
		check if the request is from ajax and its from my website or not and reout accordingly...
	*/

if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']=='http://buddychat.in/' && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest'){
	
	if ($_SERVER['REQUEST_URI']=='/sendmsg'){
		include_once("sendmsg.php");
		die();
	}
	else 	if ($_SERVER['REQUEST_URI']=='/disconnect'){
		include_once("disconnect.php");
		die();
	}
	else	if ($_SERVER['REQUEST_URI']=='/status'){
		include_once("status.php");
		die();
	}
	else	if ($_SERVER['REQUEST_URI']=='/suggestion'){
		include_once("suggestion.php");
		die();
	}
	else	if ($_SERVER['REQUEST_URI']=='/update'){
		include_once("update.php");
		die();
	}
	else{
		echo '2invalid Request';
		die();
	}
}
else{
	echo '3invalid Request';
	die();
}
	
?>
