<?php
		
		$accountToDelete = $_GET['username'];
		// check if username is not nyll and not empty.

		include ("../db.php");

		$selectPendinAccountSql = "select * from pending_account where USERNAME='$accountToDelete'";
		$selectPendinAccountQueryResult = mysqli_query($db_con,$selectPendinAccountSql);
			if(!$selectPendinAccountQueryResult){
				//echo "error processing request <br>";
				die();
			} 

			if( mysqli_num_rows($selectPendinAccountQueryResult)==0 ){
				//echo "No such account! <br>";
				die();
			}


		$sql = "delete from pending_account where USERNAME='$accountToDelete'";

		echo "  executing :<br> ", $sql , "<br>";

		$deletePendingResult = mysqli_query($db_con,$sql);


		if($deletePendingResult){
				echo "The pending account : ",$accountToDelete," is deleted!<br>";
		}else{
		   		echo "unable to delete account! ";
			}

?>