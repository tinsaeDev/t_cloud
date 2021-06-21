<?php
	
	require('../login/sec.php');
	
	if( isset($user) ){
		echo "\$user variable is set <br> ";
	}else{
		echo "\$user variable is not set <br>";
		die();
	}

	$db_con = mysqli_connect("localhost","root","");
	if( $db_con ){
		echo "database connected <br> ";
	} else {
		echo "faild to connect datase <br>";
		die();
	}


	$db_con = mysqli_connect("localhost","root","");
		if( !$db_con ){
			echo "Not connected <br> ";
		} else{
			echo "connected <br>";
			$dbSelect = mysqli_query($db_con,"use toto");
				if ($dbSelect) {
					echo "database selected <br>";
				} else{
					echo "faild to select database <br>";
				}
		}



		$theySharedSql = "select * from share as s,files as f where SHARED_WITH='$user' AND f.ID=s.ID";
		$theySharedResult = mysqli_query($db_con,$theySharedSql);

				if(!$theySharedResult){
					echo "error executing $theySharedSql <br>";
				} 

				else{

					if( mysqli_num_rows($theySharedResult)==0 ){

						echo "Nothing is shared with you yet! <br>";

					} else{

						while($row=mysqli_fetch_assoc($theySharedResult)){

								$name = $row['ACTUAL_NAME'];
								$owner =  $row['OWNER'];
								$abspath =  $row['ABS_PATH'];
								$date = $row['DATE_SHARED'];
								
								echo " <b>Name</b>: $name <br>";
								echo " <b>Owner</b>: $owner <br>";
								echo " <b>Server Path</b>: $abspath<br>";
								echo " <b>Date Shared With you</b>: $date<br>";
								echo " <hr width='400px'>";
						}

					}
				}
?>