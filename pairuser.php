<?php


//	require_once('functions.php');

	require_once('db.php');

		$hash=uniqid("hash_");
		
		
		$res=mysql_query('insert into users values (\'\',null,now(),null,0,1,\''. $hash .'\')');

			//echo '<br/>'. 'insert into users values (\'\',null,now(),null,0,1,\''. $hash .'\')';
			if (mysql_affected_rows()==1){

				
				setcookie("hash",$hash,0,'/');

							
			}else{
				$hash='';
			}
		
	$status=array();
		
	if ($hash=='') {

	
		$status['sucess']=0;
		echo json_encode($status);
		die();
	}
	


	$time=time();


	if (!findpair($hash)){

		mysql_query('update users set iswaiting=1 where hash=\'' . $hash . '\'');	

		//echo '<br/>'.'update users set iswaiting=1 where hash=\'' . $hash . '\'';
		
		while((time() - $time) < 30) {	


			$res=mysql_query('select pairid,isconnected from users where hash=\'' . $hash . '\'');
				
				//echo '<br/>'. 'select pairid,isconnected from users where hash=\'' . $hash . '\'';		
			$buddy=mysql_fetch_assoc($res);
			
				if ($buddy['pairid']!=""){
				
					$status['sucess']=1;
					echo json_encode($status);
					die();
		
				}
				else{
						if (findpair($hash)){
							$status['sucess']=1;
							echo json_encode($status);
							die();
						}
				}
	
			usleep(1000000);
		}//while

	}else{
		$status['sucess']=1;
		echo json_encode($status);
		die();
	
	}

	

		mysql_query('update users set iswaiting=0 where hash=\'' . $hash . '\'');
		
		//echo '<br/>'. 'update users set iswaiting=0 where hash=\'' . $hash . '\'';
		
		$status['sucess']=0;
		echo json_encode($status);
		
		die();






function findpair($hash){


	$res = mysql_query('select id from users where iswaiting=1 and hash!=\'' . $hash . '\' order by rand() limit 1');

		//echo '<br/>'.'select id from users where iswaiting=1 and hash!=\'' . $hash . '\' order by rand() limit 1';

	if ($res && $buddy=mysql_fetch_assoc($res)){
	
			$res=mysql_query('insert into pair values(\'\',(select id from users where hash=\''. $hash .'\'),'. $buddy['id'].',now() )');
		
		//echo '<br/>'. 'insert into pair values(\'\',(select id from users where hash=\''. $hash .'\'),'. $buddy['id'].',now() )';
	
		if (mysql_affected_rows()==1){

			mysql_query('update users set pairid=' . mysql_insert_id() . ' ,iswaiting=0 where hash=\'' . $hash . '\' or id=' . $buddy['id']);

			//echo '<br/>'. 'update users set pairid=' . mysql_insert_id() . ' ,isconnected=1,iswaiting=0 where hash=\'' . $hash . '\' or id=' . $buddy['id'];
			return 1;
			
		}

	return 0;


	
	}
	
	
}

?>
