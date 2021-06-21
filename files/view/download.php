<?php
	
	include '../../sec.php';
	$fileID = $_GET['id'];

	$checkFile = "select * from files where ID='$fileID' AND ( OWNER='$user' OR ID=(select ID from share where ID='$fileID' AND SHARED_WITH='$user' ) ) ";
	$checkFileResult = mysqli_query($db_con,$checkFile);

	if (!$checkFileResult) {
		// echo "faild to execute $checkFile <br>";
	}
	

	if ( mysqli_num_rows($checkFileResult)==0 ) {
		echo "You dont have permition to file <br>";
		die();
	}

	$row = mysqli_fetch_assoc($checkFileResult);

	$absPath = $row['ABS_PATH'];
	$actualName = $row['ACTUAL_NAME'];
	$destinationPath = "";

	$randomName = rand(1000000000,9999999999).rand(1000000000,9999999999)."";

	$mkDirResult = mkdir( 'downloads/'.$randomName );

	if (!$mkDirResult) {
		echo "Internal Error $randomName <br>";
		die();
	}

	$destinationPath =  'downloads/'.$randomName.'/'.$actualName;
	$symlinkResult = symlink($absPath, $destinationPath);
		
		if ($symlinkResult) {
			header("location:".$destinationPath);
		}
		else{
			echo "Internal error, try again latter <br>";
		}
?>