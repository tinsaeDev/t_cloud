<?php
	
	require('../../sec.php');
		
		class Shared {}
		$phpObj = new Shared();

		$fileID = $_GET['id'];
		$iSharedSql = "select * from share where ID=(select ID from files where ID='$fileID' AND OWNER='$user' ) ";
		$iSharedResult = mysqli_query($db_con,$iSharedSql);

				if(!$iSharedResult){
					echo "error executing $iSharedSql <br>";

				} 

				else{

					if( mysqli_num_rows($iSharedResult)==0 ){
							$phpObj->shareStatus = false;
					} else{
						
						$phpObj->shareStatus = true;
						$phpObj->sharedwith = array();
						
						$c = 0;
						while($row=mysqli_fetch_assoc($iSharedResult)){

								$phpObj->sharedwith[$c] = $row['SHARED_WITH'];
								$c++;
						}

					}
				}
				$json = json_encode( $phpObj );
				echo $json;
?>