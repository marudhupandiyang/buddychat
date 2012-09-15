<?php


//$mysqli = new mysqli('localhost', 'root', 'root', 'emarket');


//echo $mysqli->connect_error;


/*
	server  connection details..
*/

//$con = mysql_pconnect('localhost','buddyc_buddychat','buddychat0123') or die('Error in DB..! Contact Administrator<br/>' . mysql_error());


//mysql_selectdb('buddyc_buddychat') or die('db open');


/*
	server  connection details..
	for localhost
*/

$con = mysql_pconnect('127.0.0.1','root','root') or die('Error in DB..! Contact Administrator<br/>' . mysql_error());

mysql_selectdb('buddychat_new') or die('db open');



?>
