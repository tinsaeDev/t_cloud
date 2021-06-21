<?php
		
	include("../../sec.php");

	$json = $_GET['json'];
	$obj = json_decode($json);




	$fileId = $obj->fileId;
	$status = $obj->status;

	$removed = $obj->removed;
	$removedSize = $obj->removedSize;
	
	$newlyAdded = $obj->newlyAdded;
	$newlyAddedSize = $obj->newlyAddedSize;

	if ( !$status ) { // sharing is turned off on the file.
		
		// turn off file sharing

			$turnOffSharingSql = "update files set SHARED =0 where ID='$fileId' AND OWNER='$user' ";
			$turnOffSharingResult = mysqli_query($db_con,$turnOffSharingSql);

				if (!$turnOffSharingResult) {
						// echo "faild to execute $turnOffSharingSql <br>";
						die();
				}
	

		// delete all associated users, relation.
			$deleteSharedPeopleSql = "delete from share where ID='$fileId'  AND ID=(select ID from files where OWNER='$user' AND ID='$fileId' ) ";
			$deleteSharedPeopleResult = mysqli_query($db_con,$deleteSharedPeopleSql);

				if (!$deleteSharedPeopleResult) {
					// echo "Faild to excute $deleteSharedPeopleSql <br>";
					die();
				}

				echo "1";
	} 

	else{ // sharing is turned on the file.

		// turn on file sharing.
		
		 $turnOnSharingSql = "update files set SHARED=1 where ID='$fileId' AND OWNER='$user' ";
		 $turnOnSharingResult = mysqli_query($db_con,$turnOnSharingSql);

		 	if (!$turnOnSharingResult ) {
		 		// echo "faild to execute $turnOnSharingResult <br>";
		 	}

		addPeople( $newlyAddedSize,$newlyAdded,$fileId,$user,$db_con );
		removePeople($removedSize,$removed,$fileId,$user,$db_con );
		
		echo "1";

	}

	function addPeople($size,$people,$fid,$username,$db_con){

			$today = date('Y-m-d');
			for ($i=0; $i < $size ; $i++) { 
				$curUser = $people[ $i ];
				$addPeopleSql = "insert into share(ID, SHARED_WITH, DATE_SHARED) values( '$fid' , '$curUser' , '$today' ) ";
				$addPeopleResult = mysqli_query($db_con,$addPeopleSql);
					if (!$addPeopleSql) {
						// echo "faild to execute  $addPeopleSql <br>";
					}
			}	

	}

	function removePeople($size,$people,$fid,$username,$db_con){
				
			for ($i=0; $i < $size ; $i++) { 
				$curUser = $people[$i];
				$removePeopleSql = " DELETE FROM share WHERE ID='$fid' AND ID=(select ID from files where OWNER='$username' AND ID='$fid' ) AND SHARED_WITH='$curUser' "; 
				$removePeopleResult =  mysqli_query($db_con,$removePeopleSql);

					if (!$removePeopleResult) {
						// echo "faild to execute  $removePeopleSql <br>";
					}
			}

	}


?>