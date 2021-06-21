<?php

// only change the actual name of the file from database and file system.
    

    
    require('../../sec.php');

      $fileId = $_GET['id'];
      $newname = $_GET['newname'];


      // check if file exist


      $checkFileExistenceSql = "select * from files where OWNER='$user' AND ID='$fileId' ";
      $checkFileExistenceResult = mysqli_query($db_con,$checkFileExistenceSql);
        if(!$checkFileExistenceResult){
          // echo "faild to execute $checkFileExistenceSql <br> <br> ";
          die();

        }else{
            // get parent name, latter used to update abs path.
            if( mysqli_num_rows($checkFileExistenceResult)==0){

            //  echo "file not found. <br> <br> ";
              die();
            }
            else{

                $row = mysqli_fetch_assoc($checkFileExistenceResult);
                $name = $row['ACTUAL_NAME'];
                $fileParentID = $row['PARENT_PATH'];
                
                $fileParentAbsPath ;  // query db
                $fileAbsPath;
                
                    $selectParentPathSql = "select ABS_PATH from files where ID='$fileParentID' ";
                    $selectParentPathResult = mysqli_query($db_con,$selectParentPathSql);
                      if(!$selectParentPathResult){

                          // echo "faild to execute $selectParentPathSql <br> <br> ";
                          die();
                        }
                    $parentRow = mysqli_fetch_assoc($selectParentPathResult);
                $fileParentAbsPath = $parentRow['ABS_PATH'];
                $fileAbsPath = $fileParentAbsPath.$name;
            }
        }

        $oldAbsPath = $fileParentAbsPath.$name;
        $newAbsPath = $fileParentAbsPath.$newname;

      //  echo "File to be renamed =  $name <br>";
      //  echo "File paret = $fileParentAbsPath <br>";
      //  echo "Absolute = $fileAbsPath <br>";
      //  echo "New Path = $fileAbsPath <br>";


        // update fs

          $renameResult = rename( $oldAbsPath,$newAbsPath);
            if (!$renameResult ) {
                //echo "Faild to rename from FS";
                die();
            }


        // update db

            $updateFileNameSql = "update files set ABS_PATH='$newAbsPath',ACTUAL_NAME='$newname' where ID='$fileId' ";
            $updateFileNameResult = mysqli_query($db_con,$updateFileNameSql);

                if (!$updateFileNameResult) {
                    //echo "Faild to execute $updateFileNameSql <br>";
                    die();
                }

                echo "1";
                die();

?>