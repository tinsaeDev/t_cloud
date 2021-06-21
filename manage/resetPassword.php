<?php
	
	include ( "../sec.php" );

	if( $admin!=1 ){
		echo "This is intended only for administrators <br>";
		die();
	}
	else{
		echo "You are admin you can do what ever you want <br>";
	}


	//check if not null 

		if( !isset( $_GET['username'] ) || !isset($_GET['password1'])  || !isset($_GET['password2']) ){

			echo "All parameters should be passed <br>";
			die();

		} 

		$username = $_GET['username'];
		$password1 = $_GET['password1'];
		$password2 = $_GET['password2'];


	// check if empty

		if( $username=="" ||  $password1=="" ||  $password2=="" ){
			echo "A parameter is not supposed to be empty <br>";
			die();
		}

	// check if password marches

		if( !($password1==$password2) ){
			echo "passwords do not match <br>";
			die();
		}
	// check if password is lessthan 6 character.

		if(  strlen( $password1 ) < 6 ){
			echo "password should be at least 6 characters long <br>";
			die();
		}
 
		// All verifications are done, 



		// check if username exist

			$checkUsenameSQl  = "select * from users where USERNAME='$username'";
				echo "executing $checkUsenameSQl <br>";
			$checkUsenameResult = mysqli_query($db_con,$checkUsenameSQl);

				if( $checkUsenameResult ){
					if( mysqli_num_rows($checkUsenameResult)!=0){
							// update password for the user.	

							$updatePasswordSql = "update users set PASSWORD='$password1' where USERNAME='$username'";
							echo "executing $updatePasswordSql <br>";
								$updatePasswordResult = mysqli_query($db_con,$updatePasswordSql);
									if($updatePasswordResult){
										echo "password seems reseted <br>";
									} 

									else{
										echo "error updating password <br>";
									}
								}
					else{
						echo "No user <br>";
					}
				}
				 else{

					echo "Error executing query! <br>";
					die( mysqli_error( $db_con ) );
				 }




		// finish.

?>