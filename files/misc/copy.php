<?php

// only change the actual name of the file from database and file system.
       require('../../sec.php');

        if ( !isset( $_GET['source'] ) ||  !isset( $_GET['destination'] ) ) {
          echo "Null parameter <br>";
          die();
        }


        $source = $_GET['source'];
        $destination = $_GET['destination'];

          $checkSourceExistenceSql = "select * from files where ID='$source' ";

          $checkSourceExistenceResult = mysqli_query($db_con,$checkSourceExistenceSql);
            if (!$checkSourceExistenceResult) {
              echo "faild to execute $checkSourceExistenceSql <br>";
              die();
            }

            if ( mysqli_num_rows( $checkSourceExistenceResult )==0 ) {
              echo "source Not found <br>";
              die();
            }
                    $sourceRow = mysqli_fetch_assoc( $checkSourceExistenceResult );

                    $filename = $sourceRow['ACTUAL_NAME'];
                    $fileAbsPath = $sourceRow['ABS_PATH'];

            $checkDestinationExistenceSql = " select * from files where ID='$destination' AND OWNER='$user' ";
            $checkDestinationExistenceResult = mysqli_query($db_con, $checkDestinationExistenceSql );
              
              if (!$checkDestinationExistenceResult) {
                echo"here>> faild to execute  $checkDestinationExistenceSql <br>";
              }

              if ( mysqli_num_rows($checkDestinationExistenceResult)==0 ) {
                 echo"destination not found <br>";
                 echo "after $checkDestinationExistenceSql <br> ";
                 die();
              }
                    $destinationRow = mysqli_fetch_assoc($checkDestinationExistenceResult);
                    $destinationAbsPath = $destinationRow['ABS_PATH'];

                    $soucePath = $fileAbsPath;
                    $destinationPath = $destinationAbsPath.$filename;

                // copy on fs
                if ( file_exists($destinationPath) ) {
                 echo"File already exists <br>";
                  die();
                }

                $fsCopyResult = copy( $soucePath , $destinationPath);
                if (!$fsCopyResult) {
                  echo "Faild to copy on fs <br>";
                  die();
                }

              // copy on db
                     $newfile_ID = rand(1000000000,9999999999)."";
                     $newfile_OWNER = $sourceRow['OWNER'];
                     $newfile_ABS_PATH = $destinationPath;
                     $newfile_PARENT_PATH =$destination;
                     $newfile_ACTUAL_NAME = $sourceRow['ACTUAL_NAME'];
                     $newfile_FILE_TYPE= $sourceRow['FILE_TYPE'];
                     $newfile_FILE_SIZE= $sourceRow['FILE_SIZE'];
                     $newfile_SHARED=0;
                     $newfile_SHAREd_LINK= Null;
                     $newfile_date_created=  date('Y-m-d') ;
                     $newfile_deleted= 0;
                     $newfile_isDir= $sourceRow['isDir'];



         $copyFileSql = " INSERT INTO files(ID,OWNER,ABS_PATH,PARENT_PATH,ACTUAL_NAME,FILE_TYPE,FILE_SIZE,SHARED,SHAREd_LINK,date_created,deleted,isDir)
           VALUES ('$newfile_ID','$newfile_OWNER','$newfile_ABS_PATH','$newfile_PARENT_PATH','$newfile_ACTUAL_NAME','$newfile_FILE_TYPE',$newfile_FILE_SIZE,$newfile_SHARED,'$newfile_SHAREd_LINK','$newfile_date_created',$newfile_deleted,$newfile_isDir) ";
                     $copyFileResult = mysqli_query($db_con,$copyFileSql);
                        if(!$copyFileResult) {
                            echo "ffffffaild to execute $copyFileSql <br>";
                            die();
                        } 

                        echo "1";
                        die();

                           ?>