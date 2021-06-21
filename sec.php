<?php







include("db.php");

$user;
$admin;
$loginValue;

	if( isset( $_COOKIE['lv'] ) ){
		$loginValue = $_COOKIE['lv'];

	$selectUserSql = "select * from session,users where value='$loginValue' AND user=USERNAME";
	$selectUserResult = mysqli_query($db_con,$selectUserSql);

			if(!$selectUserResult){ // if query string is invalid
				echo "Faild to execute query <br>";
				die();
			} else{ 

				if( mysqli_num_rows($selectUserResult)==0 ){ // if no user found for that value
				} else{ // user is ok get it
					$row = mysqli_fetch_assoc($selectUserResult);
					$user  = $row['user'];
					$admin = $row['ADMIN'];
				}
		}

	}




	else{
		// echo "parameter not passed <br>";
	}


	
?>