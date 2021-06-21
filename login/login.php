<?php
	

	if( isset( $_POST['username'] ) ){
			$username = $_POST['username'];	
			if($username==""){
				header("location:loginui.php?error=empty+username");
				die();
			}

	}

	else{
			header("location:loginui.php?error=null+username");
			die();
	}



	if( isset($_POST['password']) ){
			$password = $_POST['password'];
			if ($password=="") {
				header("location:loginui.php?error=empty+password");
			}

	}


	include("../db.php");


		$userSelectSql = "select USERNAME,PASSWORD from users where USERNAME='$username' AND PASSWORD='$password' ";
		
		$userSelectResult = mysqli_query($db_con,$userSelectSql);

		if( !$userSelectResult ){
			echo "Error executing $userSelectSql <br>";
			die();
		}

		if( mysqli_num_rows($userSelectResult)==0 ){
			header("location:loginui.php?error=username+or+password+error");
			die();
		}

		$row = mysqli_fetch_assoc($userSelectResult);
		$dbUser = $row['USERNAME'];
		$cookieValue = rand(1000000000,9999999999)."";

		$date_created = date("Y-m-d");
		$userComputer = "?";

		$insertSessionSql="insert into session(value,user,date_created,device) values('$cookieValue','$dbUser','$date_created','Chrome,Desktop')";
		$insertSessionResult = mysqli_query($db_con,$insertSessionSql);
			if( !$insertSessionResult ){
				header("location:loginui.php?error=internal+error");
				die();
			} 
			
			else{
				 setcookie("lv",$cookieValue,time()+( 30*24*60*60 ),'/');
				 header("location:home.php");				
				}

?>