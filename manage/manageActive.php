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


?>
<!DOCTYPE html>
<html>
<head>

		<title> Manage Active Accounts </title>
		<script type="text/javascript">
			

			var usernameDOM;
			var passwordDOM;
			var errorTypeDOM;

			var resetPopupOverlayDOM;
			var resetPopupDOM;


			//delete popup


				var deleteActiveAccountOvelayDOM;
				var deleteActiveAccountOvelayDOM;
				var deleteActiveAccountQuestionDOM;
				var deleteActiveAccountDeleteButtonDOM;
				var deleteActiveAccountCancelButtonDOM;


				var deleteActiveAccountAjax;


			var usernameArea;
			var password1DOM;
			var password2DOM;

			var resetButton;
			var cancelButton;

			var resetPasswordAjax;


			window.onload = function () {
				usernameDOM = document.getElementById("username");
				passwordDOM = document.getElementById("password");
				errorTypeDOM = document.getElementById("errorType");

				resetPopupOverlayDOM = document.getElementById("reset-password-overlay");
					console.log("overlay initialized");
				resetPopupDOM = document.getElementById("reset-password");


				//delete account
				

				deleteActiveAccountOvelayDOM = document.getElementById("delete-user-overlay");
				deleteActiveAccountDOM = document.getElementById("delete-user");
				deleteActiveAccountQuestionDOM = document.getElementById("delete-user-content-question");
				deleteActiveAccountDeleteButtonDOM = document.getElementById("delete-user-content-buttons-delete");
				deleteActiveAccountCancelButtonDOM = document.getElementById("delete-user-content-buttons-cancel");
				deleteActiveAccountAjax = new XMLHttpRequest();
					deleteActiveAccountAjax.onreadystatechange = function(){

							if( deleteActiveAccountAjax.readyState==4 && deleteActiveAccountAjax.status==200){
									
									deleteActiveAccountDOM.style.display="none";
									deleteActiveAccountOvelayDOM.style.display = "none";
									var rowID = deleteActiveAccountAjax.rowID;
									document.getElementById( rowID ).style.display="none";
							}

					}
 



				// reset password
				usernameArea = document.getElementById("reset-password-input-username");
				password1DOM = document.getElementById("reset-password-input-password1");
				password2DOM = document.getElementById("reset-password-input-password2");

				resetButton = document.getElementById("reset-password-button-reset");
				cancelButton = document.getElementById("reset-password-button-cancel");

				resetPasswordAjax = new XMLHttpRequest();
					resetPasswordAjax.onreadystatechange = function(){
						
						console.log( "stus "+resetPasswordAjax.readyState );
						if( resetPasswordAjax.readyState==4 && resetPasswordAjax.status==200){
								resetPopupDOM.style.display = "none"; 
								resetPopupOverlayDOM.style.display = "none"; 
							}

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



				function deleteActiveAccount(rowArg,idArg){

					console.log("Deleting Active account "+ idArg);

					deleteActiveAccountDeleteButtonDOM.setAttribute("onclick", "deleteActiveAccountFinal('"+rowArg+"','"+idArg+"')" );

					deleteActiveAccountDOM.style.display="flex";
					deleteActiveAccountOvelayDOM.style.display="block";

					console.log("hidden");


				}

				function deleteActiveAccountFinal(rowArg,idArg) {
						console.log("Deleting... "+idArg);

						deleteActiveAccountAjax.rowID = rowArg;
						deleteActiveAccountAjax.open("GET","deleteActive.php?user="+idArg,true);
						deleteActiveAccountAjax.send();


				}

				function cancelDeleteActiveAccount () {
							
					deleteActiveAccountDOM.style.display="none";
					deleteActiveAccountOvelayDOM.style.display="none";

					console.log("hidden");
				}

				function resetAccount(rowArg,idArg){
					console.log("opening... popup ");
					
					resetPopupOverlayDOM.style.display = "flex";
					resetPopupDOM.style.display = "flex";
					resetButton.setAttribute("onclick"," resetPasswordFinal('"+idArg+"') ");
					usernameArea.value=idArg;
					password1DOM.value = "";
					password2DOM.value = "";

				}

				function resetPasswordFinal( idArg ){
					// check if input is valid
						// >=6 characters
						// open POST to ressetAccount?username=p=***&p2=***

					var usr = usernameArea.value;
					var pwd1 = password1DOM.value;
					var pwd2 = password2DOM.value;

					if(pwd1 != pwd2){
						alert('password dont match');
						return;
					}

					if( pwd1.length < 6  ){
						alert( 'short password' );
						return;
					}

					var url = "resetPassword.php?username="+usr+"&password1="+pwd1+"&password2="+pwd2;
					console.log(url);

					resetPasswordAjax.open("GET",url,true);
					resetPasswordAjax.send();

				}

				function calcelResetPassword(){
					resetPopupOverlayDOM.style.display = "none";
					resetPopupDOM.style.display = "none";
				}


				function updateStorage(event){
						
					username = event.originalTarget.getAttribute("username");
						inputDOM = document.getElementById( "input-"+username );
						storageValue = inputDOM.value;
						console.log(storageValue);

						obj = new Object();
						obj.username = username;
						obj.storage = storageValue * 1000000;

						ajax = new XMLHttpRequest();
						ajax.open("post","updatestorage.php");
						ajax.onreadystatechange=function(){
							if( ajax.readyState==4 && ajax.status==200 ){
									console.log("updated for "+username);
							}
						}
						form = new FormData();
						form.append("data" ,JSON.stringify(obj) );
						ajax.send( form );


		
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





		.delete-user-overlay{
			
			display: none;
			background-color: black;
			opacity: 0.5;
			position: fixed;
			height: 100vh;
			width: 100vw;
			z-index: 44;


		}


		.delete-user{
			opacity: 1;
			position: fixed;
			top: calc( (100vh / 2) - 100px );
			left: calc( (100vw / 2) - 200px );

			display: none;
			flex-flow: column;
			height: 200px;
			width: 400px;
			z-index: 777;
			border-style: solid;
			border-width: 3px;
			border-color: #00aced;
		}

		.delete-user-header{
			height: 20%;
			background-color: #00aced;

			display: flex;
			justify-content: flex-start;
			align-items: center;
		}
		.delete-user-header-title{
			color: white;
			font-size: 15pt;
			font-family: ubuntu;
			padding: 0 5%;

		}

		.delete-user-content{
			height: 80%;
			background-color: #efefef;
			display: flex;
			flex-flow: column;
		}
		.delete-user-content-question{
			height: 70%;
			display: flex;
			justify-content: flex-start;
			align-items: center;

			padding: 0 15%;


			font-size: 15pt;
			font-family: ubuntu;

		}

		.delete-user-content-buttons{
			height: 30%;

			display: flex;
			justify-content: space-around;
			margin-bottom: 10%;
		}
		
		.delete-user-content-buttons-delete{
			border:none;
			outline: none;
			background-color: #00aced;
			color: white;
			padding: 0 40px;
			cursor: pointer;

		}

		.delete-user-content-buttons-delete:hover{
			opacity: 0.5;
		}
		
		.delete-user-content-buttons-cancel{
			border:none;
			outline: none;
			background-color: red;
			color: white;
			padding: 0 40px;
			cursor: pointer;
		}

		.delete-user-content-buttons-cancel:hover{
			opacity: 0.5;
		}






		.reset-password-overlay{
			display: none;
			
			position: fixed;
			background-color: black;
			opacity: 0.4;
			height: 100vh;
			width: 100vw;
			z-index: 65;
		}
		
		.reset-password{

			display: none;
			flex-flow: column;
			width: 300px;
			height: 400px;
			background-color: white;

			position: fixed;
			top: calc( (100vh / 2 ) - 200px);
			left: calc( (100vw / 2) - 150px);
			z-index: 66;
			border-style: solid;
			border-width: 3px;
			border-color: #00aced;

		}
		
		.reset-password-header{
			background-color: #00aced;
			height: 20%;
			display: flex;
			justify-content: flex-start;
			align-items: center;
		}

		.reset-password-header-title{
			color: white;
			font-size: 15pt;
			font-family: ubuntu;
			padding: 0 5%;

		}
		
		.reset-password-content{
			height: 80%;
			display: flex;
			flex-flow: column;
			justify-content: space-around;
			padding: 10px;
		}
		
		.reset-password-label{
			font-family: ubuntu;
		}
		
		.reset-password-input{
			border:none;
			outline: none;
			border-bottom-style: solid;
			border-bottom-color: #00aced;
			height: 30px;
		}
		
		.reset-password-buttons{
			display: flex;
			justify-content: space-around;
		}
		
		.reset-password-button-reset{
			border:none;
			background-color: #00aced;
			color: white;
			padding:10px;
			cursor: pointer;
		}
		
		.reset-password-button-reset:hover{
			opacity: .5;
		}

		.reset-password-button-cancel{
			border:none;
			background-color: red;
			color: white;
			padding:10px;
			cursor: pointer;
		}
		.reset-password-button-cancel:hover{
			opacity: .5;
		}




		</style>

</head>
<body>


	<div class="delete-user-overlay"  id="delete-user-overlay"></div>
		<div class="delete-user"  id="delete-user">
			<div class="delete-user-header">
				<label class="delete-user-header-title">Are Sure ?</label>	
			</div>

			<div class="delete-user-content">
				<label class="delete-user-content-question" id="delete-user-content-question">Are you sure to delete Abebe Mamo ? </label>
				<div class="delete-user-content-buttons">
					<button class="delete-user-content-buttons-delete" id="delete-user-content-buttons-delete">Delete</button>
					<button class="delete-user-content-buttons-cancel" id="delete-user-content-buttons-cancel" onclick="cancelDeleteActiveAccount()">Cancel</button>
				</div>
			</div>
		</div>
	



	<div id="reset-password-overlay" class="reset-password-overlay"></div>
	<div id="reset-password" class="reset-password">
			
			<div class="reset-password-header">
				<label class="reset-password-header-title">Resset Password</label>
			</div>
			<div class="reset-password-content">
				
				<label class="reset-password-label">username</label>
				<input id="reset-password-input-username" class="reset-password-input" disabled type="text">

				
				<label class="reset-password-label">New Password</label>
				<input id="reset-password-input-password1" class="reset-password-input" type="password">

				
				<label class="reset-password-label">Retype Password</label>
				<input  id="reset-password-input-password2" class="reset-password-input" type="password">

				<div  class="reset-password-buttons">
						<button id="reset-password-button-reset" class="reset-password-button-reset"  onclick="resetPasswordFinal()" >Reset</button>
						<button id="reset-password-button-cancel" class="reset-password-button-cancel" onclick="calcelResetPassword()" >Cancel</button>
				</div>
			</div>

	</div>




		



	<div class="login-page">
		<div class="login-header">
			<div class="login-header-home">
				<h1 class="login-header-home-link">cloud</h1>
			</div>
			
			<div class="login-header-account">
			<button class="account-div-logout"  onclick="javascript:void( window.location='../login/logout.php' )" >Logout </button>
			</div>	

		</div>


		<div class="login-content">
			
			<h1 class="content-title"> Manage Active Accounts </h1>
				
				<?php

				$activeAcountsSql = "select * from users"; 
				$activeAcountsResult = mysqli_query($db_con,$activeAcountsSql);
					echo " 
							<div class='table-container'>
							<table class='table'> 
							<tr class='table-heading'>
								<th> Fullname </th>
								<th> Username </th>
								<th> Resset Password </th>
								<th> Quota </th>
								<th> Delete Account </th>
							</tr>
					";

					while( $row = mysqli_fetch_assoc( $activeAcountsResult )  ){
					 	 
							$fullname = $row['FISRT_NAME'].' '.$row['FATHER_NAME'].' '.$row['GRAND_FATHER_NAME'];
							$username = $row['USERNAME'];
							$role = $row["ADMIN"];
							

							echo " <tr id='trid$username' class='table-row'> ";
							echo " <td class='table-cell'>  $fullname </td> ";
							echo " <td class='table-cell'>  $username </td>";


									$storageUsageSql = "select * from storage where user='$username' ";
									$storageUsageResult = mysqli_query($db_con,$storageUsageSql);
									$storageRow = mysqli_fetch_assoc($storageUsageResult);
								
									$totalStorage = $storageRow['total'];
									$usedStorage  = $storageRow['used'];

									$totalStorageMB = $totalStorage /1000000;
									$usedStorageMB = $usedStorage / 1000000;
									$cn = number_format( (float) $usedStorageMB,2 );


							echo " <td class='table-cell'>  <button onclick='resetAccount(\"trid$username\",\"$username\")' class='table-cell-button' > Reser Password </button> </td>";
								if($role){
									echo " <td class='table-cell'> <input type='number' disabled > MB <button disabled> Update </button> </td>";
									echo " <td class='table-cell'>  <button  class='table-cell-button' title='you cant delete admin account' disabled> Delete </button> </td>";		
									continue;
								}
							echo " <td class='table-cell'> <input id=input-$username type='number' min=$cn value=$totalStorageMB > MB <button onclick='updateStorage(event)' username=$username> Update </button> </td>";
							
							echo " <td class='table-cell'>  <button onclick='deleteActiveAccount(\"trid$username\",\"$username\")'  class='table-cell-button' > Delete </button> </td>";
							
							echo " </tr> ";
					}

						echo " </table> ";
						echo "	</div>";
								
			?>


		</div>		
	</div>