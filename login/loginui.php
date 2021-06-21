<!DOCTYPE html>
<html>
<head>


		<script type="text/javascript">
			

			var usernameDOM;
			var passwordDOM;
			var errorTypeDOM;

			window.onload = function () {
				usernameDOM = document.getElementById("username");
				passwordDOM = document.getElementById("password");
				errorTypeDOM = document.getElementById("errorType");

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
			cursor: pointer;
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
			margin-top: 10px;
			padding: 10px;



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
				<h1 class="login-header-home-link" onclick="javascript:void(window.location='../login/home.php')">cloud</h1>
			</div>
			
			<div class="login-header-account">
			</div>	

		</div>


		<div class="login-content">
			
			<div class="login-content-logo">
				
				<img src="logo.png"/>

			</div>

			<div class="login-content-form-div">
				<form class="login-content-form-form" action="login.php" method="POST">
					<label id="errorType" class="login-content-form-form-error">
							
						<?php
							if( isset($_GET['error']) ) {
								echo $_GET['error'];
								
							} 
						?>

					</label>
					
					<label class="login-content-form-form-label">username</label>
					<input id="username" class="login-content-form-form-input" type="text" name="username">



					<label class="login-content-form-form-label">password</label>
					<input id="password" class="login-content-form-form-input" type="password" name="password">

					
					<input class="login-content-form-form-submit" type="submit" onclick="return checkForm()" value="login">
					<input class="login-content-form-form-submit" type="button" onclick="javascript:void(window.location='../create%20 account/signup.php')" value="Sign Up">


				</form>
			</div>

		</div>		
	</div>