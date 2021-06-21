<?php
	
	require('../../sec.php');
	

		class Shared {}
		$phpObj = new Shared();
		$phpObj->files = array();

		$iSharedSql = "select * from files as f, share as s where f.ID=s.ID AND s.SHARED_WITH='$user' ";
		$iSharedResult = mysqli_query($db_con,$iSharedSql);

				if(!$iSharedResult){
					 echo "error executing $iSharedSql <br>";
					 die();
				} 

				else{

					if( mysqli_num_rows($iSharedResult)==0 ){
						echo "Empty <br>";
						die();
					
					}

					else{

						$c = 0;
						while($row=mysqli_fetch_assoc($iSharedResult)){


									$file = new Stdclass();


									$file->id = $row['ID'];
									$file->absPath = $row['ABS_PATH'];
									$file->name = $row['ACTUAL_NAME'];
									$file->filetype = $row['FILE_TYPE'];
									$file->fileSize = $row['FILE_SIZE'];
									$file->isShared = $row['SHARED'];
									$file->dateCreated = $row['date_created'];
									$file->isDir = $row['isDir'];
									$phpObj->files[$c] = $file;
									$c++;
						}

					}
				}

				$json = json_encode( $phpObj );
				echo $json;
?>