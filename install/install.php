<?php

		// check if file named instalinfo.json exists

		if( isset( $_GET['fname'] ) && isset( $_GET['mname'] ) && isset( $_GET['gfname'] ) && isset( $_GET['username'] ) && isset( $_GET['password'] ) && isset( $_GET['dbserver'] ) && isset( $_GET['dbname'] ) && isset( $_GET['dbusername'] ) && isset( $_GET['dbpassword'] )  ) {
					
					if( file_exists("/home/tcloud/installinfo.json") ){ // check if installation file exist
						header("location:installationAborted.html"); // this is due to reinstallation, without deleting installation file.
						die();
					} 

					else{ // This means, the system is not installed and all forms data is recieved so, lets install it.


						// check if values are not empty ( !="" )  
						if( $_GET['fname']=="" || $_GET['mname']=="" || $_GET['gfname']=="" || $_GET['username']=="" || $_GET['password']=="" ||$_GET['dbserver']==""  || $_GET['dbport']=="" || $_GET['dbname']=="" ||$_GET['dbusername']==""){ // db password may can be null.
									 header("location:installForm.php?Empty+parameters+found");
									 die();
							}
							class Installinfo {} // installation prototype class	

									$dbinfo = new Installinfo();
									
									// set form data to php object will later saved as json file.

									$dbinfo->dbserver = $_GET['dbserver'];  // database server / ip:name
									$dbinfo->port = "3306"; // show default port, as default value on form.
									$dbinfo->dbname = $_GET['dbname'] ; // database name
									$dbinfo->dbusername = $_GET['dbusername']; // database username
									$dbinfo->dbpassword = $_GET['dbpassword']; // database password

								
									// check if the given database creditials work. 
										$db_con = mysqli_connect($dbinfo->dbserver.":".$dbinfo->port,$dbinfo->dbusername,$dbinfo->dbpassword);
											if($db_con){ // given database creditials are working.					
												$createDbResult = mysqli_query($db_con,"create database ".$dbinfo->dbname);
												if( $createDbResult ){ // specified  database created


														// About to create database structure.

														$pending_account = fopen("sqltable/pending_account.sql", "r");
														$users = fopen("sqltable/users.sql", "r");
														$files = fopen("sqltable/files.sql", "r");
														$share = fopen("sqltable/share.sql", "r");
														$trash = fopen("sqltable/trash.sql", "r");
														$session = fopen("sqltable/session.sql", "r");
														$storage = fopen("sqltable/storage.sql", "r");



														 $pending_accountSQL = fread($pending_account, filesize("sqltable/pending_account.sql") );
														 $usersSQL = fread($users, filesize("sqltable/users.sql") );
														 $filesSQL = fread($files, filesize("sqltable/files.sql") );
														 $shareSQL = fread($share, filesize("sqltable/share.sql") );
														 $trashSQL = fread($trash, filesize("sqltable/trash.sql") );
														 $sessionSQL = fread($session, filesize("sqltable/session.sql") );
														 $storageSQL = fread($storage, filesize("sqltable/storage.sql") );
						 



														mysqli_query($db_con,"use ".$dbinfo->dbname);


														$pending_accountResult  = mysqli_query($db_con,$pending_accountSQL);
															if(  $pending_accountResult){
															} else{
																	mysqli_query($db_con,"drop database $dbname");
																	header("location:installForm.php?error=unable+to+create+users+table");
																	die( mysqli_error($db_con) );
															}


														$usersResult  = mysqli_query($db_con,$usersSQL);
															if(  $usersResult){
															} else{
																	mysqli_query($db_con,"drop database $dbname");
																	header("location:installForm.php?error=unable+to+create+users+table");
																	die( mysqli_error($db_con) );
															}


														$filesResult  = mysqli_query($db_con,$filesSQL);
															if(  $filesResult){
															} else{
																	mysqli_query($db_con,"drop database $dbname");
																	header("location:installForm.php?error=unable+to+create+files+table");
																	die(  mysqli_error($db_con)  );
															}


														$shareResult  = mysqli_query($db_con,$shareSQL);
															if(  $shareResult){
															} else{
																	mysqli_query($db_con,"drop database $dbname");
																	header("location:installForm.php?error=unable+to+create+share+table");
																	die(  mysqli_error($db_con)   );
															}


														$trashResult  = mysqli_query($db_con,$trashSQL);
																if(  $trashResult){
																} else{
																		mysqli_query($db_con,"drop database $dbname");
																		header("location:installForm.php?error=unable+to+create+trash+table");
																		die(  mysqli_error($db_con)  );
																}

														$sessionResult  = mysqli_query($db_con,$sessionSQL);
																if(  $sessionResult){
																} else{
																		mysqli_query($db_con,"drop database $dbname");
																		header("location:installForm.php?error=unable+to+create+session+table");
																		die(  mysqli_error($db_con)  );
																}


														$storageResult  = mysqli_query($db_con,$storageSQL);
																if(  $storageResult){
																} else{
																		mysqli_query($db_con,"drop database $dbname");
																		header("location:installForm.php?error=unable+to+create+storage+table");
																		die( mysqli_error($db_con) );
																}
															// insert admin into active user account


																		$username = $_GET['username'];
																		$password = $_GET['password'];
																		$fname = $_GET['fname'];
																		$mname = $_GET['mname'];
																		$gfname = $_GET['gfname'];


															$insertAdminSql = " insert into users(USERNAME,PASSWORD,ADMIN,FISRT_NAME,FATHER_NAME,GRAND_FATHER_NAME) values( '$username','$password',true,'$fname','$mname','$gfname' ) ";

															$insertAdminResult = mysqli_query($db_con,$insertAdminSql);
															if($insertAdminResult){
																	
															// after inserting the admin, save the db creditils to file.

																		$json = json_encode($dbinfo);
																		$fileHandle = fopen("/home/tcloud/installinfo.json","w+");
																		fwrite($fileHandle, $json );

																		// create folder for uploaded files
																		mkdir("/home/tcloud/uploaded_files");
	
															}
															else{
																mysqli_query( $db_con,"drop database ". $dbinfo->dbname );
																header("location:installForm.php?error=unable+to+create+admin+account");
																die();
															}


															$dbCloseResult = mysqli_close($db_con);
															if ($dbCloseResult) {
																header("location:installed.html");

															} else{
																echo "What the hell is going on? <br>";
															}                                
														}

														// if db not created????

														else{// database connected but, cannot create specified database.
															header("location:installForm.php?error=faild+create+database");
															die();
															}
												} 

										else{
											header("location:installForm.php?error=given+database+creditials+do+not+work");
											die();
										}
					}
		}

		 else{
		 	// Not all parametrts are passed
			if( file_exists("/home/tcloud/installinfo.json") ){
				
				//System already installed, tell the user, or
				header("location:alreadyInstalled.html");
				die();

			} else{
				// No sign of system installation found. reinstall, open the form.
				header("location:installForm.php");
				die();
			}

		}

?>