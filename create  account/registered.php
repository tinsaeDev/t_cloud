



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
			flex-flow: column;
			justify-content: center;
			align-items: center;
		}

		.login-content-form-title{
			display: flex;
			justify-content: space-around;
			align-items: center;
		}

		.login-content-form-title-image{

		}

		.login-content-form-title-text{
			text-align: center;
			font-family: ubuntu;
		}

		.login-content-form-detail{
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.login-content-form-detail-text{
			font-family: ubuntu;
		}

		</style>

</head>
<body>

	<div class="login-page">
		<div class="login-header">
			<div class="login-header-home">
				<h1 class="login-header-home-link" onclick="javascript:void(window.location='../login/home.php')">cloud</h1>
			</div>

		</div>


		<div class="login-content">
			
			<div class="login-content-logo">
				<img src="logo.png"/>
			</div>

			<div class="login-content-form-div">
				<div class="login-content-form-title">
					<img  class="login-content-form-title-image" src="registered.png">
					<h1 class="login-content-form-title-text">Registred</h1>	
				</div>

				<div class="login-content-form-detail">
					<p class="login-content-form-detail-text">You can login to your account once your account is comfirmed!</p>
				</div>


			</div>

		</div>		
	</div>

</body>
</html>