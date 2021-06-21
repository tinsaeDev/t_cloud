<?php
		
		$accountTodelete = $_GET['user'];

		include ('../db.php');

		// delete other foreign key related rows
		// delete user foldeer recursively
		echo "sdsdasd<dgdjashdvc";

		$newSql = "delete from active where user= '$accountTodelete'";

		echo "<br> executing ", $newSql ," <br>";

		$res = mysqli_query($db_con,$newSql);

		if( $res ){
			echo "<br>Account is deleted <br>";
		}else{
			echo "<br>Account could not be deleted <br>";
			die( mysql_error($db_con) );
		}

?>