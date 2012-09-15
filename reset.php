
<?php


	require_once('db.php');

	mysql_query('update users set pairid=null ,isconnected=0 where id=' . $_SESSION['id']);
	mysql_query('update users set pairid=null,isconnected=0  where id=' . $_SESSION['buddy']);

	session_destroy();	
	
	
	?>
