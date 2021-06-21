<?php


include ("../sec.php");

	if( !isset($user) ){
		header("location:loginui.php");
	}

	else if( $admin==1 ){
		header("location: ../manage/manage.php");
	}
	else{
		header("location:../files/view/viewer.php");
	}

?>