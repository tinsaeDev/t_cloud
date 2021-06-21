<?php
		
	$json_file = fopen("/home/tcloud/installinfo.json", "r" );
	$json = fread($json_file, filesize("/home/tcloud/installinfo.json") );
	$phpObj = json_decode($json);

	$dbserver = $phpObj->dbserver;
	$dbport = $phpObj->port;
	$dbusername = $phpObj->dbusername;
	$dbpassword = $phpObj->dbpassword;

 	$dbname = $phpObj->dbname;

	$db_con = mysqli_connect($dbserver.':'.$dbport,$dbusername,$dbpassword);
		$selectDB = mysqli_query($db_con,"use $dbname");
		if($selectDB){
			// db selected
		}
		else{
			// faild to select db
		}

	function get_db_connection(){	
		return $GLOBALS['db_con'];
	}

?>

