<?php
	
	include ('../sec.php');

	if( !isset($user) ){
		header("location:../login/home.php");
	}

	if( !$admin==1 ){
		header("location:../login/home.php");
	}


?>


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
		.login-content-title{
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.login-content-title-text{
			text-align: center;
			font-family: ubuntu;
			font-size: 30pt;

		}

		.login-content-info{
			display: flex;
			justify-content: space-around;
			height: 300px;

		}

		.login-content-info-title{
			display: flex;
			justify-content: center;
			align-items: center;
			width: 300px;
			background-color: pink;
		}
		.login-content-info-title-text{
			font-family: ubuntu;
			font-size: 25pt;
			width: 100%;
			height: 100%;

			display: flex;
			justify-content: center;
			align-items: center;
			text-decoration: none;
			background-color: #00aced;
			color: white;

			border-style: solid;
			border-color: #00aced;
		}

		.login-content-info-title-text:hover{
			color: #00aced;
			background-color: white;
			border-style: solid;
			border-color: #00aced;
		}



		</style>

</head>
<body>

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
			
			<div class="login-content-title">
				<h1  class="login-content-title-text">Admin Dashboard</h1>
			</div>

			<div class="login-content-info">
				<div class="login-content-info-title">
					<a class="login-content-info-title-text" href="manageActive.php">Active</a>
				</div>

				<div class="login-content-info-title">
					<a class="login-content-info-title-text" href="managePending.php" >Pending</a>
				</div>
			</div>

		</div>		
	</div>