<?php
	
	include ('../db.php');

	// check the parameters are not empty.
	if (  !isset( $_POST['fname'] ) ||  !isset( $_POST['mname'] ) ||  !isset( $_POST['gname'] )||  !isset( $_POST['username'] )||  !isset( $_POST['password'] )  ){
				header("location:signup.php?error=Null+values+recieved");
				die();
	}

	$fname=$_POST['fname'];
	$mname=$_POST['mname'];
	$gname=$_POST['gname'];

	$user=$_POST['username'];
	$pwd=$_POST['password'];


	// check if the values are not empty.
	if( $fname=="" ||   $mname=="" ||   $gname=="" ||   $user=="" ||   $fname=="" ||   $pwd=="" ){
				header("location:signup.php?error=Empty+values+recieved");
				die();
	}


$registerSQL = "insert into pending_account(USERNAME,PASSWORD,FISRT_NAME,FATHER_NAME,GRAND_FATHER_NAME) values ( '$user','$pwd','$fname','$mname','$gname')";
	echo "about to execute <br>".$registerSQL."<br>";
	
	$res = mysqli_query($db_con,$registerSQL);

	if( $res ){
			if( mysqli_affected_rows($db_con)!=0 ){
				header("location:registered.php");
			}	

			else{
				header("location:signup.php?error=Unknown+error+occured");
				die();
			}
		}
?>
