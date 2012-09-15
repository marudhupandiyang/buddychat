

<?php




/*

	send the suggestion form to the user via javascript 

*/	require_once('db.php');
	
	if (isset($_POST['unme'])){

		mysql_query('insert into suggest values(\''. $_POST['unme'] .'\',\''. $_POST['umail'] .'\',\''. $_POST['suggest'] .'\')');
		
		die();

	}else{

	echo '	
	
showpopup(\'\
	<div class="popup_title"> Send your Suggestions </div>							\
	<input type="textbox" name="nme" size=35 placeholder="Enter your Name" class="nme">		<br/>\
	<input type="textbox" name="mail" size=35 placeholder="Enter your E-mail" class="mail">	<br/>\
	<textarea placeholder="Suggestions" cols=44 rows=5 style="resize:none;" class="suggest"></textarea>					<br/><br/>\
											\
	<input type="button" class="submit_popup" value="Send">		\
	<input type="button" onclick="javascript:hidepopup();" value="Close" style="margin-right:1em;" class="rfloat">			\
\');

	$(".submit_popup").click(function(){
	
		var popup_submit=$.ajax({
		  url: "/suggestion.php",
		  type: "POST",
		  data:{unme:$(".nme").val(), umail:$(".mail").val(),suggest:$(".suggest").val()}
	  
		});
		
		popup_submit.done(function(data){
			hidepopup();
		  	showpopup("Thank you for your Suggestion");
		  	setTimeout(hidepopup,1000);
		  	
		});
	
	});
	';


	}

?>

