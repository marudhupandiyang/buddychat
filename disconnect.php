<?php

	/*
	
		disconnect the user by updating the usert table and setting the time to back..
	*/

	require_once('db.php');

	@mysql_query('update users set dt=\'1-1-1990 00:00:00\' where hash=\''. $_COOKIE['hash'].'\'');
	
	$status=array();
	$status['sucess']=1;
	echo json_encode($status);
	
?>

