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

            $checkDestinationExistenceSql = " select * from files where ID='$destination' ";
            $checkDestinationExistenceResult = mysqli_query($db_con, $checkDestinationExistenceSql );
              
              if (!$checkDestinationExistenceResult) {
                echo "faild to execute  $checkDestinationExistenceSql <br>";
              }

              if ( mysqli_num_rows($checkDestinationExistenceResult)==0 ) {
               echo "destination not found <br>";
                die();
              }
                    $destinationRow = mysqli_fetch_assoc($checkDestinationExistenceResult);
                    $destinationAbsPath = $destinationRow['ABS_PATH'];

                    $soucePath = $fileAbsPath;
                    $destinationPath = $destinationAbsPath.$filename;


                // check if file exist on file system
                if ( file_exists($destinationPath) ) {
                  echo "File already exists in selected directory>";
                  die();
                }

                

                // move file from file system
                $fsMoveResult = rename($soucePath,$destinationPath);
                if (!$fsMoveResult) {
                  echo "faild to move file on disk";
                  die();
                }

              // update on database
                $updateSql = " update files set PARENT_PATH='$destination',ABS_PATH='$destinationPath' where ID='$source' ";
                     $copyFileResult = mysqli_query($db_con,$updateSql);
                        if(!$copyFileResult) {
                            echo "faild to update file information on database";
                            die();
                        } 

                        // moved
                        echo "1";
                        die();

                    ?>