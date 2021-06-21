<?php
	
	require('../../sec.php');

	$fileId="";
	if ( !isset($_GET['id']) ) {
		echo "Null parameter <br>";
		die();
	}

	$fileId = $_GET['id'];	
	$trashFileSql = "update files set deleted=0 where OWNER='$user' AND ID='$fileId' ";
	$trashFileResult = mysqli_query($db_con,$trashFileSql);
		
		if(!$trashFileResult ){

			echo "faild to execute $trashFileSql <br>";
			die();
		} 

		if ( mysqli_affected_rows($db_con)==0 ) {
			echo "Nothing happend <br>";
			die();
		}
		echo "1";

?>