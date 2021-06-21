<?php
	
	require('../../sec.php');


	$selectTrashedFilesSql = " select ABS_PATH from files where OWNER='$user' AND deleted=1";
	$selectTrashedFilesResult = mysqli_query($db_con,$selectTrashedFilesSql);

		if ( !$selectTrashedFilesResult ) {
		//		echo "Faild to execute $selectTrashedFilesSql <br> ";
			die();
			}

		while ( $row = mysqli_fetch_assoc( $selectTrashedFilesResult ) ) {
				unlink( $row['ABS_PATH'] );
		}

	// echo "All files deleted from fs. <br>";

	$trashFileSql = "delete from files where deleted=1 AND OWNER='$user' ";
	$trashFileResult = mysqli_query($db_con,$trashFileSql);
		
		if(!$trashFileResult ){
		//	echo "faild to execute $trashFileSql <br>";
			die();
		} 

		//echo "all files deleted from db <br>";
		echo "1";

?>