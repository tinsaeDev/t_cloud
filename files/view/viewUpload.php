<?php

	require('../../sec.php');
	
	if (!isset($_GET['parent'])) {
		$dirID="";	
	}
	else{
		$dirID = $_GET['parent'];
	}


	// if id of parent directory is not provided ( root folder is selected).
	if( $dirID=="" ){
		$selectRootSql = "select * from files where OWNER='$user' AND PARENT_PATH IS NULL";
		$selectRootResult = mysqli_query($db_con,$selectRootSql);
		if ($selectRootResult) {
			// echo "exected $selectRootSql <br> <br> <br>";
			$rootRow = mysqli_fetch_assoc($selectRootResult);
			$dirID = $rootRow['ID'];
			// echo "ID of parent dir is $dirID<br>  <br>  <br> ";
		} else{
			// echo "unable to execute $selectRootSql <br>  <br> ";
			echo '{ "parentDir":"null","file":[] }';
			die();
		}

	}

	// if the id of parent directory is provided
	
	$selectFilesSql = "select * from files where OWNER='$user' AND PARENT_PATH='$dirID' AND deleted=0 ";

	//echo "executing : $selectFilesSql <br>";
	
	$parentDir; // holds the id of the parent of the selected folder. 
	$selectFilesResult = mysqli_query($db_con,$selectFilesSql);
			
			if(!$selectFilesResult){
				// echo "faild to execute :  $selectFilesSql <br> ";
				echo '{ "parentDir":"null","file":[] }';
				die();
			}

			if( mysqli_num_rows($selectFilesResult)==0 ){
				//echo "No files yet! <br>";
				//echo "after executing $selectFilesSql <br>";
			}


				// select the parent of selected folder

				$selectParentIDSQL = "select ABS_PATH,PARENT_PATH from files where ID='$dirID' ";
				$selectParentIDResult = mysqli_query($db_con,$selectParentIDSQL);
					if($selectParentIDResult){
						//echo "executed $selectParentIDSQL<br>";
						$parentRow = mysqli_fetch_assoc($selectParentIDResult);
						$parentDir = $parentRow['PARENT_PATH'];
						$currenrDirAbsPath = $parentRow['ABS_PATH'];
					}
					else{
						// echo "faild to execute $selectParentIDSQL <br>";
					}


			//	echo "Some files found <br>";
				
				class files{}

				$fetchedFile = new files();
				$fetchedFile->file = array();
				$fetchedFile->parentDir = $parentDir;
				$fetchedFile->currentDir = $dirID;
				$fetchedFile->folderPath = $currenrDirAbsPath;
				$fetchedFile->user = $user;
							
							// add user total space and used space
							$storageSql = "SELECT * from storage where user='$user' ";
							$storageResult = mysqli_query($db_con,$storageSql);
								if (!$storageResult) {
									echo "faild to execute $storageSql<br>";
								}
							$storageRow = mysqli_fetch_assoc($storageResult);
				
							$fetchedFile->totalSpace = $storageRow["total"];
							$fetchedFile->usedSpace = $storageRow["used"];


				$counter = 0;
				while( $row = mysqli_fetch_assoc($selectFilesResult) ){
						$f = new files();
						
						$f->id = $row['ID'];
						$f->absPath = $row['ABS_PATH'];
						$f->name = $row['ACTUAL_NAME'];
						$f->filetype = $row['FILE_TYPE'];
						$f->fileSize = $row['FILE_SIZE'];
						$f->isShared = $row['SHARED'];
						$f->dateCreated = $row['date_created'];
						$f->isDir = $row['isDir'];
						$fetchedFile->file[$counter] = $f;
						$counter++;
				}

				$json = json_encode($fetchedFile);
				echo $json;

			?>

