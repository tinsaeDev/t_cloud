<?php
		
		$accountTodelete = $_GET['user'];

		include ('../sec.php');
		if ($admin!=1) {
			echo "THis is allowed only for admins.";
		}

		// delete other foreign key related rows, on delete cascade, on update cascade
		// delete user foldeer recursively


		//rmdir( "/home/tcloud/uploaded_files/accountTodelete" );
		
		$newSql = "delete from users where USERNAME = '$accountTodelete'";

		echo "<br> executing ", $newSql ," <br>";

		$res = mysqli_query($db_con,$newSql);

		if( $res ){
				if ( mysqli_affected_rows($db_con)==0 ) {
					echo "Nothing happend <br>";	
				}
				else{
					echo "Specified Account deleted <br>";
				}
		}

		else {
			echo "<br>Account could not be deleted <br>";
			die( mysqli_error($db_con) );
		}

?>