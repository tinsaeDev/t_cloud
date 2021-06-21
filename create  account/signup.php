
<?php
	
	include("../sec.php");
	// prevent loged user from creatinf account.
	
	if ( isset( $user ) ) {
		header("location:../login/home.php");	
	}


?>



<!DOCTYPE html>
<html>
<head>

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

				window.onload = function(){

					errorTypeDOM = document.getElementById("errorType");

					firstNameDOM = document.getElementById("firstName");
					fatherNameDOM = document.getElementById("fatherName");
					grandFatherNameDOM = document.getElementById("grandFatherName");

					usernameDOM = document.getElementById("username");
					passwordoneDOM = document.getElementById("passwordone");
					passwordtwoDOM = document.getElementById("passwordtwo");

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
			margin-bottom: 10px;

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
				<h1 class="login-header-home-link">cloud</h1>
			</div>

		</div>


		<div class="login-content">
			
			<div class="login-content-logo">
				
				<img src="logo.png"/>

			</div>

			<div class="login-content-form-div">
				<form action="register.php" method="POST" class="login-content-form-form">
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
					<input onkeyup="checkForm()"  id="grandFatherName" class="login-content-form-form-input" type="text" name="gname">
					
					<label class="login-content-form-form-label">username</label>
					<input onkeyup="checkForm()"  id="username" class="login-content-form-form-input" type="text" name="username">



					<label class="login-content-form-form-label">password</label>
					<input onkeyup="checkForm()" id="passwordone" class="login-content-form-form-input" type="password" name="password">


					<label class="login-content-form-form-label">Re type password</label>
					<input onkeyup="checkForm()"  id="passwordtwo"class="login-content-form-form-input" type="password" name="password2">

					
					<input class="login-content-form-form-submit" onclick="return checkForm(event)" type="submit" value="Sign Up">

					<input class="login-content-form-form-submit" type="button" onclick="javascript:void(window.location='../login/loginui.php')" value="Login">


				</form>
			</div>

		</div>		
	</div>

</body>
</html>