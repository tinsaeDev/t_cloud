<?php
		
		// if user is not admin abort operation.
			
		include('../db.php');
				
		$accountToConfirm = $_GET['username'];

		
		$sql= "select * from pending_account where USERNAME='$accountToConfirm' ";		

		$res = mysqli_query($db_con,$sql);

				if(!$res){
					echo "Error while processing your request <br>";
					die();
				}




			   if(  mysqli_num_rows($res)==0 ){
			   		echo "<br> No such user <br> ";
			   		die();
			   }



		$row = mysqli_fetch_assoc($res);

		$username = $row['USERNAME'];
		$password= $row['PASSWORD'];
		$fname = $row['FISRT_NAME'];
		$mname = $row['FATHER_NAME'];
		$gname = $row['GRAND_FATHER_NAME'];

		$today = date('Y-m-d');


$insertComfirmSql = "insert into users(USERNAME,PASSWORD,FISRT_NAME,FATHER_NAME,GRAND_FATHER_NAME) values ( '$username','$password','$fname','$mname','$gname')";

		$insertComfirmResult = mysqli_query($db_con,$insertComfirmSql);
		if( $insertComfirmResult ){
			echo "<br>Account for <b> $fname $mname $gname </b> is activated<br>";
			mkdir( "/home/tcloud/uploaded_files/".$accountToConfirm ); //  create ba space for the new user // need validation
			echo "Folder created for the new user <br>";

		}else{
			echo "Error activating accout for  $fname $mname $gname <br>";
			die( mysqli_error($db_con) );
		}

$rootDirId = rand(1000000000,9999999999)."";




$createRootDirSql =  "INSERT INTO files(ID,OWNER,ABS_PATH,PARENT_PATH,ACTUAL_NAME,FILE_TYPE,FILE_SIZE,SHARED,SHAREd_LINK,date_created,deleted,isDir)
 VALUES ( '$rootDirId','$username','/home/tcloud/uploaded_files/$username/',NULL,'$username','root',0,false,NULL,'$today',false,false) ";



	$createRootDirResult = mysqli_query($db_con,$createRootDirSql);
			if(!$createRootDirResult){
				echo "Faild to execute $createRootDirSql<br>";
				die( mysqli_error($db_con) );
			} else{
				echo "Root directory created in DB <br>";
			}

$insertStorageInitialSql = "INSERT INTO storage(user,total,used) values('$username',2000000000,0) ";
$insertStorageInitialResult = mysqli_query($db_con,$insertStorageInitialSql);
if(!$insertStorageInitialResult ){
	echo "faild to create storage initial";
	die( mysqli_error($db_con) );
} else{
	echo "created storage";
}

		// removing the activated acccount from pending  accounts.

		$removePendingSql = "delete from pending_account where USERNAME='$accountToConfirm'";
		$removePendingResult =  mysqli_query($db_con,$removePendingSql);
			if($removePendingResult){
				echo "Removed pending Sql <br>";
			} else{
				echo "Faild to reme pending account <br>";
			}







?>