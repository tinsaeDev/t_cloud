
<?php


// check for null and empty parameters
		
		if ( !isset( $_FILES['file'] )  || !isset($_POST['parentID'])) {
			echo "Null parameters <br>";
			die();
		}

// include database and session manager

	require("../../sec.php");
	
	$uploadedFile = $_FILES['file'];
	$parentID = $_POST['parentID'];

	//echo "directory id name :" . $parentID ."<br>";


	$uploadedFileName = $uploadedFile['name'];
	//echo "uploaded file name :" . $uploadedFileName ."<br>";

	$uploadedFileTempName = $uploadedFile['tmp_name'];
	//echo "uploadedFileTempName : $uploadedFileTempName<br>";
	//die();
	
	
	/*
	 * check if user available storage space is not full 
	 * 
	 */
	
		$storageQuerySql = "select * from storage where user='$user'";
		$storageQueryResult = mysqli_query($db_con,$storageQuerySql);
			if( !$storageQueryResult ){
				echo "unable to run $storageQuerySql";
				die( mysql_error($db_con) );
			}	
				$storageRow =  mysqli_fetch_assoc( $storageQueryResult );
				$totalSpace = $storageRow["total"];
				$usedSpace =  $storageRow["used"];
				$uploadingFileSize = $uploadedFile["size"];
				$usedSpace= $usedSpace+($uploadingFileSize);

				if( $usedSpace>$totalSpace ){
					echo "Your quota is full <br>";
					die();
				} else{

					$updateStorageSpaceSql = "UPDATE storage set used=$usedSpace where user='$user' ";
					$updateStorageSpaceResult = mysqli_query($db_con,$updateStorageSpaceSql);

						if(! $updateStorageSpaceResult){
							echo "faild to update storage space  $updateStorageSpaceSql <br>";
							die();
						}

				}

		/*
		
		*/

	// check if destination folder exist.
	$checkParentExistenceSql = "select * from files where ID='$parentID' AND OWNER='$user' ";
	$checkParentExistenceResult = mysqli_query($db_con,$checkParentExistenceSql);
		if (!$checkParentExistenceResult) {
			echo "Faild to execute $checkParentExistenceSql <br> ";
			die();
		}

		if ( mysqli_num_rows($checkParentExistenceResult)==0) {
			echo "Specified parent not found. <br>";
			die();
		}


// check if file already exist in specified dir

	
	$checkFileAlreadyExistSql = "select * from files where  ACTUAL_NAME='$uploadedFileName' AND PARENT_PATH='$parentID' AND OWNER='$user' ";
	$checkFileAlreadyExistResult = mysqli_query($db_con,$checkFileAlreadyExistSql);

		if (!$checkFileAlreadyExistResult) {
			echo "faild to execute $checkFileAlreadyExistSql <br> ";
			die();
		}

		if ( mysqli_num_rows( $checkFileAlreadyExistResult )!=0 ) {
			echo "File already exist <br>";
			die();
		}

		
// move file to parent folder

		// get abs path of parent

		$getParentAbsPathSql = "select ABS_PATH from files where ID='$parentID' AND OWNER='$user' ";
		$getParentAbsPathResult = mysqli_query( $db_con, $getParentAbsPathSql );

			if ( !$getParentAbsPathResult ) {
				echo "faild ro execute $getParentAbsPathSql <br>";
				die();
			}

			$getParentAbsPathRow = mysqli_fetch_assoc( $getParentAbsPathResult );
			
			$parentAbsPath = $getParentAbsPathRow['ABS_PATH'];
			$fileDestinationAbsPath = $parentAbsPath.$uploadedFileName;
		
			// move by > abspath of parent + name t

			$moveFile = move_uploaded_file( $uploadedFileTempName , $fileDestinationAbsPath);
			//echo "moving from $uploadedFileTempName to $fileDestinationAbsPath <br>";

			if (!$moveFile) {
				echo "Fail to move uploaded file: $moveFile :. <br>";
				die();
			}

		// insert to database
		$fileID = rand(1000000000,9999999999)."";	
		$parentID=$parentID;							
		$today = date('Y-m-d');
		$fileType = mime_content_type($fileDestinationAbsPath);
		$fileSize = $uploadedFile ['size'];
		
			$insertToDbSql =  "INSERT INTO files(ID,OWNER,ABS_PATH,PARENT_PATH,ACTUAL_NAME,FILE_TYPE,FILE_SIZE,SHARED,SHAREd_LINK,date_created,deleted,isDir) VALUES ( '$fileID','$user','$fileDestinationAbsPath','$parentID','$uploadedFileName','$fileType',$fileSize,false,NULL,'$today',false,false) ";

			$insertToDbResult = mysqli_query($db_con,$insertToDbSql);

			if ( !$insertToDbResult ) {
				echo "faild to execute $insertToDbSql <br>";
			}

			if ( mysqli_affected_rows( $db_con )==0 ) {
				echo "nothing new is inserted <br>";
				die();
			}
			echo "1";
	die();
?>