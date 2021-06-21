<?php
	include ('../sec.php');
	// if user is not admin kill and redirect to tell user,
	
	if( isset($admin) ) {
		if ($admin) {
			
		} else{

			header("location:../login/home.php");
			die();	
		}

	} 

	else{
		header("location:../login/home.php");
		die();
	}

    $data = $_POST["data"];

    $obj = json_decode($data);

    $username = $obj->username;
    $storageSize = $obj->storage;
    
    $updateStorageSql = "update storage set total=$storageSize where user='$username'";
    
    if( $query = mysqli_query($db_con,$updateStorageSql) ){
        echo 1;
    } else{
        echo -1;
        echo $updateStorageSql;
        die( mysqli_error($db_con) );
    }
?>