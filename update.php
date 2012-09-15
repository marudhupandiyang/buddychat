<?php

	
	/*
		update the count to the user...
	*/
	
	require_once('db.php');
	
	$status= array();


	$res=mysql_query('select count(*)  as cnt from users where timestampdiff(SECOND,dt,now()) < 20');

	$res=mysql_fetch_assoc($res);
	
	$status['count']=$res['cnt'];
	

	echo json_encode($status);
	die();



?>
