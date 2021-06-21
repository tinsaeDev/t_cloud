



<!DOCTYPE html>
<html>
<head>

<title>Install System</title>
		<script type="text/javascript">
			
			var errorTypeDOM;

			var firstNameDOM;
			var fatherNameDOM;
			var grandFatherNameDOM;

			var usernameDOM;
			var passwordoneDOM;
			var passwordtwoDOM;

			var firstName;
			var fatherName;
			var grandFatherName;

			var username
			var passwordone;
			var passwordtwo;


			var dbserverDOM;
			var	dbportDOM;
			var	dbnameDOM;
			var	dbusernameDOM;
			var	dbpasswordDOM;

				window.onload = function(){

					errorTypeDOM = document.getElementById("errorType");

					firstNameDOM = document.getElementById("firstName");
					fatherNameDOM = document.getElementById("fatherName");
					grandFatherNameDOM = document.getElementById("grandFatherName");

					usernameDOM = document.getElementById("username");
					passwordoneDOM = document.getElementById("passwordone");
					passwordtwoDOM = document.getElementById("passwordtwo");

					dbserverDOM = document.getElementById("dbserver");
					dbportDOM =  document.getElementById("dbport");
					dbnameDOM =  document.getElementById("dbname");
					dbusernameDOM =  document.getElementById("dbusername");
					dbpasswordDOM =  document.getElementById("dbpassword");

					console.debug("all elements ok");
				}

				function checkForm(event){

					console.log("event recieved");

					firstName = firstNameDOM.value;
					if(firstName==""){
						setErrorType("Firt name cannot be empty");
						return false;
					}

					fatherName=fatherNameDOM.value;

					console.debug("also reached here");
					if(fatherName==""){
						setErrorType("Father name cannot be empty");
						return false;

					}

					grandFatherName = grandFatherNameDOM.value;
					if(grandFatherName==""){
						setErrorType("Grand Father Name cannot be empty");
						return false;

					}


					username = usernameDOM.value;
					if(username==""){
						setErrorType("username cannot be empty");
						return false;

					}



					passwordone = passwordoneDOM.value;
					if(passwordone==""){
						setErrorType("password cannot be empty");
						return false;

					}



					passwordtwo = passwordtwoDOM.value;
					if(passwordtwo==""){
						setErrorType("the second password cannot be empty");
						return false;

					}



					if (passwordone!=passwordtwo) {
						setErrorType("Password do not mach");
						return false;
					}
				
					if(passwordone.length < 6){
						setErrorType("short password");
						return false;
					}



					if(dbserverDOM.value==""){
						setErrorType("Database Server Empty");
						return false;
					}
					if(dbportDOM.value==""){
						setErrorType("Database Server Port Empty");
						return false;
					}
					if(dbnameDOM.value==""){
						setErrorType("Database Name Empty");
						return false;
					}
					if(dbusernameDOM.value==""){
						setErrorType("Database username Empty");
						return false;
					}					

					setErrorType("");
					return true;



				}

				function setErrorType(errorTypeArg){
					errorTypeDOM.innerHTML = errorTypeArg;
					console.log( "set " +errorTypeArg );
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
			margin-top: 50px;
				}


		.login-content-logo{
			width:50%;


			display: flex;
			justify-content: center;
			align-items: center;
		}
		.login-content-form-div{
			width: 50%;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.login-content-form-form{
			display: flex;
			flex-flow: column;
			width:70%;;

		}
		
		.login-content-form-form-label{
			color: #00aced;
			font-family: ubuntu;
			font-size: 15pt;

		}

		.login-content-form-form-error{
			color: red;
			font-family: ubuntu;
			font-size: 12pt;			
		}

		.login-content-form-form-input{
			border:none;
			outline: none;
			border-bottom-style: solid;
			border-bottom-color: #00aced;

			font-family: ubuntu;
			font-size: 12pt;

			margin: 10px 0 20px 0;
		}

		.login-content-form-form-submit{
			background-color: #00aced;
			color: white;

			font-family: ubuntu;
			font-size: 15pt;

			border:none;
			outline: none;

			border-style:solid;
			border-color: #00aced;

			padding: 10px;
			margin-bottom: 100px;

		}

		.login-content-form-form-submit:hover{
			background-color: white;
			color: #00aced;
		}

		</style>

</head>
<body>

	<div class="login-page">
		<div class="login-header">
			<div class="login-header-home">
				<h1 class="login-header-home-link">t-cloud</h1>
			</div>
			

		</div>


		<div class="login-content">
			
			<div class="login-content-logo">
				
				<img src="logo.png"/>

			</div>

			<div class="login-content-form-div">
				<form action="install.php" method="GET" class="login-content-form-form">
					<label  id="errorType" class="login-content-form-form-error">
						
						<?php
							if( isset( $_GET['error'] ) ){
								echo $_GET['error'];
							}
						?>

					</label>
					
					<label class="login-content-form-form-label">First Name</label>
					<input onkeyup="checkForm()" id="firstName" class="login-content-form-form-input" type="text" name="fname">
					
					<label class="login-content-form-form-label">Father Name</label>
					<input onkeyup="checkForm()"  id="fatherName" class="login-content-form-form-input" type="text" name="mname">
					
					<label class="login-content-form-form-label">Grand Father Name</label>
					<input onkeyup="checkForm()"  id="grandFatherName" class="login-content-form-form-input" type="text" name="gfname">
					
					<label class="login-content-form-form-label">username</label>
					<input onkeyup="checkForm()"  id="username" class="login-content-form-form-input" type="text" name="username">



					<label class="login-content-form-form-label">password</label>
					<input onkeyup="checkForm()" id="passwordone" class="login-content-form-form-input" type="password" name="password">


					<label class="login-content-form-form-label">Re type password</label>
					<input onkeyup="checkForm()"  id="passwordtwo"class="login-content-form-form-input" type="password" name="password2">

					


					<label class="login-content-form-form-label">Database Server</label>
					<input onkeyup="checkForm()" id="dbserver" class="login-content-form-form-input" type="text" name="dbserver" value="localhost">
					
					<label class="login-content-form-form-label">Database Server Port</label>
					<input onkeyup="checkForm()"  id="dbport" class="login-content-form-form-input" type="text" name="dbport" value="3306">
					
					<label class="login-content-form-form-label">Database Name</label>
					<input onkeyup="checkForm()"  id="dbname" class="login-content-form-form-input" type="text" name="dbname">
					
					<label class="login-content-form-form-label">Database username</label>
					<input onkeyup="checkForm()" id="dbusername" class="login-content-form-form-input" type="text" name="dbusername">
					
					<label class="login-content-form-form-label">Database password</label>
					<input onkeyup="checkForm()"  id="dbpassword" class="login-content-form-form-input" type="password" name="dbpassword">
					

					<input class="login-content-form-form-submit" onclick="return checkForm(event)" type="submit" value="Install">


				</form>
			</div>

		</div>		
	</div>

</body>
</html>