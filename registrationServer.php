<?php



if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];

    switch($action) {
        case 'isValidUserName' : isValidUserName($_POST['username']);break;
        case 'register' : register($_POST['username'],$_POST['email'],$_POST['password']);break;

    }
}




function register($pUser, $pEmail, $pPassword)
{
	$con = mysqli_connect("localhost","root","","tickets");
	session_start();
	$username = mysqli_real_escape_string($con,$pUser);
	$email = mysqli_real_escape_string($con,$pEmail);
	$password = mysqli_real_escape_string($con,$pPassword);
	mysqli_query($con,"INSERT INTO user (username, password, email) VALUES ('$username','$password','$email')");
	$_SESSION['userName']=$username;
	$_SESSION['loggedIn']=true;
	echo("true");
}






function isValidUserName($username)
{

	$con = mysqli_connect("localhost","root","","tickets");
	session_start();
	$user=mysqli_real_escape_string($con,$username);
	$result=mysqli_query($con,"SELECT * FROM user WHERE username='".$user."'");
	if(mysqli_num_rows($result)>0)
	{
		echo("false");
	}
	else
	{
		echo("true");
	}
}

?>