<?php

	session_write_close();

	require_once('db.php');
	
	//request by ajax.. stiore the message to the table
	
	$res=mysql_query('insert into msg values(\'\',(select pairid from users where hash=\''. $_COOKIE['hash'] .'\') ,(select id from users where hash=\''. $_COOKIE['hash'] .'\'),\''. $_POST['msg'] .'\',0,now())');

	
	if (mysql_affected_rows()==1){
		$status['status']=1;
		
	}
	else{
		$status['status']=0;
	}

	echo json_encode($status);
	die();
?>
