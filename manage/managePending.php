<?php
	include ('../sec.php');
	// if user is not admin kill and redirect to tell user,
	
	if( isset($admin) ) {
		if ($admin) {
		}

		else{
			header("location:../login/home.php");
			die();	
		}

	} 

	else{
		header("location:../login/home.php");
		die();
	}


?>
<!DOCTYPE html>
<html>
<head>


		<script type="text/javascript">
			

			var usernameDOM;
			var passwordDOM;
			var errorTypeDOM;

			var comfirmAjax;
			var deleteAjax;

			window.onload = function () {
				usernameDOM = document.getElementById("username");
				passwordDOM = document.getElementById("password");
				errorTypeDOM = document.getElementById("errorType");

				comfirmAjax = new XMLHttpRequest();


				deleteAjax = new XMLHttpRequest();
					deleteAjax.onreadystatechange=function(){
						console.log("ready D:"+ deleteAjax.readyState );
						console.log("status D :"+deleteAjax.status)
					}



				console.debug("page loaded");
			}

			function checkForm(){

				username = usernameDOM.value;
				password = passwordDOM.value;

				if( username=="" ){
					setErrorType("Username is Empty");
					return false;
				}

				if( password=="" ){
					setErrorType("Password is Empty");
					return false;
				}

				setErrorType("");
				return true;

			}

			function setErrorType(errorTypeArg){
				errorTypeDOM.innerHTML = errorTypeArg;
			}


			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

				function deletePending(rowArg,idArg){
						
						var sourceRow = document.getElementById(rowArg);
							sourceRow.style.opacity = 0.5;

						deleteAjax.open( "GET", "deletePending.php?username="+idArg ,true);
											deleteAjax.onreadystatechange = function(){
													if( deleteAjax.readyState==4 && deleteAjax.status==200 ){
															sourceRow.style.display="none";
														}
													}


						deleteAjax.send();

				}

				function comfirmPending(rowArg,idArg){						

						var sourceRow = document.getElementById(rowArg);
							sourceRow.style.opacity = 0.5;

						comfirmAjax.open( "GET", "confirmPending.php?username="+idArg ,true);
											comfirmAjax.onreadystatechange = function(){
													if( comfirmAjax.readyState==4 && comfirmAjax.status==200 ){
														sourceRow.style.display="none";
														}
													}
						comfirmAjax.send();
				}

		</script>



		<style type="text/css">
		
		body{
			margin: 0;
		}

		.login-page{}
		

		.login-header{
			height: 50px;
			position: sticky;
			background-color: #00aced;

			display: flex;
			justify-content: space-between;
		}
		.login-header-home{
			width: 50%;
			display: flex;
			justify-content: flex-start;
			align-items: center;

		}

		.login-header-home-link{
			color: white;
			font-family: ubuntu;
			padding: 0 10px;
		}

		.login-header-account{
			width: 50;
			display: flex;
			justify-content: flex-end;
			align-items: center;

		}

		.login-header-account-link{
			color: white;
			font-family: ubuntu;
			padding: 0 10px;		
		}

		.login-content{
			display: flex;
			flex-flow: column;

			margin-top: 50px;

			}
		
		.content-title{
			font-family: ubuntu;
		}

		.table-container {
			display: flex;
			justify-content: center;
		}
		.table{
			width: 80%;
		}
		.table-heading{
			background-color: #0285a1;
			color: white;
			font-family:ubuntu;
			width: 100%;
		}

		.table-row{

			background-color: #d5e2eb;
			font-family: ubuntu;
			widows: 500px;
		}

		.table-row:hover{
			background-color: #a5c4e3;
		}

		.table-cell{

			text-align: center;

		}

		.table-cell-button{
			cursor: pointer;
		}

		</style>

</head>
<body>

	<div class="login-page">
		<div class="login-header">
			<div class="login-header-home">
				<h1 class="login-header-home-link">t-cloud</h1>
			</div>
			
			<div class="login-header-account">
				<button class="account-div-logout"  onclick="javascript:void( window.location='../login/logout.php' )" >Logout </button>
			</div>	

		</div>


		<div class="login-content">
			
			<h1 class="content-title"> Manage Pending Accounts </h1>
				
				<?php

				$activeAcountsSql = "select * from pending_account"; 
				$activeAcountsResult = mysqli_query($db_con,$activeAcountsSql);
					if( $activeAcountsResult ){
						//echo "LOADED ACTIVE ACCOUNTS<br>";
					} 

					else{
						//echo "UNABLE TO LOAD ACTIVE ACCOUNTS<br>";
					}



					echo " 
							<div class='table-container'>
							<table class='table'> 
							<tr class='table-heading'>
								<th> Fullname </th>
								<th> Username </th>
								<th> Comfirm </th>
								<th> Delete </th>
							</tr>


					";

					while( $row = mysqli_fetch_assoc( $activeAcountsResult )  ){
					 	 
							$fullname = $row['FISRT_NAME'].' '.$row['FATHER_NAME'].' '.$row['GRAND_FATHER_NAME'];
							$username = $row['USERNAME'];
							

							echo " <tr id='trid$username' class='table-row'>
										<td class='table-cell'>  $fullname </td>
										<td class='table-cell'>  $username </td>
										<td class='table-cell'>  <button onclick='comfirmPending(\"trid$username\",\"$username\")' class='table-cell-button' > Comfirm </button> </td>
										<td class='table-cell'>  <button onclick='deletePending(\"trid$username\",\"$username\")'  class='table-cell-button' > Delete </button> </td>
							 	   </tr>"
							 	   ;
					}

						echo " </table> 
								</div>
								";



				// load active accounts fromdb
				// add
				// crwate table 
				//		username [fullname] <delete acc. link> <edit password link>
				//

			?>


		</div>		
	</div>