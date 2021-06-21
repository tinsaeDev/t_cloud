<?php
	



	include("../db.php");


		$lv = $_COOKIE['lv'];

		$selectCookieSql = "select * from session where value='$lv' ";
		$selectCookieReslut = mysqli_query($db_con,$selectCookieSql);

		if (!$selectCookieReslut) {
			echo "Faild to execute <br>";
			die();
		}

		if ( mysqli_num_rows($selectCookieReslut)==0 ) {
			echo "no such cooke <br>";
			header("location:loginui.php");	
		    setcookie("lv",$cookieValue,time(),'/');
		}

		$row = mysqli_fetch_assoc($selectCookieReslut);
		
		//delte from client
		setcookie('lv','0',time());	


		// delet from db

		$deleteCookieSql = "delete from session where value='$lv' ";
		$deleteCookieResult = mysqli_query($db_con,$deleteCookieSql);

		if (!$deleteCookieResult) {
			echo "faild to execute $deleteCookieSql <br>";
			die();
		}

		 setcookie("lv",$cookieValue,time(),'/');
				 
		header("location:loginui.php");

?>