<?php


/*
	functions grouped in a single file..

*/


//disconnect form client

function disconnect(){


		//update the user table 
			mysql_query('update users set pairid=null ,isconnected=1,iswaiting=0 where id=' . $_SESSION['id'] . ' or id=' . $_SESSION['buddy']) ;

			unset($_SESSION['pairid']);
			unset($_SESSION['buddy']);
			
			$status['sucess']=2;
			echo json_encode($status);



}

/*

	function: findpair
	Parameters: none
	
	Description:
		find if any user is waitin..
		
		if found call the pair user
		
		if not set i'm waiting 
	

*/

function findpair(){


	$res = mysql_query('select id from users where iswaiting=1 and id!=' . $_SESSION['id'] . ' order by rand() limit 1');


	
	if ($res && $buddy=mysql_fetch_assoc($res)){
	
		$buddy=$buddy['id'];

		return pairme($buddy);

	
	}
	
	
}

/*

	function: pairme
	Parameters: none
	
	Description:
		
		set the pair to the tablesand update all tables
		

*/


function pairme($buddy){
	
			$res=mysql_query('insert into pair values(\'\','. $_SESSION['id'] .','. $buddy.',now() )');
		
	
		if (mysql_affected_rows()==1){

			$_SESSION['pairid']=mysql_insert_id();
			$_SESSION['buddy']=$buddy;
			
			mysql_query('update users set pairid=' . $_SESSION['pairid'] . ' ,isconnected=1 where id=' . $_SESSION['id']);
			mysql_query('update users set pairid=' . $_SESSION['pairid'] . ' ,isconnected=1 where id=' . $_SESSION['buddy']);
			
			return 1;
			
		}

	return 0;
}


/*

	function: updateme
	Parameters: none
	
	Description:

		check if its my first time..
		
		if so create a new entr in table  by createing the rows
		if not  update the exsiting one ..

*/


function updateme(){

	if ( ( isset($_POST['first_time']) && $_POST['first_time']==1 ) &&  !isset($_COOKIE['hash'])){
	
		$hash=uniqid("hash_");
		
		$res=mysql_query('insert into users values (\'\',null,now(),null,0,0,'. $hash .')');

		if (mysql_affected_rows()==1){

			setcookie("hash",$hash,0,'/');
			unset($_SESSION['pairid']);
			unset($_SESSION['buddy']);
			
		}
	}//set session id
	else {

		mysql_query('update users set dt=now(),iswaiting=0 where hash=' . $_COOKIE['hash']);
	}



}
?>
