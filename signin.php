<?php require_once "config/class_inc.php";

$con = mysqli_connect("localhost","root","","tickets");

function getLogin($con,$table,$sqlUser,$sqlPass,$user,$pass,$returnType)
{
	
	$result = mysqli_query($con,"SELECT * FROM ".$table." WHERE ".$sqlUser."='".$user."'");
	while($row = mysqli_fetch_array($result))
  	{	
  		if($row[$sqlPass]==$pass)
  		{
  			if($returnType=="boolean")
  			{
                $_SESSION['user_id'] = $row['user_id'];
  				return true;
  			}
  			else
  			{
  				return $row;
  			}
  		}
  	}

	return false;

}


if(isset($_POST['formSubmit']))
{
			
			if(getLogin($con,"user","username","password",$_POST['formUsername'],sha1($_POST['formPassword']),"boolean"))
			{
	  			$_SESSION['loggedIn']=true;
	  			$_SESSION['userEmail']=getEmailFromUsername($_POST['formUsername']);

          		$_SESSION['userName']=$_POST['formUsername'];
          		header( 'Location: buy.php' ) ;
			}
  		else
  		{
  			//TODO Change HTML if login is wrong
  			echo("<h4 style='color:red;'>Wrong Email or Password</h4>");
  		}
  	}




function getEmailFromUsername($user)
{
    global $con;
	
	$result=mysqli_query($con,"SELECT * FROM user WHERE username='".$user."'");
	
	while($row = mysqli_fetch_array($result))
  	{	
  		return $row['email'];
  	}

	return false;
}


?>



<html>

<head>

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>

<script>
    var base_url = "http://localhost/Tick-It";
    var user_id = undefined;




function isValidEmail(email)
{
	var atpos=email.indexOf("@");
	var dotpos=email.lastIndexOf(".");

	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length){
        return false;
    }
    return true;
}



function submitRegistration()
{

	var username=document.getElementsByName("formUserName")[0].value.trim();
	var password1=document.getElementsByName("formPassword1")[0].value.trim();
	var password2=document.getElementsByName("formPassword2")[0].value.trim();
	var email=$("#formEmail").val().trim();



	if(isValid(username,password1,password2,email))
	{
		registerIfValidUserName(username,password1,email);
	}

}

function registerIfValidUserName(pUserName,pPassword,pEmail)
{
	$.ajax({
        url: 'registrationServer.php',
        data: {action: 'isValidUserName',username: pUserName},
        type: 'post',
        success:function(data) {
            registerValidUserName(data,pUserName,pPassword,pEmail);
        }
    });

}


function registerValidUserName(bool,pUserName,pPassword,pEmail){
	if(JSON.parse(bool))
	{
        $.ajax({
            url: 'registrationServer.php',
            data: {action: 'register',username: pUserName, password: pPassword, email: pEmail},
            type: 'post',
            success:function(data) {
                informRegistrationSuccess(data);
            }

		});

	}
	else
	{
		document.getElementById("registerError").innerHTML="Username Already In Use.";
	}
}


function informRegistrationSuccess(bool)
{
	if(JSON.parse(bool))
	{
		document.getElementById("registerError").innerHTML="Successful!.";
		window.location= "buy.php";
	}
	else
	{
		document.getElementById("registerError").innerHTML="Registration Failed, Please Try Again Later";
	}
}




var REQUIREDPASSWORDLENGTH=5; 

function isValid( username,password1, password2,email)
{

	var valid=true;
	document.getElementById("registerError").innerHTML="";
	if(username.length<=3)
	{

		
		document.getElementById("registerError").innerHTML="Please Make Username Longer."; 
		valid=false;
	}
	else if(!isValidEmail(email))
	{
		document.getElementById("registerError").innerHTML="Email Not Valid.";
		valid=false;
	}

	else if(password1.length<REQUIREDPASSWORDLENGTH)
	{
		document.getElementById("registerError").innerHTML="Password Too Short.";
		valid=false;
	}
	else if(password1!=password2){

		document.getElementById("registerError").innerHTML="Passwords Don't Match.";
		valid=false;
	}


	return valid;
}



$('#btnRegister')
    .on('click', function () {
        var btn = $(this)
        btn.button('loading')
        setTimeout(function () {
            btn.button('reset')
        }, 3000)
    });


</script>
<body>


<div class="row">
	<div class="col-md-10">
		<!-- <div class="row"> -->
			<div class="col-md-6">
			<h1>Log In:</h1>


		<form method="POST" action="signin.php" class="form-horizontal" role="form">
		  <div style="text-align:left" >
				

		  		<label>Username:</label>
				<input class="form-control" placeholder="Username" type="text" name="formUsername"/> <br>

		  		<label>Password:</label>
				<input class="form-control" placeholder="Password" type="password" name="formPassword"/><br>
				<input class="btn btn-lg btn-primary" type="submit" value="Log In" name="formSubmit"/><br>

		  </div>
		</form>
		</div>




	






			<div class="col-md-6">


				<h1>Register:</h1>
				<div><h4 style="color:red" id="registerError"></h4></div>
				<div class="form-group">
				
		  		<label>Username:</label>
				<input placeholder="User Name" class="form-control" type="text" name="formUserName"/><br>

				<label>Email:</label>
				<input placeholder="Email" id="formEmail" class="form-control" type="text" name="formEmail"/><br>


		  		<label>Password:</label>
				<input placeholder="Password" class="form-control" type="password" name="formPassword1"/><br>

		  		<label>Confirm Password:</label>
				<input placeholder="Confirm Password" class="form-control" type="password" name="formPassword2"/><br>

		  		

				<button class="btn btn-lg btn-primary" data-loading-text="Loading..." id="btnRegister" onClick="submitRegistration();" name="formSubmit">Register</button>
				</div>

				</div>

				



			</div>
		</div>
	<!-- </div> -->
</div>

</body>



</html>
<?php
require_once "inc/footer.php";

?>