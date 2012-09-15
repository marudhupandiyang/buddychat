<?php


	/*
	
		sendd the status to the user
		
		
		LONG POLLING...
		
		long polling by making the request wait for prescrbied time and checking for changes from the server
		constatntly
		
		get message or status in the waiting time..
		
	*/

	ignore_user_abort(false);

	require_once('db.php');
	

	
	$time = time();
		
	while(( (time() - $time) < 20 ) && !connection_aborted() ) {
				
				online_status();
				
				get_msg();
				
				usleep(2000000);
	}
	
	$status=array();
	$status['status']=1;
	
	echo json_encode($status);
	die();


function online_status(){

		

		$res=mysql_query('select a.pairid,time_to_sec(timediff(now(),c.dt)) as sec from users a,pair b,users c where a.hash=\'' . $_COOKIE['hash'] . '\' and a.pairid=b.pairid and (c.id=b.buddy1 or c.id=b.buddy2) and c.id!=a.id');
	
//		echo 'select a.pairid,time_to_sec(timediff(now(),c.dt)) as sec from users a,pair b,users c where a.hash=\'' . $_COOKIE['hash'] . '\' and a.pairid=b.pairid and (c.id=b.buddy1 or c.id=b.buddy2) and c.id!=a.id';

		$me=mysql_fetch_assoc($res);
		

		if ($me['sec']>5){
			$status =array();
			$status['status']=3;
			echo json_encode($status);
			die();
		}

		mysql_query('update users set dt=now() where hash=\'' . $_COOKIE['hash']. '\'');

//		free($res);
//		free($me);
		
		return true;

}



function get_msg(){

			$res = mysql_query('select msg,msgid from msg where pairid=(select pairid from users where hash=\''. $_COOKIE['hash'] .'\') and buddyid !=(select id from users where hash=\''. $_COOKIE['hash'] .'\') and view=0 order by msgid asc');

			if ($res && mysql_num_rows($res)>0){

				$msgid=0;
				
				$status_msg=array();
				
				while( $msg= mysql_fetch_assoc($res)){
					$status_msg['msg']=$msg['msg'];
					$msgid=$msg['msgid'];
				}
				
				
				mysql_query('update msg set view=1 where msgid<='. $msgid);
				
				echo json_encode($status_msg);
				die();
				
			}

return false;
}

?>
