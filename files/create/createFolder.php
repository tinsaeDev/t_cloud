<?php

// check for null and empty parameters
if ( !isset( $_GET['parentID'] ) || !isset($_GET['name'])) {
	echo "Null parametet <br>";
	die();
}
 
if(  $_GET['name'] =="" || $_GET['parentID']==""){
	echo "Empty value detected.<br>";
	die();
}

	
// include database and session manager
require('../../sec.php');	


 // declare folder structure
 
$parentID = $_GET['parentID'];
$folderToCreate = $_GET['name'].'/';
$parentAbsPath = "";
	
	// Used to get the absolute path of parent from its ID. 
	$selectParentAbsPathSql = "select ABS_PATH from files where ID='$parentID' AND OWNER='$user' ";
	$selectParentAbsPathResult = mysqli_query($db_con,$selectParentAbsPathSql);
		if ($selectParentAbsPathResult) {
				if( mysqli_num_rows($selectParentAbsPathResult)!=0 ){
						$row = mysqli_fetch_assoc( $selectParentAbsPathResult );
						$parentAbsPath = $row['ABS_PATH'];

				}	else{
						//echo "No matching parent <br>";
						echo "0";
						die();
				}
		}
		else{
			//echo "Faild to execute $selectParentAbsPathSql <br>";
			echo "0";
			die( mysqli_error($db_con) );
		}



// abs path of parent = select ab spath fro fril s where id = arg.
// folder abspath = abspath of parent  + name of parent.
$folderAbsPath = $parentAbsPath.$folderToCreate;

		// ckeck if parent do exist else abort.
		$checkPaparentIfExistSql = " select * from files where ABS_PATH='$parentAbsPath' ";
		$checkPaparentIfExistResult = mysqli_query($db_con,$checkPaparentIfExistSql);
			if ($checkPaparentIfExistResult) {
					if( mysqli_num_rows( $checkPaparentIfExistResult )==0){
						//echo "parent $parentAbsPath do not exist <br>";
						//echo "after quering $ $checkPaparentIfExistSql ";
						die(); // abort

					} else{
						//echo "Parent folder existed : OK <br>";
						//ok
					}

			} else{
					//echo "error processing query : $checkPaparentIfExistSql <br>";
			}		



		// check if fneeded folder do not exist before, if exist abort.
		$checkIfExistSql = " select * from files where ABS_PATH='$folderAbsPath' ";
		$checkIfExistResult = mysqli_query($db_con,$checkIfExistSql);
			if ($checkIfExistResult) {
					if( mysqli_num_rows( $checkIfExistResult )==0){
						//echo "SPecified folder name do not exist : OK <br>";
					} else{
						//echo "folder already exist : Fail<br>";
						die(); // abort
					}

			} else{
					//echo "error processing query : $checkIfExistSql <br>";
					die();
			}	


				// make the physical folder.

				$createDir =  mkdir($folderAbsPath);
							if($createDir){
								//echo "Folder created <br>";
							} 
							else{
								//echo "Folder did not created due to FS : $folderAbsPath <br>" ;
								die();
							}

				// create attributes that are about to be inserted to db.
				$fileId = rand(1000000000,9999999999)."";
				$parentId;
					$selectParentSql = "select * from files where ABS_PATH='$parentAbsPath' ";

							$selectParentResult = mysqli_query($db_con,$selectParentSql);
							if( $selectParentResult ){
								$row = mysqli_fetch_assoc($selectParentResult);
								$parentId = $row['ID'];
								//echo "Got parent ID : OK  <br> ";

							}else{
								//echo "faild getting parent id : fail <br>";
								echo "0";
								die();
							}
				$today = date('Y-m-d');


				// insert the data to db.
				$insertNewFolderSql =  "INSERT INTO files(ID,OWNER,ABS_PATH,PARENT_PATH,ACTUAL_NAME,FILE_TYPE,FILE_SIZE,SHARED,SHAREd_LINK,date_created,deleted,isDir) VALUES ('$fileId','$user','$folderAbsPath','$parentId','$folderToCreate','folder',0,false,NULL,'$today',false,true)";

				 $insertNewFolderResult = mysqli_query($db_con,$insertNewFolderSql);
						 	if($insertNewFolderResult){
						 		if( mysqli_affected_rows($db_con)==0 ){
						 			//echo "Nothing is inserted <br>";
						 			echo "0";
						 		} else{
						 			// make folder here
						 			//echo "Data folder inserted to database <br>";
						 			echo "1";
						 		}
						 	 } else {
						 			//echo "Faild to execute $sql ";
									echo "0";
						 	 }
?>