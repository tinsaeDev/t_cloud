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



		$imageSql = "select * from files where OWNER='$user' AND FILE_TYPE ='image' ";
		// selection may include shared files


		$imageResult = mysqli_query($db_con,$imageSql);

				if(!$imageResult){
					echo "error executing $imageSql <br>";
				} 

				else{

					if( mysqli_num_rows($imageResult)==0 ){

						echo "no image files found yet! <br>";

					} else{

						while($row=mysqli_fetch_assoc($imageResult)){

								$name = $row['ACTUAL_NAME'];
								$owner =  $row['OWNER'];
								$abspath =  $row['ABS_PATH'];
								$type = $row['FILE_TYPE'];
								
								echo " <b>Name</b>: $name <br>";
								echo " <b>Owner</b>: $owner <br>";
								echo " <b>Server Path</b>: $abspath<br>";
								echo " <b>type</b>: $type<br>";

								echo " <hr width='400px'>";
						}

					}
				}
?>