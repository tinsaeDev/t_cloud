<?php
	
	require('../../sec.php');	
	$fileId = $_GET['id'];
 

	// check if file exist.
		$checkFileExistenceSql = "select * from files where OWNER='$user' AND ID='$fileId' ";
		$checkFileExistenceResult = mysqli_query($db_con,$checkFileExistenceSql);
			if( !$checkFileExistenceResult ){
				//echo "Faild to execute $checkFileExistenceSql <br>";
				die();
			}

			if ( mysqli_num_rows($checkFileExistenceResult)==0 ) {
				//echo "Not found <br>";
				die();
			}


			$row = mysqli_fetch_assoc( $checkFileExistenceResult );
			$fileAbsPath = $row['ABS_PATH'];
			$isDir = $row['isDir'];

			if (!$isDir) {
				$deletedFs = unlink($fileAbsPath);
				if (!$deletedFs) {
					//echo "file could not be deleted from fs <br>";
					die();
				}

			} else{

				 $rmdirFs =  delete_directory( $fileAbsPath);
				 if (!$rmdirFs) {
				 	//echo "could not remove directory <br>";
				 	die();
				 }
			}
			
			// remove from database

			$removeFileSql = "delete from files where ID='$fileId' ";
			$removeFileResult = mysqli_query($db_con,$removeFileSql);
				if (!$removeFileResult) {
					//echo "failf to remove from db <br>";
				}

				echo "1";

				die();

		// update storage usage


				// A third party API to recursively remove directory.
				// https://paulund.co.uk/php-delete-directory-and-files-in-directory

				function delete_directory($dirname) {
				         if (is_dir($dirname))
				           $dir_handle = opendir($dirname);
				    	
				    	 if (!$dir_handle)
				          return false;
				    	
				    	 while($file = readdir($dir_handle)) {
				           if ($file != "." && $file != "..") {
				                if (!is_dir($dirname."/".$file))
				                     unlink($dirname."/".$file);
				                else
				                     delete_directory($dirname.'/'.$file);
				           }
				     }
				     closedir($dir_handle);
				     rmdir($dirname);
				     return true;
				 }
?>